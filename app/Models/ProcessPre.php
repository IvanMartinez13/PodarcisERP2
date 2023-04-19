<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessPre extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "process_pre";
    protected $fillable = ["name", "responsable", "target", "process_type_id"];

    //relationships
    public function process_type()
    {
        return $this->belongsTo(ProcessType::class, "process_type_id");
    }

    public function activities_pre()
    {
        return $this->belongsToMany(ActivityPre::class, "process_pre_activities_pre", "process_pre_id", "activity_pre_id"); //CLASE, tabla intermedia, id_THIS, id_CLASE, 
    }
}
