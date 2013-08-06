# Closure Strategy

A strategy prototype with closure

## What

It's a template for strategy pattern if your strategies are just simple
functions. You don't want to create many classes just for one use, this tool
is for you

## How

Just inherit from Context interface and use ContextImpl trait, you're done.

There is a public method setStrategy() to inject your closure and a protected
method callStrategy() with any number of arguments to call the closure 
(and check if setted)

## Note

Beware of copy-paste : if you need to copy-paste closure all over your project,
it's time to use a real Strategy pattern.

Injecting Strategy also in constructor of the context could be a good idea.