# Auto-magic getter/setter for anemic model

## What

The purpose of this trait is to replace a container with public properties
by an anemic model with dumb accessor/mutator and ready to be subclassed
without generating future WTF.

Automagic can be very bad for debugging that's why I try to minimize the
amount of "magic" with this trait. No surprise for subclasses.

## Howto

Insert this trait in your class and all accessible properties of THIS class
in THIS class scope will have a camelCase getter and a setter.

protected $firstName enables getFirstName() and setFirstName($str)

This behavior is NOT inherited for new properties added in subclasses.
Of course the previous getters and setters are still enabled on subclasses.

## Note

Not using '_' in properties name is by design. See tests.

No getter/setter on injected (public) properties : this will be a WTF generator.