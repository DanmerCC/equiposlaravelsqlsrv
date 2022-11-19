<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'equipo_id',
        'estado'
    ];

    protected $appends = [
        'full_name'
    ];

    protected $with = [
        //'full_name'
    ];

    /**
     * Get the equipo associated with the Asesor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function equipo(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Asesor::class, 'id', 'equipo_id');
    }

    public function getFullNameAttribute(){
        return $this->nombres." ".$this->apellido_paterno . " ".$this->apellido_materno;
    }

    function scopeSearch(Builder $query, $text, $and = true)
    {
        if ($and) {

            $query->where('nombres', 'like', '%' . $text);
        } else {
            $query->orWhere('nombres', '');
        }
        $query->orWhere('nombres',  'like', '%' . $text . '%');
        $query->orWhere('nombres',  'like', $text . '%');

        $query->orWhere('apellido_paterno',  'like', '%' . $text);
        $query->orWhere('apellido_paterno',  'like', '%' . $text . '%');
        $query->orWhere('apellido_paterno',  'like', $text . '%');

        $query->orWhere('apellido_materno',  'like', '%' . $text);
        $query->orWhere('apellido_materno',  'like', '%' . $text . '%');
        $query->orWhere('apellido_materno',  'like', $text . '%');
        $query->orWhere('dni',  '=', $text);
        $query->orWhere('dni',  'like', $text . '%');
    }
}
