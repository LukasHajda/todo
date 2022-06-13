<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemUser;
use App\Models\User;

class ItemsController extends Controller
{
    public function index() {
        $categories = ItemCategory::all();
        $users = User::where('admin', 0)->get();

        // Items filter
        $category = request('category_id');
        $status = request('status');
        $shared = request('shared');
        $d = false;

        $items = Item::when($category, function ($q) use ($category) {
            $q->where('category_id', $category);
        })->when($status, function ($q) use ($status) {
            $q->where('done', $status);
        })->where(function ($q) use ($shared) {
            if ($shared != null) {
                if (auth()->user()->admin) {
                    $q->whereHas('users', function ($q2) use ($shared) {
                        $q2->where('users.id', $shared);
                    });
                } else {
                    $q->whereHas('users', function ($qe) {
                        $qe->where('users.id', auth()->user()->id);
                    });
                }
            } else {
                if ($shared == -1) {
                    $q->withCount('users')->whereHas('users', function ($q2) use ($shared) {
                        $q2->where('users.id', auth()->user()->id);
                    })->having('items_count', '>', 1);
                } else {
                    if ($shared == auth()->user()->id) {
                        $q->whereHas('users', function ($q2) use ($shared) {
                            $q2->where('users.id', auth()->user()->id)->withCount('users')->having('items_count', '=', 1);
                        });
                    } else {
                        if (!auth()->user()->admin) {
                            $q->whereHas('users', function ($q2) {
                                $q2->where('users.id', auth()->user()->id);
                            });
                        }
                    }
                }
            }
        })->where('pre_deleted', 0)->get();

        return view('frontend.pages.items.index', compact('categories', 'users', 'items'));
    }

    public function edit($id) {
        $item = Item::findOrFail($id);
        $categories = ItemCategory::all();
        $users = User::where('admin', 0)->get();
        $items = Item::all();

        return view('frontend.pages.items.edit', compact('item', 'users', 'categories', 'items'));
    }

    public function update(UpdateItemRequest $request, $id) {
        $item = Item::findOrFail($id);
        $item->heading = $request->heading;
        $item->description = $request->description;
        $item->category_id = $request->category_id;
        $item->save();
        $item->users()->detach();
        $item->users()->attach($request->user_id);

        $item->save();

        return redirect()->route('index');
    }

    public function store(CreateItemRequest $request) {
        $item = new Item;

        $item->heading = $request->heading;
        $item->description = $request->description;
        $item->category_id = $request->category_id;
        $item->save();

        $item->users()->attach($request->user_id);

        $item->save();


        return redirect()->route('index');
    }

    public function deleted_items() {
        $items = Item::where('pre_deleted', 1)->get();

        return view('frontend.pages.items.delete', compact('items'));
    }

    public function restore($id) {
        $item = Item::findOrFail($id);
        $item->pre_deleted = 0;
        $item->save();

        return redirect()->back();
    }

    public function delete($id) {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->back();
    }


    public function make_deleted_finished($id, $finished_deleted)  {

        $item = null;
        if (auth()->user()->admin) {
            $item = Item::findOrFail($id);
        } else {
            $item = Item::whereHas('users', function ($q) {
                $q->where('users.id', auth()->user()->id);
            })->where('id', $id)->get();
        }

        if (!$item) return redirect()->route('index');
        $item->$finished_deleted = 1;
        $item->save();

        return redirect()->route('index');
    }


}
