<?php namespace Pyro\Email;

/**
 * A base class for all collections to extend.
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

use IteratorAggregate;
use ArrayAccess;
use Countable;
use ArrayIterator;

class Collection implements IteratorAggregate, ArrayAccess, Countable
{
    /**
     * Collection of objects.
     *
     * @var array
     */
    protected $data = array();
    
    /**
     * Constructor
     *
     * @param array $attributes
     * 
     * @return void
     */
    public function __construct(array $data = array())
    {
        $this->data = $data;
    }
    
    /**
     * Gets an object from the collection or $default if doesn't exist.
     *
     * @param string $key
     * @param mixed  $default
     * 
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        
        return $default;
    }
    
    /**
     * Adds an object to the collection.
     *
     * @param string $key
     * @param mixed  $value
     * 
     * @return Pyro\Email\Collection
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
        
        return $this;
    }
    
    /**
     * Returns all the objects currently present in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
    
    /**
     * Replace the collection with another one.
     *
     * @param array $data
     * 
     * @return Pyro\Email\Collection
     */
    public function replace(array $data)
    {
        $this->data = $data;
        
        return $this;
    }
    
    /**
     * Merges an another array/collection with this one.
     *
     * @param array $data
     * 
     * @return Pyro\Email\Collection
     */
    public function merge(array $data)
    {
        if (count($data) >= 1) {
            $this->data = array_merge(
                $this->data,
                $data
            );
        }
        
        return $this;
    }
    
    /**
     * Determines if an aobject exists in the collection.
     *
     * @param string $key
     * 
     * @return boolean
     */
    public function exists($key)
    {
        return array_key_exists($key, $this->attributes);
    }
    
    /**
     * Removes an object from the collection.
     *
     * @param string $key
     * 
     * @return void
     */
    public function remove($key)
    {
        unset($this->data[$key]);
    }
    
    /**
     * Clears all data from the collection.
     *
     * @return Pyro\Email\Collection
     */
    public function clear()
    {
        return $this->replace(array());
    }
    
    /**
     * Arbitrarily retrieves an object from the collection by treating
     * it as a public class property.
     *
     * @see Pyro\Email\Collection::get()
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Arbitrarily adds an object into the collection by treating
     * it as a public class property.
     *
     * @see Pyro\Email\Collection::set()
     * 
     * @param string $key
     * @param mixed  $value
     * 
     * @return void
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }
    
    /**
     * Arbitrarily checks for the object in the collection by treating
     * it as a public class property.
     *
     * @see Pyro\Email\Collection::exists()
     * 
     * @param string $key
     * 
     * @return boolean
     */
    public function __isset($key)
    {
        return $this->exists($key);
    }

    /**
     * Arbitrarily remove an object from the collection by treating
     * it as a public class property.
     *
     * @see Pyro\Email\Collection::remove()
     * 
     * @param string $key
     * 
     * @return void
     */
    public function __unset($key)
    {
        $this->remove($key);
    }
    
    /**
     * Returns the current element in the collection.
     * 
     * @see Iterator::current()
     * 
     * @return mixed
     */
    public function current()
    {
        return current($this->data);
    }
    
    /**
     * Returns the key of the current element in the collection.
     * 
     * @see Iterator::key()
     * 
     * @return scalar
     */
    public function key()
    {
        return key($this->data);
    }
    
    /**
     * Moves the current position to the next object in the collection.
     * 
     * @see Iterator::next()
     * 
     * @return void
     */
    public function next()
    {
        next($this->data);
    }
    
    /**
     * Goes back to the first object in the collection. 
     * 
     * @see Iterator::rewind()
     * 
     * @return void
     */
    public function rewind()
    {
        reset($this->data);
    }
    
    /**
     * Checks if the current position in the collection is valid.
     * 
     * @see Iterator::valid()
     * 
     * @return boolean
     */
    public function valid()
    {
        // return key($this->data) !== null;
        return ! is_null(key($this->data));
    }
    
    /**
     * Gets the aggregate iterator
     *
     * @see IteratorAggregate::getIterator()
     * 
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }
    
    /**
     * Retrieves an object from the collection using array syntax. 
     *
     * @see ArrayAccess::offsetGet()
     * @see Pyro\Email\Collection::get()
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }
    
    /**
     * Adds an object to the collection using array syntax.
     *
     * @see ArrayAccess::offsetSet()
     * @see Pyro\Email\Collection::set()
     * 
     * @param string $key
     * @param mixed  $value
     * 
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }
    
    /**
     * Checks if an object is within the collection using array syntax.
     *
     * @see ArrayAccess::offsetExists()
     * @see Pyro\Email\Collection::exists()
     * 
     * @param string $key
     * 
     * @return boolean
     */
    public function offsetExists($key)
    {
        return $this->exists($key);
    }
    
    /**
     * Removes an object from the collection using array syntax.
     *
     * @see ArrayAccess::offsetUnset()
     * @see Pyro\Email\Collection::remove()
     * 
     * @param string $key
     * 
     * @return void
     */
    public function offsetUnset($key)
    {
        $this->remove($key);
    }
    
    /**
     * Number of objects in the collection.
     *
     * @see Countable::count()
     * 
     * @return integer
     */
    public function count()
    {
        return count($this->data);
    }
}
