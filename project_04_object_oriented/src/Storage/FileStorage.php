<?php

namespace Storage;

use Concept\Distinguishable;
use Config\Directory;
use Widget\Widget;

class FileStorage implements Storage
{
    public function store(Distinguishable $d) : void{
        $dir=Directory::storage();
        $s=serialize($d);
        file_put_contents($dir.$d->key(),$s);
    }
    public function loadAll(): array
    {
        $dir=Directory::storage();
        $tab = array();
        $files=scandir($dir);
        if($files) {
            foreach ($files as $item) {
                if ($item == "." or $item == ".." or $item == ".gitignore" or is_dir($item)) {
                    continue;
                }
                $myfile = fopen($dir . $item, "r+") or die("Unable to open file!");
                $size=filesize($dir . $item);
                if($size){
                    $value = fread($myfile, $size);
                    if($value){
                        $un = unserialize($value);
                        if ($un instanceof Widget){
                            array_push($tab, $un);
                        }
                    }
                }
                fclose($myfile);
            }
        }
        return $tab;
    }
}