# Bi-directional Tree

An extended Composite Design Pattern 

## Howto

Your node object with children must implement Composite and use trait CompositeImpl

Your leaf object must implement Leaf and use trait LeafImpl. You can only implement
Component but checking if a node is a leaf or not will be more complicated.

## Note

To keep things separate, I've copy-paste most of Composite Pattern.
Therefore, I can keep a tight type-hinting : a leaf is a Leaf and cannot
have children. 