<?php

namespace Tests\Unit;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Models\Assunto;
use App\Repositories\AssuntoRepository;
use App\Services\AssuntoService;
use App\Validators\AssuntoValidator;
use App\Validators\ValidatorFactory;
use Tests\TestCase;

class AssuntoServiceTest extends TestCase
{
    private $assuntoService;
    private $assuntoRepositoryMock;
    private $validatorFactoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->assuntoRepositoryMock = $this->createMock(AssuntoRepository::class);
        $this->validatorFactoryMock = $this->createMock(ValidatorFactory::class);

        $this->assuntoService = new AssuntoService(
            $this->assuntoRepositoryMock,
            $this->validatorFactoryMock
        );
    }

    public function testGetAllReturnsAllAssuntos()
    {
        $mockedAssuntos = [
            (object) ['id' => 1, 'descricao' => 'Assunto 1'],
            (object) ['id' => 2, 'descricao' => 'Assunto 2'],
        ];

        $this->assuntoRepositoryMock
            ->expects($this->once())
            ->method('getAll')
            ->with([])
            ->willReturn($mockedAssuntos);

        $result = $this->assuntoService->getAll();

        $this->assertEquals($mockedAssuntos, $result);
    }

    public function testGetByIdReturnsAssuntoIfFound()
    {
        $mockedAssunto = (object) ['id' => 1, 'Descricao' => 'Assunto 1'];

        $this->assuntoRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($mockedAssunto);

        $result = $this->assuntoService->getById(1);

        $this->assertEquals($mockedAssunto, $result);
    }

    public function testGetByIdThrowsNotFoundExceptionIfNotFound()
    {
        $this->assuntoRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(999)
            ->willReturn(null);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Assunto não encontrado.');

        $this->assuntoService->getById(999);
    }

    public function testValidatesAndCreatesAssunto()
    {
        $data = ['Descricao' => 'Novo Assunto'];
        $validatedData = $data;

        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::ASSUNTO)
            ->willReturn(new class {
                public function validate(array $data) { return $data; }
            });

        $this->assuntoRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($validatedData)
            ->willReturn(true);

        $result = $this->assuntoService->create($data);

        $this->assertTrue($result);
    }

    public function testCreateThrowsValidationException()
    {
        $validatorMock = $this->createMock(AssuntoValidator::class);

        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::ASSUNTO)
            ->willReturn($validatorMock);

        $validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with(['Descricao' => null])
            ->willThrowException(new ValidationException(['Invalid data.']));

        $this->expectException(ValidationException::class);
        $this->assuntoService->create(['Descricao' => null]);
    }

    public function testValidatesAndUpdatesAssunto()
    {
        $data = ['Descricao' => 'Assunto Atualizado'];
        $validatedData = $data;
        $mockedAssunto = (object) ['id' => 1, 'Descricao' => 'Assunto Antigo'];

        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::ASSUNTO)
            ->willReturn(new class {
                public function validate(array $data) { return $data; }
            });

        $this->assuntoRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($mockedAssunto);

        $this->assuntoRepositoryMock
            ->expects($this->once())
            ->method('update')
            ->with(1, $validatedData)
            ->willReturn(true);

        $result = $this->assuntoService->update(1, $data);

        $this->assertTrue($result);
    }

    public function testUpdateThrowsNotFoundExceptionIfNotFound()
    {
        $data = ['Descricao' => 'Assunto Atualizado'];

        $this->assuntoRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(999)
            ->willReturn(null);

        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::ASSUNTO)
            ->willReturn(new class {
                public function validate(array $data) { return $data; }
            });

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Assunto não encontrado.');

        $this->assuntoService->update(999, $data);
    }

    public function testUpdateThrowsValidationException()
    {
        $validatorMock = $this->createMock(AssuntoValidator::class);

        $this->validatorFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(ValidatorFactory::ASSUNTO)
            ->willReturn($validatorMock);

        $validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with(['Descricao' => null])
            ->willThrowException(new ValidationException(['Invalid data.']));

        $this->expectException(ValidationException::class);

        $this->assuntoService->update(1, ['Descricao' => null]);
    }

    public function testDeleteDestroysAssuntoIfFound()
    {
        $mockedAssunto = (object) ['id' => 1, 'descricao' => 'Assunto to delete'];

        $this->assuntoRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($mockedAssunto);

        $this->assuntoRepositoryMock
            ->expects($this->once())
            ->method('destroy')
            ->with(1)
            ->willReturn(true);

        $result = $this->assuntoService->delete(1);

        $this->assertTrue($result);
    }

    public function testDeleteThrowsNotFoundExceptionIfNotFound()
    {
        $this->assuntoRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with(999)
            ->willReturn(null);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Assunto não encontrado.');

        $this->assuntoService->delete(999);
    }
}
