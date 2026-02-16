# balakumar.dev - WordPress Blog Setup

## Overview

This project manages the WordPress blog at **https://blog.balakumar.dev** via SSH and WP-CLI.

## Access Details

| Component | Value |
|-----------|-------|
| **Blog URL** | https://blog.balakumar.dev |
| **Main Site** | https://balakumar.dev |
| **Server IP** | 107.161.23.124 |
| **SSH User** | balakuma |
| **WordPress Path** | `/home/balakuma/blog.balakumar.dev/` |
| **Themes Path** | `/home/balakuma/blog.balakumar.dev/wp-content/themes/` |
| **Plugins Path** | `/home/balakuma/blog.balakumar.dev/wp-content/plugins/` |

## Server Access

### SSH (via Bash tool)
- **Purpose**: Direct file access (themes, CSS, PHP, JS), deployments
- **Auth**: SSH key at `/Users/bkumara/Downloads/wordpress_ssh_key`

### WP-CLI (on server)
- **Purpose**: WordPress management (posts, plugins, themes, DB, options, search-replace)
- **Binary**: `/home/balakuma/bin/wp` (wrapper script that calls PHP CLI)
- **Phar**: `/home/balakuma/bin/wp-cli.phar`
- **PHP**: Uses `/usr/local/bin/php` (CLI SAPI — the default `/usr/bin/php` is CGI and won't work)
- **Version**: 2.12.0
- **WordPress**: 6.9.1

## SSH Key Info

| File | Location |
|------|----------|
| Private Key | `/Users/bkumara/Downloads/wordpress_ssh_key` |
| Public Key | `/Users/bkumara/Downloads/wordpress_ssh_key.pub` |
| Passphrase | None (no passphrase) |
| Created | January 7, 2026 |

**Note**: The public key is authorized in cPanel under SSH Access.

## What Claude Can Do

### Via SSH (Bash Tool)
- Create custom themes from scratch
- Edit theme CSS, PHP, JS files
- Modify plugin files
- Access wp-config.php
- Direct database access via CLI

### Via WP-CLI (Preferred for WordPress Operations)
- List/create/edit/delete posts and pages
- Manage plugins (install, activate, deactivate, update, delete)
- Manage themes (install, activate, update)
- Database export/import (`wp db export`, `wp db import`)
- Search-replace with serialized data support (`wp search-replace`)
- Manage options (`wp option get/update`)
- User management (`wp user list/create/update`)
- Cache operations (`wp cache flush`)
- Core updates (`wp core update`)

**SSH Command Template:**
```bash
ssh -i /Users/bkumara/Downloads/wordpress_ssh_key balakuma@107.161.23.124 "command here"
```

**WP-CLI Command Template:**
```bash
ssh -i /Users/bkumara/Downloads/wordpress_ssh_key balakuma@107.161.23.124 "cd ~/blog.balakumar.dev && ~/bin/wp <command>"
```

## Quick Commands

### SSH
```bash
# Connect manually
ssh -i /Users/bkumara/Downloads/wordpress_ssh_key balakuma@107.161.23.124

# List themes
ssh -i /Users/bkumara/Downloads/wordpress_ssh_key balakuma@107.161.23.124 "ls ~/blog.balakumar.dev/wp-content/themes/"

# Clear LiteSpeed cache after changes
ssh -i /Users/bkumara/Downloads/wordpress_ssh_key balakuma@107.161.23.124 "rm -rf ~/lscache/*"
```

### WP-CLI
```bash
# All wp commands must cd into the WordPress dir first
SSH_CMD="ssh -i /Users/bkumara/Downloads/wordpress_ssh_key balakuma@107.161.23.124"

# List posts
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp post list --post_type=post --post_status=publish --fields=ID,post_title,post_date --format=table"

# Create a post
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp post create --post_title='My Title' --post_status=draft --post_type=post"

# List plugins
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp plugin list --format=table"

# Activate/deactivate a plugin
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp plugin activate plugin-name"
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp plugin deactivate plugin-name"

# List themes
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp theme list --format=table"

# Get/set options
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp option get siteurl"
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp option update blogdescription 'New tagline'"

# DB export (backup)
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp db export ~/backup_\$(date +%Y%m%d).sql"

# Search-replace (handles serialized data safely!)
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp search-replace 'old-url.com' 'new-url.com' --dry-run"

# User list
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp user list --format=table"

# Cache flush
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp cache flush"

# Check core version
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp core version"
```

### When to Use WP-CLI vs Raw SSH vs Raw SQL

| Task | Best Tool |
|------|-----------|
| Edit theme/plugin files | SSH (rsync or direct edit) |
| Create/edit posts | WP-CLI (`wp post create/update`) |
| Manage plugins | WP-CLI (`wp plugin install/activate`) |
| URL migration / search-replace | WP-CLI (`wp search-replace` — handles serialized data!) |
| DB backup | WP-CLI (`wp db export`) |
| Complex SQL queries | Raw SSH + mysql CLI |
| Deploy theme/plugin files | rsync via SSH or `./deploy.sh` |
| Site options | WP-CLI (`wp option get/update`) |
| Clear cache | SSH (`rm -rf ~/lscache/*`) |

## Themes

- **developer-portfolio** - Custom portfolio theme (active, tracked in git)
- Other themes (balakumar-dark, twentytwenty*, bedrock, etc.) are on the server but not tracked in git

## Tag Navigation System

The blog uses a **hierarchical tag navigation** that auto-generates from tag names. Tags use `/` as a delimiter to create nested dropdowns (like Obsidian's nested tags).

### Tag Naming Convention

**Format:** `Category/Subcategory/Item`

**Examples:**
- `AI/Agents` → Shows "Agents" under "AI" dropdown
- `Tools/IDE/IntelliJ` → Shows "IntelliJ" under "IDE" under "Tools"
- `Architecture/API/GraphQL` → Shows "GraphQL" under "API" under "Architecture"

### Current Tag Hierarchy

| Top Level | Children |
|-----------|----------|
| **AI** | Agents, LLM, ML, RAG, Tools |
| **Infrastructure** | Kubernetes, Redis, Distributed Systems, Microservices, Databases, Bloom Filters, Sorted Sets |
| **Architecture** | API (GraphQL, gRPC, Protobuf, DGS), System Design, Design Patterns, Software Architecture |
| **Programming** | Go, Java, JavaScript |
| **Tools** | IDE (IntelliJ, Cursor, Windsurf), Plugins, Browser (Firefox, Tampermonkey), Git, GitHub, Developer |
| **Meta** | Projects, Open Source, Workflow, Tips, Crash Course |

### Adding New Tags

When creating new posts, follow these conventions:

1. **Use existing hierarchy** - Check if a parent category exists
2. **Use `/` delimiter** - e.g., `Programming/Python` not `programming-python`
3. **Title Case** - e.g., `AI/Machine Learning` not `ai/machine learning`
4. **Max 3 levels** - e.g., `Tools/IDE/VSCode` (deeper nesting gets unwieldy)

### Theme Files for Tag Navigation

| File | Purpose |
|------|---------|
| `inc/tag-navigation.php` | PHP logic to parse tags and build hierarchy |
| `header.php` | Renders tag nav on blog/archive/single pages |
| `assets/css/main.css` | Dropdown styling (search for `.tag-navigation`) |

### How It Works

1. Tags are fetched via `get_tags()`
2. Tag names are split by `/` to build a tree structure
3. Top-level items appear in the horizontal nav bar
4. Hovering reveals nested children as dropdowns
5. Each tag links to its archive page

## Hosting Provider

- **Type**: Shared hosting with cPanel
- **SSH Access**: Enabled and authorized
- **Server Software**: LiteSpeed (based on wp-json namespaces)
- **OS**: Linux 3.10.0 (CentOS/CloudLinux)
- **PHP**: 8.3.30 (default is CGI; CLI at `/usr/local/bin/php` or `/opt/cpanel/ea-php83/root/usr/bin/php`)
- **MySQL**: MariaDB 10.5.26
- **Custom binaries**: `~/bin/rsync`, `~/bin/wp` (WP-CLI wrapper), `~/bin/wp-cli.phar`

## Project Structure

```
~/personal/balakumar.dev/
├── .env                   # Environment variables (not committed)
├── .gitignore             # Git ignore file
├── .github/workflows/     # CI/CD
│   └── deploy.yml         # Auto-deploy on push to main
├── CLAUDE.md              # This documentation
├── deploy.sh              # Deploy script (rsync to production)
├── docker-compose.yml     # Docker container configuration
├── setup.sh               # Local environment setup script
├── db-data/               # MySQL data (not committed)
├── scripts/               # Setup scripts and SQL backups
│   └── balakuma_blog.sql  # Production database backup
└── wp-content/            # WordPress content
    ├── themes/            # Custom themes (developer-portfolio, balakumar-dark)
    ├── plugins/           # Essential plugins
    └── uploads/           # Media files
```

## Local Development Environment

### Prerequisites
- Docker and Docker Compose
- At least 2GB of free disk space

### Quick Start

```bash
cd ~/personal/balakumar.dev
./setup.sh
```

### Access URLs

| Service | URL |
|---------|-----|
| WordPress | http://localhost:8082 |
| phpMyAdmin | http://localhost:8081 |
| MySQL | localhost:3306 |

### WordPress Admin (Local)

| Field | Value |
|-------|-------|
| **Admin URL** | http://localhost:8082/wp-admin |
| **Username** | `balakumar` |
| **Password** | `password123` |

### Docker Containers

| Container Name | Image | Purpose |
|----------------|-------|---------|
| `wp_wordpress` | wordpress:latest | WordPress application |
| `wp_mysql` | mysql:8.0 | MySQL database server |
| `wp_phpmyadmin` | phpmyadmin:latest | Database admin UI |

### Database Configuration

| Field | Value |
|-------|-------|
| **Host** | `wp_mysql` (inside Docker) / `localhost:3306` (outside) |
| **Database Name** | `wordpress` |
| **Username** | `wordpress` |
| **Password** | `wordpress123` |
| **Root Password** | `rootpassword123` |
| **Table Prefix** | `blog_` |
| **Charset** | `utf8mb4` |

### Core WordPress Tables

| Table | Purpose |
|-------|---------|
| `blog_posts` | All posts and pages |
| `blog_postmeta` | Post metadata (custom fields) |
| `blog_options` | Site settings and configuration |
| `blog_users` | User accounts |
| `blog_usermeta` | User metadata |
| `blog_terms` | Categories and tags |
| `blog_term_taxonomy` | Term relationships |
| `blog_term_relationships` | Post-to-term mappings |
| `blog_comments` | Post comments |
| `blog_commentmeta` | Comment metadata |

### Volume Mounts

| Local Path | Container Path | Purpose |
|------------|----------------|---------|
| `./wp-content/themes/` | `/var/www/html/wp-content/themes/` | Theme files |
| `./wp-content/plugins/` | `/var/www/html/wp-content/plugins/` | Plugin files |
| `./wp-content/uploads/` | `/var/www/html/wp-content/uploads/` | Media uploads |
| `./db-data/` | `/var/lib/mysql` | MySQL data persistence |

### Environment Variables (.env)

```bash
MYSQL_ROOT_PASSWORD=rootpassword123
MYSQL_DATABASE=wordpress
MYSQL_USER=wordpress
MYSQL_PASSWORD=wordpress123
WORDPRESS_TABLE_PREFIX=blog_
WORDPRESS_PORT=8082
PHPMYADMIN_PORT=8081
```

### Common Commands

```bash
# Start the environment
./setup.sh

# Stop containers
docker-compose down

# View logs
docker-compose logs -f

# Access WordPress container shell
docker exec -it wp_wordpress bash

# Access MySQL CLI
docker exec -it wp_mysql mysql -u wordpress -pwordpress123 wordpress

# Restart just WordPress
docker-compose restart wordpress
```

### Syncing from Production (Pull)

Use rsync for all file syncing (installed at `~/bin/rsync` on remote).

```bash
# Pull theme from production
rsync -avz --rsync-path="~/bin/rsync" -e "ssh -i ~/Downloads/wordpress_ssh_key" \
  balakuma@107.161.23.124:/home/balakuma/blog.balakumar.dev/wp-content/themes/developer-portfolio/ \
  wp-content/themes/developer-portfolio/

# Pull uploads from production
rsync -avz --rsync-path="~/bin/rsync" -e "ssh -i ~/Downloads/wordpress_ssh_key" \
  balakuma@107.161.23.124:/home/balakuma/blog.balakumar.dev/wp-content/uploads/ \
  wp-content/uploads/

# Pull all plugins from production
rsync -avz --rsync-path="~/bin/rsync" -e "ssh -i ~/Downloads/wordpress_ssh_key" \
  balakuma@107.161.23.124:/home/balakuma/blog.balakumar.dev/wp-content/plugins/ \
  wp-content/plugins/
```

### Deploying Local Changes to Production (Push)

**Preferred: Use the deploy script:**

```bash
# Deploy all changes (themes + plugins)
./deploy.sh

# Preview what would change (no files modified)
./deploy.sh --dry-run
```

**Manual rsync (if needed):**

```bash
rsync -avz --rsync-path="~/bin/rsync" -e "ssh -i ~/Downloads/wordpress_ssh_key" \
  wp-content/themes/developer-portfolio/ \
  balakuma@107.161.23.124:/home/balakuma/blog.balakumar.dev/wp-content/themes/developer-portfolio/

ssh -i ~/Downloads/wordpress_ssh_key balakuma@107.161.23.124 "rm -rf /home/balakuma/lscache/*"
```

**Note:** Remote rsync is at `~/bin/rsync` (compiled from source on shared hosting). Always use `--rsync-path="~/bin/rsync"` flag.

### CI/CD - GitHub Actions

Pushes to `main` that change files in `wp-content/themes/` or `wp-content/plugins/` auto-deploy via `.github/workflows/deploy.yml`.

**GitHub Secret:** `SSH_PRIVATE_KEY` - contains the SSH private key for production access (already configured).

**Workflow:** checkout → setup SSH key + known_hosts → run `deploy.sh`

### Database Sync (Content Only)

To push local content to production without overwriting settings/users:

```bash
# Export content tables from local Docker
docker exec wp_mysql mysqldump -u wordpress -pwordpress123 wordpress \
  blog_posts blog_postmeta blog_terms blog_term_taxonomy blog_term_relationships \
  --no-create-info --replace > /tmp/wp_content_export.sql

# Fix URLs: localhost:8082 → production
sed -i '' 's|http://localhost:8082|https://blog.balakumar.dev|g' /tmp/wp_content_export.sql

# Import to remote
cat /tmp/wp_content_export.sql | ssh -i ~/Downloads/wordpress_ssh_key balakuma@107.161.23.124 \
  "mysql -u balakuma_blog -p'h1](TSp5U1' balakuma_blog"
```

### Database Backup/Restore via WP-CLI (Preferred)

```bash
SSH_CMD="ssh -i ~/Downloads/wordpress_ssh_key balakuma@107.161.23.124"

# Backup production DB
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp db export ~/backup_\$(date +%Y%m%d).sql"

# Download the backup
scp -i ~/Downloads/wordpress_ssh_key balakuma@107.161.23.124:~/backup_*.sql /tmp/

# Import a backup to production
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp db import ~/backup_file.sql"

# Search-replace URLs (safe for serialized data — ALWAYS use this over sed for WP DB)
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp search-replace 'http://localhost:8082' 'https://blog.balakumar.dev' --dry-run"
# Remove --dry-run to execute
```

### Useful Queries (WP-CLI or MySQL)

**WP-CLI (preferred):**
```bash
SSH_CMD="ssh -i ~/Downloads/wordpress_ssh_key balakuma@107.161.23.124"

# Get site URL
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp option get siteurl"

# Get active theme
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp theme list --status=active --format=table"

# Get active plugins
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp plugin list --status=active --format=table"

# List published posts
$SSH_CMD "cd ~/blog.balakumar.dev && ~/bin/wp post list --post_type=post --post_status=publish --fields=ID,post_title,post_date --format=table"
```

**Raw SQL (for complex queries):**
```sql
-- Get site URL
SELECT option_value FROM blog_options WHERE option_name = 'siteurl';

-- Get all published posts
SELECT ID, post_title, post_date FROM blog_posts WHERE post_status = 'publish' AND post_type = 'post';

-- Get active theme
SELECT option_value FROM blog_options WHERE option_name = 'stylesheet';

-- Get active plugins
SELECT option_value FROM blog_options WHERE option_name = 'active_plugins';

-- Update site URL (if needed)
UPDATE blog_options SET option_value = 'http://localhost:8082' WHERE option_name IN ('siteurl', 'home');
```

### Installed Themes

- **developer-portfolio** - Custom portfolio theme (active)

### Installed Plugins (Tracked in Git)

- **merpress** - MermaidJS diagram support
- **syntaxhighlighter** - Code syntax highlighting
- **wordpress-mcp** - MCP protocol adapter
- **wp-feature-api** - WordPress Feature API

Other plugins (wp-githuber-md, akismet, etc.) are installed on the server but not tracked in git.

### Browser Testing & Automation (Two-Tier)

**When doing any UI/browser work, follow this decision flow:**

1. Check if `.codex/config.toml` has `chrome-devtools` configured in the current project
2. **Not configured** -> run `/browser-mcp-setup` (one-time setup per project)
3. **Already configured** -> use `mcp__chrome-devtools__*` tools directly
4. **Chrome DevTools MCP can't handle it** -> fall back to `agent-browser` CLI

### Chrome DevTools MCP Tools (after setup)

| Tool | Description |
|------|-------------|
| `mcp__chrome-devtools__navigate_page` | Navigate to URLs |
| `mcp__chrome-devtools__take_snapshot` | A11y tree with uids (preferred over screenshot) |
| `mcp__chrome-devtools__take_screenshot` | Visual screenshots |
| `mcp__chrome-devtools__click` / `fill` | Interact with elements by uid |
| `mcp__chrome-devtools__evaluate_script` | Run JS in page |
| `mcp__chrome-devtools__list_console_messages` | Get console output |
| `mcp__chrome-devtools__list_network_requests` | Get network requests |

### Fallback: `agent-browser` CLI (when Chrome DevTools MCP is insufficient)

Use ONLY when Chrome DevTools MCP cannot handle the task:
- Multi-page workflows requiring complex navigation sequences
- Form automation with file uploads or drag-and-drop
- Tasks requiring persistent browser state across multiple sessions
- iOS Simulator testing (Mobile Safari)
- When Chrome DevTools MCP errors out or is unavailable

### Troubleshooting Local Dev

**Port 8082 already in use:**
```bash
# Check what's using the port
lsof -i :8082
# Kill the process or change WORDPRESS_PORT in .env
```

**Database connection errors:**
```bash
# Check MySQL is running
docker ps | grep wp_mysql
# Check logs
docker logs wp_mysql
# Reset database
rm -rf db-data/* && ./setup.sh
```

**Theme/plugin changes not showing:**
```bash
# Restart WordPress to pick up file changes
docker-compose restart wordpress
```

## Future Plans

- [ ] Create custom theme for landing page + portfolio
- [ ] Set up GitHub deployment workflow
- [ ] Migrate to better hosting if needed (Cloudways recommended)

## Troubleshooting

### SSH Connection Failed
1. Check if key is authorized in cPanel → SSH Access → Manage Keys
2. Verify IP hasn't changed: `dig +short blog.balakumar.dev`
3. Test manually: `ssh -i /Users/bkumara/Downloads/wordpress_ssh_key balakuma@107.161.23.124`

### WordPress Not Responding
1. Check if site is up: `curl -I https://blog.balakumar.dev`
2. Test WP-CLI: `ssh -i /Users/bkumara/Downloads/wordpress_ssh_key balakuma@107.161.23.124 "cd ~/blog.balakumar.dev && ~/bin/wp core version"`

---

*Last updated: February 14, 2026*
*WP-CLI 2.12.0 installed at ~/bin/wp on production server*
*Local Docker development environment fully documented*
*Database: wordpress | User: wordpress | Password: wordpress123 | Prefix: blog_*
*Containers: wp_wordpress (8082), wp_mysql (3306), wp_phpmyadmin (8081)*
*Setup by: Claude Code*
