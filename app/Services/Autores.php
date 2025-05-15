<?php

namespace App\Services;

use App\Models\Autor as ModelAutor;
use Exception;

class Autores
{
    /**
     * Método responsável por buscar um autor com base no codAu recebido
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param int $codAu Identificador único do autor
     */
    public function getById(int $codAu)
    {
        return ModelAutor::where('codAu', $codAu)->firstOrFail();
    }

    /**
     * Método responsável por buscar os autores com base no filtro recebido
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param array $filtros Filtros para buscar um autor expecifico
     */
    public function get($filtros = [])
    {
        $assuntos = ModelAutor::when($filtros, function ($query, $busca) {
            return $query->where('nome', 'like', '%' . $busca . '%');
        })
            ->orderBy('codAu')
            ->paginate(10)
            ->withQueryString();

        return $assuntos;
    }

    /**
     * Método responsável por salvar um autor 
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param array $dadosAutor Dados do autor que serão salvos
     */
    public function save(array $dadosAutor)
    {
        if (!empty($dadosAutor['codAu'])) {
            $autor = $this->getById($dadosAutor['codAu']);
            return $autor->update($dadosAutor);
        }

        return ModelAutor::create($dadosAutor);
    }

     /**
     * Método responsável por deletar um autor
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param int $codAu Identificador único do autor
     */
    public function delete(int $codAu)
    {
        $autor = $this->getById($codAu);
        if ($autor->livros()->exists()) {
            throw new Exception('O autor esta vinculado a um ou mais livros.');
        }
        return $autor->delete();
    }
}
