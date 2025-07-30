# IUM Development Environment

A comprehensive PHP development environment using Docker Compose with support for multiple PHP versions, intelligent routing, and custom CLI tools.

## Features

- **Multi-PHP Support**: PHP 7.4 and 8.4 with intelligent version detection
- **Custom Domains**: `.local` TLD support (app1.local, rms.local, etc.)
- **Intelligent CLI**: `ium` command for context-aware PHP execution
- **Complete Stack**: Apache, MariaDB, Redis, Mailpit, phpMyAdmin
- **Easy Configuration**: Host-mounted config volumes for easy customization
- **Data Persistence**: Separate data volumes for databases and caches

## Quick Start

1. **Setup Environment**:
   ```bash
   chmod +x setup.sh
   ./setup.sh
   ```

2. **Access Applications**:
   - http://app1.local (PHP 7.4)
   - http://rms.local (PHP 7.4)
   - http://app3.local (PHP 8.4)
   - http://app4.local (PHP 8.4)

3. **Development Services**:
   - phpMyAdmin: http://localhost:8080
   - Mailpit: http://localhost:8025
   - MariaDB: localhost:3306 (root/root)
   - Redis: localhost:6379

## Directory Structure

```
ium/
├── docker-compose.yml          # Main Docker Compose configuration
├── Dockerfile.php-apache       # Custom PHP/Apache image
├── setup.sh                    # Automated setup script
├── ium                         # CLI tool
├── www/                        # Web applications
│   ├── find-app.php           # App discovery utility
│   ├── php74/                 # PHP 7.4 applications
│   │   ├── app1/
│   │   └── rms/
│   └── php84/                 # PHP 8.4 applications
│       ├── app3/
│       └── app4/
├── config/                     # Configuration files
│   ├── apache/                # Apache virtual hosts
│   ├── php74/                 # PHP 7.4 configuration
│   ├── php84/                 # PHP 8.4 configuration
│   ├── mysql/                 # MariaDB configuration
│   ├── redis/                 # Redis configuration
│   ├── phpmyadmin/           # phpMyAdmin configuration
│   └── supervisor/           # Process supervisor
├── data/                      # Persistent data
│   ├── mysql/                # MariaDB data
│   └── redis/                # Redis data
└── logs/                     # Log files
    └── apache/               # Apache logs
```

## IUM CLI Tool

The `ium` command provides intelligent command execution based on your current directory:

### Basic Usage

```bash
# Show PHP version (auto-detected from directory)
ium php -v

# Run Laravel Artisan commands
cd www/php74/app1
ium php artisan about

# Install Composer dependencies
ium composer install

# Install NPM dependencies
ium npm install

# Run any shell command
ium ls -la
ium git status
ium bash

# Run any PHP script
ium php script.php
```

### Special Commands

```bash
# Container management
ium wake                      # Start all containers
ium sleep                     # Stop all containers
ium reborn                    # Rebuild containers from scratch

# Update hosts file with .local domains
ium reload

# Show environment status
ium status

# Show help
ium help
```

### How It Works

1. **Version Detection**: Automatically detects PHP version from directory path
2. **Container Execution**: Routes commands to appropriate PHP environment in container
3. **Working Directory**: Maintains correct working directory context
4. **Command Intelligence**: Automatically handles PHP and Composer commands with correct versions
5. **Domain Management**: Automatically manages `.local` domain entries in hosts file

## Services Configuration

### PHP Versions

- **PHP 7.4**: Located in `/www/php74/`
- **PHP 8.4**: Located in `/www/php84/`

Both versions include common extensions:
- MySQL/MariaDB support
- Redis support
- GD, cURL, mbstring, XML, JSON
- Composer pre-installed

### Apache Routing

Apache intelligently routes requests based on:
1. Directory structure (`/php74/` → PHP 7.4, `/php84/` → PHP 8.4)
2. Custom `.local` domains (automatic app discovery)
3. Fallback app finder for flexible routing

### Database

- **MariaDB**: Latest version with UTF8MB4 support
- **Default Database**: `ium_default`
- **Credentials**: root/root, ium_user/ium_password
- **Port**: 3306

### Caching

- **Redis**: Alpine version with custom configuration
- **Port**: 6379
- **Persistence**: Enabled with both RDB and AOF

### Email Testing

- **Mailpit**: Modern email testing tool
- **SMTP**: Port 1025
- **Web Interface**: http://localhost:8025

## Development Workflow

### Adding New Applications

1. **Create Directory**:
   ```bash
   mkdir -p www/php84/mynewapp
   ```

2. **Add Application Files**:
   ```bash
   echo "<?php phpinfo(); ?>" > www/php84/mynewapp/index.php
   ```

3. **Update Hosts**:
   ```bash
   ium reload
   ```

4. **Access Application**:
   - http://mynewapp.local

### Managing Configuration

All configuration files are mounted from the `config/` directory:

- **Apache**: `config/apache/`
- **PHP Settings**: `config/php74/` and `config/php84/`
- **Database**: `config/mysql/`
- **Redis**: `config/redis/`

Edit these files and restart services:
```bash
docker compose restart
```

### Working with Different PHP Versions

Navigate to the appropriate directory and use `ium`:

```bash
# PHP 7.4 environment
cd www/php74/app1
ium php -v                    # Shows PHP 7.4.x
ium composer install         # Uses PHP 7.4

# PHP 8.4 environment
cd www/php84/app3
ium php -v                    # Shows PHP 8.4.x
ium php artisan migrate      # Uses PHP 8.4
```

## Docker Commands

### Service Management

```bash
# Start all services
docker compose up -d

# Stop all services
docker compose down

# Restart services
docker compose restart

# View logs
docker compose logs -f

# Rebuild containers
docker compose build --no-cache
```

### Individual Service Control

```bash
# Restart specific service
docker compose restart php-apache

# View service logs
docker compose logs -f mariadb

# Execute commands in container
docker compose exec php-apache bash
```

## Troubleshooting

### Common Issues

1. **Port Conflicts**:
   - Check if ports 80, 3306, 6379, 8080, 8025 are available
   - Stop conflicting services or modify ports in docker-compose.yml

2. **Permission Issues**:
   - Ensure proper ownership of www/ directory
   - Run: `sudo chown -R $USER:$USER www/`

3. **Domain Not Working**:
   - Run `ium reload` to update hosts file
   - Clear browser cache and restart browser

4. **Container Won't Start**:
   - Check logs: `docker-compose logs`
   - Rebuild: `docker-compose build --no-cache`

### Logs Location

- **Apache**: `logs/apache/`
- **PHP-FPM**: Inside container at `/var/log/`
- **Docker**: `docker-compose logs`

## Security Notes

- This environment is designed for **development only**
- Default passwords are used (change for production)
- Services are exposed on localhost only
- SSL is not configured by default

## Contributing

1. Fork the repository
2. Create feature branch
3. Test thoroughly
4. Submit pull request

## License

This project is open source. Feel free to modify and distribute.

---

For additional help, run `ium help` or check the Docker Compose logs.
