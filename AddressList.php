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

use Countable;
use Iterator;
use Exception;
use Pyro\Email\Address;
 
class AddressList implements Countable, Iterator
{
    /**
     * Stores an array of Address objects.
     * 
     * @var <array> $addresses
     */
    private $addresses;

    /**
     * Stores all values in the array into the address list.
     * 
     * @param <array> $addresses
     * 
     * @return <void>
     */
    public function __construct(array $addresses = array())
    {
        if ( ! is_array($this->addresses)) {
            $this->addresses = array();
        }
    
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
        // be case-sensitive).
        $this->addresses[strtolower($email->getEmail())] = $email;
    }
    
    /**
     * Retrieve a particular email address from the list.
     * 
     * @param <string> $email 
     * @param <mixed> $default Returned if email not found
     * 
     * @return <Address|mixed>
     */
    public function get($email, $default = null)
    {
        $email = strtolower($email);
    
        if (array_key_exists($email, $this->addresses)) {
            return $this->addresses[$email];
        }
        
        return $default;
    }
    
    /**
     * Checks if an email exists in the address list.
     * 
     * @param <string> $email 
     * 
     * @return <boolean>
     */
    public function exists($email)
    {
        return array_key_exists(strtolower($email), $this->addresses);
    }
    
    /**
     * Removes an email from the address list.
     * 
     * @param <string> $email 
     * 
     * @return <void>
     */
    public function remove($email)
    {
        $email = strtolower($email);
    
        if (array_key_exists($email, $this->addresses)) {
            unset($this->addresses[$email]);
        }
    }
    
    /**
     * Merge in an another address list with the local one.
     * If the same address exists in both lists than the 
     * address list to be merged will overwrite the local one.
     * 
     * @param <AddressList> $addresses 
     * @param <AddressList> $overwrite TRUE if should overwrite local addresses
     * 
     * @return <void>
     */
    public function merge(AddressList $addresses, $overwrite = true)
    {
        // NOTE: Come up with a cleaner/better alternative.
        if ($overwrite) {
            $this->addresses = array_merge(
                $this->addresses,
                $addresses->all()
            );
        } else {
            $this->addresses = array_merge(
                $addresses->all(),
                $this->addresses
            );
        }
    }
    
    /**
     * Returns an all email addresses in the address list.
     * 
     * @return <array>
     */
    public function all()
    {
        return $this->addresses;
    }
    
    /**
     * Number of email addresses in the list.
     * 
     * @return <integer>
     */
    public function count()
    {
        return count($this->addresses);
    }
    
    /**
     * Returns the current email address.
     * 
     * @sees Iterator::current()
     * 
     * @return <string>
     */
    public function current()
    {
        return current($this->addresses);
    }
    
    /**
     * Returns the key of the current email address.
     * 
     * @see Iterator::key()
     * 
     * @return <scalar|null>
     */
    public function key()
    {
        return key($this->addresses);
    }
    
    /**
     * Moves the current position to the next email address.
     * 
     * @sees Iterator::next()
     * 
     * @return <void>
     */
    public function next()
    {
        return next($this->addresses);
    }
    
    /**
     * Goes back to the first email in the address list. 
     * 
     * @see Iterator::rewind()
     * 
     * @return <void>
     */
    public function rewind()
    {
        return reset($this->addresses);
    }
    
    /**
     * Checks if the current position in the address list is valid.
     * 
     * @see Iterator::valid()
     * 
     * @return <boolean>
     */
    public function valid()
    {
        // return key($this->addresses) !== null;
        return ! is_null(key($this->addresses));
    }
    
    /**
     * Creates a string of all email addresses in a format defined
     * by RFC 5322, Section ...
     * 
     * @return <string>
     */
    public function __toString()
    {
        return implode(', ', array_values($this->addresses));
    }
}
