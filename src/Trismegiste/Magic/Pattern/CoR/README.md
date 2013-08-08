# Chain Of Responsibilities

A simulator of CoR with Closure

## What

It's a CoR builder using Closure instead of Handler classes.

Despite the fact that you provided a set of closures for handling the request,
this builder creates a chain with real handlers (subclases of Handler).

So, the day you want to replace closures with your own subclasses, this can be done
without changing clients of the CoR. You have only to inherit from Handler.

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

## Notes

This simulator is intended to be easily replaced with a real CoR when you will
have the time. In the mean time, this tool is ready to go in production.

Anyway, I think it is wise to encapsulate all the creation of the chain
in a factory so replacing this builder by your own chain will go 
smoothly.

About Handler : it is a "constrained" handler, I mean, it is structured as a 
Template Method so you don't have to bother to call successor. The only thing
is to implement one abstract method "processing" and return true of false if
the handler has handled the request or not.

Feel free to extend the Request interface for your needs.
