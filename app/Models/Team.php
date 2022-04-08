<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "teams";

    protected $fillable = [
        "name",
        "description",
        "image",
        "customer_id",
        "token"
    ];

    public function users(){

        return $this->belongsToMany(User::class, "teams_user");
    }

}
