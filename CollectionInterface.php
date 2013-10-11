<?php namespace Pyro\Email;

/**
 * Pyro\Email\CollectionInterface.php
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
 
use Pyro\Email\Collection;

interface CollectionInterface
{
    /**
     * 
     * 
     * 
     * @return string
     */
    public function toString();
}