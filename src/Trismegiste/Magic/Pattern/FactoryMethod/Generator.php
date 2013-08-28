<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\FactoryMethod;

/**
 * Generator is a dynamic generator for factory methods
 */
class Generator
{

    public function getFactory($fqcnProduct)
    {
        $refl = new \ReflectionClass($fqcnProduct);
        $fmName = 'Concrete' . $refl->getShortName() . 'Factory' . crc32($fqcnProduct);
        $fqcnFM = $refl->getNamespaceName() . '\\' . $fmName;
        if (!class_exists($fqcnFM)) {
            eval($this->generate(
                            $refl->getNamespaceName(), $refl->getShortName() . 'Factory', $fmName, $refl->getName()
            ));
        }

        return new $fqcnFM();
    }

    protected function generate($ns, $iName, $fName, $product)
    {
        $template = file_get_contents(__DIR__ . '/factory.tpl');

        return \str_replace(array(
            '_NamespaceProduct_',
            '_ProductFactory_',
            '_ConcreteProductFactory_',
            '_FqcnProduct_'
                ), array(
            $ns,
            $iName,
            $fName,
            $product
                ), $template
        );
    }

}