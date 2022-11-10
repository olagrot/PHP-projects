<?php

namespace Concept;

abstract class Distinguishable
{
    private int $id;
    public function __construct(int $id)
    {
        $this->id=$id;
    }
    public function key():string{
        $name=explode("\\",static::class);
        return "widget_".strtolower($name[1])."_".$this->id;
    }
}