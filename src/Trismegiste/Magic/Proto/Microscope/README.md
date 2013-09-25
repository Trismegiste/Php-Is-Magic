# Microscope

A tool for refactoring : less is more

## What

This is a dynamic adapter generator like the one in ../../Pattern except it works
like a decorator generator. Uh ? Imagine you have a big concrete class with too
many methods and no interface. You want to inject it in a new system with 
interface-type-hinted parameters, without touching anything in your legacy code. 

## Why

The goal is to reduce a too-big contract of an existing class (and its instance)
with a smaller interface. This is an adapter (because the existing class does not
inherit from the small interface) but there is an auto-matching of methods for
implementation.

As you know LSP & ISP, you need your classes to be inherited from multiple little
interfaces, this is the best way to loosely-coupled your new system.

## When

You have legacy code full of concrete classes without abstraction and you have
developped a new system you need to connect with. You have 4 solutions :
 1. type-hint your new system with concrete class : bad
 2. no type-hint and relying on luck for hidden coupling : the worst
 3. type-hint your new system with interfaces and injecting them in legacy code : good but could frighten your project manager
 4. using adapters to narrow the scope of your big object : the best but this is a boring job

## How

This is a builder for the fourth solution. You need an instance of concrete 
class with a big contract and a new interface which share some of its methods
with the class. The builder generates the adapter and wraps the existing object.

It redirects all methods with the same signature from the interface to the object.

The scope is narrower, that's why: "microscope".

```php
$builder = new Builder();
$reducedScope = $builder->scope('My\New\Interface')
                        ->reduce($existingObject);
```

In this way, you don't pollute your new system with legacy classes or have to create 
dumb adapters coupled with the legacy code (that you will throw, someday) 

## Note

If method signatures do not match, use a true adapter or the dynamic adapter builder
I provide in this library (it uses closures to adapt your class to the new interface)