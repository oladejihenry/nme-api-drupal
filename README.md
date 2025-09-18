# NME News API Drupal Platform

A modern Drupal 11 platform featuring a custom NME News API module that fetches and displays the latest news from NME (New Musical Express) with beautiful Tailwind CSS styling.

![NME News Drupal Platform](https://cdn.fortiplacecdn.com/Screenshot%202025-09-18%20at%2017.19.08.png)

## Features

- **Custom NME News Module** - Fetches latest news from NME API
- **Responsive Design** - Modern UI with Tailwind CSS
- **Advanced Caching** - 1-hour cache for optimal performance
- **Block System** - Flexible block placement in any region
- **Admin Configuration** - Easy settings management
- **Error Handling** - Graceful fallbacks and logging
- **DDEV Integration** - Local development environment
- **CI/CD Ready** - GitHub Actions workflow included

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- [DDEV](https://ddev.readthedocs.io/en/stable/users/install/) (latest version)
- [Git](https://git-scm.com/downloads)
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/) (optional, for frontend tools)

## 🛠️ Installation

### 1. Clone the Repository

```bash
git clone https://github.com/oladejihenry/nme-api-drupal.git
cd nme-api-drupal
```

### 2. Environment Setup

Copy the environment example file and configure your settings:

```bash
cp .env.example .env
```

Edit the `.env` file with your preferred settings:

```env
# Database Configuration
DB_NAME=drupal
DB_USER=drupal
DB_PASSWORD=drupal
DB_HOST=db
DB_PORT=3306

# Site Configuration
SITE_NAME="NME News Platform"
SITE_MAIL=admin@example.com
ADMIN_USER=admin
ADMIN_PASSWORD=admin

# API Configuration
NME_API_URL=https://www.nme.com/wp-json/wp/v2/posts/
NME_CACHE_DURATION=3600
NME_ARTICLES_PER_PAGE=12
```

### 3. Start DDEV Environment

```bash
ddev start
```

This will:

- Download and configure the Docker containers
- Set up the database
- Install PHP dependencies via Composer
- Configure the web server

### 4. Install Drupal

```bash
# Install Drupal with default settings
ddev drush site:install --site-name="NME News Platform" --account-name=admin --account-pass=admin --account-mail=admin@example.com -y

# Clear cache
ddev drush cr
```

### 5. Enable the NME News Module

```bash
# Enable the custom module
ddev drush en nme_news -y

# Clear cache again
ddev drush cr
```

## Setup Instructions

### Database Configuration

The database is automatically configured by DDEV. The default settings are:

- **Database Name**: `db`
- **Username**: `db`
- **Password**: `db`
- **Host**: `db`
- **Port**: `3306`

These settings are configured in `web/sites/default/settings.ddev.php` and are automatically loaded when using DDEV.

### Accessing Your Site

After installation, you can access your site at:

- **Frontend**: `https://nme-api-drupal.ddev.site`
- **Admin Panel**: `https://nme-api-drupal.ddev.site/admin`
- **Login**: admin / admin

## 📰 NME News Module Setup

### 1. Place the News Block

1. Log in to your Drupal admin panel
2. Navigate to **Structure** → **Block layout**
3. Click **Place block** in your desired region (e.g., Content, Sidebar)
4. Find **"NME News Block"** in the list
5. Click **Place block**
6. Configure the block settings:
   - **Block title**: "Latest News from NME"
   - **Region**: Choose your preferred region
   - **Visibility**: Configure as needed
7. Click **Save block**

### 2. Configure Module Settings

1. Navigate to **Configuration** → **Content authoring** → **NME News**
2. Adjust the following settings:
   - **Articles per page**: Number of articles to display (default: 12)
   - **Cache duration**: How long to cache articles (default: 1 hour)
3. Click **Save configuration**

### 3. View the News Feed

Visit your site's front page to see the NME news feed in action. The block will display:

- Latest news articles from NME
- Article thumbnails
- Publication dates
- Article excerpts
- "Read More" links to full articles

## Customization

### Styling

The module uses Tailwind CSS for styling. You can customize the appearance by:

1. **Modifying Templates**: Edit files in `web/modules/custom/nme_news/templates/`
2. **CSS Overrides**: Add custom CSS in your theme
3. **Tailwind Configuration**: Modify the Tailwind classes in the templates

### Block Configuration

The NME News Block supports various configuration options:

- **Articles per page**: Control how many articles to display
- **Cache duration**: Adjust caching behavior
- **Region placement**: Place in any Drupal region
- **Visibility rules**: Show/hide based on pages, roles, etc.

## Development

### Local Development Commands

```bash
# Start the development environment
ddev start

# Stop the environment
ddev stop

# Access the database
ddev mysql

# Run Drush commands
ddev drush [command]

# Access the container shell
ddev ssh

# View logs
ddev logs
```

### Useful Drush Commands

```bash
# Clear all caches
ddev drush cr

# Enable/disable modules
ddev drush en module_name -y
ddev drush pm:uninstall module_name -y

# Export/import configuration
ddev drush config:export
ddev drush config:import

# Update database
ddev drush updatedb

# Generate login URL
ddev drush user:login
```

### Code Structure

```bash
web/modules/custom/nme_news/
├── nme_news.info.yml # Module information
├── nme_news.module # Module hooks and theme functions
├── nme_news.services.yml # Service definitions
├── nme_news.libraries.yml # CSS/JS libraries
├── nme_news.routing.yml # Route definitions
├── nme_news.links.menu.yml # Menu links
├── src/
│ ├── Service/
│ │ └── NmeNewsService.php # API service class
│ ├── Plugin/Block/
│ │ └── NmeNewsBlock.php # Block plugin
│ └── Form/
│ └── NmeNewsConfigForm.php # Configuration form
└── templates/
├── nme-news-block.html.twig # Block template
└── nme-news-article.html.twig # Article template
```

## 🧪 Testing

### Running Tests

```bash
# Run unit tests
ddev exec phpunit web/modules/custom/nme_news/tests/src/Unit/

# Run functional tests
ddev exec phpunit web/modules/custom/nme_news/tests/src/Functional/

# Run all tests
ddev exec phpunit web/modules/custom/nme_news/tests/
```

### Test Coverage

The module includes comprehensive tests:

- **Unit Tests**: Service class methods and caching
- **Functional Tests**: Block placement and configuration
- **Integration Tests**: End-to-end workflows

## 🚀 Deployment

### Production Deployment

1. **Environment Setup**:

   ```bash
   # Set production environment
   export ENVIRONMENT=production

   # Install dependencies
   composer install --no-dev --optimize-autoloader
   ```

2. **Database Configuration**:

   - Update `web/sites/default/settings.php` with production database credentials
   - Ensure proper file permissions

3. **Cache Optimization**:
   ```bash
   drush cr
   drush config:import
   ```

### CI/CD Pipeline

The project includes a GitHub Actions workflow (`.github/workflows/deploy.yml`) that:

- Runs tests on pull requests
- Deploys to production
- Handles database updates
- Clears caches

## 📊 Performance

### Caching Strategy

The module implements a multi-layer caching approach:

1. **API Response Caching**: 1-hour cache for API responses
2. **Block Caching**: Drupal block-level caching
3. **Page Caching**: Full page caching for anonymous users

### Optimization Features

- **Lazy Loading**: Images load only when needed
- **Responsive Images**: Optimized for different screen sizes
- **Minified Assets**: Compressed CSS and JavaScript
- **CDN Ready**: External asset loading

## 🐛 Troubleshooting

### Common Issues

1. **Module Not Appearing**:

   ```bash
   ddev drush cr
   ddev drush en nme_news -y
   ```

2. **API Errors**:

   - Check network connectivity
   - Verify API endpoint is accessible
   - Check logs: `ddev drush watchdog:show --type=nme_news`

3. **Styling Issues**:

   - Clear cache: `ddev drush cr`
   - Check if Tailwind CSS is loading
   - Verify template files are in place

4. **Database Connection Issues**:
   ```bash
   ddev restart
   ddev drush status
   ```

### Debug Mode

Enable debug mode for development:

```bash
# Enable verbose logging
ddev drush config:set system.logging error_level verbose

# View recent log entries
ddev drush watchdog:show --count=50
```

## 📚 API Documentation

### NME API Endpoints

The module integrates with the NME WordPress REST API:

- **Latest Posts**: `https://www.nme.com/wp-json/wp/v2/posts/?per_page=12`
- **Single Post**: `https://www.nme.com/wp-json/wp/v2/posts/{id}`

### Response Format

```json
{
  "id": 3892889,
  "date": "2025-09-16T13:09:30",
  "title": {
    "rendered": "Article Title"
  },
  "content": {
    "rendered": "Article content..."
  },
  "link": "https://www.nme.com/news/article-url",
  "thumbnail_url": "https://www.nme.com/wp-content/uploads/image.jpg"
}
```

### Development Guidelines

- Follow Drupal coding standards
- Write tests for new features
- Update documentation
- Use meaningful commit messages

## License

This project is licensed under the GPL-2.0-or-later License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- [Drupal](https://www.drupal.org/) - The CMS platform
- [NME](https://www.nme.com/) - News API source
- [Tailwind CSS](https://tailwindcss.com/) - Styling framework
- [DDEV](https://ddev.readthedocs.io/) - Local development environment

## 📞 Support

For support and questions:

- **Issues**: [GitHub Issues](https://github.com/oladejihenry/nme-api-drupal/issues)
- **Documentation**: [Drupal Documentation](https://www.drupal.org/docs)
- **Community**: [Drupal Slack](https://www.drupal.org/slack)

---

**Built with ❤️ using Drupal 11**
