# NuvisAccounting™

[![Release](https://img.shields.io/github/v/release/nuvisaccounting/nuvisaccounting?label=release)](https://github.com/nuvisaccounting/nuvisaccounting/releases)
![Downloads](https://img.shields.io/github/downloads/nuvisaccounting/nuvisaccounting/total?label=downloads)
[![Tests](https://img.shields.io/github/actions/workflow/status/nuvisaccounting/nuvisaccounting/tests.yml?label=tests)](https://github.com/nuvisaccounting/nuvisaccounting/actions)

Online accounting software designed for small businesses and freelancers. NuvisAccounting is built with modern technologies such as Laravel, VueJS, Tailwind, RESTful API etc. Thanks to its modular structure, NuvisAccounting provides an awesome App Store for users and developers.

* [Home](https://nuvistechnologies.com.fj/accounting) - NuvisAccounting
* [Support & Documentation](https://nuvistechnologies.com.fj/accounting) - Learn how to use

## Requirements

* PHP 8.1 or higher
* Database (e.g.: MariaDB, MySQL, PostgreSQL, SQLite)
* Web Server (e.g.: Apache, Nginx, IIS)

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

## Changelog

Please see [Releases](../../releases) for more information about what has changed recently.

## Security

Please review [our security policy](SECURITY.md) on how to report security vulnerabilities or contact `accounting@nuvistechnologies.com.fj`.

## Credits

* Nuvis Technologies
* Nilesh Chandrra


## License

NuvisAccounting is released under the [BSL license](LICENSE.txt).
