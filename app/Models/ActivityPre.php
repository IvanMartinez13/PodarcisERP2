<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityPre extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "activity_pre";
    protected $fillable = ["name", "process_type_id"];

    public function process_pre()
    {
        return $this->belongsToMany(ProcessPre::class, "process_pre_activities_pre", "activity_pre_id", "process_pre_id"); //relaciones
    }
}
