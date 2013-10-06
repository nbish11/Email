<?php error_reporting(-1);

// @todo Implement an autoloader for email library.
include 'Email.php';
include 'AddressList.php';
include 'Address.php';
include 'Attachment.php';
include 'Mimetype.php';


// Basic Use:
$email = new Pyro\Email\Email();


$email->from(['test@domain.com']);
$email->to(['random@totally.com']);

$email->subject('Some totally random subject!');
$email->message('This is a bogus test email.');

$composed = $email->compose();

echo '<pre>', $composed, '</pre>';