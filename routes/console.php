<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled Commands
|--------------------------------------------------------------------------
|
| This command simulates automatic supplier product synchronization.
| In a real B2B e-commerce project, this would keep local products,
| prices, stock and images updated from the supplier API.
|
*/

Schedule::command('supplier:import-products --limit=30 --skip=0')
    ->everyThirtyMinutes()
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/supplier-imports.log'));
