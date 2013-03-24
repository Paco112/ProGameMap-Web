<?php
/**
 * Debugging utility class
 *
 * @version 1.0.3
 * @author gplanchat
 * @license BSD
 * @see http://www.naivelywatching.net/
 *
 * Copyright (c) 2009, Grégory PLANCHAT
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice,
 * this list of conditions and the following disclaimer.
 *  - Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *  - Neither the name of the contributors may be used to endorse or promote
 * products derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * Version history:
 * ----------------
 * 1.0.0 gplanchat Messages logging utilities
 * 1.0.1 gplanchat Errors & Exception default handlers implementation
 * 1.0.2 gplanchat Encapsulation of trigger_error() language construct to enable
 *  some features from PHP>=5.3
 * 1.0.3 gplanchat Class dataptation for Mystic World
 *
 */


/**
 * Enhances error management and implements unnified debugging routines for a
 * fully maintainable application.
 *
 * @author gplanchat
 */
class Debug
{
    /**
     * @ignore
     */
    private function __construct() {}

    /**
     * Sends an E_ERROR error message
     *
     * @param string $message The error message which will be sent to the error
     * reporting handler
     */
    public static function error($message = NULL)
    {
        trigger_error($message, E_USER_ERROR);
    }

    /**
     * Sends an E_WARNING error message
     *
     * @param string $message The error message which will be sent to the error
     * reporting handler
     */
    public static function warning($message = NULL)
    {
        trigger_error($message, E_USER_WARNING);
    }

    /**
     * Sends an E_NOTICE error message
     *
     * @param string $message The error message which will be sent to the error
     * reporting handler
     */
    public static function notice($message = NULL)
    {
        trigger_error($message, E_USER_NOTICE);
    }

    /**
     * Should send a E_USER_DEPRECATED error message while PHP's main version
     * will be >=5.3, sends an E_NOTICE for the time being.
     *
     * @param string $message The error message which will be sent to the error
     * reporting handler
     */
     public static function deprecated($message = NULL)
     {
         //trigger_error($message, E_USER_DEPRECATED);
         self::notice('DEPRECTATED : ' . $message);
     }

    /**
     * Debug methods initializer. Registers custom error handling methods, for
     * proper error reporting.
     *
     * @return
     */
    public static function init()
    {
        set_exception_handler(array(__CLASS__, 'displayException'));
        set_error_handler(array(__CLASS__, 'displayError'), error_reporting());
    }

    /**
     * Prepares error pages data from catched exceptions
     *
     * @param Exception $e The exception messages to display
     */
    public static function displayException(Exception $e)
    {
        self::displayMessage(
            get_class($e),
                sprintf('<p>%s</p><p>In File <i>%s</i>, line <b>%d</b>'
                    .'</p><p>Stack trace:</p><pre>%s</pre>',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine(),
                $e->getTraceAsString()
                )
            );

        exit(0);
    }

    /**
     * Prepares error pages data from catched user errors
     *
     * @param int $errno The error number
     * @param string $errstr The error message
     * @param string $file The file where the error has been located
     * @param int $line The line where the error has been located in $file
     * @param array $context
     */
    public static function displayError($errno, $errstr, $file, $line, $context)
    {
        $errors = array(
            E_USER_ERROR => 'Fatal Error',
            E_USER_WARNING => 'Warning',
            E_USER_NOTICE => 'Notice',
            E_DEBUG => 'Debug'
            );

        self::displayMessage(
            isset($errors[$errno]) ? $errors[$errno] : 'Unknown Error Type',
            sprintf('<p>%s</p><p>In File <i>%s</i>, line <b>%d</b></p>'
                    .'<p>Context:</p><pre>%s</pre>',
                $errstr,
                $file,
                $line,
                print_r($context, true)
                )
            );

        exit(0);
    }

    public static function displayMessage($title, $message)
    {
        echo <<<EOF
<html>
<head>
<title>Mystic World :: $title</title>
<style type="text/css">
<!--
html,
body
{
    font-size: 10px;

    font-family: Verdana, Arial, sans-serif;
    font-size: 12px;

    padding: 0;
    margin: 0;
}

pre
{
    border: 1px solid #999;
    border-left: 15px solid #999;
    border-top: 5px solid #999;
    padding: 1em;
    color: #333;
    background: #EEE;
}
-->
</style>
</head>
<body>
<div>
<h1>$title</h1>
<span>$message</span>
<hr />
<p>Powered by <i>ProGameMap.com/1.0-dev</i> on <i>${_SERVER['HTTP_HOST']}</i></p>
<p>Copyright &copy; naivelywatching.net</p>
</div>
</body>
</html>
EOF;
    }
}

?>
