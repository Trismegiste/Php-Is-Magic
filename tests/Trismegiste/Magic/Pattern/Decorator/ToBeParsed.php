<?php

namespace tests\Trismegiste\Magic\Pattern\Decorator;

interface ToBeParsed
{

    public function getName();

    public function &getPtr();

    public function withParam(\SplFixedArray $arr, \Iterator& $it);
}