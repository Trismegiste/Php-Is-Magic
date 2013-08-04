# Object Adapter Pattern

A dynamic generation for Object Adapter Pattern

## What 

This is a way to generate on-the-fly adapted object with eval and closures.
Most useful when you have bad legacy code you want to inject in kewl new code. 

## Howto

There is a builder named AdapterBuilder
```
$builder = new AdapterBuilder();
$newObj = $builder
        ->adapt('Fully\Qualified\Interface\Name')
        ->addMethod('getName', function() use ($adaptee) {
                    return $adaptee->data;
                })
        ->getInstance();
```

You are not bound to implement all methods with closure if the method
is not called in the client. Although an exception will be thrown if it is called
anyway. This behavior to prevent silent bug.

## Note

Some parts are copy-paste from ircmaxel/MixinPHP (for generator)

Not working with interfaces which contain magic methods (__call, __isset ...)
because magic combined with magic is too dangerous.