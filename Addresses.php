<?php namespace Pyro\Email;

/**
 * Stores an array of email addresses.
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

use Pyro\Email\Address;
use Pyro\Email\Collection;
 
class Addresses extends Collection
{
    /**
     * Adds an array of email addresses and their optional
     * names to the addresses collection.
     * 
     * @param array $addresses
     * 
     * @return void
     */
    public function __construct(array $addresses = array())
    {
        foreach ($addresses as $name => $email) {
            is_string($name) ? $this->add($name, $email) : $this->add($email);
        }
    }
    
    /**
     * Adds a single email address and optional name to the collection.
     * 
     * @see Pyro\Email\Collection::set()
     * 
     * @param string $name 
     * @param string $email  
     * 
     * @return void
     */
    public function add($name, $email = null)
    {
        $email = new Address($name, $email);
        
        // When searching/manipulating addresses we want to do this
        // by using case-insensitive emails (but storing the email
        // should be case-sensitive).
        parent::set(strtolower($email->getEmail()), $email);
    }
    
    /**
     * Creates a string of all email addresses in a format defined
     * by RFC 5322, Section ...
     * 
     * @see Pyro\Email\Collection::toString()
     * 
     * @return string
     */
    public function toString()
    {
        return implode(', ', array_values(parent::all()));
    }
}
