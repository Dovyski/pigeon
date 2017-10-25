<img src="./img/pigeon.png" align="right" title="Pigeon" />

# Pigeon

Pigeon is an easy and hassle-free PHP microservice for sending e-mails via HTTP requests. It values simplicity over a rich feature set and is intended for small, in-house projects that require e-mail sending.

## Getting started

These instructions will get you a copy of Pigeon up and running on your machine.

### Prerequisites

You need [PHP](https://php.net) to run Pigeon. If you indent to use its SMTP funcionality, you will need [composer](https://getcomposer.org/) and access to a SMTP server you can dispatch messages to.

### Installing

Clone Pigeon's repository in a folder of your web server's document root (e.g. `/var/www/`):

```
git clone https://github.com/Dovyski/pigeon.git pigeon
```

At this point Pigeon is ready for use relying on the existing e-mail infra-instructure of the machine. If you intend to use its SMPT capabilities, you need to download a few dependencies.

In the folder where you cloned Pigeon, run:

```
composer install
```

### Configuring

Pigeon has a default configuration file named `config.php`. The best practice is to create a local configuration file named `config.local.php` that overrides only the directives you need.

Go to the folder where Pigeon is and create your local configuration file:

```
cp config.php config.local.php
```

Next edit `config.local.php` with your needs, such as SMTP credentials, a prefix text for all messages, etc.

***IMPORTANT: Pigeon does not use any authentication token by default, so any request will be served (and an e-mail be sent). It is highly recommended that you set a value for the `AUTH_TOKEN` directive in your `config.local.php` to password-protect your service.***

## Usage

Assuming your Pigeon installation is available at `http://localhost/pigeon`, you can send e-mails by sending a `POST` or `GET` request containing the fields `to`, `subject` and `text` as follows:

```
curl -d "to=john@snow.com&subject=Notice&text=Winter is coming!" http://localhost/pigeon
```

Pigeon will reply with a JSON reponse, e.g.

```
{"success":true,"method":"send","timestamp":1508918383,"version":"1.0.0"}
```

If you have configured the `AUTH_TOKEN` directive in your `config.local.php` file, you need to also specify a `token` param that matches your `AUTH_TOKEN` value for your request to be accepted.

Assuming `AUTH_TOKEN` is `stark`, your e-mail request will be:

```
curl -d "to=john@snow.com&subject=Notice&text=Winter is coming!&token=stark" http://localhost/pigeon
```

Please check the [config.php](config.php) file for more configuration parameters.

## Limitations

Pigeon is by no means an enterprise grade microservice. It is not designed around security and there is no queue system in place, so e-mails are dispatched as they arrive. Requests hang the webserver for the duration of the e-mail sending process, which consumes web resources unnecessarily. Pigeon is a quick drop-in solution for small projects that just want to send e-mails, no questions asked.

## License

Pigeon is licensed under the terms of the [MIT](https://choosealicense.com/licenses/mit/) Open Source
license and is available for free.

## Changelog

See all changes in the [CHANGELOG](CHANGELOG.md) file.
