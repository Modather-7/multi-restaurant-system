<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        $branches = $restaurant->branches()
            ->where('status', 'active')
            ->get();

        return view('front.branch', compact('restaurant', 'branches'));
    }

    public function select(Restaurant $restaurant, Branch $branch)
    {
        $branch = $restaurant->branches()->where('status', 'active')->findOrFail($branch->id);

        Cookie::queue("res_{$restaurant->id}_branch", $branch->id, 60*24*30);

        return redirect()->route('restaurant.menu.index', [$restaurant, $branch]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
