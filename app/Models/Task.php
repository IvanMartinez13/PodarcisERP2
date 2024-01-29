<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "tasks";

    protected $fillable = [
        "name",
        "year",
        "description",
        "is_done",
        "progress",
        "token",
        "project_id",
        "task_id",
        "priority_id"
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function departaments()
    {
        return $this->belongsToMany(Departament::class, "departament_task");
    }

    public function users()
    {
        return $this->belongsToMany(User::class, "tasks_users", "task_id", "user_id");
    }

    public function strategy()
    {
        return $this->belongsToMany(Strategy::class, 'task_strategy');
    }

    public function objective()
    {
        return $this->belongsToMany(Objective::class, 'task_objective');
    }
}
