<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\CoR;

/**
 * ClosureHandler is a Handler with a Closure
 */
class ClosureHandler extends Handler
{

    private $algo;

    public function __construct(\Closure $cls)
    {
        $this->algo = $cls;
    }

    protected function processing(Request $req)
    {
        return call_user_func($this->algo, $req);
    }

}