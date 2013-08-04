<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Decorator;

class Article implements Model
{

    protected $title;

    public function __construct($str)
    {
        $this->title = $str;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($str)
    {
        $this->title = $str;
    }

}