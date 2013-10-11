<?php namespace Pyro\Email;

/**
 * Pyro\Email\Attachments.php
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
use Pyro\Email\Attachment;
use Pyro\Email\Collection;
use Pyro\Email\CollectionInterface;
 
class Attachments extends Collection implements CollectionInterface
{
    /**
     * Stores all values in the array into the address list.
     * 
     * @param array $addresses
     * 
     * @return void
     */
    public function __construct(array $attachments = array())
    {
        foreach ($attachments as $file => $disposition) {
            $this->add($file, $disposition);
        }
    }
    
    /**
     * Adds a single email address to the list.
     * 
     * @param string $name 
     * @param string $email  
     * 
     * @return void
     */
    public function add($file, $disposition = 'attachment')
    {
        $attachment = new Attachment($file, $disposition);
        
        parent::set($attachment->getFileName(), $attachment);
    }
    
    /**
     * Returns all attachments in the finished format.
     * 
     * @return string
     */
    public function toString()
    {
        return implode("\r\n", array_values($this->all()));
    }
    
    /**
     * Magic toString() method.
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
