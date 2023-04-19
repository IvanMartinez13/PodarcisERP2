<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'activities';
    protected $fillable = ["name", "process_id"];

    public function process()
    {
        return $this->belongsTo(Process::class, "process_id"); //relaciones
    }
}
