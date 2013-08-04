# Object Adapter Pattern

A dynamic generation for Object Adapter Pattern

## What 

This is a way to generate on-the-fly adapted object with eval and closure.
Most useful when you have bad legacy code you want to inject in kewl new code. 

## Howto

There is a builder named AdapterBuilder

## Note

To keep things separate, I've copy-paste most of Composite Pattern.
Therefore, I can keep a tight type-hinting : a leaf is a Leaf and cannot
have children. 