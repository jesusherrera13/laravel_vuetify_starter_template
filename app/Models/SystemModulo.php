<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemModulo extends Model
{
    use HasFactory;
    protected $table = "system_modulos";
    protected $fillable = ["nombre", "key","route", "mdi_icon", "status"];

    public function menus(): HasMany {

        return $this->hasMany(SystemModuloMenu::class, 'modulo_id');
    }
}
