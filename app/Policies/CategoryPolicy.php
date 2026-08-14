<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('category.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Category $category): bool
    {
        return $admin->can('category.view') && $category->restaurant_id == $admin->restaurant_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('category.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Category $category): bool
    {
        return $admin->can('category.update') && $category->restaurant_id == $admin->restaurant_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Category $category): bool
    {
        return $admin->can('category.delete') && $category->restaurant_id == $admin->restaurant_id;
    }

    public function viewTrash(Admin $admin): bool
    {
        return $admin->can('category.trash');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Category $category): bool
    {
        return $admin->can('category.restore') && $category->restaurant_id == $admin->restaurant_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Category $category): bool
    {
        return $admin->can('category.forceDelete') && $category->restaurant_id == $admin->restaurant_id;
    }
}
