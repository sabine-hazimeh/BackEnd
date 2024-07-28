<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model


{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'code'];

    public function user()
    {
        $this->belongsTo(User::class);
    }

}
