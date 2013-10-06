<?php namespace Pyro\Email;

/**
 * Pyro\Email\Attachment.php
 *
 * Creates a new object for a file with common functions
 * associated with creating emails.
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

use Pyro\Email\Mimetype;

class Attachment
{
    private $file;
    private $disposition;

    /**
     * Checks if the file exists
     */
    public function __construct($file, $disposition = 'attachment')
    {
        if ( ! file_exists($file)) {
            throw new Exception('File does not exist at the following location: ' . $file);
        }
    
        $this->file = $file;
        $this->disposition = strtolower($disposition);
    }
    
    /**
     * Returns the basename (everything after the 
     * last slash in the directory path).
     */
    public function getBaseName()
    {
        return pathinfo($this->file, PATHINFO_BASENAME);
    }
    
    /**
     * Retrieves the file extension (from the last period).
     * E.g. WILL NOT return .tar.gz
     */
    public function getExtension()
    {
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }
    
    /**
     * Essentially the basename but without the file extension.
     */
    public function getFileName()
    {
        return pathinfo($this->file, PATHINFO_FILENAME);
    }
    
    /**
     * Returns the mimetype based on the file extension. This
     * function DOES NOT use the finfo_* library.
     */
    public function getMimeType()
    {
        return Mimetype::get($this->getExtension());
    }
    
    /**
     * Returns the contents of the file base64 encoded and
     * returned with a chunk length of 76, with each line
     * terminating in a CRLF (\r\n).
     */
    public function getContents()
    {
        return chunk_split(
            base64_encode(
                file_get_contents($this->file)
            )
        );
    }
}
