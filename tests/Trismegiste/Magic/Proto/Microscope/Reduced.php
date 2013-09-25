<?php

namespace tests\Trismegiste\Magic\Proto\Microscope;

interface Reduced
{

    public function proto(\Iterator $ita, array& $arr2, callable $func2);

    public function noMatching();

    public function checkReference($arg);

    public function checkArray(array $arg);
    
    public function checkNumber($a, $b);
}