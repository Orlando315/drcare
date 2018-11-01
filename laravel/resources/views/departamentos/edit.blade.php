@extends( 'layouts.app' )
@section( 'title', 'Departamentos - '.config( 'app.name' ) )
@section( 'header','Departamento' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li><a href="{{ route( 'departamentos.index' ) }}" title="Departamentos"> Departamentos </a></li>
    <li class="active">Editar</li>
  </ol>
@endsection
@section('content')
    <!-- Formulario -->
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <form class="" action="{{ route('departamentos.update', [ 'id' => $departamento->id ] ) }}" method="POST">

          {{ method_field('PATCH') }}
          {{ csrf_field() }}

          <h4>Editar Departamento</h4>

          <div class="form-group {{ $errors->has( 'departamento' ) ? 'has-error' : '' }}">
            <label class="control-label" for="departamento">Departamento: *</label>
            <input id="departamento" class="form-control" type="text" name="departamento" value="{{ old('departamento') ? old('departamento') : $departamento->departamento }}" placeholder="Departamento" required>
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
            <a class="btn btn-flat btn-default" href="{{ route( 'departamentos.index' ) }}"><i class="fa fa-reply"></i> Atras</a>
            <button class="btn btn-flat btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
          </div>
        </form>
      </div>
    </div>
@endsection
