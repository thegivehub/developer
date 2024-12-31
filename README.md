# The Give Hub Developer Portal 🌍

The official developer portal for The Give Hub platform. This portal provides documentation, tools, and resources for developers integrating with The Give Hub's APIs and services to help make global impact through technology.

## 🚀 Overview

The Give Hub Developer Portal is built with:
- 📱 Vanilla JavaScript for frontend interactivity
- ⚡ PHP backend for API handling and developer registration
- 💾 MySQL/MariaDB for data storage
- 🔗 Stellar blockchain integration via Soroban smart contracts

## 🏁 Getting Started

### 📋 Prerequisites

- PHP 8.1 or higher
- MySQL/MariaDB 10.4 or higher
- Node.js 18+ (for build tools)
- Composer

### 💻 Installation

1. Clone the repository:
```bash
git clone https://github.com/thegivehub/developer-portal.git
cd developer-portal
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Copy the example configuration:
```bash
cp config.example.php config.php
```

4. Create the database and run migrations:
```bash
mysql -u root -p
CREATE DATABASE givehub_dev;
exit;
php migrations/run.php
```

5. Start the development server:
```bash
php -S localhost:8000
```

The portal should now be accessible at `http://localhost:8000` 🎉

## 📁 Project Structure

```
├── api/                  # API endpoints
│   └── developer/       # Developer-specific endpoints
├── lib/                 # PHP library files
├── public/              # Static assets
│   ├── css/
│   ├── js/
│   └── img/
├── templates/           # HTML templates
├── migrations/          # Database migrations
├── tests/              # Test files
└── config.php          # Configuration file
```

## ✨ Features

- 📚 Interactive API Documentation
- 🔑 Developer Registration System
- 🎮 API Key Management
- 📊 Usage Analytics Dashboard
- 🏗️ Sandbox Environment
- 🔔 Webhook Configuration
- 🔒 OAuth 2.0 Integration
- ⛓️ Stellar Network Integration

## ⚙️ Configuration

Key configuration options in `config.php`:

```php
// Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'givehub_dev');
define('DB_USER', 'your_user');
define('DB_PASS', 'your_password');

// API Settings
define('API_RATE_LIMIT', 1000);
define('API_VERSION', 'v1');

// Stellar Network
define('STELLAR_NETWORK', 'testnet'); // or 'public'
```

## 👩‍💻 Development

### 🎨 Code Style

We follow PSR-12 for PHP code style. You can check your code with:

```bash
composer run-script check-style
```

### 🧪 Running Tests

```bash
composer test
```

### 📖 Building Documentation

The documentation is built using markdown files in the `docs/` directory. To build:

```bash
npm run build-docs
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and pull request process.

## 📚 API Reference

Full API documentation is available at [https://developers.givehub.org/docs](https://developers.givehub.org/docs)

Quick links:
- 🔐 [Authentication](/docs/auth.md)
- 📢 [Campaigns](/docs/campaigns.md)
- 💰 [Donations](/docs/donations.md)
- 🔔 [Webhooks](/docs/webhooks.md)

## 💬 Support

- 💻 [Developer Forum](https://developers.givehub.org/forum)
- 🎮 [Discord Community](https://discord.gg/givehub)
- ✉️ Email: developer-support@givehub.org

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🔒 Security

Please report security vulnerabilities to security@givehub.org. We have a responsible disclosure policy and will work with you to address any issues.
