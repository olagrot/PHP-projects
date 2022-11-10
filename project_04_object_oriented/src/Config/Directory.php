<?php

namespace Config;

class Directory
{
    private static string $root;
    public static function set(string $root): void
    {
        self::$root=$root;
    }
    public static function root():string{
        return self::$root;
    }
    public static function storage():string{
        return self::root()."storage/";
    }
    public static function view():string{
        return self::root()."view/";
    }
    public static function src():string{
        return self::root()."src/";
    }
}
