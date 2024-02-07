<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;

    protected $table = "cluster";
    protected $guarded = [];

    protected $fillable = [
        'nama_cluster',
    ];
}
