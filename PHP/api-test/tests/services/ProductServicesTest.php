<?php
namespace Tests\Services;
use PHPUnit\Framework\TestCase;
use Services\ProductService;


class ProductServicesTest extends TestCase
{
    public function testGetProductsNull(): void {
        $productService = new ProductService();
        $result = $productService->Get();
        $this->assertIsArray($result);
    }
    public function testGetOneProduct(): void {
        $productService = new ProductService();
        $result = $productService->Get(1);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('id_product', $result[0]);
        $this->assertEquals(1, sizeof($result));
    }
    public function testCreateProduct(): void {
        $productService = new ProductService();
        $data = [
            'id_category' => 1,
            'name' => 'Test Product',
            'additional_info' => 'Test Info',
            'price' => 10.99,
            'stock_quantity' => 100
        ];
        $result = $productService->Create($data);
        $this->assertIsInt($result);
    }
    public function testUpdateProduct(): void {
        $service = new ProductService();
        $data = [
            'name' => 'Updated Product',
            'additional_info' => 'Updated Info',
            'price' => 15.99,
            'stock_quantity' => 50
        ];
        $result = $service->Update(1, $data);
        $this->assertIsBool($result);
        $this->assertTrue($result);
    }
    public function testDeleteProduct(): void {
        $service = new ProductService();
        $result = $service->Delete(1);
        $this->assertIsBool($result);
        $this->assertTrue($result);
    }
    public function testChangeState(): void {
        $service = new ProductService();
        $result = $service->ChangeState(1, 0);
        $this->assertIsBool($result);
        $this->assertTrue($result);
    }
}



?>