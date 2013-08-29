# Magic design patterns

A collection of design patterns redesigned with special features of PHP

## What

Here it is a collection of DP re-visitied with the extra-features of PHP 5.4

The 23 DP of Gang of Four was originally thought with C++ in mind 
(see he Adapter Class DP for exemple). Then comes Java and its single concrete
inheritance and we lost some special features of C++. The lost of 
concrete multi-inheritance was not a big deal (IMO), but there is no reason to try
to adapt some of these DP with unique features of PHP like trait, magic
methods and closures.

## How 

There are two kinds of pattern here : magic patterns which rely on eval, __call
or closure that you can use AS IS. They are much like emulators of pattern than
real new implementation (I don't pretend to invent anything here,
the GoF are the discovers of patterns for OOP, thanks to them !). 

The others are combo of interface + trait to use it anywhere anytimes. Since
there's no class to extend, even abstract ones, you are free to design your
classes how you like it. Interfaces give you strong typing and traits avoid
the copy-paste bad habit. Let think out of box.

## Y U NO use static code generator
... instead of using crappy eval and __call ?

I try to avoid code generation. Because in an usual project management, 
you spend more time on its maintenance and its update than its development,
code generators are the best way to overwhelm the maintenance capabilities of a 
team of developers. And IMO, I find code generators kill the K.I.S.S 
approach and they kill any chance to build better OO design.

Furthermore, most of items in this library are meant to be replaced by
real patterns, but only when they prove to be **really** useful.