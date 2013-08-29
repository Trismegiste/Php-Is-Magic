# Singleton Design Pattern

## What

A singleton in C++ or Java cannot be subclassed. In PHP you can !

## How

Just subclass Singleton and you have a singleton with a static method named
"getInstance()"

## Note

 * singleton => static => cannot evolve => problem in the future
 * singleton => global => cannot be mockuped => no unit test

If you have a DiC like Pimple or within Symfony2, you don't need singletons anymore.