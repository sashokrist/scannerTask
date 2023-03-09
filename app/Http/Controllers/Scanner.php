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
        $counts = array();
        $discounts = array();

        // count the number of each item
        foreach ($this->items as $item) {
            $counts[$item->productCode] += 1;
        }

        $total = 0;

        // calculate the total cost for each item
        foreach ($counts as $code => $count) {
            $itemTotal = 0;
            switch ($code) {
                case "#RA":
                    // apply discount for more than 3 raspberries
                    $discountedCount = $count;
                    if ($count > 3) {
                        $discountedCount = 3 + ($count - 3) * 0.5;
                    }
                    $itemTotal = $discountedCount * 1.5;
                    break;
                case "#AP":
                    $itemTotal = $count * 3.5;
                    break;
                case "#WA":
                    // apply "buy one get one free" discount for watermelons
                    $discountedCount = $count - floor($count / 2);
                    $itemTotal = $discountedCount * 5;
                    break;
                default:
                    throw new Exception("Invalid product code: " . $code);
            }

            // add the item's total cost to the overall total
            $total += $itemTotal;

            // add any discounts applied to the discount array
            if ($discountedCount < $count) {
                $discounts[] = ($count - $discountedCount) * $item->price;
            }
        }

        // subtract any discounts from the total
        foreach ($discounts as $discount) {
            $total -= $discount;
        }

        return $total;
    }

    public function scanProduct()
    {
        $scanner = new self();
        $scanner->scan(new Item("#RA", 1.5));
        $scanner->scan(new Item("#RA", 1.5));
        $scanner->scan(new Item("#RA", 1.5));
        $scanner->scan(new Item("#RA", 1.5));
        $scanner->scan(new Item("#WA", 5));
        $scanner->scan(new Item("#WA", 5));
        $scanner->scan(new Item("#AP", 3.5));
        $scanner->scan(new Item("#RA", 1.5));
        $total = $scanner->total(); // $total should be 15.00
    }
}

