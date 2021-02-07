<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfers extends Model
{
    protected $table = 'transfers';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'payer_id',
        'payee_id',
        'amount',
        'status'
    ];

    public function payer()
    {
        return $this->belongsTo(User::class);
    }

    public function payee()
    {
        return $this->belongsTo(User::class);
    }
}
