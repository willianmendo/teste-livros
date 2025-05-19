<?php

namespace App\Services;

use App\Models\Livro as ModelLivro;
use App\Models\LivroAssunto as ModelLivroAssunto;
use App\Models\LivroAutor as ModelLivroAutor;
use Exception;
use App\Models\ViewLivrosResumo;


class Livros
{
    /**
     * Método responsável por buscar um livro com base no codL recebido
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param int $codL Identificador único do livro
     */
    public function getById(int $codL)
    {
        return ModelLivro::with(['autores', 'assunto'])->where('codL', $codL)->firstOrFail();
    }

    /**
     * Método responsável por buscar os livros com base no filtro recebido
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param array $filtros Filtros para buscar um livro expecifico
     */
    public function get($filtros = [])
    {
        $livros = ModelLivro::with(['autores', 'assunto'])->when($filtros, function ($query, $busca) {
            return $query->where('titulo', 'like', "%{$busca}%")
                ->orWhere('editora', 'like', "%{$busca}%")
                ->orWhereHas('autores', function ($q) use ($busca) {
                    $q->where('nome', 'like', "%{$busca}%");
                })
                ->orWhereHas('assunto', function ($q) use ($busca) {
                    $q->where('descricao', 'like', "%{$busca}%");
                });
        })
            ->orderBy('codL')
            ->paginate()
            ->withQueryString();

        return $livros;
    }

    /**
     * Método responsável por salvar um livro 
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param array $dadosLivro Dados do livro que serão salvos
     */
    public function save(array $dadosLivro)
    {
        if (empty($dadosLivro)) {
            throw new Exception('Os dados para salvar um livro não forão encontrados');
        }
        $dadosLivro['valor'] = (float)str_replace(['.', ','], ['', '.'], $dadosLivro['valor']);
        if (!empty($dadosLivro['codL'])) {
            return $this->updateLivro($dadosLivro);
        }
        $livro = ModelLivro::create([
            'titulo' => $dadosLivro['titulo'],
            'editora' => $dadosLivro['editora'],
            'edicao' => $dadosLivro['edicao'],
            'anoPublicacao' => $dadosLivro['anoPublicacao'],
            'valor' => $dadosLivro['valor']
        ]);
        foreach ($dadosLivro['autores'] as $key => $autor) {
            $this->salvaLivroAutor(['codL' => $livro->codL, 'autor_codAu' => $autor]);
        }
        $this->salvaLivroAssunto(['codL' => $livro->codL, 'assunto_codAs' => $dadosLivro['assunto_codAs']]);

        return $livro;
    }

    /**
     * Método responsável por fazer a atualização de um livro 
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param array $dadosLivro Dados do livro que serão salvos
     */
    public function updateLivro(array $dadosLivro)
    {
        $livro = $this->getById($dadosLivro['codL']);
        $livro->update($dadosLivro);
        $this->deleteLivroAssunto($livro->codL);
        $this->salvaLivroAssunto($dadosLivro);
        $this->deleteLivroAutor($livro->codL);
        foreach ($dadosLivro['autores'] as $key => $autor) {
            $this->salvaLivroAutor(['codL' => $livro->codL, 'autor_codAu' => $autor]);
        }
        return $livro;
    }

    /**
     * Método responsável por deletar um registro da tabela livro_assunto
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param int $codL Identificador do livro
     */
    public function deleteLivroAssunto(int $codL)
    {
        $livroAssunto = $this->getLivroAssuntoByLivro($codL);
        $livroAssunto->delete();
    }

    /**
     * Método responsável por buscar um registro da tabela livro_assunto pelo identificador do livro
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param int $codL Identificador do livro
     */
    public function getLivroAssuntoByLivro(int $codL)
    {
        return ModelLivroAssunto::where('livro_codL', $codL)->firstOrFail();
    }

    /**
     * Método responsável por deletar um registro da tabela livro_autor
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param int $codL Identificador do livro
     */
    public function deleteLivroAutor(int $codL)
    {
        $livroAutor = $this->getLivroAutorByLivro($codL);
        $livroAutor->delete();
    }

    /**
     * Método responsável por buscar um registro da tabela livro_autor pelo identificador do livro
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param int $codL Identificador do livro
     */
    public function getLivroAutorByLivro(int $codL)
    {
        return ModelLivroAutor::where('livro_codL', $codL)->firstOrFail();
    }

    /**
     * Método responsável por salvar um novo registro na tabela livro_assunto
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param array $dadosLivro Dados que serão salvos
     */
    public function salvaLivroAssunto(array $dadosLivro)
    {
        return ModelLivroAssunto::create(['livro_codL' => $dadosLivro['codL'], 'assunto_codAs' => $dadosLivro['assunto_codAs']]);
    }

    /**
     * Método responsável por salvar um registro na tabela livro_autor
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param array $dadosLivro Dados que serão salvos
     */
    public function salvaLivroAutor(array $dadosLivro)
    {
        return ModelLivroAutor::create(['livro_codL' => $dadosLivro['codL'], 'autor_codAu' => $dadosLivro['autor_codAu']]);
    }

    /**
     * Método responsável por deletar um livro
     * @author Willian Gustavo Mendo <williangustavomendo@gmail.com>
     * @param int $codL Identificador do livro
     */
    public function deleteLivro(int $codL)
    {
        $livro = $this->getById($codL);
        $this->deleteLivroAssunto($livro->codL);
        $this->deleteLivroAutor($livro->codL);
        $livro->delete();
    }

    public function getDadosLivrosRelatorioGeral()
    {
        return ViewLivrosResumo::all()->toArray();
        $auxLivros = ViewLivrosResumo::all();
        $livros = $auxLivros->groupBy('codL')->map(function ($livroGrupo) {
            $first = $livroGrupo->first();
            return [
                'titulo' => $first->titulo,
                'editora' => $first->editora,
                'edicao' => $first->edicao,
                'valor' => number_format((float)$first->valor, 2, ',', '.'),
                'ano_publicacao' => $first->anoPublicacao,
                'autores' => $livroGrupo->pluck('nome')->unique()->implode('; '),
                'assunto' => $first->descricao,
            ];
        });

        return $livros;
    }
}
