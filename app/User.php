<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const TYPE_PARENTS = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_parents_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public static $rules = [
        'name'     => 'required|string',
        'email'    => 'required|unique:users,email',
        'password'  => 'required|string',
    ];

    public function isParents()
    {
        return $this->user_parents_id == User::TYPE_PARENTS;
    }

    public function userIdByName($name, $userParentsId)
    {
        return User::where('name', $name)
                    ->where('user_parents_id', $userParentsId)
                    ->pluck('id');
    }

    public function hasChildren()
    {
        return User::where('user_parents_id', $this->id)->count();
    }
}
