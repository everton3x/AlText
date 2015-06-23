<?php

/**
 * Translates text to the selected language.
 * @param string $text The text to translate.
 * @return string The translated text.
 * @throws Exception
 */
function altext($text){
    $sha1 = sha1($text);
    
    if(!isset($GLOBALS['LANG'])){
        throw new Exception('LANG not defined!');
    }else{
        $LANG = $GLOBALS['LANG'];
    }
    
    if(@key_exists($sha1, $LANG)){
        return $LANG[$sha1];
    }else{
        return $text;
    }
}