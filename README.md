# WebEngine CMS 2.0 BETA 3

Open source Content Management System for Mu servers. WebEngine's goal is to provide a fast and secure framework for server owners to create and implement their own features to the CMS.

## Getting Started

These instructions will help you deploy your own copy of the CMS. Please note that WebEngine 2.0 is currently in BETA and it is not recommended to use the CMS in a production website.

### Prerequisites

Here's what you need to run WebEngine 2.0

* Apache mod_rewrite
* PHP 5.4 or higher
* PHP PDO dblib and sqlite3
* cURL

### Installing

An installer will be included with the first stable release of the project, for the time being you may install the CMS by following these instructions.

1. Upload and extract the BETA 3 release on your host
2. Open WebEngine's configuration file `/includes/config/webengine.json`
3. Change the following settings:
    * `offline_mode` set to `false`
    * `SQL_DB_HOST` your MSSQL host
    * `SQL_DB_NAME` your MuOnline database name
    * `SQL_DB_2_NAME` your Me_MuOnline database name
    * `SQL_DB_USER` your SQL user
    * `SQL_DB_PASS` your SQL password
    * `SQL_DB_PORT` your SQL port (commonly 1433)
    * `SQL_USE_2_DB` set to `true` if using Me_MuOnline
    * `SQL_PDO_DRIVER` `1 = dblib, 2 = sqlsrv, 3 = odbc`
    * `SQL_ENABLE_MD5` set to `true` if you're using MD5
4. Make sure the following paths and files are writable (recursively) `chmod to 0777`
    * `/includes/cache/`
    * `/includes/config/`
    * `/includes/webengine.db`
5. Add the master cron job `/includes/cron/cron.php` to run `once per minute`

### Getting Access to the Admin Panel

By default, the user `webengine` will have access to the admin panel. If you don't have such account created you may use the registration form to create the account with username `webengine` and then proceed to access the admin panel.

You will be able to add, edit and remove users' access once inside the admin panel.

## Other Software

WebEngine 2.0 wouldn't be possible without following awesome open source projects.

* [Hybridauth](https://github.com/hybridauth/hybridauth)
* [SweetAlert2](https://github.com/limonte/sweetalert2)
* [CodeMirror](https://github.com/codemirror/CodeMirror)
* [PHPMailer](https://github.com/PHPMailer/PHPMailer/)
* [Light Bootstrap Dashboard](https://www.creative-tim.com/product/light-bootstrap-dashboard)
* [Bootstrap](https://getbootstrap.com/)
* [jQuery](http://jquery.com/)

## Versioning

We use [SemVer](http://semver.org/) for versioning. 

## Authors

* **Lautaro Angelico** - *Developer*

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

## Support

### Official Discord Server
[WebEngine CMS Official Discord](https://webenginecms.org/discord)

### WebEngine Community Support Forum
[WebEngine Support Forum](https://forum.webenginecms.org/)
