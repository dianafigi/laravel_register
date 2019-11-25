@extends('layout.app', ['current' => 'categorias'])

@section('body')
  <div class="card border">
    <div class="card-body">
      <form action="/categorias" method="POST">
        <div class="form-group">
          <label for="nomeCategoria">Nome da Categoria</label>
          <input type="text" class="form-control" name="nomeCategoria" id="nomeCategoria" placeholder="Categoria">
        </div>
        {{csrf_field()}}
        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
        <button type="cancel" class="btn btn-danger btn-sm">Cancelar</button>
      </form>
    </div>
  </div>
@endsection

