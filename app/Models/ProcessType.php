<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessType extends Model
{
    use HasFactory;

    public const SOPORTE = 1;
    public const OPERATIVOS = 2;
    public const ESTRATEGICOS = 3;

    protected $table = "process_type";
    protected $fillable = ["name"];

    public function process_pre()
    {
        return $this->hasMany(ProcessPre::class, "process_type_id");
    }
}
