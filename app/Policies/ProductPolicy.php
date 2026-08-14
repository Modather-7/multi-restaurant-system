<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('product.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Product $product): bool
    {
        return $admin->can('product.view') && $product->restaurant_id == $admin->restaurant_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('product.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Product $product): bool
    {
        return $admin->can('product.update') && $product->restaurant_id == $admin->restaurant_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Product $product): bool
    {
        return $admin->can('product.delete') && $product->restaurant_id == $admin->restaurant_id;
    }

    public function viewTrash(Admin $admin): bool
    {
        return $admin->can('product.trash');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Product $product): bool
    {
        return $admin->can('product.restore') && $product->restaurant_id == $admin->restaurant_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Product $product): bool
    {
        return $admin->can('product.forceDelete') && $product->restaurant_id == $admin->restaurant_id;
    }
}
