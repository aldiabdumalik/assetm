<?php

namespace Database\Seeders;

use App\Models\ItemBrand;
use App\Models\ItemModel;
use App\Models\ItemType;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = ItemType::create([
            'type_name' => 'STB'
        ]);

        $brand = ItemBrand::create([
            'item_type_id' => $type->id,
            'brand_name' => 'TELKOM',
        ]);

        $model = ItemModel::create([
            'item_brand_id' => $brand->id,
            'model_name' => 'XNXX-1234',
        ]);
    }
}
