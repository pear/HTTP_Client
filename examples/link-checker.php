<?php
/**
 * An example implementation of HTTP_Client_Listener: a simple
 * link checker.
 * 
 * @package HTTP_Client
 * @author  Alexey Borzov <avb@php.net>
 * @version $Revision$
 * 
 * $Id$
 */

require_once 'HTTP/Client.php';
require_once 'HTTP/Client/Listener.php';

class HTTP_Client_LinkChecker extends HTTP_Client_Listener
{
   /**
    * Results of link checking ('url' => 'result')
    * @var array
    */
    var $_urls;

   /**
    * An URL being checked 
    * @var string
    */
    var $_checkedUrl;

   /**
    * An URL we were redirected to
    * @var string
    */
    var $_redirUrl;


    function update(&$subject, $event, $data)
    {
        switch ($event) {
            case 'httpSuccess':
                if ('' == $this->_redirUrl) {
                    $this->_urls[$this->_checkedUrl] = 'OK';
                } else {
                    $this->_urls[$this->_checkedUrl] = 'Moved to ' . $this->_redirUrl;
                }
                break;

            case 'httpError':
                $response =& $subject->currentResponse();
                $this->_urls[$this->_checkedUrl] = 'HTTP Error ' . $response['code'];
                break;

            case 'httpRedirect':
                $this->_redirUrl = $data;
                break;

            case 'request':
                $this->_checkedUrl = $data;
                $this->_redirUrl   = '';
        }
    }


   /**
    * Returns the link checking results 
    *
    * @access public
    * @return array
    */
    function getResults()
    {
        return $this->_urls;
    }
}

$urlList = array(
    'http://www.php.net/',
    'http://www.php.net/fsockopen',
    'http://pear.php.net/foobar.php'
);

$client  =& new HTTP_Client(array('allowRedirects' => false));
$checker =& new HTTP_Client_LinkChecker();
$client->attach($checker);

foreach ($urlList as $url) {
    $client->head($url);
}

var_dump($checker->getResults());
?>
