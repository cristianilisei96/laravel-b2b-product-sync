<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\ImportLog;
use App\Models\Product;
use App\Services\DummyJsonSupplierService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportSupplierProductsAction
{
    public function __construct(
        private readonly DummyJsonSupplierService $supplierService
    ) {}

    public function execute(int $limit = 30, int $skip = 0): array
    {
        $startedAt = now();

        $created = 0;
        $updated = 0;
        $skipped = 0;
        $errors = [];

        $response = $this->supplierService->getProducts($limit, $skip);

        if (!$response['success']) {
            ImportLog::create([
                'source' => 'dummyjson',
                'status' => 'failed',
                'products_created' => 0,
                'products_updated' => 0,
                'products_skipped' => 0,
                'message' => $response['message'] ?? 'Supplier API request failed.',
                'context' => $response,
                'started_at' => $startedAt,
                'finished_at' => now(),
            ]);

            return [
                'success' => false,
                'message' => 'Supplier API request failed.',
                'created' => 0,
                'updated' => 0,
                'skipped' => 0,
                'errors' => [$response['message'] ?? 'Unknown API error'],
            ];
        }

        $products = $response['data']['products'] ?? [];

        foreach ($products as $supplierProduct) {
            try {
                DB::transaction(function () use ($supplierProduct, &$created, &$updated): void {
                    $category = $this->createOrUpdateCategory($supplierProduct);

                    $product = $this->createOrUpdateProduct($supplierProduct, $category);

                    if ($product->wasRecentlyCreated) {
                        $created++;
                    } else {
                        $updated++;
                    }

                    $this->syncProductImages($product, $supplierProduct['images'] ?? []);
                });
            } catch (\Throwable $exception) {
                $skipped++;
                $errors[] = [
                    'external_id' => $supplierProduct['id'] ?? null,
                    'message' => $exception->getMessage(),
                ];
            }
        }

        ImportLog::create([
            'source' => 'dummyjson',
            'status' => empty($errors) ? 'success' : 'partial',
            'products_created' => $created,
            'products_updated' => $updated,
            'products_skipped' => $skipped,
            'message' => 'Product import finished.',
            'context' => [
                'limit' => $limit,
                'skip' => $skip,
                'errors' => $errors,
            ],
            'started_at' => $startedAt,
            'finished_at' => now(),
        ]);

        return [
            'success' => true,
            'message' => 'Product import finished.',
            'created' => $created,
            'updated' => $updated,
            'skipped' => $skipped,
            'errors' => $errors,
        ];
    }

    private function createOrUpdateCategory(array $supplierProduct): Category
    {
        $categorySlug = $supplierProduct['category'] ?? 'uncategorized';

        return Category::updateOrCreate(
            ['external_id' => $categorySlug],
            [
                'name' => Str::headline($categorySlug),
                'slug' => Str::slug($categorySlug),
                'parent_id' => null,
            ]
        );
    }

    private function createOrUpdateProduct(array $supplierProduct, Category $category): Product
    {
        $externalId = (string) $supplierProduct['id'];
        $sku = 'DUMMY-' . $externalId;

        $supplierPrice = (float) ($supplierProduct['price'] ?? 0);
        $price = $this->calculateFinalPrice($supplierPrice);

        $stock = (int) ($supplierProduct['stock'] ?? 0);

        return Product::updateOrCreate(
            ['external_id' => $externalId],
            [
                'category_id' => $category->id,
                'sku' => $sku,
                'name' => $supplierProduct['title'] ?? 'Untitled product',
                'slug' => Str::slug(($supplierProduct['title'] ?? 'product') . '-' . $externalId),
                'brand' => $supplierProduct['brand'] ?? null,
                'description' => $supplierProduct['description'] ?? null,
                'supplier_price' => $supplierPrice,
                'price' => $price,
                'stock' => $stock,
                'stock_status' => $stock > 0 ? 'in_stock' : 'out_of_stock',
                'thumbnail' => $supplierProduct['thumbnail'] ?? null,
                'is_active' => true,
                'last_synced_at' => now(),
            ]
        );
    }

    private function syncProductImages(Product $product, array $images): void
    {
        $product->images()->delete();

        foreach ($images as $index => $imageUrl) {
            $product->images()->create([
                'url' => $imageUrl,
                'position' => $index,
            ]);
        }
    }

    private function calculateFinalPrice(float $supplierPrice): float
    {
        $markupMultiplier = 1.30;

        return round($supplierPrice * $markupMultiplier, 2);
    }
}
