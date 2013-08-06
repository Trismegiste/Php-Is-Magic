# Fast prototyping

A set of tools for fast development

## What

A collection of ready-to-use tools and dynamic generators for fast prototyping.

You are tired of coding similar code ever and ever (example : getters and setters)
Let's PHP do this for you.

## How

Okay, there is magic, evil eval and weird things but this is just a fast way to start :
these tools are designed to be easily replaced by better practices.

What is the best ? A class full of public properties or a class with magic getter/setter ?
I believe magic getter/setter can be refactored with real methods later, 
public properties cannot unless making many changes. That was my goal when I
started this library.

As always I tried to minimize the amount of WTF by limiting the magic.