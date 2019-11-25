@extends('layout.app', ['current' => 'produtos'])

@section('body')
<div class="card border">
    <div class="card-body">
      <h5 class="card-title">Registo de Produtos</h5>
        <table class="table table-ordered table-hover" id="tabelaProdutos">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nome</th>
              <th>Quantidade</th>
              <th>Preço</th>
              <th>Departamento</th>
              <th>Acções</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    </div>
    <div class="card-footer">
      <button class="btn btn-sm btn-primary" role="button" onClick="novoProduto()">Novo Produto</button>
    </div>
  </div>

  <div class="modal" tabindex="-1" role="dialog" id="dlgProdutos">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="" class="form-horizontal" id="formProduto">
          <div class="modal-header">
            <h5 class="modal-title">Novo Produto</h5>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id" class="form-control">
            <!-- o input acima fica escondido e mostra um 'value = '2'' no inspect, o value é igual ao id do produto selecionado para editar. Isto é util e usado para saber se estamos a abrir o form para criar um produto novo ou a editar um (ja existente) -->
            <div class="form-group">
              <label for="nomeProduto" class="control-label">Nome do Produto</label>
              <div class="input-group">
                <input type="text" class="form-control" id="nomeProduto" placeholder="Nome do Produto">
                <!-- id aqui tem de ser igual ao label -->
              </div>
            </div>
            <div class="form-group">
              <label for="precoProduto" class="control-label">Preço do Produto</label>
              <div class="input-group">
                <input type="number" class="form-control" id="precoProduto" placeholder="Preço do Produto">
              </div>
            </div>
            <div class="form-group">
              <label for="quantidadeProduto" class="control-label">Quantidade do Produto</label>
              <div class="input-group">
                <input type="number" class="form-control" id="quantidadeProduto" placeholder="Quantidade do Produto">
              </div>
            </div>
            <div class="form-group">
              <label for="categoriaProduto" class="control-label">Categoria</label>
              <div class="input-group">
                <select class="form-control" id="categoriaProduto">
                </select>
              </div>
            </div>
          </div>
          {{ csrf_field() }}
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
  <script type="text/javascript">

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      }
    });

    function novoProduto() {
      $('#id').val()
      $('#nomeProduto').val()
      $('#precoProduto').val()
      $('#quantidadeProduto').val()
      $('#dlgProdutos').modal('show')
    };

    function carregarCategorias() {
      //$.get() é a funçao do jquery propria para o ajax mas dps tenho de usar a funçao JSON.parse() para transformar para objecto e conseguir mexer no resultado
      //$.getJSON() é a funçao do jquery propria para o ajax e ja faz o 'parser'
      $.getJSON('/api/categorias', function(data){
        console.log(data);
        for(i=0; i<data.length; i++) {
            opcao = '<option value="' + data[i].id + '">' + data[i].nome + '</option>';
            $('#categoriaProduto').append(opcao);
        }
      })
    };

    function montarLinha(p) {
      var linha = "<tr>" +
                    "<td>" + p.id + "</td>" +
                    "<td>" + p.nome + "</td>" +
                    "<td>" + p.stock + "</td>" +
                    "<td>" + p.preco + "</td>" +
                    "<td>" + p.categoria_id + "</td>" +
                    "<td>" +
                      '<button class="btn btn-xs btn-primary" onClick="editar(' + p.id + ')">Editar</button>' +
                      '<button class="btn btn-xs btn-primary" onClick="remover(' + p.id + ')">Apagar</button>' +
                    "</td>" +
                  "</tr>";

      return linha;
    };

    function editar(id) {
      $.getJSON('/api/produtos/'+id, function(data){ //neste caso nao faço JSON.parse() pq o proprio getJSON ja o faz, transforma de string para num objecto
      $('#id').val(data.id)
      $('#nomeProduto').val(data.nome)
      $('#precoProduto').val(data.preco)
      $('#quantidadeProduto').val(data.stock)
      $('#categoriaProduto').val(data.categoria_id)
      $('#dlgProdutos').modal('show')
      })
    };

    function remover(id) {
      $.ajax({  //a funçao ajax espera receber um objecto
        type: "DELETE",
        url: "/api/produtos/" + id,
        context: this,
        success: function() {
          console.log('Produto removido com sucesso! ');
          linhas = $('#tabelaProdutos>tbody>tr');
          e = linhas.filter( function(i, elemento) {  //'elemento' é um index
            return elemento.cells[0].textContent == id;  // 'cells' sao colunas
          });
          if(e)
            e.remove();
        },
        error: function() {
          console.log(error);
        }
      });
    };

    function carregarProdutos() {
      $.getJSON('/api/produtos', function(produtos){
        for(i=0; i<produtos.length; i++) {
            linha = montarLinha(produtos[i])
            $('#tabelaProdutos>tbody').append(linha);
        }
      })
    };

    function criarProduto() {
      prod = {
        nome: $('#nomeProduto').val(),
        preco: $('#precoProduto').val(),
        stock: $('#quantidadeProduto').val(),
        categoria_id: $('#categoriaProduto').val()
      }

      $.post('/api/produtos', prod, function(data) {
        produto = JSON.parse(data);
        linha = montarLinha(produto);
        $('#tabelaProdutos>tbody').append(linha);
      });

    };

    function guardarProduto() {
      prod = {
        id: $('#id').val(),
        nome: $('#nomeProduto').val(),
        preco: $('#precoProduto').val(),
        stock: $('#quantidadeProduto').val(),
        categoria_id: $('#categoriaProduto').val()
      };

      $.ajax({
        type: "PUT",
        url: "/api/produtos/" + prod.id,
        context: this,
        data: prod,
        success: function(data) {
          prod = JSON.parse(data);
          linhas = $('#tabelaProdutos>tbody>tr');
          e = linhas.filter( function(i, elemento) {
            return (elemento.cells[0].textContent == prod.id);
          });
          if(e) {
            e[0].cells[0].textContent == prod.id;
            e[0].cells[1].textContent == prod.nome;
            e[0].cells[2].textContent == prod.stock;
            e[0].cells[3].textContent == prod.preco;
            e[0].cells[4].textContent == prod.categoria_id;
          }
        },
        error: function(error) {
          console.log(error);
        }
      });
    }

    $('#formProduto').submit(function(event) {
      event.preventDefault();  //esta linha vai fazer com que, ao clicar para guardar o formulario, a pagina n faça refresh
      if ($("#id").val() != '') { //ver comentario no html acima
        guardarProduto();
      }
      else {
        criarProduto();
      }
      $('#dlgProdutos').modal('hide');
    });

//funçao do jquery que chama as funçoes (para as inicializar)
    $(function(){
      carregarCategorias();
      carregarProdutos();
    });

  </script>
@endsection