<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * @var string
     */
    protected $guard = 'admin';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'mobile', 'image', 'status', 'created_at', 'updated_at'
    ];

    /**
     * @var array
     */
    protected $hidden = ['remember_token', 'password'];
}
