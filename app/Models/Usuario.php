<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Clase Usuario
 * 
 * Representa la entidad de los usuarios en el sistema. 
 * Este modelo permite la autenticación mediante tokens usando Laravel Sanctum.
 */
class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory;

    /**
     * Define la tabla asociada a este modelo.
     */
    protected $table = 'usuarios';

    /**
     * Llave primaria de la tabla.
     */
    protected $primaryKey = 'id';

    /**
     * Indica si el modelo debe manejar las columnas created_at y updated_at.
     */
    public $timestamps = true;

    /**
     * Campos que se pueden llenar de forma masiva.
     */
    protected $fillable = [
        'nombre',
        'correo',
        'password',
        'rol',
        'fecha_nacimiento',
        'sexo',
        'numero_seguro',
        'historial_medico',
        'contacto_emergencia',
        'fecha_creacion'
    ];

    /**
     * Atributos que no deben mostrarse cuando el modelo se convierta a JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Define la conversión automática de ciertos campos a tipos de datos específicos.
     */
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_creacion' => 'datetime',
    ];
}
