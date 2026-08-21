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
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        $restaurantId = auth('admin')->user()->restaurant_id;

        $path = $validated['file']->store('imports');

        ImportProducts::dispatch($path, $restaurantId)->onQueue('import');

        return redirect()
            ->route('dashboard.products.index')
            ->with('success', 'Import is running...');
    }
}
