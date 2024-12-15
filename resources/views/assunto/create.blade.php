@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>Cadastrar novo Assunto</h1>
        </div>
    </div>
    <div class="row my-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col">
            <form method="POST" action="{{ route('assuntos.store') }}">
                @method('POST')
                @csrf
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" name="Descricao" id="Descricao" value="{{ old('Descricao') }}">
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
        </div>
    </div>
@endsection
