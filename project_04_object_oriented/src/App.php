<?php

class App
{
    public function run(): void {

        $storage=new \Storage\FileStorage();
        $button1=new \Widget\Button(1);
        $button2=new \Widget\Button(2);
        $button3=new \Widget\Button(3);
        $link1=new \Widget\Link(1);
        $link2=new \Widget\Link(2);
        $link3=new \Widget\Link(3);
        $storage->store($button1);
        $storage->store($button2);
        $storage->store($button3);
        $storage->store($link1);
        $storage->store($link2);
        $storage->store($link3);

        $tab=$storage->loadAll();
        foreach ($tab as $el){
            if ($el instanceof \Widget\Widget){
                $this->render($el);
            }
        }

    }
    private function render(Widget\Widget $w):void{
        $w->draw();
    }
}
