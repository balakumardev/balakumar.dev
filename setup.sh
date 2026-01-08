#!/bin/bash

# WordPress Local Development Setup Script
# This script sets up the local WordPress environment

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

# Load environment variables
source .env

echo "=========================================="
echo "WordPress Local Development Setup"
echo "=========================================="

# Step 1: Stop any existing containers
echo ""
echo "[1/6] Stopping existing containers..."
docker-compose down 2>/dev/null || true

# Step 2: Start the containers
echo ""
echo "[2/6] Starting Docker containers..."
docker-compose up -d db phpmyadmin

# Step 3: Wait for MySQL to be ready
echo ""
echo "[3/6] Waiting for MySQL to be ready..."
max_attempts=30
attempt=0
while ! docker exec wp_mysql mysql -u "${MYSQL_USER}" -p"${MYSQL_PASSWORD}" -e "SELECT 1" 2>/dev/null; do
    attempt=$((attempt + 1))
    if [ $attempt -ge $max_attempts ]; then
        echo "ERROR: MySQL failed to start after ${max_attempts} attempts"
        exit 1
    fi
    echo "  Waiting for MySQL... (attempt $attempt/$max_attempts)"
    sleep 2
done
echo "  MySQL is ready!"

# Step 4: Check if database needs import
echo ""
echo "[4/6] Checking database..."
TABLE_COUNT=$(docker exec wp_mysql mysql -u "${MYSQL_USER}" -p"${MYSQL_PASSWORD}" -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='${MYSQL_DATABASE}';" 2>/dev/null || echo "0")

if [ "$TABLE_COUNT" -eq "0" ] || [ "$TABLE_COUNT" = "0" ]; then
    echo "  Database is empty. Importing..."
    if [ -f "scripts/balakuma_blog.sql" ]; then
        docker exec -i wp_mysql mysql -u "${MYSQL_USER}" -p"${MYSQL_PASSWORD}" "${MYSQL_DATABASE}" < scripts/balakuma_blog.sql
        echo "  Database imported successfully!"
    else
        echo "  WARNING: SQL file not found at scripts/balakuma_blog.sql"
        echo "  WordPress will create a fresh installation."
    fi
else
    echo "  Database already has $TABLE_COUNT tables. Skipping import."
fi

# Step 5: Start WordPress container
echo ""
echo "[5/6] Starting WordPress container..."
docker-compose up -d wordpress

# Wait for WordPress to be ready
echo "  Waiting for WordPress to initialize..."
sleep 5

# Step 6: Run URL replacement (using blog_ table prefix from production)
echo ""
echo "[6/6] Replacing URLs in database..."

# Direct SQL replacement with blog_ table prefix
docker exec -i wp_mysql mysql -u "${MYSQL_USER}" -p"${MYSQL_PASSWORD}" "${MYSQL_DATABASE}" << EOF
UPDATE blog_options SET option_value = REPLACE(option_value, 'https://blog.balakumar.dev', '${LOCAL_SITE_URL}') WHERE option_name IN ('siteurl', 'home');
UPDATE blog_posts SET guid = REPLACE(guid, 'https://blog.balakumar.dev', '${LOCAL_SITE_URL}');
UPDATE blog_posts SET post_content = REPLACE(post_content, 'https://blog.balakumar.dev', '${LOCAL_SITE_URL}');
UPDATE blog_postmeta SET meta_value = REPLACE(meta_value, 'https://blog.balakumar.dev', '${LOCAL_SITE_URL}') WHERE meta_value LIKE '%blog.balakumar.dev%';
EOF
echo "  URL replacement completed!"

echo ""
echo "=========================================="
echo "Setup Complete!"
echo "=========================================="
echo ""
echo "Access your local WordPress:"
echo "  - WordPress:  ${LOCAL_SITE_URL}"
echo "  - phpMyAdmin: http://localhost:${PHPMYADMIN_PORT}"
echo ""
echo "Database credentials:"
echo "  - Host: localhost:3306"
echo "  - Database: ${MYSQL_DATABASE}"
echo "  - User: ${MYSQL_USER}"
echo "  - Password: ${MYSQL_PASSWORD}"
echo ""
echo "To stop the environment:"
echo "  docker-compose down"
echo ""
echo "To view logs:"
echo "  docker-compose logs -f"
echo ""
