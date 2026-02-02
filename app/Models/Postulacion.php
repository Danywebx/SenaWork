<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory;

    public $timestamps = false;


    protected $table = "postulaciones";
    // protected $primary = "id";


    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_cierre' => 'date',
    ];


    protected $fillable = [
        'fecha_inicio',
        'fecha_cierre',
        'estado_postulacion',
        'puntuacion_empleado',
        'comentario_empleado',
        'puntuacion_empleador',
        'comentario_empleador',
        'usuario_id',
        'empleo_id',
        'estado'
    ];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }


    public function empleo()
    {
        return $this->belongsTo(Empleo::class, 'empleo_id');
    }    
}
