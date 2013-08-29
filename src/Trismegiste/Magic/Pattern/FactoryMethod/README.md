# Factory Method

A dynamic generator for Factory Method design pattern

## Why

Say, you have a class you want to build. You need a factory and you need to type-hint
a method with the interface of this factory (see the [Factory Method pattern][1])

This tool provide a way to rapidly generate that interface and the concrete
factory.

## How

Use the generator to create a new factory

```php
$generator = new Generator();
$factory = $generator->getFactory('MySpace\MyProduct');
$newProduct = $factory->create()
```

$factory implements the generated interface MySpace\MyProductFactory

The methood "create" can accept any number of arguments and they are passed to
the constructor of MyProduct as is.

## Note

If you need a more complex factory, code a real one. This generator is useful
when you have MyProduct but you want to type-hint a method with a factory for
MyProduct.

[1]: http://www.oodesign.com/images/stories/factory%20method%20implementation%20-%20uml%20class%20diagram.gif