<?php

namespace Widget;

class Link extends Widget
{
    public function draw(): void
    {
        $d=$this->key();
        echo "<a href=''>$d</a>";
    }

}