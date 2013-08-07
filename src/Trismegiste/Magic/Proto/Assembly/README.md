# Trait assembly

A new way of programing by assembling traits and interfaces

## What

Yes, it is ambitious, but maybe this is your way.

By dynamically assembling traits and interfaces, you can have both world :
SRP, ISP, no copy-paste, fast prototyping and strong type-hinting.

You need conventions : For each interface, you need an "implementation" of
this interface in a trait. With these small pieces of code, you build complex
objects.

## How

FrankenTrait makes that.

It is a builder with fluent interface. Default naming conventions are mine, sorry :)

```
$doctor = new FrankenTrait();
$monster = $this->doctor
        ->start()  // reset builder
        ->addPart('Parts\Person')   // adds Person interface and PersonImpl trait
        ->addPart('Parts\TwoArmed') // adds TwoArmed interface and TwoArmedImpl trait
        ->addPart('Parts\TwoLegged', 'Parts\RobotLeggedTrait') // adds TwoLegged interface and RobotLeggedTrait trait
        ->getInstance('Kiki');  // param constructor
```

Each addPart adds one interface and one trait. If trait name is unspecified,
the trait name is the interface name suffixed with 'Impl'.

Same interfaces and traits will give you the same class.
 
See unit test.
