<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Proto\Assembly\Parts;

trait PersonImpl
{

    protected $name;

    public function __construct($str)
    {
        $this->name = $str;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($str)
    {
        $this->name = $str;
    }

}