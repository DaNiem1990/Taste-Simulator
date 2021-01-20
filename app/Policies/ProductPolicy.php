<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show():bool
    {
        return true;
    }

    public function update():bool
    {
        return false;
    }

    public function store():bool
    {
        return false;
    }

    public function delete():bool
    {
        return false;
    }
}
