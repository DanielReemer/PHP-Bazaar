<?php

namespace App\Interfaces;

interface ICsvHandler 
{
    public function parseCsvFile($file);
}