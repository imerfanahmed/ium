#!/bin/bash

# IUM Development Environment Setup Script
set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

print_info() {
    echo -e "${BLUE}[SETUP]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SETUP]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[SETUP]${NC} $1"
}

print_error() {
    echo -e "${RED}[SETUP]${NC} $1"
}

# Get the directory where this script is located
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

print_info "Setting up IUM Development Environment..."
print_info "Working directory: $SCRIPT_DIR"

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    print_error "Docker is not installed. Please install Docker first."
    exit 1
fi

# Check if Docker Compose is installed (modern syntax)
if ! docker compose version &> /dev/null; then
    print_error "Docker Compose is not available. Please install Docker with Compose plugin."
    exit 1
fi

# Make ium script executable
print_info "Making ium script executable..."
chmod +x "$SCRIPT_DIR/ium"

# Install ium globally
print_info "Installing ium CLI globally..."
if [[ -w "/usr/local/bin" ]]; then
    ln -sf "$SCRIPT_DIR/ium" "/usr/local/bin/ium"
    print_success "ium CLI installed to /usr/local/bin/ium"
else
    print_warning "Cannot write to /usr/local/bin. Requesting sudo access..."
    sudo ln -sf "$SCRIPT_DIR/ium" "/usr/local/bin/ium"
    print_success "ium CLI installed to /usr/local/bin/ium (with sudo)"
fi

# Create necessary directories
print_info "Creating directory structure..."
mkdir -p data/mysql data/redis logs/apache

# Set proper permissions
print_info "Setting directory permissions..."
chmod -R 755 www config
chmod -R 777 data logs

# Build and start the containers
print_info "Building and starting Docker containers..."
docker compose build
docker compose up -d

# Wait for services to start
print_info "Waiting for services to start..."
sleep 10

# Check if containers are running
if docker compose ps | grep -q "Up"; then
    print_success "Containers are running successfully!"
else
    print_error "Some containers failed to start. Check logs with: docker compose logs"
    exit 1
fi

# Update hosts file
print_info "Updating hosts file with application domains..."
ium reload

# Show status
print_success "IUM Development Environment setup complete!"
echo ""
print_info "Available services:"
echo "  • Web Server: http://localhost"
echo "  • phpMyAdmin: http://localhost:8080"
echo "  • Mailpit: http://localhost:8025"
echo "  • MariaDB: localhost:3306 (root/root)"
echo "  • Redis: localhost:6379"
echo ""
print_info "Sample applications:"
echo "  • http://app1.local (PHP 7.4)"
echo "  • http://rms.local (PHP 7.4)"
echo "  • http://app3.local (PHP 8.4)"
echo "  • http://app4.local (PHP 8.4)"
echo ""
print_info "CLI Usage:"
echo "  • ium wake            - Start development environment"
echo "  • ium sleep           - Stop development environment"
echo "  • ium reborn          - Rebuild containers from scratch"
echo "  • ium status          - Show environment status"
echo "  • ium php -v          - Show PHP version (auto-detected)"
echo "  • ium composer install - Install dependencies"
echo "  • ium reload          - Update hosts file"
echo ""
print_warning "Note: You may need to restart your browser to use .local domains"
