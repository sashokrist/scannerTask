<?php

namespace App\Models;

interface ScannerInterface
{
    public function scan($item);

    public function total();

}
