<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\User;

class ItemsController extends Controller
{
    public function index() {
        $categories = ItemCategory::all();
        $users = User::where('admin', 0)->get();
        return view('frontend.pages.items.index', compact('categories', 'users'));
    }

    public function edit($id) {

    }

    public function update(UpdateItemRequest $request, $id) {

    }

    public function store(CreateItemRequest $request) {
        $item = new Item();

        $item->heading = $request->heading;
        $item->description = $request->description;
        $item->category_id = $request->category_id;
        $item->users()->attach($request->user_id);

        $item->save();

        return redirect()->route('index');
    }


}
