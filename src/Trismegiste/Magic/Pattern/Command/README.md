# Command Pool

A Command pattern (sort of)

## What

It's an implementation of a command pattern with closure and magic call.

You attach your closures to the CommandPool and call execute with the command name
and other parameters, or use the magic call execMyCommandName($param).

## How 

```
$command = new CommandPool();
$command
        ->attach('Area', function($radius) {
                    return pi() * $radius * $radius;
                });
$command->execute('Area', 3);
-- or --
$command->execArea(3);
```

See tests

## Notes

Feel free to inject the Receiver (from the real design pattern) with "use ($receiver)"
in the Closure.

Ready to be refactored with a real Command Pattern : use a full interface to
declare the 'execXxxxx' methods.

Also could be used as an abstract factory (without type-hinting anyway) if
each closure creates a new object with the provided parameters.