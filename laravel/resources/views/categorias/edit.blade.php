@extends( 'layouts.app' )
@section( 'title', 'Categorias - '.config( 'app.name' ) )
@section( 'header','Categorias' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li><a href="{{ route( 'categorias.index' ) }}" title="Categorias"> Categorias </a></li>
    <li class="active">Editar</li>
  </ol>
@endsection
@section('content')
    <!-- Formulario -->
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <form class="" action="{{ route('categorias.update', [ 'id' => $categoria->id ] ) }}" method="POST">

          {{ method_field('PATCH') }}
          {{ csrf_field() }}

          <h4>Editar Categoria</h4>

          <div class="form-group {{ $errors->has( 'categoria' ) ? 'has-error' : '' }}">
            <label class="control-label" for="categoria">Categoria: *</label>
            <input id="categoria" class="form-control" type="text" name="categoria" value="{{ old('categoria') ? old('categoria') : $categoria->categoria }}" placeholder="Categoria">
          </div>

          @if (count($errors) > 0)
          <div class="alert alert-danger alert-important">
            <ul>
              @foreach($errors->all() as $error)
                 <li>{{ $error }}</li>
               @endforeach
            </ul>  
          </div>
          @endif

          <div class="form-group text-right">
            <a class="btn btn-flat btn-default" href="{{ route( 'categorias.index' ) }}"><i class="fa fa-reply"></i> Atras</a>
            <button class="btn btn-flat btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
          </div>
        </form>
      </div>
    </div>
@endsection
