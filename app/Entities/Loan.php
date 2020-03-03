<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }
}
