<?php
namespace App\Abstracts;
use App\Interfaces\ICsvHandler;
use App\Http\Controllers\AdvertController;

abstract class AbstractAdvertCsvHandler implements ICsvHandler
{
    public function __construct()
    {
    }

    public abstract function parseCsvFile($file);

}