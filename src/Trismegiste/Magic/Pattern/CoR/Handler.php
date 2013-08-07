<?php

/*
 * DesignPatternPHP
 */

namespace Trismegiste\Magic\Pattern\CoR;

/**
 * Handler is a generic handler in the chain of responsibilities
 */
abstract class Handler
{

    private $successor = null;

    /**
     * Append a responsibility to the end of chain
     */
    final public function append(Handler $handler)
    {
        if (is_null($this->successor)) {
            $this->successor = $handler;
        } else {
            $this->successor->append($handler);
        }

        return $this;
    }

    /**
     * Handle the request. 
     */
    final public function handle(Request $req)
    {
        $req->forDebugOnly = get_called_class();
        $processed = $this->processing($req);
        if (!$processed) {
            // the request has not been processed by this handler => see the next
            if (!is_null($this->successor)) {
                $processed = $this->successor->handle($req);
            }
        }

        return $processed;
    }

    /**
     * Each concrete handler has to implement the processing of the request
     * 
     * @return bool true if the request has been handled (stop iterating the chain)
     */
    abstract protected function processing(Request $req);
}