<?php

/*
 * Magic php
 */

namespace Trismegiste\Magic\Pattern\Observer;

/**
 * SplSubjectImpl is an standard implementation of a \SplSubject
 */
trait SplSubjectImpl
{

    private $observerList;

    protected function getObserver()
    {
        if (is_null($this->observerList)) {
            $this->observerList = new \SplObjectStorage();
        }

        return $this->observerList;
    }

    public function attach(\SplObserver $observer)
    {
        $this->getObserver()->attach($observer);
    }

    public function detach(\SplObserver $observer)
    {
        $this->getObserver()->detach($observer);
    }

    public function notify()
    {
        foreach ($this->getObserver() as $observer) {
            $observer->update($this);
        }
    }

}