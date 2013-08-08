# Decorator Pattern

A dynamic generation for [Decorator][1] of object

## What 

This is a way to generate on-the-fly decorated object with eval and closures.
Useful when you have bad legacy objects you want to inject in kewl new code. 

As you know, Decorator pattern lets you replace any object by its decorated
version. Since it implements the same interface, clients don't notice the
difference with the original (wrapped) object. 

In many situations, decorating an object is most efficient than 
inheritance because your classes are loosely-coupled
and it is dynamic. The drawback is it's slower (just a little)

## How

Starting with an interface. The decorator pattern is based on a contract, 
both implemented by "real" object and by decorator. If your kewl new source code
don't rely on interfaces but concrete classes, well, I must inform you it 
is not that kewl than you think...

This builder instantiates a new decorator implementing the contract and wrapping
an object which implements the same contract. 

You can override any method of the contract with "override".
In this example, getTitle() is decorated with html tag :

```
$this->builder = new DecoratorBuilder();
$decorated = $builder
                ->decorate('Some\Interface')
                ->override('getTitle', function() {
                            return '<h1>' . $this->wrapped->getTitle() . '</h1>';
                        })
                ->getInstance($wrapped); // passes the original object
```

As you see the wrapped object is accesible through $this->wrapped in the decorator.

## Notes

There is no possible way to add new methods with this builder. This could be
enabled with the magic __call and closures but I don't want to let you build 
some Frankenstein's monsters. In this way, you keep relying on type-hinting.

If you need more complicated decorator, code a real decorator pattern. This tool
is only intended to build decorated objects from time to time, with legacy code,
for example.

The decorator has a (generated) public method to inject closures but its name
is randomized to forbid you to change overriding after instantiation. With this,
the decorator cannot be mis-used from its original behavior. 

[1]: http://en.wikipedia.org/wiki/Decorator_pattern