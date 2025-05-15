<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW view_livros_resumo AS
                SELECT 
                    autor.codAu,
                    autor.nome AS autor_nome,
                    COUNT(DISTINCT livro.codL) AS total_livros,
                    SUM(livro.valor) AS soma_valores,
                    GROUP_CONCAT(DISTINCT livro.titulo SEPARATOR ', ') AS titulos
                FROM livro
                JOIN livro_autor ON livro.codL = livro_autor.livro_codL
                JOIN autor ON autor.codAu = livro_autor.autor_codAu
                GROUP BY autor.codAu, autor.nome;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_livros_resumo");
    }
};
