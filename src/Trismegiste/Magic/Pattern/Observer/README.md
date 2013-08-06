# Observer Pattern implementation for SPL

## What

Since there is not class to
extend, only one interface to add and one trait, you can use it no matter your model looks
like and you do have strong typing.

## Howto

The observer object must implement \SplObserver

The subject object (the observed) must implement \SplSubject and use trait SplSubjectImpl

See tests