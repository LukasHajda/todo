<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Mail\ItemNotificationMail;
use App\Mail\SharedItemNotificationMail;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemUser;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

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
            $q->where('done', $status == 'finished' ? 1 : 0);
        })->where(function ($q) use ($shared) {
            if ($shared != null) {
                if (auth()->user()->admin) {
                    $q->whereHas('users', function ($q2) use ($shared) {
                        $q2->where('users.id', $shared);
                    });
                } else {
                    if ($shared == auth()->user()->id) {
                        $q->whereHas('users', function ($q) use ($shared) {
                            $q->where('users.id', auth()->user()->id);
                        })->withCount('users')->having('users_count', '>', 1);
                    }
                }
            } else {
                if ($shared == -1) {
                    $q->withCount('users')->whereHas('users', function ($q2) use ($shared) {
                        $q2->where('users.id', auth()->user()->id);
                    })->having('users_count', '>', 1);
                } else {
                    if ($shared == auth()->user()->id) {
                        $q->whereHas('users', function ($q2) use ($shared) {
                            $q2->where('users.id', auth()->user()->id);
                        })->withCount('users')->having('users_count', '=', 1);
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

        return view('frontend.pages.items.index', compact('categories', 'users', 'items', 'shared'));
    }

    public function edit($id) {
        $item = Item::findOrFail($id);
        $categories = ItemCategory::all();
        $users = User::where('admin', 0)->get();
        $items = Item::where('pre_deleted', 0)->get();

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

        if (auth()->user()->admin) {
            $data['emails'] = array();
            $data['usernames'] = array();
            foreach ($request->user_id as $user_id) {
                $user = User::findOrFail($user_id);
                array_push($data['emails'], $user->email);
                array_push($data['usernames'], $user->username);
            }
            $data['heading'] = $item->heading;

            $this->send_shared_notification($data);
        }


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
            })->where('id', $id)->first();
        }

        if (!$item) return redirect()->route('index');
        $item->$finished_deleted = 1;

        $item->save();

        if ($finished_deleted == 'done' && !auth()->user()->admin) {
            $data['from'] = auth()->user()->username;
            $data['item'] = $item;
            $data['email'] = auth()->user()->email;
            $this->send_item_notification($data);
        }

        return redirect()->route('index');
    }


    private function send_item_notification($data) {
        $recipient = env('MAIL_RECIPIENT', 'example@gmail.com');
        Mail::to($recipient)->send(new ItemNotificationMail($data));
    }

    private function send_shared_notification($data) {
        Mail::to($data['emails'])->send(new SharedItemNotificationMail($data));
    }




}
