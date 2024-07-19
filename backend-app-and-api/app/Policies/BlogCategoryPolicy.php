<?php

namespace App\Policies;

use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BlogCategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can("blog catageory");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can("blog category details");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("create blog category");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can("update blog category");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can("delete blog category");
    }
}
