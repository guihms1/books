<?php

namespace Tests\Unit;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Repositories\AutorRepository;
use App\Services\AutorService;
use App\Validators\AutorValidator;
use App\Validators\ValidatorFactory;
use Tests\TestCase;

class AutorServiceTest extends TestCase
{
    private $autorService;
    private $autorRepositoryMock;
    private $validatorFactoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->autorRepositoryMock = $this->createMock(AutorRepository::class);
        $this->validatorFactoryMock = $this->createMock(ValidatorFactory::class);

        $this->autorService = new AutorService(
            $this->autorRepositoryMock,
            $this->validatorFactoryMock
        );
    }

    public function testGetAllReturnsAllAutores()
    {
        $mockedAutores = [
            (object) ['id' => 1, 'Nome' => 'Autor 1'],
            (object) ['id' => 2, 'Nome' => 'Autor 2'],
        ];

        $this->autorRepositoryMock
            ->expects($this->once())
            ->method('getAll')
            ->with([])
            ->willReturn($mockedAutores);

        $result = $this->autorService->getAll();

        $this->assertEquals($mockedAutores, $result);
    }

    public function testGetByIdReturnsAutorIfFound()
    {
        $mockedAutor = (object) ['id' => 1, 'Nome' => 'Autor 1'];

        $this->autorRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($mockedAutor);

        $result = $this->autorService->getById(1);

        $this->assertEquals($mockedAutor, $result);
    }

    public function testGetByIdThrowsNotFoundExceptionIfNotFound()
    {
        $this->autorRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(999)
            ->willReturn(null);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Autor não encontrado.');

        $this->autorService->getById(999);
    }

    public function testValidatesAndCreatesAutor()
    {
        $data = ['Nome' => 'Novo Autor'];
        $validatedData = $data;

        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::AUTOR)
            ->willReturn(new class {
                public function validate(array $data) { return $data; }
            });

        $this->autorRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($validatedData)
            ->willReturn(true);

        $result = $this->autorService->create($data);

        $this->assertTrue($result);
    }

    public function testCreateThrowsValidationException()
    {
        $validatorMock = $this->createMock(AutorValidator::class);

        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::AUTOR)
            ->willReturn($validatorMock);

        $validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with(['Nome' => null])
            ->willThrowException(new ValidationException(['Invalid data.']));

        $this->expectException(ValidationException::class);
        $this->autorService->create(['Nome' => null]);
    }

    public function testValidatesAndUpdatesAutor()
    {
        $data = ['Nome' => 'Autor Atualizado'];
        $validatedData = $data;
        $mockedAutor = (object) ['id' => 1, 'Nome' => 'Autor Antigo'];

        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::AUTOR)
            ->willReturn(new class {
                public function validate(array $data) { return $data; }
            });

        $this->autorRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($mockedAutor);

        $this->autorRepositoryMock
            ->expects($this->once())
            ->method('update')
            ->with(1, $validatedData)
            ->willReturn(true);

        $result = $this->autorService->update(1, $data);

        $this->assertTrue($result);
    }

    public function testUpdateThrowsNotFoundExceptionIfNotFound()
    {
        $data = ['Nome' => 'Autor Atualizado'];

        $this->autorRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(999)
            ->willReturn(null);

        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::AUTOR)
            ->willReturn(new class {
                public function validate(array $data) { return $data; }
            });

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Autor não encontrado.');

        $this->autorService->update(999, $data);
    }

    public function testUpdateThrowsValidationException()
    {
        $validatorMock = $this->createMock(AutorValidator::class);

        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::AUTOR)
            ->willReturn($validatorMock);

        $validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with(['Nome' => null])
            ->willThrowException(new ValidationException(['Invalid data.']));

        $this->expectException(ValidationException::class);

        $this->autorService->update(1, ['Nome' => null]);
    }

    public function testDeleteDestroysAutorIfFound()
    {
        $mockedAutor = (object) ['id' => 1, 'Nome' => 'Autor to delete'];

        $this->autorRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($mockedAutor);

        $this->autorRepositoryMock
            ->expects($this->once())
            ->method('destroy')
            ->with(1)
            ->willReturn(true);

        $result = $this->autorService->delete(1);

        $this->assertTrue($result);
    }

    public function testDeleteThrowsNotFoundExceptionIfNotFound()
    {
        $this->autorRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(999)
            ->willReturn(null);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Autor não encontrado.');

        $this->autorService->delete(999);
    }
}
