<?php error_reporting(-1);

include 'Email.php';
include 'Collection.php';
include 'CollectionInterface.php';
include 'Attachment.php';
include 'Attachments.php';
include 'Address.php';
include 'Addresses.php';
include 'Mimetype.php';


// Basic Use:
$email = new Pyro\Email\Email();


$email->from(['test@domain.com']);
$email->to(['random@totally.com']);

$email->subject('Some totally random subject!');
$email->message('This is a bogus test email.');

// For archival...
$composed = $email->compose();

echo '<pre>', $composed, '</pre><hr>';
//$email->send();

$attachments = new Pyro\Email\Attachments([
    'index.php' => 'attachment',
    'email.php' => 'attachment'
]);

//var_dump($attachments->all());
//var_dump($attachments->toString());

echo nl2br($attachments->toString());

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
*/