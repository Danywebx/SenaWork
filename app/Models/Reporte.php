<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    public $timestamps = false;

    // protected $table = "";
    // protected $primary = "id";

    protected $casts = [
        'fecha_reporte' => 'date',
    ];


    protected $fillable = [
        'tipo_reporte',
        'motivo',
        'comentario',
        'fecha_reporte',
        'notificador_id',
        'notificado_id',
        'empleo_id',
        'estado'
    ];


    public function notificador()
    {
        return $this->belongsTo(User::class, 'notificador_id');
    }

    public function notificado()
    {
        return $this->belongsTo(User::class, 'notificado_id');
    }

    public function empleo()
    {
        return $this->belongsTo(Empleo::class, 'empleo_id');
    }
}
