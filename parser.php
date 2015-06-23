<?php
/**
 * Implements a parser.
 */
require_once 'altext.parser.php';

/**
 * It runs only in CLI mode.
 */
if(php_sapi_name() !== 'cli'){
    throw new Exception('PHP not in CLI mode.');
}

AlTextParser::run($argv[1], $argv[2]);
