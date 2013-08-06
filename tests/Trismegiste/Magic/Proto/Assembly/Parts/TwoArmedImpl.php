<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Proto\Assembly\Parts;

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