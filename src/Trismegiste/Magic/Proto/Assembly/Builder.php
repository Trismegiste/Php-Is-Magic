<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Proto\Assembly;

/**
 * Builder is a contract for building mixin object
 */
interface Builder
{

    public function start();

    public function addPart($interfaceName, $traitName = null);

    public function getInstance();
}