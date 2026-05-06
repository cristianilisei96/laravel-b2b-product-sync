<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class DummyJsonSupplierService
{
    private string $baseUrl = 'https://dummyjson.com';

    /**
     * Get paginated products from DummyJSON.
     */
    public function getProducts(int $limit = 30, int $skip = 0): array
    {
        try {
            $response = Http::timeout(15)->get($this->baseUrl . '/products', [
                'limit' => $limit,
                'skip' => $skip,
            ]);

            if ($response->failed()) {
                return [
                    'success' => false,
                    'message' => 'Supplier API request failed.',
                    'status' => $response->status(),
                    'data' => null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Products fetched successfully.',
                'status' => $response->status(),
                'data' => $response->json(),
            ];
        } catch (ConnectionException $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => null,
                'data' => null,
            ];
        }
    }

    /**
     * Get a single product by external ID.
     */
    public function getProduct(int $id): array
    {
        try {
            $response = Http::timeout(15)->get($this->baseUrl . '/products/' . $id);

            if ($response->failed()) {
                return [
                    'success' => false,
                    'message' => 'Supplier product request failed.',
                    'status' => $response->status(),
                    'data' => null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Product fetched successfully.',
                'status' => $response->status(),
                'data' => $response->json(),
            ];
        } catch (ConnectionException $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => null,
                'data' => null,
            ];
        }
    }

    /**
     * Get product categories from DummyJSON.
     */
    public function getCategories(): array
    {
        try {
            $response = Http::timeout(15)->get($this->baseUrl . '/products/categories');

            if ($response->failed()) {
                return [
                    'success' => false,
                    'message' => 'Supplier categories request failed.',
                    'status' => $response->status(),
                    'data' => null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Categories fetched successfully.',
                'status' => $response->status(),
                'data' => $response->json(),
            ];
        } catch (ConnectionException $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => null,
                'data' => null,
            ];
        }
    }
}
