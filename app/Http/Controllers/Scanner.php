<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ScannerInterface;
use Illuminate\Http\Request;

class Scanner extends Controller implements ScannerInterface
{
    /**
     * @var array
     */
    private $items = array();

    /**
     * @param $item
     * @return void
     */
    public function scan($item) {
        $this->items[] = $item;
    }

    /**
     * @return float|int|mixed
     */
    public function total() {

        // calculate the total cost for each item
        foreach ($this->items as $code => $count) {
            $itemTotal = 0;
            switch ($code) {
                case "#AP":
                    $discountedCount = $count;
                    if ($count > 3) {
                        $discountedCount = 3 + ($count - 3) * 0.5;
                    }
                    $itemTotal = $discountedCount * 1.5;
                case "#WA":
                // price for #WA
                case "#RA":
                // price for #RA
                    break;
                default:
                    throw new Exception("Invalid product code: " . $code);
            }

        }

    }

    public function scanProduct()
    {
        // scan product
    }
}

