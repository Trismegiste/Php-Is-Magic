# State Design Pattern

A state pattern with closures

## What

It is a prototype of State pattern using closures. Useful for a little set of state
with few transitions (actions). All states are embedded in the context.

## How

You must implement the interface Context and use the trait ContextImpl in your own
class. You can add a state with its transition with the protected method addState (I
advice you to do it in the ctor).

Then you have two public methods "getState()" and "doTransition()" to move the state
through the workflow you've defined.

```php
$this->addState('basket', array(
                   'payment' => function() {
                        $this->setState('order');
                    }
                ));

$context->doTransition('payment');             
```

The first defined state is the initial state.

All closures are bound to the context so you can use $this with correct visibility.

Optionnaly, you can use the trait MagicTransition which alias all transitions call
by a method doXxxxxx() where xxxxxx is the transition name. 

## Note

Since the standard state pattern replaces tons of if/switch, I find this very useful but 
the drawback is you have tons of little methods scattered among a set of state classes.

With this approch, you keep all states management in the original class and replaces
tons of if/switch. This tool simplifies the refactoring in a real State pattern.

You can add magic call method to alias doTransition() with the trait MagicTransition
but I'm reluctant to add magic call in a trait (too much magic)
