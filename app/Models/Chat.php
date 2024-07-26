<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'message'];

    public function sender()
    {
         $this->belongsTo(User::class);
    }

   
    public function receiver()
    {
       $this->belongsTo(User::class);
    }
}
