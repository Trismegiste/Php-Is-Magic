<?php

/*
 * Magic pattern example
 */

namespace tests\Trismegiste\Magic\Pattern\BiDirTree\Example;

/**
 * ModelImpl is an implementation of ModelInterface
 */
trait ModelImpl
{

    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

}