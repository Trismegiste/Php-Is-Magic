# PHP is Magic

Ok, you already know that PHP is slow, heavy and with inconsistent syntax.

So, where are the plus sides ? 

This interpreted language has some hidden magic. This library try to use
it without messing everything.
 
## Eval

"eval is evil" (sounds good, I like that). O RLY ? Eval is very powerful.
But with great power comes great responsibility. Most of the mockup frameworks 
(PHPUnit for example) use eval. So, is this the Evil serving for the Good ? 
Seems so.

## Magic method __call

This magic method is powerful but it does not replace "hard" type-hinting.
Practical for fast prototyping, it is not suited for further maintenance. Use 
it with cautions.

## Reflection

Long time ago, in a far far away galaxy I coded with c++ and RTTI was not in 
the standard. Later, Java has reflection but very slow compared to its
average speed. Now PHP has reflection and not much slower than its average
"slowness". Using it is not an issue.

## Trait

Traits are very powerful. At first I was very skeptical but now, with good conventions,
I think it is THE real shit of PHP 5.4. They have the power of multi-inheritance 
and solving the diamond problem.

## Closure

I'm talking about binded closures i.e linked to an object, not lamba functions.
Many design patterns (like strategy and template method) can benefit from closures.

## Parsing PHP with PHP

There is a wonderful libray called nikic/PHPParser which does magic too.
Redefining and changing dynamically a class is possible but very slow.

## So what ?

By combining all these features, I'll try to gather some magic tricks which 
can be useful, specially when dealing with legacy code.

## TODO

 * bundle for symfony


