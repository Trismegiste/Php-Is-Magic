<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Dynamic\Parts;

trait TwoArmedImpl
{

    public function lift($str)
    {
        echo "lifting $str";
    }

    public function punch($str)
    {
        echo "punching $str";
    }

}