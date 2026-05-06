<?php

namespace App\Console\Commands;

use App\Actions\ImportSupplierProductsAction;
use Illuminate\Console\Command;

class ImportSupplierProductsCommand extends Command
{
    protected $signature = 'supplier:import-products 
                            {--limit=30 : Number of products to import}
                            {--skip=0 : Number of products to skip}';

    protected $description = 'Import products from the external supplier API.';

    public function handle(ImportSupplierProductsAction $importSupplierProductsAction): int
    {
        $limit = (int) $this->option('limit');
        $skip = (int) $this->option('skip');

        $this->info('Starting supplier product import...');
        $this->line('Limit: ' . $limit);
        $this->line('Skip: ' . $skip);

        $result = $importSupplierProductsAction->execute($limit, $skip);

        if (empty($result['success'])) {
            $this->error($result['message'] ?? 'Import failed.');

            if (!empty($result['errors'])) {
                $this->warn('Errors:');
                $this->line(json_encode($result['errors'], JSON_PRETTY_PRINT));
            }

            return self::FAILURE;
        }

        $this->info($result['message']);
        $this->table(
            ['Created', 'Updated', 'Skipped'],
            [[
                $result['created'] ?? 0,
                $result['updated'] ?? 0,
                $result['skipped'] ?? 0,
            ]]
        );

        if (!empty($result['errors'])) {
            $this->warn('Some products were skipped:');
            $this->line(json_encode($result['errors'], JSON_PRETTY_PRINT));
        }

        return self::SUCCESS;
    }
}
