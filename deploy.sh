#!/bin/bash
set -euo pipefail

# Deploy local WordPress changes to production via rsync
# Usage: ./deploy.sh [--dry-run]

REMOTE_USER="balakuma"
REMOTE_HOST="107.161.23.124"
REMOTE_PATH="/home/balakuma/blog.balakumar.dev"
REMOTE_RSYNC="~/bin/rsync"

# SSH key: use SSH_KEY env var (for CI) or default local path
SSH_KEY="${SSH_KEY:-$HOME/Downloads/wordpress_ssh_key}"
SSH_OPTS="-i $SSH_KEY -o StrictHostKeyChecking=no"

DRY_RUN=""
if [[ "${1:-}" == "--dry-run" ]]; then
    DRY_RUN="--dry-run"
    echo "==> DRY RUN MODE (no changes will be made)"
fi

echo "==> Deploying to $REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH"

# Sync theme files
echo "--- Syncing themes..."
rsync -avz $DRY_RUN \
    --rsync-path="$REMOTE_RSYNC" \
    -e "ssh $SSH_OPTS" \
    --exclude='error_log' \
    wp-content/themes/developer-portfolio/ \
    "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/wp-content/themes/developer-portfolio/"

rsync -avz $DRY_RUN \
    --rsync-path="$REMOTE_RSYNC" \
    -e "ssh $SSH_OPTS" \
    --exclude='error_log' \
    wp-content/themes/balakumar-dark/ \
    "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/wp-content/themes/balakumar-dark/"

# Sync plugins
echo "--- Syncing plugins..."
rsync -avz $DRY_RUN \
    --rsync-path="$REMOTE_RSYNC" \
    -e "ssh $SSH_OPTS" \
    --exclude='error_log' \
    wp-content/plugins/ \
    "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/wp-content/plugins/"

# Clear LiteSpeed cache
if [[ -z "$DRY_RUN" ]]; then
    echo "--- Clearing LiteSpeed cache..."
    ssh $SSH_OPTS "$REMOTE_USER@$REMOTE_HOST" "rm -rf /home/balakuma/lscache/*"
fi

echo "==> Deploy complete!"
