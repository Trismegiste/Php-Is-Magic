# Trait assembly

A new way of programing by assembling traits and interfaces

## What

Yes, it is ambitious, but this can be your way.

By dynamically assembling traits and interfaces, you can have both world :
SRP, no copy-paste, fast prototyping and strong type-hinting.

You need conventions : For each interface, you need an "implementation" of
this interface in a trait. With these small pieces of code, you build complex
objects.

## How

FrankenTrait make that.

It is a builder with fluent interface. Default naming conventions are mine, sorry :)

```
doctor = new FrankenTrait();
$monster = $this->doctor
        ->start("Castle\Creature")  // classname
        ->addPart('Parts\Person')  
        ->addPart('Parts\TwoArmed')
        ->addPart('Parts\TwoLegged')
        ->getInstance('Kiki');  // param constructor
```

Each addPart adds an interface and a trait. If trait name is empty,
the trait name is the interface name suffixed with 'Impl'.
 
See unit test.
