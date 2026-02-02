<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "usuarios";
    // protected $primary = "id";


    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];


    protected $fillable = [
        'nombre',
        's_nombre',
        'apellido',
        's_apellido',
        't_documento',
        'n_documento',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'correo',
        'contrasena',
        'foto',
        'prom_puntuaciones',
        'api_key',
        'estado_perfil',
        'rol_id',
        'categoria_id',
        'estado'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'contrasena',
        // 'remember_token',
    ];    

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'usuario_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'contrasena' => 'hashed',
        ];
    }
}
