# Composite Design Pattern implementation

## Howto

Your node object with children must implement Composite and use trait CompositeImpl

Your leaf object must implement Leaf. You can only implement
Component but checking if a node is a leaf or not will be more complicated.
