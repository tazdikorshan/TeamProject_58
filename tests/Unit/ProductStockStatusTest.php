<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Product;

class ProductStockStatusTest extends TestCase
{
    /**
     * @test
     * Product with zero stock reports "Out of Stock!"
     */
    public function test_out_of_stock_status()
    {
        $product = new Product();
        $product->stock_quantity    = 0;
        $product->low_stock_threshold = 5;

        $this->assertSame('Out of Stock!', $product->stock_status);
    }

    /**
     * @test
     * Product with stock at or below threshold reports "Low Stock"
     */
    public function test_low_stock_status()
    {
        $product = new Product();
        $product->stock_quantity    = 3;
        $product->low_stock_threshold = 5;

        $this->assertSame('Low Stock', $product->stock_status);
    }

    /**
     * @test
     * Product with stock exactly equal to threshold reports "Low Stock"
     */
    public function test_stock_at_threshold_is_low_stock()
    {
        $product = new Product();
        $product->stock_quantity    = 5;
        $product->low_stock_threshold = 5;

        $this->assertSame('Low Stock', $product->stock_status);
    }

    /**
     * @test
     * Product with stock above the threshold reports "In Stock!"
     */
    public function test_in_stock_status()
    {
        $product = new Product();
        $product->stock_quantity    = 50;
        $product->low_stock_threshold = 5;

        $this->assertSame('In Stock!', $product->stock_status);
    }

    /**
     * @test
     * Stock quantity can be read and set correctly.
     */
    public function test_product_stock_quantity_is_readable()
    {
        $product = new Product();
        $product->stock_quantity = 42;

        $this->assertEquals(42, $product->stock_quantity);
    }
}
