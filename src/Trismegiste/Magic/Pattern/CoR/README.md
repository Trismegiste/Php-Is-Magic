# Chain Of Responsibilities

A simulator of CoR with Closure

## What

It's a CoR builder using Closure instead of Handler classes.

Despite the fact that you provided a set of closures for handling the request,
this builder creates a chain with real handlers (subclasses of Handler).

So, the day you want to replace closures with your own subclasses, this can be done
without changing clients of the CoR. You only have to inherit from Handler.

## How

Create the builder :
```
$builder = new ChainBuilder();
```

Add your closures :
```
$chain = $builder
            ->start()
            ->append(function(Request $req) {
                        return true;
                    })
            ->getResult();
```

$chain is an instance of ClosureHandler (a subclass of Handler) so
it can handle a request with :
```
$chain->handle($request);
```

## Why

This pattern is really useful if there is a identified Request idea (like
a mouse event on a GUI), it's not just a funny way to transform a linear algorithm
into a recursive one. If you would have different chains built with a pool of handlers,
this pattern is suited. If there is only one chain without re-using handlers,
forget it and K.I.S.S.

Eventually, if you are limited by this simulator (you need to copy-paste closures
for example), it's that you really need a CoR after all.

## Notes

This simulator is intended to be easily replaced with a real CoR when you will
have the time. In the mean time, this tool is ready to go in production.

Anyway, I think it is wise to encapsulate all the creation of the chain(s)
in a factory(ies) so replacing this builder by your own chain will go 
smoothly.

About subclassing Handler : it is a "constrained" handler, I mean, it is structured as a 
Template Method so you don't have to bother to call successor. The only thing
is to implement one abstract method "processing" and returning true of false if
the handler has handled the request or not.

Feel free to extend the Request interface for your needs and don't be afraid to break
LSP in your handler to check for the Request subclass.
