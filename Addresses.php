<?php namespace Pyro\Email;

/**
 * Pyro\Email\AddressList.php
 *
 * Creates an address list from an array of email objects.
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
 * @todo    Add the ability to change email validation level.
 */

use Exception;
use Pyro\Email\Address;
use Pyro\Email\Collection;
use Pyro\Email\CollectionInterface;
 
class Addresses extends Collection implements CollectionInterface
{
    /**
     * Stores all values in the array into the address list.
     * 
     * @param <array> $addresses
     * 
     * @return <void>
     */
    public function __construct(array $addresses = array())
    {
        foreach ($addresses as $name => $email) {
            is_string($name) ? $this->add($name, $email) : $this->add($email);
        }
    }
    
    /**
     * Adds a single email address to the list.
     * 
     * @param <string> $name 
     * @param <string> $email  
     * 
     * @return <void>
     */
    public function add($name, $email = null)
    {
        $email = new Address($name, $email);
        
        // When searching/manipulating addresses we want to do this
        // by using case-insensitive emails (but storing should 
        // the email should be case-sensitive).
        parent::set(strtolower($email->getEmail()), $email);
    }
    
    /**
     * Creates a string of all email addresses in a format defined
     * by RFC 5322, Section ...
     * 
     * @return <string>
     */
    public function toString()
    {
        return implode(', ', array_values($this->data));
    }
    
    /**
     * Convenience method.
     * 
     * @return <string>
     */
    public function __toString()
    {
        return $this->toString();
    }
}