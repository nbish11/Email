<?php error_reporting(-1);

// Collections
include 'Collection.php';
include 'Addresses.php';
include 'Attachments.php';

// Objects
include 'Email.php';
include 'Attachment.php';
include 'Address.php';

// Helpers
include 'Mimetype.php';
include 'RFC.php';


// Basic Use:
$email = new Pyro\Email\Email();


//$email->from([/* 'first.last@example.123', */'first.last@iana.org']);   // false, true
//$email->from([/* 'first.last@example.123', */'first.last@iana.org']);   // false, true
//$email->from([/* 'first.last@example.123', */'first.last@iana.org']);   // false, true

/* $email->from([
    'Hello World' => 'helloworld@program.com',
    'first.last@iana.org'
]);
$email->from([
    'Firstname Lastname' => 'fnln@domain.com',
    'Testing' => 'testdomain@testing.com'
]);
$email->from(['first.last@domain.com', 'username@domain.com']);
$email->from('k91968@hotmail.com'); */
$email->from('Nathan Bishop', 'nbish11@hotmail.com');


$email->to(['random@totally.com']);

$email->subject('Some totally random subject!');
$email->message('This is a bogus test email.');

// For archival...
$composed = $email->compose();

var_dump($composed);
//$email->send();


/*
    TODO:
    
    Create an Attachments class.
    Add validation options to Address class.
    Rewrite merge function in AddressList class to allow for name override.
    Move all "new AddressList" into a single function (make it look cleaner/nicer).
    I might create a base class for the AddressList/Attachments class.
    Allow single address/name params for the "from, to, cc, bcc, replyTo" methods.
    Comment/Clean-Up main email class.
    Autoloader function for core files.
    Get a basic send working with PHP's mail() function.
    Create SMTP, MAIL (wrapper for PHP's mail() function), SENDMAIL transport classes.
    Page load is doubled for basic email class use... Try and optimize time.
*/
