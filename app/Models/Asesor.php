<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    use HasFactory;

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
    }
}
