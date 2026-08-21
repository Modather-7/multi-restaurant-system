<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use Illuminate\Http\Request;

class ImprotProductsController extends Controller
{
    public function create()
    {
        return view('dashboard.products.import');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'count' => ['required', 'integer', 'min:1', 'max:5000'],
        ]);

        ImportProducts::dispatch($validated['count'])->onQueue('import')->delay(now()->addSeconds(5));

        return redirect()
            ->route('dashboard.products.index')
            ->with('success', 'Import is running...');
    }
}
