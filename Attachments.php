<?php namespace Pyro\Email;

/**
 * Holds an array of attachments.
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

use Pyro\Email\Attachment;
use Pyro\Email\Collection;
 
class Attachments extends Collection
{
    /**
     * Adds an array of files to the attachments collection.
     * 
     * @param array $attachments
     * 
     * @return void
     */
    public function __construct(array $attachments = array())
    {
        foreach ($attachments as $file) {
            $this->add($file);
        }
    }
    
    /**
     * Adds a single file to the attachments collection.
     * 
     * @see Pyro\Email\Collection::set()
     * 
     * @param string $name 
     * @param string $email
     * 
     * @return void
     */
    public function add($file)
    {
        $attachment = new Attachment($file, 'attachment');
        
        parent::set($attachment->getFileName(), $attachment);
    }
    
    /**
     * Returns all attachments in the finished format.
     * 
     * @see Pyro\Email\Collection::toString()
     * 
     * @return string
     */
    public function toString()
    {
        return implode("\r\n", array_values(parent::all()));
    }
}
