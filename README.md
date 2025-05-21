<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel Real-Time Messaging Application

A modern real-time messaging application built with Laravel, featuring Google OAuth authentication, real-time chat capabilities, and a dark/light theme toggle.

## Features

- 🔐 User authentication with Google OAuth
- 💬 Real-time messaging
- 🔍 User search functionality
- 🌓 Dark/Light theme toggle
- 📱 Responsive design
- 📧 Contact form
- 🎨 Tailwind CSS styling

## Requirements

- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- Node.js & NPM
- Google OAuth credentials

## Installation

1. **Clone the repository**
```bash
git clone https://github.com/YOUR_USERNAME/messenger-app-2.git
cd messenger-app-2
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install NPM dependencies**
```bash
npm install
```

4. **Configure environment variables**
```bash
cp .env.example .env
```

Update the following variables in your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=messenger_app_1
DB_USERNAME=your_username
DB_PASSWORD=your_password

GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI="http://127.0.0.1:8000/auth/google/callback"
```

5. **Generate application key**
```bash
php artisan key:generate
```

6. **Run database migrations**
```bash
php artisan migrate
```

7. **Build assets**
```bash
npm run build
```

8. **Start the development server**
```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`

## Google OAuth Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com)
2. Create a new project or select existing project
3. Enable the Google+ API
4. Go to Credentials
5. Create OAuth 2.0 Client ID
6. Add authorized redirect URIs:
   - `http://127.0.0.1:8000/auth/google/callback`
7. Copy Client ID and Client Secret to your `.env` file

## Directory Structure

```plaintext
messenger-app-2/
├── app/                    # Application core code
│   ├── Http/              # Controllers and Middleware
│   └── Models/            # Eloquent models
├── database/              # Database migrations and seeders
├── public/               # Publicly accessible files
├── resources/            # Views, assets, and language files
│   ├── css/             # Stylesheets
│   ├── js/              # JavaScript files
│   └── views/           # Blade templates
└── routes/              # Application routes
```

## Available Routes

- `/` - Welcome page
- `/login` - Login page
- `/register` - Registration page
- `/dashboard` - User dashboard
- `/messages` - Messages index
- `/messages/{user}` - Individual chat
- `/contact` - Contact form
- `/profile` - User profile

## Development

Watch for changes and recompile assets:
```bash
npm run dev
```

## Testing

Run PHP tests:
```bash
php artisan test
```

## Security

- All routes except welcome and contact are protected by authentication
- Google OAuth is used for secure authentication
- CSRF protection is enabled
- XSS protection is implemented
- Sensitive data is kept in `.env` file

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

## Authors

- Your Name - Initial work

## Acknowledgments

- Laravel Framework
- Tailwind CSS
- Alpine.js
- Google OAuth

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
