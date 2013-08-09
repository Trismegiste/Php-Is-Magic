# Composite Design Pattern implementation

## What

It is Composite pattern default implementation. Since there is no class to
extend, only interfaces and traits to add, you can use it no matter your model looks
like and you do have strong typing.

## Howto

Your node object with children must implement Composite and use trait CompositeImpl

Your leaf object must implement Leaf. You could only implement
Component but checking if a node is a leaf or not will be more complicated.
