<?php

// Control if Pigeon should run in debug mode. If true, more logs will
// be generated, such as SMTP negotiation messages, etc.
define('DEBUG', false);

// Control if a password is required for a request to be accepted. If
// AUTH_TOKEN is empty (default), all requests are accepted (and an e-mail
// is sent). It is highly recommended that you set a value for AUTH_TOKEN
// to password-protect your service. When AUTH_TOKEN is not empty, all
// request must contain a field named "token" whose content matches the
// content of AUTH_TOKEN, otherwise the request is rejected and no e-mail
// is sent.
define('AUTH_TOKEN', '');

// Below are directives that allow you to customize the sent e-mails.
// You can, for instance, prefix a string to the body of all messages.
define('SENDER_EMAIL', 'pigeon@pigeon.com');
define('SENDER_NAME', 'Pigeon');
define('SUBJECT_PREFIX', '[Pigeon] ');
define('TEXT_PREFIX', '');
define('TEXT_SUFIX', "\n\n----\nThis message was automatically sent by Pigeon.");

// Pigeon can use more then one e-mail sending mechanism at the same time.
// The directives "USE_*" allow you to enable/disable the use of such mechanisms.
// Below you can control which method(s) Pigeon should use to send e-mails.
// If two mechanisms are active, Pigeon will send two e-mails from a single
// received request.

// Enable/disable the use of PHP's mail() function as an e-mail sending mechanism.
// Such function relies on the systems e-mail sending capabilities, e.g. sendmail
// on Linux. If you are running Pigeon on Windows, it is very likely this mechanism
// will not work out of the box.
define('USE_MAIL_FUNCTION', true);

// Enable/disable the us of a third-party SMTP server to send e-mails.
// In that case, you must provide the credentials (host, user and password)
// of the SMTP server to be used.
define('USE_CUSTOM_SMTP', false);
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', '');
define('SMTP_PASSWORD', '');

?>
