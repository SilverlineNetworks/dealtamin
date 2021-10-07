<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
	protected $table = 'service_reviews';

	protected $guarded = ['id'];

    protected $fillable = [
        'service_id',
        'user_id',
        'message',
        'ratings',
        'booking_id'
    ];

    public $timestamps = false;

}
