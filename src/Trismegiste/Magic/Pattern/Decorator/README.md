# Decorator Pattern

A dynamic generation for Decorator of object

## What 

This is a way to generate on-the-fly decorated object with eval and closures.
Useful when you have bad legacy code you want to inject in kewl new code. 

## Howto

Starting with an interface. The decorator pattern is based on a contract, 
both implemented by "real" object and by decorator.

This builder instantiates a new decorator implementing the contract and wrapping
an object which implements the same contract.