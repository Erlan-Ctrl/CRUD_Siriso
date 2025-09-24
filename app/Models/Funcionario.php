<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcionario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'funcionarios';

    protected $fillable = [
        'nome',
        'matricula',
        'dt_nascimento',
        'sexo',
        'email',
        'cargo_id',
        'unidade_id',
        'status',
    ];

    protected $casts = [
        'matricula' => 'string',
        'dt_nascimento' => 'date',
        'cargo_id' => 'integer',
        'unidade_id' => 'integer',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $hidden = ['deleted_at'];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }
}
