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
     * @param string $email
     * @param string $name
     * 
     * @return void
     */
    public function __construct($email, $name = null)
    {
        $this->setEmail($email);
        
        if ( ! is_null($name)) {
            $this->setName($name);
        }
    }
    
    /**
     * Validates and sets the email address.
     * 
     * @param string $email 
     * 
     * @return void
     */
    public function setEmail($email)
    {
        if (RFC::parseEmail($email) == 0) {
            throw new Exception('The email address "'.$email.'" does not conform to the RFC 5322 addr-spec.');
        }
        
        $this->email = $email;
    }
    
    /**
     * Validates and sets the name for the email address.
     * 
     * @param string $name 
     * 
     * @return void
     */
    public function setName($name)
    {
        if (is_string($name) && !empty($name)) {
            
        }
        
        $this->name = $name;
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
}
