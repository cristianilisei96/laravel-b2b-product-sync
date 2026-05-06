<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ImportSupplierProductsAction;
use App\Http\Controllers\Controller;
use App\Models\ImportLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierImportController extends Controller
{
    public function index(): View
    {
        $importLogs = ImportLog::query()
            ->latest()
            ->take(10)
            ->get();

        return view('admin.supplier-imports.index', [
            'importLogs' => $importLogs,
        ]);
    }

    public function store(Request $request, ImportSupplierProductsAction $importSupplierProductsAction): RedirectResponse
    {
        $validated = $request->validate([
            'limit' => ['required', 'integer', 'min:1', 'max:100'],
            'skip' => ['required', 'integer', 'min:0'],
        ]);

        $result = $importSupplierProductsAction->execute(
            (int) $validated['limit'],
            (int) $validated['skip']
        );

        if (empty($result['success'])) {
            return redirect()
                ->route('admin.supplier-imports.index')
                ->with('error', $result['message'] ?? 'Product import failed.');
        }

        return redirect()
            ->route('admin.supplier-imports.index')
            ->withInput()
            ->with('success', 'Import finished. Created: ' . $result['created'] . ', updated: ' . $result['updated'] . ', skipped: ' . $result['skipped'] . '.');
    }
}
