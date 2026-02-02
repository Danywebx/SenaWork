<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    public $timestamps = false;

    // protected $table = "";
    // protected $primary = "id";

    protected $fillable = [
        'tipo',
        'numero',
        'ruta',
        'usuario_id',
        'estado_doc',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
