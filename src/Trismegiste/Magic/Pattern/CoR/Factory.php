<?php

namespace Trismegiste\Magic\Pattern\CoR;

interface Factory
{

    /**
     * Gets the chain of responsibilities
     * 
     * @return Handler the head of the chain
     */
    function createChain();
}