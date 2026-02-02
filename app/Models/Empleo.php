<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleo extends Model
{
    use HasFactory;

    public $timestamps = false;

    // protected $table = "";
    // protected $primary = "id";


    protected $casts = [
        'fecha_creacion' => 'date',
        'fecha_cierre' => 'date',
    ];


    protected $fillable = [
        'nombre',
        'descripcion',
        'fotos',
        'fecha_creacion',
        'fecha_cierre',
        'ubicacion',
        'estado_empleo',
        'usuario_id',
        'categoria_id',
        'estado'
    ];


    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }


    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }


    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class, 'empleo_id');
    }
}
