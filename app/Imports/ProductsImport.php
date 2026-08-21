<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // بدونها Laravel Excel هيعتبر أول row من Excel ك data

class ProductsImport implements ToModel, WithHeadingRow
{
    public function __construct(protected int $restaurantId)
    {
        //
    }

    public function model(array $row): Model|null
    {
        $product = new Product([
            'name' => $row['name'],
            'category_id' => $row['category_id'],
            'restaurant_id' => $this->restaurantId,
            'ingredients' => $row['ingredients'] ?? null,
            'price' => $row['price'],
            'compare_price' => $row['compare_price'] ?? null,
            'featured' => $row['featured'] ?? false,
            'slug' => Str::slug($row['name']),
        ]);

        $product->save();

        $product->branches()->sync(
            $product->restaurant->branches->pluck('id')
        );

        return null;
    }
}
