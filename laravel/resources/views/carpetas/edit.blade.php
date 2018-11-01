@extends( 'layouts.app' )
@section( 'title', 'Carpetas - '.config('app.name') )
@section( 'header', 'Carpetas' )
@section( 'breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li><a href="{{ route('productos.show', ['id' => $carpeta->producto_id]) }}" title="Producto"> Producto </a></li>
    <li class="active">Carpeta</li>
  </ol>
@endsection
@section('content')
  <!-- Formulario -->
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <form class="" action="{{ route( 'carpetas.update', ['id' => $carpeta->id] ) }}" method="POST">

        {{ method_field( 'PATCH' ) }}
        {{ csrf_field() }}

        <h4>Editar Carpeta</h4>

        <div class="form-group {{ $errors->has( 'carpeta' ) ? 'has-error' : '' }}">
          <label class="control-label" for="carpeta">Carpeta: *</label>
          <input id="carpeta" class="form-control" type="text" name="carpeta" value="{{ old( 'carpeta' ) ? old( 'carpeta ' ) : $carpeta->carpeta }}" placeholder="Carpeta" required>
        </div>

        @if(count($errors) > 0)
          <div class="alert alert-danger alert-important">
            <ul>
              @foreach( $errors->all() as $error )
                <li>{{ $error }}</li>
              @endforeach
            </ul>  
          </div>
        @endif

        <div class="form-group text-right">
          <a class="btn btn-flat btn-default" href="{{ route('carpetas.show', ['id' => $carpeta->id]) }}"><i class="fa fa-reply"></i> Atras</a>
          <button class="btn btn-flat btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
@endsection
