<?php namespace Pyro\Email;

/**
 * Email Address formatting and validation class.
 *
 * PHP version 5
 * 
 * Copyright (C) 2013  Nathan Bishop
 *
 * LICENSE: This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    Pyro\Email
 * @author     Nathan Bishop <nbish11@hotmail.com>
 * @version    0.0.1
 * @copyright  2013 Nathan Bishop
 * @license    GPLv2
 * @link       https://github.com/nbish11/Email
 *
 * $Id$
 */

use Exception;
use RFC;
 
class Address
{
    /**
     * Stores the name of the email address if
     * provided
     * 
     * @var string $name
     */
    private $name;
    
    /**
     * Stores the email address in the format
     * according to the RFC 5322 publication.
     * 
     * @var string $name
     */
    private $email;

    /**
     * Validates email address and optional name.
     * 
     * @param string $name
     * @param string $email
     * 
     * @return void
     */
    public function __construct($name, $email = null)
    {
        // IF only 1 argument than argument 1 is email address.
        if (is_null($email)) {
            $email = $name;
            $name = null;
        }
        
        if ( ! $this->isValidEmail($email)) {
            throw new Exception('The email address "'.$email.'" does not conform to the RFC 5322 addr-spec.');
        }
        
        if ( ! is_null($name) && ! $this->isValidName($name)) {
            throw new Exception('Name is not in a valid format and/or is empty!');
        }
        
        $this->name  = $name;
        $this->email = $email;
    }
    
    /**
     * Gets the name.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Gets the email address.
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Returns the full email address and name
     * in format specified by RFC 5322.
     * 
     * @return string
     */
    public function toString()
    {
        $string = '<' . $this->email . '>';
        
        if ( ! is_null($this->name)) {
            $string = $this->name . ' ' . $string;
        }
        
        return $string;
    }
    
    /**
     * Convenience method.
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
    
    /**
     * Whether the email address conforms to 
     * RFC 5322.
     * 
     * @param string $email
     * 
     * @return boolean
     */
    private function isValidEmail($email)
    {
        return (bool) RFC::parseEmail($email);
    }
    
    /**
     * Whether the name conforms to RFC 5322.
     * 
     * @param string $name
     * 
     * @return boolean
     */
    private function isValidName($name)
    {
        return is_string($name) && !empty($name);
        // return (bool) RFC::parseName($name);
    }
}
