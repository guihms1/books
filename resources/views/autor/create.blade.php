@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>Cadastrar novo Autor</h1>
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
            <form method="POST" action="{{ route('autores.store') }}">
                @method('POST')
                @csrf
                <div class="mb-3">
                    <label for="Nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" name="Nome" id="Nome" value="{{ old('Nome') }}">
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
        </div>
    </div>
@endsection
