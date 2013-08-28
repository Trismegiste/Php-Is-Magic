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

    public function generate($fqcnProduct)
    {
        $refl = new \ReflectionClass($fqcnProduct);
        $fmName = 'Concrete' . $refl->getShortName() . 'Factory' . crc32($fqcnProduct);
        $fqcnFM = $refl->getNamespaceName() . '\\' . $fmName;
        if (!class_exists($fqcnFM)) {
            $template = file_get_contents(__DIR__ . '/factory.tpl');
            eval(str_replace(array(
                '_NamespaceProduct_',
                '_ProductFactory_',
                '_ConcreteProductFactory_',
                '_FqcnProduct_'
                            ), array(
                $refl->getNamespaceName(),
                $refl->getShortName() . 'Factory',
                $fmName,
                $refl->getName()
                            ), $template
            ));
        }

        return new $fqcnFM();
    }

}