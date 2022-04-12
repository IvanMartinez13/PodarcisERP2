<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ods_document extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "ods_documents";

    protected $fillable = [
        "name",
        "customer_id",
        "path",
        "token"
    ];
}
