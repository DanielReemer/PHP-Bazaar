<?php

namespace App\Models;
use App\Abstracts\AbstractQueue;

class AdvertQueue extends AbstractQueue
{
    public function __construct()
    {
        parent::__construct();
    }

    public function enqueue($item)
    {
        if (!($item instanceof Advert)) 
        {
            return;
        }

        Parent::enqueue($item);
        return;
    }

    public function dequeue()
    {
        return Parent::dequeue();
    }
}