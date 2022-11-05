<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'asesor_id',
        'grupo',
        'marca',
        'modelo',
        'color',
        'serie',
        'fecha_compra',
        'observacion',

    ];

    /**
     * Get the asesor associated with the Equipo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function asesor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Asesor::class, 'id', 'asesor_id');
    }
}
