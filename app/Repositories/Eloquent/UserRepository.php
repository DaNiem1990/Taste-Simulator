<?php


namespace App\Repositories\Eloquent;


use App\Models\User;
use App\Repositories\Eloquent\Base\BaseRepository;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }


    public function getPublicVisible(): Collection
    {
        return $this->model
            ->where('only_friends', '=', '0')
            ->get();
    }

    public function getPublicVisibleByUser(User $user): Collection
    {
        return $this->model
            ->where('id', '<>', $user->id)
            ->where('only_friends', '=', '0')
            ->get();
    }

    public function getHidden(User $user): Collection
    {
        if ($user->isadmin) {
            return new Collection();
        }
        $id = $user->id;

        return $this->model
            ->where('id', '<>', $id)
            ->where('only_friends', '=', '1')
            ->whereDoesntHave(
                'friends',
                function ($query) use ($id) {
                    $query->whereId($id);
                }
            )
            ->get(['id', 'name', 'email'])
            ->transform(
                function ($userItem, $userKey) {
                    $userItem->email = $userItem->getHiddenEmail();

                    return $userItem;
                }
            );
    }

    public function getVisibleByUser(User $user): Collection
    {
        if ($user->isadmin) {
            return $this->model->all();
        }
        $id = $user->id;

        return $user->friends
            ->merge(
                $this->getPublicVisibleByUser($user)
            );
    }

    public function getUsersListByUser($user): Collection
    {
        if (is_null($user)) {
            return $this->getPublicVisible();
        }

        if ($user->is_admin) {
            return $this->model->all();
        }

        return $this->getPublicVisibleByUser($user)
            ->merge($this->getVisibleByUser($user));

    }

    public function getUserByUser(User $caller, int $user_id): User
    {
        $user = User::find($user_id);
        if (!is_null($user)) {
            $canSeeUserDetails = ($caller->isadmin
                || !$user->only_friends
                || ($user->only_friends
                    && $user->friends->contains($caller))
            );
            if (!$canSeeUserDetails) {
                $user->email = $user->getHiddenEmail();
                $user->friends = [];
            }

            return $user;
        } else {
            return new User();
        }
    }
}
