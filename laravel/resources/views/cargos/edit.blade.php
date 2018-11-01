@extends( 'layouts.app' )
@section( 'title', 'Cargos - '.config( 'app.name' ) )
@section( 'header','Cargos' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li><a href="{{ route( 'cargos.index' ) }}" title="Cargos"> Cargos </a></li>
    <li class="active">Editar</li>
  </ol>
@endsection
@section('content')
  <!-- Formulario -->
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <form class="" action="{{ route('cargos.update', [ 'id' => $cargo->id ] ) }}" method="POST">

        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <h4>Editar Cargo</h4>

        <div class="form-group {{ $errors->has( 'departamento' ) ? 'has-error' : '' }}">
          <label class="control-label" for="Departamento">Departamento: *</label>
          <select id="departamento" class="form-control" name="departamento_id" required>
            <option value="">Seleccione...</option>
            @foreach($departamentos as $departamento)
              <option value="{{ $departamento->id }}" @if ( old( 'departamento_id' ) ) {{ old( 'departamento_id' ) == $departamento->id ? 'selected' : '' }} @else {{ $departamento->id == $cargo->departamento_id ? 'selected' : '' }} @endif >{{ $departamento->departamento }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group {{ $errors->has( 'cargo' ) ? 'has-error' : '' }}">
          <label class="control-label" for="cargo">Cargo: *</label>
          <input id="cargo" class="form-control" type="text" name="cargo" value="{{ old( 'cargo' ) ? old( 'cargo' ) : $cargo->cargo }}" placeholder="Cargo" required>
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
          <a class="btn btn-flat btn-default" href="{{ route( 'cargos.index' ) }}"><i class="fa fa-reply"></i> Atras</a>
          <button class="btn btn-flat btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
@endsection
