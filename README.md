# NuvisAccounting™

[![Release](https://img.shields.io/github/v/release/nuvisaccounting/nuvisaccounting?label=release)](https://github.com/nuvisaccounting/nuvisaccounting/releases)
![Downloads](https://img.shields.io/github/downloads/nuvisaccounting/nuvisaccounting/total?label=downloads)
[![Tests](https://img.shields.io/github/actions/workflow/status/nuvisaccounting/nuvisaccounting/tests.yml?label=tests)](https://github.com/nuvisaccounting/nuvisaccounting/actions)

Online accounting software designed for small businesses and freelancers. NuvisAccounting is built with modern technologies such as Laravel, VueJS, Tailwind, RESTful API etc. Thanks to its modular structure, NuvisAccounting provides an awesome App Store for users and developers.

* [Home](https://nuvisaccounting.com) - The house of NuvisAccounting
* [Forum](https://nuvisaccounting.com/forum) - Ask for support
* [Documentation](https://nuvisaccounting.com/hc/docs) - Learn how to use
* [Developer Portal](https://developer.nuvisaccounting.com) - Generate passive income
* [App Store](https://nuvisaccounting.com/apps) - Extend your NuvisAccounting

## Requirements

* PHP 8.1 or higher
* Database (e.g.: MariaDB, MySQL, PostgreSQL, SQLite)
* Web Server (eg: Apache, Nginx, IIS)
* [Other libraries](https://nuvisaccounting.com/hc/docs/on-premise/requirements/)

## Framework

NuvisAccounting uses [Laravel](http://laravel.com), the best existing PHP framework, as the foundation framework and [Module](https://github.com/nuvisaccounting/module) package for Apps.

## Installation

* Clone the repository: `git clone https://github.com/nuvisaccounting/nuvisaccounting.git`
* Install dependencies: `composer install ; npm install ; npm run dev`
* Install NuvisAccounting:

```bash
php artisan install --db-name="nuvisaccounting" --db-username="root" --db-password="pass" --admin-email="admin@company.com" --admin-password="123456"
```

* Create sample data (optional): `php artisan sample-data:seed`

## Contributing

Please, be very clear on your commit messages and Pull Requests, empty Pull Request messages may be rejected without reason.

When contributing code to NuvisAccounting, you must follow the PSR coding standards. The golden rule is: Imitate the existing NuvisAccounting code.

Please note that this project is released with a [Contributor Code of Conduct](https://nuvisaccounting.com/conduct). *By participating in this project you agree to abide by its terms*.

## Changelog

Please see [Releases](../../releases) for more information about what has changed recently.

## Security

Please review [our security policy](https://github.com/nuvisaccounting/nuvisaccounting/security/policy) on how to report security vulnerabilities.

## Credits

* [Denis Duliçi](https://github.com/denisdulici)
* [Cüneyt Şentürk](https://github.com/cuneytsenturk)
* [All Contributors](../../contributors)

## License

NuvisAccounting is released under the [BSL license](LICENSE.txt).
