<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Livros as ServiceLivros;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;
use Illuminate\Support\Facades\DB;

class LivrosServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ServiceLivros $livrosService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');

        $this->livrosService = new ServiceLivros();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testSalvarLivroOK()
    {
        $autor1 = Autor::factory()->create();
        $autor2 = Autor::factory()->create();

        $assunto = Assunto::factory()->create();
        
        $dados = [
            'titulo' => 'Livro Teste',
            'editora' => 'Editora X',
            'edicao' => '1',
            'anoPublicacao' => '2023',
            'valor' => '123,45',
            'autores' => [$autor1->codAu, $autor2->codAu],
            'assunto_codAs' => $assunto->codAs,
        ];

        $livro = $this->livrosService->save($dados);

        $this->assertDatabaseHas('livro', [
            'codL' => $livro->codL,
            'titulo' => 'Livro Teste',
            'editora' => 'Editora X',
            'edicao' => '1',
            'anoPublicacao' => '2023',
            'valor' => 123.45,
        ]);

        $this->assertDatabaseHas('livro_autor', [
            'livro_codL' => $livro->codL,
            'autor_codAu' => $autor1->codAu,
        ]);

        $this->assertDatabaseHas('livro_autor', [
            'livro_codL' => $livro->codL,
            'autor_codAu' => $autor2->codAu,
        ]);

        $this->assertDatabaseHas('livro_assunto', [
            'livro_codL' => $livro->codL,
            'assunto_codAs' => $assunto->codAs,
        ]);
    }

    /** @test */
    public function testBuscaLivroPorId()
    {
        $livro = Livro::factory()->create();

        $encontrado = $this->livrosService->getById($livro->codL);

        $this->assertEquals($livro->codL, $encontrado->codL);
    }

    /** @test */
    public function testAtualizarLivro()
    {
        $livro = Livro::factory()->create([
            'titulo' => 'Original',
            'valor' => 50.00,
        ]);

        $autor = Autor::factory()->create();
        $assunto = Assunto::factory()->create();

        DB::table('livro_autor')->insert([
            ['livro_codL' => $livro->codL, 'autor_codAu' => $autor->codAu],
        ]);
        DB::table('livro_assunto')->insert([
            ['livro_codL' => $livro->codL, 'assunto_codAs' => $assunto->codAs],
        ]);


        $dadosAtualizados = [
            'codL' => $livro->codL,
            'titulo' => 'Atualizado',
            'editora' => 'Nova Editora',
            'edicao' => '2',
            'anoPublicacao' => '2024',
            'valor' => '200.00',
            'autores' => [2],
            'assunto_codAs' => 2,
        ];

        $autor2 = Autor::factory()->create();
        $assunto2 = Assunto::factory()->create();

        $livroAtualizado = $this->livrosService->updateLivro($dadosAtualizados);

        $this->assertEquals('Atualizado', $livroAtualizado->titulo);
        $this->assertEquals(200.00, $livroAtualizado->valor);
        $this->assertDatabaseHas('livro_autor', [
            'livro_codL' => $livro->codL,
            'autor_codAu' => $autor2->codAu,
        ]);

        $this->assertDatabaseHas('livro_assunto', [
            'livro_codL' => $livro->codL,
            'assunto_codAs' => $assunto2->codAs,
        ]);
    }

    /** @test */
    public function testDeletarLivro()
    {
        $livro = Livro::factory()->create();

        $autor = Autor::factory()->create();
        $assunto = Assunto::factory()->create();

        DB::table('livro_autor')->insert(['livro_codL' => $livro->codL, 'autor_codAu' => $autor->codAu]);
        DB::table('livro_assunto')->insert(['livro_codL' => $livro->codL, 'assunto_codAs' => $assunto->codAs]);


        $this->livrosService->deleteLivro($livro->codL);

        $this->assertDatabaseMissing('livro', ['codL' => $livro->codL]);
        $this->assertDatabaseMissing('livro_autor', ['livro_codL' => $livro->codL]);
        $this->assertDatabaseMissing('livro_assunto', ['livro_codL' => $livro->codL]);
    }
}
