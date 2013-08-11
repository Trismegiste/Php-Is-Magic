# Observer Pattern implementation for SPL

## What

Since there is no class to
extend, only one interface and one trait to add, you can use it no matter your model looks
like and you do have strong typing.

## How

The observer object must implement \SplObserver

The subject object (the observed) must implement \SplSubject and use trait SplSubjectImpl

See tests