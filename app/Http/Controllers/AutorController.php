<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\IAutorService;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    private $autorService;

    public function __construct(
        IAutorService $autorService
    ) {
        $this->autorService = $autorService;
    }

    public function index()
    {
        return view('autor.index', [
            'autores' => $this->autorService->getAll()
        ]);
    }

    public function create()
    {
        return view('autor.create');
    }

    public function store(Request $request)
    {
        if ($this->autorService->create($request->only('Nome'))) {
            return redirect()->route('autores.index')
                ->with('success', 'Autor cadastrado com sucesso!');
        }

        return redirect()->route('autores.index')
            ->with('error', 'Erro ao cadastrar autor!');
    }

    public function show(string $id)
    {
        return view('autor.show', [
            'autor' => $this->autorService->getById($id)
        ]);
    }

    public function edit(string $id)
    {
        $autor = $this->autorService->getById($id);

        return view('autor.edit', [
            'autor' => $autor,
        ]);
    }

    public function update(Request $request, string $id)
    {
        if ($this->autorService->update($id, $request->only('Nome'))) {
            return redirect()->route('autores.index')
                ->with('success', 'Autor atualizado com sucesso!');
        }

        return redirect()->route('autores.index')
            ->with('error', ['Erro ao cadastrar autor!']);
    }

    public function destroy(string $id)
    {
        if ($this->autorService->delete($id)) {
            return redirect()->route('autores.index')
                ->with('success', 'Autor excluído com sucesso!');
        }

        return redirect()->route('autores.index')
            ->with('error', ['Erro ao excluir autor!']);
    }
}
