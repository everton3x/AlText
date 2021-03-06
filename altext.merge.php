<?php

/**
 * Compare and merge INI files with translations. Compares an old file, already translated, with a new file generated by the parser, merging the existing messages with new messages and excluding non-existent messages.
 */
class AlTextMerge{
    
    /**
     * Performs the merge.
     * @param string $old The old INI file.
     * @param string $new The new INI file.
     * @param string $result The merged INI file.
     * @throws Exception
     */
    public static function merge($old, $new, $result){
        if(!file_exists($old)){
            throw new Exception("\$old '$old' not exist!");
        }else{
            if(!$fold = parse_ini_file($old)){
                throw new Exception("Unable to load \$old '$old'.");
            }
        }
        
        if(!file_exists($new)){
            throw new Exception("\$new '$new' not exist!");
        }else{
            if(!$fnew = parse_ini_file($new)){
                throw new Exception("Unable to load \$old '$old'.");
            }
        }
        
        if(!$fresult = fopen($result, 'wb')){
            throw new Exception("Unable to create \$result '$result'.");
        }
        
        $newer = 0;
        $stand = 0;
        $deleted = 0;
        foreach ($fnew as $hash => $text){
            if(key_exists($hash, $fold)){
                $text = $fold[$hash];
                $stand++;
            }else{
                $newer++;
            }
            
            $string = "$hash = \"$text\"".PHP_EOL;
            if(!fwrite($fresult, $string)){
                throw new Exception("Unable to write \$string '$string' into $result");
            }
        }
        
        $deleted = count($fold) - $stand;
        fclose($fresult);
        
        exit("Comparing the new file $new to the old file $old identified $newer news messages, $stand messages were kept and $deleted deleted messages.".PHP_EOL);
    }
}