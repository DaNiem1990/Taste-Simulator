<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @property string name
 * @property string email
 * @property string password
 * @property bool|mixed isadmin
 * @property bool only_friends
 * @property bool is_active
 * @property mixed remember_token
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'only_friends'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_active',
        'is_admin'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * @var bool|mixed
     */

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendship', 'user_id', 'friend_id');
    }

    public function getHiddenEmail()
    {
        return $this->email[0]
            . "*****@*****"
            . substr($this->email, -4);
    }
}
