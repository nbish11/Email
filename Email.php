<?php namespace Pyro\Email;

/**
 * Pyro\Email\Email.php
 *
 * Returns and validates an email address and option name
 * according to the RFC 5322 document.
 *
 * Copyright (c) 2013 Nathan Bishop <nbish11@hotmail.com>
 * 
 * LICENSE: This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, please visit 
 * <http://www.gnu.org/licenses/gpl-2.0.html>.
 * 
 *
 * @package Pyro\Email
 * @version 0.0.1
 * @author  Nathan Bishop <nbish11@hotmail.com>
 * @link    http://github.com/nbish11/Email
 */

use Exception;
use Pyro\Email\Address;
use Pyro\Email\AddressList;
use Pyro\Email\Attachment;
 
class Email
{
    /**
     * CLASS CONSTANTS
     */
    const EOL = "\n";
    const CRLF = "\r\n";
    const MIME_HEADER = 'MIME-Version: 1.0';
    const DEFAULT_CONTENT_TYPE = 'text/plain';
    const DEFAULT_CHARSET = 'utf-8';
    //const DEFAULT_MAILER = 'X-Mailer: PHP/' . phpversion();
    const DEFAULT_TIMEZONE = 'Australia/Brisbane';
    
    /**
     * EMAIL HEADERS
     */
    public $from;
    public $sender;
    public $to;
    public $cc;
    public $bcc;
    public $replyTo;
    public $subject;
    public $date;
    public $messageID;
    public $inReplyTo;
    
    
    /**
     * MESSAGE CONTENT
     */
    public $contentType;
    public $alternate;
    public $message;
    public $attachments;
    
    
    /**
     * CLASS VARIABLES
     */
    public $headers;
    public $isHtml;
    public $recipients;
    public $timezone;

    public function __construct()
    {
        $this->timezone = self::DEFAULT_TIMEZONE;
        
        $this->from     = new AddressList();
        //$this->sender   = null;
        $this->to       = new AddressList();
        $this->cc       = new AddressList();
        $this->bcc      = new AddressList();
        //$this->replyTo  = null;
        $this->replyTo  = new AddressList();
        //$this->inReplyTo= null;
        
        $this->contentType = self::DEFAULT_CONTENT_TYPE;
        $this->attachments = array();
        $this->recipients  = array();
    }
    
    public function priority($priority)
    {
        /* $priority = (int) $priority;
        
        if ($priority < 1 || $priority > 5) {
            $priority = 3; // Normal
        }
        
        $this->headers['X-Priority'] = $priority; */
    }
    
    public function from(array $from)
    {
        $this->from->merge(new AddressList($from));
    }
    
    public function sender($name, $email = null)
    {
        $this->sender = new Address($name, $email);
    }
    
    public function to(array $to)
    {
        $this->to->merge(new AddressList($to));
    }
    
    public function cc(array $cc)
    {
        $this->cc->merge(new AddressList($cc));
    }
    
    public function bcc(array $bcc)
    {
        $this->bcc->merge(new AddressList($bcc));
    }
    
    public function replyTo(array $replyTo)
    {
        $this->replyTo->merge(new AddressList($replyTo));
    }
    
    public function subject($subject)
    {
        $this->subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
    }
    
    public function inReplyTo($name, $email = null)
    {
        $this->inReplyTo = new Address($name, $email);
    }
    
    public function alternate($body)
    {
        if (file_exists($body)) {
            $body = file_get_contents($body);
        }
    
        // No use doing anything if were not sending a html email.
        // Than further validate by making sure the alternate contains
        // no HTML.
        if ($this->isHtml && !$this->hasHtml($body)) {
            $this->alternate = static::format($body);
        }
    }
    
    /* public function message($body)
    {
        if (file_exists($body)) {
            $body = file_get_contents($body);
        }

        $this->isHtml = $this->hasHtml($body);
        $this->message = static::format($body);
    } */
    
    /**
     * Sets the message body of the email. Can only
     * contain ASCII characters 0-127.
     * 
     * @param <string> $body 
     * @param <boolean> $validate  
     * 
     * @return <void>
     */
    public function message($body, $validate = false)
    {
        if (file_exists($body)) {
            $body = file_get_contents($body);
        }
        
        if ($validate && ! $this->isASCII($body)) {
            throw new \Exception('The message MUST contain ASCII characters 0-127 only.');
        }

        $this->isHtml = $this->hasHtml($body);
        $this->message = wordwrap($body, 76, self::CRLF);
    }
    
    public function attach($file, $type = 'disposition')
    {
        $this->attachments[] = new Attachment($file);
    }
    
    public function attachments(array $files)
    {
        $this->attachments = array_unique(
            array_merge($this->attachments, $files)
        );
    }
    
    public function compose()
    {
        // header field for current date.
        // header field for from.
        // if more than 1 from than sender is required and must be different from from.
        
        /*
            from            =   "From:" mailbox-list CRLF                   // Author
            sender          =   "Sender:" mailbox CRLF                      // On behalf of / Transmission of message
            to              =   "To:" address-list CRLF                     //
            cc              =   "Cc:" address-list CRLF                     //
            bcc             =   "Bcc:" [address-list / CFWS] CRLF           // Header should not be present
            reply-to        =   "Reply-To:" address-list CRLF               //
            subject         =   "Subject:" unstructured CRLF                // message topic
            orig-date       =   "Date:" date-time CRLF                      //
            message-id      =   "Message-ID:" msg-id CRLF                   // Should be shown
            in-reply-to     =   "In-Reply-To:" 1*msg-id CRLF                //
            mime            =   "MIME-Version:" 1*DIGIT "." 1*DIGIT CRLF    // ONLY if a mime message is being sent
        */
        
        /**
         * VALIDATION CHECKS
         */
        
        if (count($this->from->all()) < 1) {
            throw new Exception('You have not declared who this message is from.');
        }
        
        if (count($this->from->all()) == 1 && ($this->from->all() == $this->sender)) {
            throw new Exception('You cannot declare a sender if the from address is the same as the senders address.');
        }
        
        if (count($this->from->all()) > 1 && is_null($this->sender)) {
            throw new Exception('You have multiple from address but no sender was specified.');
        }
        
        if (count($this->to->all()) < 1) {
            throw new Exception('Please add a to address.');
        }
        
        
        /**
         * DETERMINE RECIPIENTS
         */
         
        $this->recipients = new AddressList();
        
        $this->recipients->merge($this->to);
        $this->recipients->merge($this->cc);
        $this->recipients->merge($this->bcc);
    
        return $this->getHeaderString() . self::CRLF . $this->message;
    }
    
    protected function getHeaderString()
    {
        $headers = array();
        
        $headers[] = "From: " . $this->from;
        
        if ( ! is_null($this->sender)) {
            $headers[] = "Sender: " . $this->sender;
        }
        
        $headers[] = "To: " . $this->to;
        
        if (count($this->cc) > 1) {
            $headers[] = "Cc: " . $this->cc;
        }
        
        if (count($this->replyTo) > 1) {
            $headers[] = "Reply-To: " . $this->replyTo;
        }
        
        if ( ! empty($this->subject)) {
            $headers[] = "Subject: " . $this->subject;
        }
        
        $headers[] = "Date: " . $this->getDate();
        $headers[] = "Message-ID: " . $this->getMessageId();
        
        if ( ! is_null($this->inReplyTo)) {
            $headers[] = "In-Reply-To: " . $this->inReplyTo;
        }
        
        foreach ($headers as &$header) {
            // check line length and fold if over 76
            $header = wordwrap($header, 76, self::CRLF);
        }
        
        return implode(self::CRLF, $headers) . self::CRLF;
    }
    
    protected function getDate()
    {
        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone($this->timezone));
        
        return $datetime->format("r");
    }
    
    protected function getMessageId()
    {
        return '<testabcd.1234@silly.example>';
    }
    
    /**
     * Checks if the string contains valid 7bit 
     * ASCII characters.
     * 
     * @param <string> $string 
     * 
     * @return <boolean>
     */
    private function isASCII($string)
    {
        return (bool) ! preg_match('/[\\x80-\\xff]+/', $string);
    }

    /**
     * Strips any whitespace characters from the 
     * beginning and end of the string as well as
     * any CRLFs contained within the string.
     * 
     * @param <string> $string 
     * 
     * @return <string>
     */
    private function strip($string)
    {
        return str_replace(self::CRLF, "", trim($string));
    }
    
    /**
     * Formats the message body to RFC... conformance.
     * 
     * @param <string> $string 
     * 
     * @return <string>
     */
    private static function format($string)
    {
        $string = wordwrap($string, 70, self::CRLF);
        $string = str_replace("\n.", "\n..", $string);
        
        return $string;
    }
    
    /**
     * Does html exist in the supplied string.
     * 
     * @param <string> $string 
     * 
     * @return <boolean>
     */
    private function hasHtml($string)
    {
        return ($string != strip_tags($string)) ? true : false;
    }
}