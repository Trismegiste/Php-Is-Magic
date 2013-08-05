# Command Pool

A Command pattern (sort of)

## What

It's an implementation of a command pattern with closure and magic call.

You attach your closures to the CommandPool and call execute wih the command name
and other arguments or use the magic call execMyCommandName($param).

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

See test

## Notes

Feel free to add the Receiver (from the real design pattern) with "use ($receiver)"
in the Closure.