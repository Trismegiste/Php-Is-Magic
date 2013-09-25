<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Proto\Microscope;

/**
 * AdapterGenerator generates code based on an interface
 */
class AdapterGenerator
{

    protected $redirect;
    protected $missing;

    public function __construct()
    {
        $this->redirect = new RedirectGenerator();
        $this->missing = new MissingGenerator();
                
    }

    public function generate(\ReflectionClass $refl, $adapterName, \ReflectionClass $wrapped)
    {
        if (!$refl->isInterface()) {
            throw new \LogicException($refl->getName() . ' must be an interface');
        }

        $namespace = $refl->getNamespaceName();
        $shortName = $refl->getShortName();

        $body = ' protected $wrapped;
            public function __construct($obj) { $this->wrapped = $obj; } ';

        foreach ($refl->getMethods() as $method) {
            $methodGenerator = $this->missing;
            $searchName = $method->getName();
            if ($wrapped->hasMethod($searchName)) {
                if ($this->canRedirected($method, $wrapped->getMethod($searchName))) {
                    $methodGenerator = $this->redirect;
                }
            }
            $body .= $methodGenerator->generate($method);
        }

        return "namespace $namespace { class $adapterName implements $shortName { $body } }";
    }

    protected function canRedirected(\ReflectionMethod $source, \ReflectionMethod $target)
    {
        if ($target->isPublic() &&
                !preg_match('#^__#', $source->getName()) &&
                ( $source->returnsReference() == $target->returnsReference())) {

            $sourceParam = $source->getParameters();
            $targetParam = $target->getParameters();

            // check parameters
            if (count($targetParam) != count($sourceParam)) {
                return false;
            }

            foreach ($targetParam as $idx => $to) {
                $from = $sourceParam[$idx];
                
                if (($to->isArray() != $from->isArray()) ||
                        ($to->getClass() != $from->getClass()) ||
                        ($to->isCallable() != $from->isCallable()) ||
                        ($to->isPassedByReference() != $from->isPassedByReference())) {
                    return false;
                }
            }
            // all ok returns true
            return true;
        }

        return false;
    }

}