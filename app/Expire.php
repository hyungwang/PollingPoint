<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expire extends Model
{
    protected $table = 'expires';

    public function poll(){
        return $this->belongsTo(Poll::class);
    }
}
