<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        $categories = ItemCategory::all();
        return view('frontend.pages.index', compact('categories'));
    }
}
