<?php

namespace App\Abstracts;
use App\Interfaces\IQueue;

abstract class AbstractQueue implements IQueue
{
    protected array $queue;
    public function __construct()
    {
        $this->queue = [];
    }

    public function enqueue($item) 
    {
        array_push($this->queue, $item);

        return;
    }
    public function dequeue()
    {
        if (!($this->isEmpty())) {
            return array_shift($this->queue);
        }

        return null;
    }
    public  function isEmpty() : bool
    {
        return empty($this->queue);
    }
    public function size() : int
    {
        return count($this->queue);
    }

    public function reset() : void
    {
        $this->queue = [];

        return;
    }

}