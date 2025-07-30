#!/bin/bash

# IUM Container Rebuild Script
# Use this script when you need to rebuild containers after Dockerfile changes

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

echo "Rebuilding IUM containers..."

# Stop existing containers
echo "Stopping existing containers..."
docker compose down

# Remove existing images to force rebuild
echo "Removing existing images..."
docker compose build --no-cache

# Start containers
echo "Starting containers..."
docker compose up -d

# Wait for services to start
echo "Waiting for services to initialize..."
sleep 10

# Test PHP versions
echo "Testing PHP installations..."
docker exec ium-php-apache php7.4 --version
docker exec ium-php-apache php8.4 --version

# Test Composer
echo "Testing Composer..."
docker exec ium-php-apache php7.4 /usr/local/bin/composer --version
docker exec ium-php-apache php8.4 /usr/local/bin/composer --version

echo "Rebuild complete!"
