<?php

namespace App\Models;

use App\Abstracts\AbstractAdvertCsvHandler;
use App\Http\Controllers\AdvertController;
use League\Csv\Reader;
use Exception;

class AdvertCsvHandler extends AbstractAdvertCsvHandler
{
    public function __construct()    
    {
        parent::__construct();
    }

    public function parseCsvFile($file)
    {
        // Check file is not null;
        if (!$file) {
            throw new Exception('File not set');
        }

        // Test file format
        $reader = Reader::createFromFileObject($file->openFile());
        $reader->setHeaderOffset(0);
        
        $expectedHeaders = ['Title', 'Description', 'Is_Rental'];
        $headers = $reader->getHeader();

        if ($headers !== $expectedHeaders) {
            throw new Exception('Csv file headers do not match expected format');
        }

        // Handle data;
        $data = $reader->getRecords();

        return $data;
    }
}
