<?php


namespace App;


class Opacity
{
    public function __construct(System $system)
    {
        $dirs = $system->getDirList('dir1');
        echo '<pre>';
        print_r($dirs);
        exit;
    }
}