<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    /**
     * A basic feature test example.
     * Response 200 ( success )
     * Response Json status -> success
     * @return void
     */
    public function testCreateProductSuccess()
    {
        // Arrange
        $url = "/api/createProduct";
        $productData = [
            'product-name'      => "Producttest",
            'product-price'     => 150,
            'product-currency'  => "ILS"
        ];

        // Act
        $response = $this->postJson($url, $productData);

        // Assert
        $response->assertStatus(200)
                 ->assertJson(['status' => 'success',]);
    }

    /**
     * Validator Request Failed
     * Response from Requests @CreateProduct
     * Failed by Request Validator
     * @return void
     */
    public function testCreateProductFailedName()
    {
        // Arrange
        $url = "/api/createProduct";
        $productData = [
            'product-name'      => "New Product",
            'product-price'     => 150,
            'product-currency'  => "NIS"
        ];

        // Act
        $response = $this->postJson($url, $productData);

        // Assert
        $response->assertStatus(422)
                 ->assertJson(['message' => 'The given data was invalid.']);
    }

    /**
     * Response By PayMe Api
     * Failed
     * Currency is not allowed
     * @return void
     */
    public function testCreateProductApiValidator()
    {
        // Arrange
        $url = "/api/createProduct";
        $productData = [
            'product-name'      => "Product",
            'product-price'     => 150,
            'product-currency'  => "ns"
        ];

        // Act
        $response = $this->postJson($url, $productData);

        // Assert
        $response->assertStatus(200)
                 ->assertJson(['status' => 'failed']);
    }
}
