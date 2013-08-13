<?php

namespace Trismegiste\Magic\Pattern\CoR;

interface Factory
{

    /**
     * Gets the chain of responsibilities
     * 
     * @return Hnndler
     */
    function createChain();
}