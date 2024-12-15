<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\IAssuntoService;
use App\Services\Interfaces\IAutorService;
use App\Services\Interfaces\ILivroService;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    private $livroService;
    private $assuntoService;
    private $autorService;

    public function __construct(
        ILivroService $livroService,
        IAssuntoService $assuntoService,
        IAutorService $autorService
    )
    {
        $this->livroService = $livroService;
        $this->assuntoService = $assuntoService;
        $this->autorService = $autorService;
    }

    public function index()
    {
        return view('livro.index', [
            'livros' => $this->livroService->getAll()
        ]);
    }

    public function create()
    {
        return view('livro.create', [
            'assuntos' => $this->assuntoService->getAll(),
            'autores' => $this->autorService->getAll(),
        ]);
    }

    public function store(Request $request)
    {
        $requestData = $this->getRequestData($request);

        if ($this->livroService->create($requestData)) {
            return redirect()->route('livros.index')
                ->with('success', 'Livro cadastrado com sucesso!');
        }

        return redirect()->route('livros.index')
            ->with('error', 'Erro ao cadastrar livro!');
    }

    public function show(int $id)
    {
        return view('livro.show', [
            'livro' => $this->livroService->getById($id)
        ]);
    }

    public function edit(int $id)
    {
        return view('livro.edit', [
            'livro' => $this->livroService->getById($id),
            'assuntos' => $this->assuntoService->getAll(),
            'autores' => $this->autorService->getAll(),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $requestData = $this->getRequestData($request);

        if ($this->livroService->update($id, $requestData)) {
            return redirect()->route('livros.index')
                ->with('success', 'Livro atualizado com sucesso!');
        }

        return redirect()->route('livros.index')
            ->with('error', ['Erro ao atualizar livro!']);
    }

    public function destroy(int $id)
    {
        if ($this->livroService->delete($id)) {
            return redirect()->route('livros.index')
                ->with('success', 'Livro excluído com sucesso!');
        }

        return redirect()->route('livros.index')
            ->with('error', ['Erro ao excluir autor!']);
    }

    private function getRequestData(Request $request): array
    {
        return $request->only(
            'Titulo',
            'Editora',
            'Edicao',
            'AnoPublicacao',
            'Valor',
            'CodAu',
            'CodAs'
        );
    }
}
