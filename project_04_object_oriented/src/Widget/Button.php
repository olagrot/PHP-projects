<?php

namespace Widget;

class Button extends Widget
{
    public function draw(): void
    {
        $d=$this->key();
        echo "<input type='button' value='$d'>";
    }
}