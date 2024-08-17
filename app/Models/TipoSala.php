<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSala extends Model
{
    protected $table = 'tiposala';

    protected $primaryKey = 'codigotiposala';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'precio'
    ];

    public function salas()
    {
        return $this->hasMany(Sala::class, 'codigotiposala', 'codigotiposala');
    }
}