<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        /**
         * The variable $LANG should receive the result of {@link http://php.net/parse_ini_file parse_ini_file()}. The @ in early suppresses the error message if the INI file is not found. $LANG is a standardized variable name. If you want to use another variable name, you must change the {@link altext()} function in the file {@link altext.php}
         */
        $LANG = @parse_ini_file('en_US.ini');
        
        /*
         * include altext library
         */
        require_once 'altext.php';
        
        /**
         * The translation is done by {@link altext()} function. If you want to use another name function, keep in mind that "altext" is used by the parser to search for messages to translate.
If you want to change the function name (for gettext, for example), also change the {@link altext.php} files and {@link altext.parser.php}.
In {@link altext.php}, just change the name of the function.
In {@link altext.parser.php} file, change the line <code>preg_match_all ("/altext\(\'(.*)\'\)/", $data, $matches)</code> exchanging "altext" with the name of the desired function. This will make the parser search for the new function name and not by "altext".
         */
        echo altext('Esta mensagem será traduzida');
        echo altext("Outra mensagem para traduzir");//Only messages in single quotes are identified by the parser. This is necessary to prevent variables are interpreted during the execution of the source code and are not identified in the INI files.
        echo sprintf(//We need to place multiple lines because the parser is confused with)
                altext('Hoje é dia %s')
                , date('d'));
        
        ?>
    </body>
</html>
