<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Session extends Model
{
    use HasFactory, Prunable;

    protected $table = "sessions";

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];

    public function prunable()
    {
        return static::where('created_at', '<', now());
    }

    protected function pruning()
    {
        //
    }
}
