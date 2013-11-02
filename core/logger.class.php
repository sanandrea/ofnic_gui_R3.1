<?php

if (!defined('OFNIC')) die('Direct access not allowed!');

/**
 * Logger class file.
 */

/**
* Copyright 2013 (C) Universita' di Roma La Sapienza
*
* This file is part of OFNIC Uniroma GE.
*
* OFNIC is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* OFNIC is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with OFNIC.  If not, see <http://www.gnu.org/licenses/>.
*
* @author Andi Palo
* @created 02/11/2014
*/

 Class logger {
        /**
         * Keeps a log of registers happened during the execution
         *
         * @access private
         */
        private static $logs = array();

        /**
         * General enabled, determined from Registry configuration
         *
         * @access private
         */
        private static $enabled = false;

        /**
         * Ajax enabled output, configured in Registry
         *
         * @access private
         */
        private static $ajaxEnabled = true;

        /**
         * Action to be executed, established by router class
         *
         * @access private
         */
        private static $action = '';

        /**
         * Controller to be called, established by router class
         *
         * @access private
         */
        private static $controller = '';

        /**
         * Header template to be used for report
         *
         * @access private
         */
        private static $header = 'DEBUG INFORMATION';

        /**
         * Separator to be used in report
         *
         * @access private
         */
        private static $separator = '---------------------------------------------';

        /**
         * Format for time display
         *
         * @access private
         */
        private static $format = '7.3';

        /**
         * Line break to be used
         *
         * @access private
         */
        private static $lineBreak = "\n";

        /**
         * Internal reference for instancing and initializing the class
         *
         * @access private
         */
        private static $logger = null;

        /**
         * Serves as an internal marker to finish queries block and start views section
         * TODO: enable true sections in this class by using nested associative arrays
         *
         * @access public
         */
        public static $firstView = true;

        /**
         * Constructor
         */
        public function __construct() {
            // profiler is called during registry initialization
            // cannot use registry to get the configuration
            include (__ROOT_PATH . '/config/config.php');

            self::$enabled = isset($config['enable_log']) ? $config['enable_log'] : false;
        }

        /**
         * Adds a log to the internal array
         *
         * @param string $msg to show
         * @param boolean $checkpoint if true, marks times with the last checkpoint, allowing blocks or sections
         * @param boolean $finish this is the finish record, it outputs the total time
         * @param float $start if used, then the time is measured incrementally since this value, instead of since last record
         * @param boolean $error if an error is marked, the output is labeled in red
         *
         * @access public
         */
        static public function addLog($msg = '', $checkpoint = false, $finish = false, $start = 0, $error = false) {
            // create the object for the very first time
            if (!self::$logger) {
                self::$logger = new Logger();
            }

            // must be explicitly enabled
            if (self::$enabled) {
                // check that the entry does not exist previously
                foreach (self::$logs as $i => $log) {
                /*    if ($log['msg'] == $msg) {
                        $msg = sprintf('Duplicates #%2.0F', $i);
                    } */
                }

                self::$logs[] = array('time' => microtime(true), 'msg' => $msg, 'checkpoint' => $checkpoint, 'finish' => $finish, 'start' => $start, 'error' => $error);
            }
        }

        /**
         * Alias for addLog for checkpoints
         *
         * @param string $msg
         *
         * @access public
         */
        static public function checkpoint($msg = '') {
            self::addLog($msg, true);
        }

        /**
         * Alias for addLog for the finish entry
         *
         * @param string $msg
         *
         * @access public
         */
        static public function finish($msg = '') {
            self::addLog($msg, true, true);
        }

        /**
         * Alias for addLog for queries
         *
         * @param string $qry the message to show
         * @param float $start if used, then the time is measured incrementally since this value, instead of since last record
        
         * @access public
         */
        static public function query($qry = '', $start = 0) {
            self::addLog($qry, false, false, $start);
        }

        /**
         * Alias for addLog for sqlErrors
         *
         * @param string $err the error to show
         *
         * @access public
         */
        static public function sqlError($err = '') {
            self::addLog($err, false, false, 0, true);
        }

        /**
         * Alias for addLog for general errors
         *
         * @param string $err the error to show
         *
         * @access public
         */
        static public function error($err = '') {
            self::addLog($err, false, false, 0, true);
        }

        /**
         * Produces an output
         *
         * @access public
         */
        static public function show() {

            // must be explicitly enabled
            if (!self::$enabled) {
                return;
            }

            // calculate times
            $output = '';
            $current = TIME_START;
            $checkpoint = TIME_START;
            $line = '';
            //

            $output .= self::$lineBreak;
            $output .= self::$header . self::$lineBreak . self::$separator . self::$lineBreak;

            $output .= '<strong>Controller:</strong> <em>' . self::$controller . '</em>' . self::$lineBreak;
            $output .= '<strong>Action:</strong>     <em>' . self::$action . '</em>' . self::$lineBreak . self::$separator . self::$lineBreak;

            foreach (self::$logs as $i => $log) {
                // checkpoints mark time since last checkpoint
                if ($log['checkpoint']) {
                    if (!self::$logs[$i - 1]['checkpoint']) {
                        $output .= sprintf(self::$separator . self::$lineBreak);
                    }
                    $diff = $log['time'] - ($log['finish'] ? TIME_START : $checkpoint);
                    $checkpoint = $log['time'];
                }
                // some processes mark the start time, so that the different is calculated based on that
                else if ($log['start']) {
                    $diff = $log['time'] - $log['start'];
                }
                // finally, check difference against last log
                else {
                    $diff = $log['time'] - $current;
                }

                // then generate line
                $line = sprintf('#%2.0F %' . self::$format . 'F ms: ' . str_replace("%", "%%", $log['msg']) . self::$lineBreak, $i, $diff * 1000);

                if ($log['checkpoint']) {
                    $output .= '<strong>' . $line . '</strong>';
                } else if ($log['error']) {
                    $output .= '<span style="color:red">' . $line . '</span>';
                } else {
                    $output .= $line;
                }

                // add another separator for checkpoints for better readability
                if ($log['checkpoint']) {
                    $output .= sprintf(self::$separator . self::$lineBreak);
                }

                $current = $log['time'];
            }

            $output = '<pre style="margin: 30px 0px; padding:5px; clear: both; overflow: auto; background-color: lightyellow;">' . str_replace(self::$separator . self::$lineBreak, '<hr />', str_replace(self::$header, '<strong>' . self::$header . '</strong>', $output)) . '</pre>';
            echo $output;
        }

        /**
         * Used to set the action in real time
         * 	Useful to choose an output mode
         *
         * @param string the action
         *
         * @access public
         */
        public static function setAction($action = '') {
            self::$action = $action;
        }

        /**
         * Used to set the controller in real time
         * 	Given as debug information
         *
         * @param string the action
         *
         * @access public
         */
        public static function setController($controller = '') {
            self::$controller = $controller;
        }

    }

?>
