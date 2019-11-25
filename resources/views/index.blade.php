@extends('layout.app', ['current' => 'home'])

@section('body')
  <div class="jumbotron bg-lighht border border-secundary">
    <div class="row">
      <div class="card-deck">
        <div class=" card border border-primary">
          <div class="card-body">
            <h5 class="card-title">Registo de produtos</h5>
            <p class="card-text">
              Regista aqui os produtos. Mas regista previamente as categorias.
            </p>
            <a href="/produtos" class="btn btn-primary">Regista aqui os produtos</a>
          </div>
        </div>
        <div class=" card border border-primary">
          <div class="card-body">
            <h5 class="card-title">Registo de Categorias</h5>
            <p class="card-text">
              Regista aqui as categorias dos teus produtos.
            </p>
            <a href="/produtos" class="btn btn-primary">Regista aqui as categorias</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endSection