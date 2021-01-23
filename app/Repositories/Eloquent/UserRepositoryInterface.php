<?php


namespace App\Repositories\Eloquent;


use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function getPublicVisible(): Collection;
    public function getHidden(User $user): Collection;
}
