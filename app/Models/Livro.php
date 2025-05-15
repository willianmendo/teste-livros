<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Livro extends Model
{
    protected $table = 'livro';
    protected $primaryKey = 'codL';
    use HasFactory;

    protected $fillable = [
        'titulo',
        'editora',
        'edicao',
        'anoPublicacao',
        'valor'
    ];

    public function livroAssunto()
    {
        return $this->hasOne(LivroAssunto::class, 'livro_codL');
    }

    public function assunto()
    {
        return $this->hasOneThrough(
            Assunto::class,
            LivroAssunto::class,
            'livro_codL',
            'codAs',
            'codL',
            'assunto_codAs'
        );
    }

    public function livroAutores()
    {
        return $this->hasMany(LivroAutor::class, 'livro_codL');
    }

    public function autores()
    {
        return $this->hasManyThrough(
            Autor::class,
            LivroAutor::class,
            'livro_codL',
            'codAu',
            'codL',
            'autor_codAu'
        );
    }

    protected function valorFormatado(): Attribute
    {
        return Attribute::get(
            fn() => number_format($this->valor, 2, ',', '.')
        );
    }

    protected function nomesAutores(): Attribute
    {
        return Attribute::get(
            fn() => $this->autores->pluck('nome')->implode('; ')
        );
    }
}
