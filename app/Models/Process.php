<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Process extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'process';
    protected $fillable = ["name", "responsable", "target", "customer_id", "type_process_id"];

    public function activity()
    {
        return $this->hasMany(Activity::class, "process_id"); //relaciones
    }
}
