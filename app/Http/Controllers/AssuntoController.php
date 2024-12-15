<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\IAssuntoService;
use Illuminate\Http\Request;

class AssuntoController extends Controller
{
    private $assuntoService;

    public function __construct(
        IAssuntoService $assuntoService
    )
    {
        $this->assuntoService = $assuntoService;
    }

    public function index()
    {
        return view('assunto.index', [
            'assuntos' => $this->assuntoService->getAll(),
        ]);
    }

    public function create()
    {
        return view('assunto.create');
    }

    public function store(Request $request)
    {
        if ($this->assuntoService->create($request->only('Descricao'))) {
            return redirect()->route('assuntos.index')
                ->with('success', 'Assunto cadastrado com sucesso!');
        }

        return redirect()->route('assuntos.index')
            ->with('error', 'Erro ao cadastrar assunto!');
    }

    public function show(int $id)
    {
        return view('assunto.show', [
            'assunto' => $this->assuntoService->getById($id)
        ]);
    }

    public function edit(int $id)
    {
        $assunto = $this->assuntoService->getById($id);

        return view('assunto.edit', [
            'assunto' => $assunto,
        ]);
    }

    public function update(Request $request, int $id)
    {
        if ($this->assuntoService->update($id, $request->only('Descricao'))) {
            return redirect()->route('assuntos.index')
                ->with('success', 'Assunto atualizado com sucesso!');
        }

        return redirect()->route('assuntos.index')
            ->with('error', ['Erro ao cadastrar assunto!']);
    }

    public function destroy(int $id)
    {
        if ($this->assuntoService->delete($id)) {
            return redirect()->route('assuntos.index')
                ->with('success', 'Assunto excluído com sucesso!');
        }

        return redirect()->route('assuntos.index')
            ->with('error', ['Erro ao excluir assunto!']);
    }
}
