<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemRol extends Model
{
    use HasFactory;
    protected $table = "system_roles";
    protected $fillable = ["nombre", "status"];
}
