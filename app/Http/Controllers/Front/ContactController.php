<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Restaurant $restaurant, Branch $branch)
    {
        return view('front.contact', compact('restaurant', 'branch'));
    }
}
