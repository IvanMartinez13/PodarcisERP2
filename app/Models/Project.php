<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "projects";

    protected $fillable = [
        "name",
        "description",
        "color",
        "image",
        "token",
        "customer_id",
        "is_ods",
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function countAltas()
    {
        $count = Task::where('project_id', $this->id)->whereHas('priority', function ($q) {

            $q->where('id', 1); // id ALta
        })->where('task_id', null)->get();

        return count($count); //cuenta el número de resulrados
    }

    public function countMedias()
    {
        $count = Task::where('project_id', $this->id)->whereHas('priority', function ($q) {

            $q->where('id', 2); // id Medias
        })->where('task_id', null)->get();

        return count($count); //cuenta el número de resulrados
    }

    public function countBajas()
    {
        $count = Task::where('project_id', $this->id)->whereHas('priority', function ($q) {

            $q->where('id', 3); // id Bajas
        })->where('task_id', null)->get();

        return count($count); //cuenta el número de resulrados
    }

    public function tareas()
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }
}
