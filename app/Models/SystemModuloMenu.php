<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemModuloMenu extends Model
{
    use HasFactory;
    protected $table = "system_modulos_menus";

    public function modulo(): BelongsTo {
        return $this->belongsTo(SystemModulo::class);
    }
}
