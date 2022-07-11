<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessType extends Model
{
    use HasFactory;
    protected $table = "process_type";
    protected $fillable = ["name"];

    public function process_pre()
    {
        return $this->hasMany(ProcessPre::class, "process_type_id");
    }
}
