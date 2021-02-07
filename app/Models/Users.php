<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTypes extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'name',
        'document',
        'email',
        'password',
        'user_type_id'
    ];

    public function userType()
    {
        return $this->belongsTo(UserTypes::class);
    }
}
