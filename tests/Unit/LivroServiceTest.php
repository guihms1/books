<?php

namespace Tests\Unit;

use App\Exceptions\NotFoundException;
use App\Repositories\AssuntoRepository;
use App\Repositories\AutorRepository;
use App\Repositories\LivroAssuntoRepository;
use App\Repositories\LivroAutorRepository;
use App\Repositories\LivroRepository;
use App\Services\LivroService;
use App\Validators\ValidatorFactory;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LivroServiceTest extends TestCase
{
    private $livroService;
    private $livroRepositoryMock;
    private $assuntoRepositoryMock;
    private $autorRepositoryMock;
    private $livroAssuntoRepositoryMock;
    private $livroAutorRepositoryMock;
    private $validatorFactoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->livroRepositoryMock = $this->createMock(LivroRepository::class);
        $this->assuntoRepositoryMock = $this->createMock(AssuntoRepository::class);
        $this->autorRepositoryMock = $this->createMock(AutorRepository::class);
        $this->livroAssuntoRepositoryMock = $this->createMock(LivroAssuntoRepository::class);
        $this->livroAutorRepositoryMock = $this->createMock(LivroAutorRepository::class);
        $this->validatorFactoryMock = $this->createMock(ValidatorFactory::class);

        $this->livroService = new LivroService(
            $this->livroRepositoryMock,
            $this->assuntoRepositoryMock,
            $this->autorRepositoryMock,
            $this->livroAssuntoRepositoryMock,
            $this->livroAutorRepositoryMock,
            $this->validatorFactoryMock
        );
    }

    public function testGetAllReturnsAllLivros()
    {
        $mockedLivros = [
            (object) ['CodL' => 1, 'Titulo' => 'Livro 1'],
            (object) ['CodL' => 2, 'Titulo' => 'Livro 2'],
        ];

        $this->livroRepositoryMock
            ->expects($this->once())
            ->method('getAll')
            ->with([])
            ->willReturn($mockedLivros);

        $result = $this->livroService->getAll();

        $this->assertEquals($mockedLivros, $result);
    }

    public function testGetByIdReturnsLivroIfFound()
    {
        $mockedLivro = (object) ['CodL' => 1, 'Titulo' => 'Livro 1'];

        $this->livroRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($mockedLivro);

        $result = $this->livroService->getById(1);

        $this->assertEquals($mockedLivro, $result);
    }

    public function testGetByIdThrowsNotFoundExceptionIfNotFound()
    {
        $this->livroRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(999)
            ->willReturn(null);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Livro não encontrado.');

        $this->livroService->getById(999);
    }

    public function testValidatesAndCreatesLivro()
    {
        $data = [
            'Titulo' => 'Novo Livro',
            'Editora' => 'Editora 1',
            'Edicao' => 1,
            'AnoPublicacao' => '2024',
            'Valor' => 50.00,
            'CodAs' => [1, 2],
            'CodAu' => [1]
        ];

        $livroAttributes = [
            'Titulo' => 'Novo Livro',
            'Editora' => 'Editora 1',
            'Edicao' => 1,
            'AnoPublicacao' => '2024',
            'Valor' => 50.00,
        ];

        // Mocking the validator and repository
        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::LIVRO)
            ->willReturn(new class {
                public function validate(array $data) { return $data; }
            });

        $this->livroRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($livroAttributes)
            ->willReturn((object) ['CodL' => 1, ...$livroAttributes]);

        $this->livroAssuntoRepositoryMock
            ->expects($this->exactly(2))
            ->method('create')
            ->willReturnMap([
                [['Livro_CodL' => 1, 'Assunto_CodAs' => 1], (object)['Livro_CodL' => 1, 'Assunto_CodAs' => 1]],
                [['Livro_CodL' => 1, 'Assunto_CodAs' => 2], (object)['Livro_CodL' => 1, 'Assunto_CodAs' => 2]],
            ]);

        $this->livroAutorRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with(['Livro_CodL' => 1, 'Autor_CodAu' => 1]);

        $result = $this->livroService->create($data);

        $this->assertTrue($result);
    }

    public function testCreateHandlesExceptionAndLogsError()
    {
        $data = [
            'Titulo' => 'Novo Livro',
            'Editora' => 'Editora 1',
            'Edicao' => 1,
            'AnoPublicacao' => 2024,
            'Valor' => 50,
            'CodAs' => [1, 2],
            'CodAu' => [1]
        ];

        $livroAttributes = [
            'Titulo' => 'Novo Livro',
            'Editora' => 'Editora 1',
            'Edicao' => 1,
            'AnoPublicacao' => 2024,
            'Valor' => 50,
        ];

        // Mocking the validator and repository
        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::LIVRO)
            ->willReturn(new class {
                public function validate(array $data) { return $data; }
            });

        $this->livroRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($livroAttributes)
            ->willThrowException(new \Exception('Erro ao cadastrar livro.'));

        Log::shouldReceive('error')
            ->once()
            ->with('Erro ao cadastrar livro.');

        $result = $this->livroService->create($data);

        $this->assertFalse($result);
    }

    public function testValidatesAndUpdatesLivro()
    {
        $data = [
            'Titulo' => 'Livro Atualizado',
            'Editora' => 'Nova Editora',
            'Edicao' => 2,
            'AnoPublicacao' => '2024',
            'Valor' => 65.00,
            'CodAs' => [1],
            'CodAu' => [2]
        ];

        $livroAttributes = [
            'Titulo' => 'Livro Atualizado',
            'Editora' => 'Nova Editora',
            'Edicao' => 2,
            'AnoPublicacao' => '2024',
            'Valor' => 65.00,
        ];

        $mockedLivro = (object) [
            'CodL' => 1,
            'Titulo' => 'Livro 1',
            'Editora' => 'Editora Antiga',
            'Edicao' => 1,
            'AnoPublicacao' => '2023',
            'Valor' => 60.00,
        ];

        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::LIVRO)
            ->willReturn(new class {
                public function validate(array $data) { return $data; }
            });

        $this->livroRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($mockedLivro);

        $this->livroRepositoryMock
            ->expects($this->once())
            ->method('update')
            ->with(1, $livroAttributes)
            ->willReturn(true);

        $this->livroAssuntoRepositoryMock
            ->expects($this->once())
            ->method('deleteByCodL')
            ->with(1)
            ->willReturn(true);

        $this->livroAssuntoRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with(['Livro_CodL' => 1, 'Assunto_CodAs' => 1]);

        $this->livroAutorRepositoryMock
            ->expects($this->once())
            ->method('deleteByCodL')
            ->with(1)
            ->willReturn(true);

        $this->livroAutorRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with(['Livro_CodL' => 1, 'Autor_CodAu' => 2]);

        $result = $this->livroService->update(1, $data);

        $this->assertTrue($result);
    }

    public function testUpdateThrowsNotFoundExceptionIfLivroNotFound()
    {
        $data = [
            'Titulo' => 'Livro Atualizado',
        ];

        $this->livroRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(999)
            ->willReturn(null);

        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::LIVRO)
            ->willReturn(new class {
                public function validate(array $data) { return $data; }
            });

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Livro não encontrado.');

        $this->livroService->update(999, $data);
    }

    public function testDeleteDestroysLivroIfFound()
    {
        $mockedLivro = (object) [
            'CodL' => 1,
            'Titulo' => 'Livro 1',
            'Editora' => 'Editora Antiga',
            'Edicao' => 1,
            'AnoPublicacao' => 2023,
            'Valor' => 60.00,
        ];

        $this->livroRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($mockedLivro);

        $this->livroRepositoryMock
            ->expects($this->once())
            ->method('destroy')
            ->with(1)
            ->willReturn(true);

        $result = $this->livroService->delete(1);

        $this->assertTrue($result);
    }

    public function testDeleteThrowsNotFoundExceptionIfLivroNotFound()
    {
        $this->livroRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(999)
            ->willReturn(null);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Livro não encontrado.');

        $this->livroService->delete(999);
    }
}
