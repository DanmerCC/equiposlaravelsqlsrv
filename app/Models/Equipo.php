<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
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
        'procesador',
        'memoria',
        'disco_duro',

    ];

    protected $appends = [
        'antiguedad'
    ];

    protected $casts = [
        'fecha_compra' => 'date:Y-m-d'
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

    /**
     * Get the asesor associated with the Equipo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function supervisor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Asesor::class, 'id', 'supervisor_id');
    }

    function scopeSearch(EloquentBuilder $query, $string)
    {

        $query->where('modelo', 'like', $string . "%");
        $query->orWhere('modelo', 'like', "%" . $string . "%");
        $query->orWhere('modelo', 'like', "%" . $string);

        $fields = [
            'grupo',
            'marca',
            'modelo',
            'color',
            'serie',
            'fecha_compra',
            'observacion',
            'procesador',
            'memoria',
            'estado',
            'tipo_disco',
            'capacidad_disco_duro',
        ];

        for ($i = 0; $i < count($fields); $i++) {
            $query->orWhere($fields[$i], 'like', $string . "%");
            $query->orWhere($fields[$i], 'like', "%" . $string . "%");
            $query->orWhere($fields[$i], 'like', "%" . $string);
        }

        $query->orWhereHas('asesor', function ($query) use ($string) {
            $query->search($string, false);
        });

        return $query;
    }

    function getAntiguedadAttribute()
    {

        if (!$this->fecha_compra) {
            return null;
        }
        $time = new Carbon();

        $options = [
            'join' => ', ',
            'parts' => 2,
            'syntax' => CarbonInterface::DIFF_ABSOLUTE,
        ];

        return $this->fecha_compra->diffForHumans($time, $options);
    }
}
