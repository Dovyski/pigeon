<img src="./img/pigeon.png" align="right" title="Pigeon" />

# Pigeon

Pigeon is an easy to use, hassle-free PHP microservice for sending e-mails via HTTP requests. It values simplicity above all, i.e. no database required, extremely easy and quick installation. It is intended for small, in-house projects that require e-mail sending capabilities.

## Getting started

### 1. Prerequisites

You need [PHP](https://php.net) and a web server to run Pigeon. If you indent to use its SMTP funcionality, you will need [composer](https://getcomposer.org/) and access to an SMTP server you can dispatch messages to.

### 2. Installing

Clone Pigeon's repository in document root of your web server (e.g. `/var/www/`):

```
git clone https://github.com/Dovyski/pigeon.git pigeon && cd pigeon
```

At this point Pigeon is already ready for use. It is relying on the existing e-mail infra-instructure of the machine, i.e. PHP's `mail()` function.

### 3. Installing SMTP dependencies (optional)

If you intend to use SMPT as a sending mechanism, you need to download a few dependencies. In the folder where you cloned Pigeon, run:

```
composer install
```

It will download and install everything you need.

### 4. Configuring

Pigeon has a default configuration file named `config.php`. In fact you don't have to configure anything to start using Pigeon, since it comes pre-configured and ready to use after instalation.

However the best practice is to create a local configuration file named `config.local.php` that overrides only the directives you want to change, e.g. increase security.

Go to the folder where Pigeon is and create your local configuration file:

```
cp config.php config.local.php
```

Next edit `config.local.php` with your needs, such as SMTP credentials, a prefix text for all messages, etc.

***IMPORTANT: Pigeon does not use any authentication token by default, so any request will be served (and an e-mail be sent). It is highly recommended that you set a value for the `AUTH_TOKEN` directive in your `config.local.php` to password-protect your service.***

If nothing else, ensure you have `AUTH_TOKEN` not empty in your `config.local.php`, like this:

```
define('AUTH_TOKEN', 'mysuperhardtoguesspassword');
```

Please check the [config.php](config.php) file for more configuration directives.

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

Assuming `AUTH_TOKEN` is `mysuperhardtoguesspassword`, your e-mail request will be:

```
curl -d "to=john@snow.com&subject=Notice&text=Winter is coming!&token=mysuperhardtoguesspassword" http://localhost/pigeon
```

## Limitations

Pigeon is by no means an enterprise grade microservice. It is not designed around security and there is no queue system in place, so e-mails are dispatched as they arrive. You can choke the web server by making lots of request at the same time. Requests hang the web server up for the duration of the e-mail sending process, which also consumes resources unnecessarily. Pigeon is a quick drop-in solution for small projects that just want to send e-mails, no questions asked.

## License

Pigeon is licensed under the terms of the [MIT](https://choosealicense.com/licenses/mit/) Open Source
license and is available for free.

## Changelog

See all changes in the [CHANGELOG](CHANGELOG.md) file.
