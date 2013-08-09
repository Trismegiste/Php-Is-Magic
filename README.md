# PHP is Magic

![Pony](./doc/img/pony.jpg)

Ok, you already know that PHP is slow, memory intensive and with inconsistent syntax.

So, where are the plus sides ?

This interpreted language has some hidden magic. This library tries to use
it without messing your project.

Despite the funny pics, this lib is fully tested : [![Build Status](https://travis-ci.org/Trismegiste/Php-Is-Magic.png?branch=master)](https://travis-ci.org/Trismegiste/Php-Is-Magic)

## Eval

"eval is evil" (sounds good, I like that). O RLY ? Eval is very powerful.
But with great power comes great responsibility. Most of the mockup frameworks 
([PHPUnit][2] for example) use eval. So, is this the Evil serving for the Good ? 
Seems so.

## Magic method __call

This magic method is powerful but it does not replace "strong" type-hinting.
Practical for fast prototyping, it is not suited for further maintenance. Use 
it with cautions.

![color](./doc/img/gandalf.jpg)

## Reflection

Long time ago, in a far far away galaxy I was coding with VC++ and RTTI was not in 
the standard. Later, Java has reflection but very slow compared to its
average speed. Now PHP has reflection and not much slower than its average
"slowness". Using it is not an issue.

## Trait

Traits are very efficient. At first I was very skeptical but now, with good conventions,
I think it is THE real shit of PHP. They have the power of multi-inheritance 
and solving the [diamond problem][3].

![shrike](./doc/img/nagato.jpg)

## Closure

I'm talking about bound closures i.e linked to an object, not [lamba functions][4].
Many design patterns (like Strategy and Command) can benefit from closures.

## Parsing PHP with PHP

There is a wonderful libray called nikic/PHPParser which does magic too.
Redefining and changing dynamically a class is possible but very slow.

![harry](./doc/img/harry.jpg)

## So what ?

By combining all these features, I'll try to gather some magic tricks which 
can be useful, specially when dealing with legacy code. I like to think
most of the tools provided here are like **simulators** and 
not always good practices (specially true for design pattern simulators)

Simulators can be helpful in early stage of development when your design are
not finished and you want to test which pattern is suited to solve your problem. 
Well, at least it's better than copy-paste some scripts from an old project :)

Read the listing of features in this library :
 * [Design Pattern simulator/implementor](/src/Trismegiste/Magic/Pattern)
 * [Fast Prototyping (boilerplate)](/src/Trismegiste/Magic/Proto)

## Notes

Despite the fact that magic is a potential WTF generator, I try to minimize
problems by forcing the use of interface, adding many validators and also 
preventing mis-uses of some tools (see DecoratorBuilder for example).

It is also an another way to explore common patterns with new features.
For example, I believe traits will change the future of PHP frameworks
(in fact it has [already started][1]).

## Doc

I have written a readme for each tool in its folder

## TODO

 * bundle for symfony

[1]: http://silex.sensiolabs.org/doc/usage.html#traits
[2]: https://github.com/sebastianbergmann/phpunit-mock-objects/blob/master/PHPUnit/Framework/MockObject/Generator.php#L272
[3]: http://en.wikipedia.org/wiki/Multiple_inheritance#The_diamond_problem
[4]: http://en.wikipedia.org/wiki/Anonymous_function
