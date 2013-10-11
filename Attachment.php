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

use Exception;
use Pyro\Email\Mimetype;

class Attachment
{
    /**
     * 
     * 
     * 
     * 
     * 
     */
    private $file;
    
    /**
     * 
     * 
     * 
     * 
     * 
     */
    private $encoding;
    
    /**
     * 
     * 
     * 
     * 
     * 
     */
    private $disposition;
    
    /**
     * 
     *
     *
     *
     *
     */
    private $attributes;

    /**
     * 
     * 
     * @param string $file 
     * @param string $encoding  
     * @param string $disposition  
     * 
     * @return void
     */
    public function __construct($file, $disposition = 'attachment')
    {
        $this->setFile($file);
        $this->setEncoding('base64');
        $this->setDisposition($disposition);
        
        $this->attributes = $this->info($this->file);
    }
    
    /**
     * 
     * 
     * @param <type> $file 
     * 
     * @return Pyro\Email\Attachment
     */
    public function setFile($file)
    {
        if ( ! file_exists($file)) {
            throw new Exception('File does not exist at the following location: ' . $file);
        }
        
        $this->file = $file;
        
        return $this;
    }
    
    /**
     * 
     * 
     * @param <type> $encoding 
     * 
     * @return Pyro\Email\Attachment
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        
        return $this;
    }
    
    /**
     * 
     * 
     * @param <type> $disposition 
     * 
     * @return Pyro\Email\Attachment
     */
    public function setDisposition($disposition)
    {
        $this->disposition = $disposition;
        
        return $this;
    }
    
    /**
     * 
     * 
     * 
     * @return string
     */
    public function getContentType()
    {
        $string = '';
        
        $string .= 'Content-Type: ';
        $string .= $this->attributes['mimetype'];
        $string .= '; name="';
        $string .= $this->attributes['basename'];
        $string .= '"';
        
        return $string;
    }
    
    /**
     * 
     * 
     * 
     * @return string
     */
    public function getContentTransferEncoding()
    {
        return "Content-Transfer-Encoding: {$this->encoding}";
    }
    
    /**
     * 
     * 
     * 
     * @return string
     */
    public function getContentDisposition()
    {
        $string = '';
        
        $string .= 'Content-Disposition: ';
        $string .= $this->disposition;
        $string .= '; filename="';
        $string .= $this->attributes['filename'];
        $string .= '"';
        
        return $string;
    }
    
    /**
     * 
     * 
     * 
     * @return string|Exception
     */
    public function getContents()
    {
        switch ($this->encoding) {
            case 'base64':
                return $this->encodeBase64();
        
            case 'quoted-printable':
                return $this->encodeQuotedPrintable();
                
            case 'binary':
                return $this->encodeBinary();
                
            default:
                throw new Exception('The transfer encoding format "'.$this->encoding.'" is not supported!');
        }
    }
    
    /**
     * 
     * 
     * 
     * @return string
     */
    public function getDirectory()
    {
        return $this->attributes['directory'];
    }
    
    /**
     * 
     * 
     * 
     * @return string
     */
    public function getBaseName()
    {
        return $this->attributes['basename'];
    }
    
    /**
     * 
     * 
     * 
     * @return string
     */
    public function getExtension()
    {
        return $this->attributes['extension'];
    }
    
    /**
     * 
     * 
     * 
     * @return string
     */
    public function getFileName()
    {
        return $this->attributes['filename'];
    }
    
    /**
     * 
     * 
     * 
     * @return string
     */
    public function getMimeType()
    {
        return $this->attributes['mimetype'];
    }
    
    /**
     * 
     * 
     * 
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
    
    /**
     * 
     * 
     * @param string $eol  
     * 
     * @return string
     */
    public function toString($eol = "\r\n")
    {
        $string = '';
        
        $string .= $this->getContentType() . $eol;
        $string .= $this->getContentTransferEncoding() . $eol;
        $string .= $this->getContentDisposition() . $eol . $eol;
        $string .= $this->getContents();
        
        return $string;
    }
    
    /**
     * 
     * @see Pyro\Email\Attachment::toString()
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
    
    /**
     * 
     * 
     * 
     * @return string
     */
    protected function encodeBase64()
    {
        return chunk_split(
            base64_encode(
                file_get_contents($this->file)
            )
        ); 
    }
    
    /**
     * 
     * 
     * 
     * @return string
     */
    protected function encodeQuotedPrintable()
    {
        return '';
    }
    
    /**
     * 
     * 
     * 
     * @return string
     */
    protected function encodeBinary()
    {
        return '';
    }
    
    /**
     * 
     * 
     * @param string $file 
     * 
     * @return array
     */
    private function info($file)
    {
        $directory = dirname($file);
        $basename = basename($file);
        $extension = substr(strrchr($basename, "."), 1);
        $filename = basename($file, '.' . $extension);
        $mimetype = Mimetype::get($extension);
        
        return compact('directory', 'basename', 'extension', 'filename', 'mimetype');
    }
}
