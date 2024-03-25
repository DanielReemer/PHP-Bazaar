<?php

namespace App\Interfaces;

interface IQueue
{
    public function enqueue($item);
    public function dequeue();
    public function isEmpty();
    public function size();
    public function reset();
}