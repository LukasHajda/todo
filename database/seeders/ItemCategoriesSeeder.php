<?php

namespace Database\Seeders;

use App\Models\ItemCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorities = ['low', 'medium', 'high', 'urgent'];
        foreach ($priorities as $priority) {
            if (!ItemCategory::where('name', $priority)->count() > 0) {
                DB::table('item_categories')->insert([
                    'name' => $priority,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
