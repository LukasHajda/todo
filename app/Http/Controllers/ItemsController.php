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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ItemsController extends Controller
{
    public function index() {
        $categories = ItemCategory::all();
        $users = User::where('admin', 0)->get();

        // Items filter
        $category = request('category_id') == null ? null : request('category_id');
        $status = request('status') == null ? null : request('status');
        $shared = request('shared') == null ? null : request('shared') ;

        $items = null;
        $category_where = $category == null ? 1 : 'category_id = ' . $category;
        $status_where = $status == null ? 1 : ' done = ' . ($status == 'finished' ? 1 : 0);

        if (auth()->user()->admin) {
            if ($shared != null) {
                $items = DB::select('SELECT * FROM item_user left join items on items.id = item_user.item_id left JOIN item_categories ON item_categories.id = category_id where user_id = ' . $shared . ' AND ' . $category_where . ' AND ' . $status_where . ' AND ' . ' pre_deleted = 0');
            } else {
                $items = DB::select('SELECT * FROM item_user inner join items on items.id = item_user.item_id INNER JOIN item_categories ON item_categories.id = category_id where ' . $category_where . ' AND ' . $status_where . ' AND ' . ' pre_deleted = 0');
            }
        } else {
            if ($shared == -1) {
                $items = DB::select('SELECT * FROM item_user INNER JOIN items ON items.id = item_user.item_id INNER JOIN item_categories ON item_categories.id = category_id where user_id = ' . auth()->user()->id . ' AND ' . $category_where . ' AND ' . $status_where . ' AND ' . ' pre_deleted = 0');
            } else {
                if ($shared == auth()->user()->id) {
                    $items = DB::select('SELECT T1.*, heading, category_id, done, item_categories.name FROM (SELECT * FROM item_user GROUP BY item_id HAVING COUNT(*) = 1) as T1 
                            INNER JOIN (SELECT * FROM item_user WHERE user_id = ' . auth()->user()->id . ') as T2 ON T1.user_id = T2.user_id
                            INNER JOIN items ON items.id = T1.item_id LEFT JOIN item_categories ON item_categories.id = category_id WHERE ' . $category_where . ' AND ' . $status_where . ' AND ' . ' pre_deleted = 0  GROUP BY item_id');
                } else {
                    $items = DB::select('SELECT * FROM item_user LEFT JOIN items ON items.id = item_user.item_id LEFT JOIN item_categories ON item_categories.id = category_id where user_id = ' . auth()->user()->id . ' AND ' .  $category_where . ' AND ' . $status_where . ' AND ' . ' pre_deleted = 0');
                }
            }
        }
        return view('frontend.pages.items.index', compact('categories', 'users', 'items'));
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

    public function show($id) {
        $item = Item::findOrFail($id);
        $categories = ItemCategory::all();
        $users = User::where('admin', 0)->get();
        $items = Item::where('pre_deleted', 0)->get();
        $show_modal = true;

        return view('frontend.pages.items.index', compact('item', 'users', 'categories', 'items', 'show_modal'));
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

        if ($finished_deleted == 'undone') {
            $item->done = 0;
        } else {
            $item->$finished_deleted = 1;
        }

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
