<?php

/**
 * Is to translate messages.
 */
class AlTextParser{
    
    /**
     * Performs searches for messages for translation.
     * 
     * @param string $source_dir The directory where the source files with messages for translation. All files in this directory and child directories are searched.
     * @param string $output_file An INI file to save the results of the scan.
     * @throws Exception
     */
    public static function run($source_dir, $output_file){
        if(!is_dir($source_dir)){
            throw new Exception("\$source_dir '$source_dir' is not a valid directory.");
        }
        
        
        $ini = [];
        $found = [];
        $files = [];
        
        $files = self::getFiles($source_dir, $files);
        
        foreach ($files as $source){
            $result = self::parseFile($source);
            $found = array_merge($result, $found);
        }
        
        if(count($found) > 0){
            foreach ($found as $message){
                $ini[sha1($message)] = $message;
            }
        }
        
        if(count($ini) === 0){
            exit('Nothing was found to translate.'.PHP_EOL);
        }
        
        if(!$output = fopen($output_file, 'wb')){
            throw new Exception("Error trying to open / create \$output_file $output_file");
        }
        
        $counter = 0;
        foreach ($ini as $hash => $text){
            $write = "$hash = \"$text\"".PHP_EOL;
            if(!fwrite($output, $write)){
                throw new Exception("Error on write '$write' to $output_file!");
            }
            $counter++;
        }
        
        fclose($output);
        
        exit("They were found and written $counter texts in the file $output_file.".PHP_EOL);
    }
    
    /**
     * Runs the scan on a specific file.
     * @param string $filename The path to the file to be searched.
     * @return array An array with the results of the scan.
     * @throws Exception
     */
    protected static function parseFile($filename){
        
        if(!file_exists($filename)){
            throw new Exception("\$filename '$filename' not found!");
        }
        
        if(!$handle = fopen($filename, 'rb')){
            throw new Exception("Erro on open \$filename '$filename'.");
        }
        
        $return = [];
        $counter = 0;

        while(!feof($handle)){
            $data = fgets($handle);
            preg_match_all("/altext\('(.*)'\)/", $data, $matches);

            if(count($matches) > 0){
                foreach ($matches[1] as $text){
                    $return[] = $text;
                    $counter++;
                }
            }
        }
        
        fclose($handle);
        
        echo "Analyzing $filename: $counter found.".PHP_EOL;
        
        return $return;
    }
    
    /**
     * Search files in a given directory.
     * @param string $dir The directory to be searched.
     * @param array $files The list of found files.
     * @return array The list of found files.
     * @throws Exception
     */
    protected static function getFiles($dir, array $files){
        if(!is_dir($dir)){
            throw new Exception("\$dir '$dir' is not a valid directory.");
        }
        
        $childs = glob("$dir/*");
        
        array_shift($childs);//remove ./
        array_shift($childs);//remove ../
        
        foreach ($childs as $filename){
            if(is_dir($filename)){
                $files = self::getFiles($filename, $files);
            }else{
                $files[] = realpath($filename);
            }
        }
        
        return $files;
    }
}