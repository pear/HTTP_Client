<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at                              |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Alexey Borzov <avb@php.net>                                  |
// +----------------------------------------------------------------------+
//
// $Id$

/**
 * This class implements the Observer part of a Subject-Observer
 * design pattern. It listens to the events sent by a 
 * HTTP_Client instance.
 *
 * @package HTTP_Client
 * @author  Alexey Borzov <avb@php.net>
 * @version $Revision$
 */
class HTTP_Client_Listener 
{
   /**
    * A listener's identifier
    * @var string
    */
    var $_id;

   /**
    * Constructor, sets the object's identifier
    *
    * @access public
    */
    function HTTP_Client_Listener()
    {
        $this->_id = md5(uniqid('http_client_', 1));
    }


   /**
    * This method is called when Listener is notified of an event
    *
    * @access   public
    * @param    object  an object the listener is attached to
    * @param    string  Event name
    * @param    mixed   Additional data
    * @abstract
    */
    function update(&$subject, $event, $data = null)
    {
        echo "Notified of event: '$event'\n";
        if (null !== $data) {
            echo "Additional data: ";
            var_dump($data);
        }
    }
}
?>
