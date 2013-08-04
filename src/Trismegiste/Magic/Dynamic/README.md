# Trait assembly

A new way of programing by assembling traits and interfaces

## What

Yes, it is ambitious, but this can be your way.

By dynamically assembling traits and interfaces, you can have both world :
SRP, no copy-paste, fast prototyping and strong type-hinting.

You need conventions : For each interface, you need an "implementation" of
this interface in a trait. With this small pieces of code, you build complex
objects.

## How

FrankenTrait make that.

It is a builder with fluent interface. Default naming conventions are mine, sorry :)

```
doctor = new FrankenTrait();
$monster = $this->doctor
        ->start("Castle\Creature")
        ->addPart(__NAMESPACE__ . '\Parts\Person')
        ->addPart(__NAMESPACE__ . '\Parts\TwoArmed')
        ->addPart(__NAMESPACE__ . '\Parts\TwoLegged')
        ->getInstance('Kiki');
```

Each addPart adds the interface and the trait named with a suffix Impl (can be
overriden)
 
See unit test.
