<?php

/*
 * Php is magic
 */

namespace tests\Trismegiste\Magic\Pattern\Observer;

use Trismegiste\Magic\Pattern\Observer\SplSubjectImpl;

/**
 * SplSubjectImplTest tests the SplSubjectImpl trait
 */
class SplSubjectImplTest extends \PHPUnit_Framework_TestCase
{

    protected $subject;
    protected $observer;

    protected function setUp()
    {
        $this->observer = $this->getMock('SplObserver');
        $this->subject = new SubjectExample();
    }

    public function testSubscribe()
    {
        $this->subject->attach($this->observer);
        $this->observer
                ->expects($this->once())
                ->method('update')
                ->with($this->subject);
        // notify observer
        $this->subject->notify();
    }

    public function testUnsubscribe()
    {
        $this->subject->attach($this->observer);
        $this->observer
                ->expects($this->never())
                ->method('update');

        $this->subject->detach($this->observer);
        // notify observers (no one has subscribed)
        $this->subject->notify();
    }

}

// example test
class SubjectExample implements \SplSubject
{

    use SplSubjectImpl;
}

