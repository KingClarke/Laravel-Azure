<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'group_id',
        'content',
        'image',
        'read_at'
    ];

    protected $dates = ['read_at'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function scopeUnreadFor($query, $userId)
    {
        return $query->where('receiver_id', $userId)->whereNull('read_at');
    }

    public static function markAsRead($userId, $senderId)
    {
        static::where('receiver_id', $userId)
            ->where('sender_id', $senderId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}
