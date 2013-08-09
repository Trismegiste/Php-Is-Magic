# Bi-directional Tree

An extended Composite Design Pattern 

## What

It's a Composite pattern with bi-directional navigation :
 * from a node to its children
 * from a child to its parent

Since there is no class to
extend, only interfaces and traits to add, you can use it no matter your model looks
like and you do have strong typing.

## Howto

Your node object with children must implement Composite and use trait CompositeImpl

Your leaf object must implement Leaf and use trait LeafImpl. You can only implement
Component but checking if a node is a leaf or not will be more complicated.

## Note

To keep things separate, I've copy-paste most of Composite Pattern.
Therefore, I can keep a tight type-hinting : a leaf is a Leaf and cannot
have children. 