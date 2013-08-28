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

    /**
     * Creates the factory for this concrete product.
     * If the class does not exists yet, it is generated on the fly.
     * 
     * The factory implements an interface named after the short name of the
     * product class name with the suffix "Factory". The namespace is the
     * same namespace as the product classname.
     * 
     * The concrete factory is not of your concern, that's the trick of
     * factory method.
     * 
     * @param string $fqcnProduct
     * 
     * @return object the the new factory
     */
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