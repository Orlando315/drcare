@extends( 'layouts.app' )
@section( 'title', 'Usuarios - '.config('app.name') )
@section( 'header', 'Usuarios' )
@section( 'breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li><a href="{{ route( 'users.index' ) }}" title="Usuarios"> Usuarios </a></li>
    <li class="active">Agregar</li>
  </ol>
@endsection
@section('content')
  <!-- Formulario -->
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <form class="" action="{{ route( 'users.store' ) }}" method="POST" enctype="multipart/form-data">

        {{ method_field( 'POST' ) }}
        {{ csrf_field() }}

        <h4>Agregar Usuario</h4>

        <div class="form-group {{ $errors->has( 'role' ) ? 'has-error' : '' }}">
          <label class="control-label" class="form-control" for="role">Role: *</label>
          <select id="role" class="form-control" name="role" required>
            <option value="">Seleccione...</option>
            <option value="Usuario" @if( old('role') ) {{ old( 'role' ) == 'Usuario' ? 'selected' : '' }} @endif>Usuario</option>
            <option value="Operativo" @if( old('role') ) {{ old( 'role' ) == 'Operativo' ? 'selected' : '' }} @endif>Operativo</option>
            <option value="Admin" @if( old('role') ) {{ old( 'role' ) == 'Admin' ? 'selected' : '' }} @endif>Admin</option>
          </select>
        </div>

        <div class="form-group {{ $errors->has( 'status' ) ? 'has-error' : '' }}">
          <label class="control-label" class="form-control" for="status">Status: *</label>
          <select id="status" class="form-control" name="status" required>
            <option value="">Seleccione...</option>
            <option value="Inactivo" @if( old('status') ) {{ old( 'status' ) == 'Inactivo' ? 'selected' : '' }} @endif>Inactivo</option>
            <option value="Activo" @if( old('status') ) {{ old( 'status' ) == 'Activo' ? 'selected' : '' }} @endif>Activo</option>
          </select>
        </div>

        <div class="form-group {{ $errors->has( 'nombre' ) ? 'has-error' : '' }}">
          <label class="control-label" for="nombre">Nombre: *</label>
          <input id="nombre" class="form-control" type="text" name="nombre" value="{{ old( 'nombre' ) ? old( 'nombre ' ) : '' }}" placeholder="Nombre">
        </div>

        <div class="form-group {{ $errors->has( 'tipo_cedula' ) ? 'has-error' : '' }}">
          <label class="control-label" class="form-control" for="tipo_cedula">Tipo de documento: *</label>
          <select id="tipo_cedula" class="form-control" name="tipo_cedula" required>
            <option value="" selected>Seleccione...</option>
            <option value="V" @if( old('tipo_cedula') ) {{ old( 'tipo_cedula' ) == 'V' ? 'selected' : '' }} @endif> V </option>
            <option value="E" @if( old('tipo_cedula') ) {{ old( 'tipo_cedula' ) == 'E' ? 'selected' : '' }} @endif> E </option>
          </select>
        </div>

        <div class="form-group {{ $errors->has( 'cedula' ) ? 'has-error' :'' }}">
          <label class="control-label" for="cedula">Cedula: *</label>
          <input id="cedula" class="form-control" type="text" name="cedula" minlength="6" maxlength="10" value="{{ old( 'cedula' ) ? old( 'cedula' ) : '' }}" placeholder="Cedula" required>
          <p class="help-block">No incluir puntos.</p>
        </div>

        <div class="form-group {{ $errors->has( 'departamento' ) ? 'has-error' : '' }}">
          <label class="control-label" class="form-control" for="departamento">Departamento: *</label>
          <select id="departamento" class="form-control" name="departamento_id" required>
            <option value="" selected>Seleccione...</option>
            @foreach($departamentos as $departamento)
              <option value="{{ $departamento->id }}" @if( old('departamento_id') ) {{ old( 'departamento_id' ) == $departamento->id ? 'selected' : '' }} @endif>{{ $departamento->departamento }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group {{ $errors->has( 'cargo' ) ? 'has-error' : '' }}">
          <label class="control-label" for="cargo">Cargo: *</label>
          <select id="cargo" class="form-control" name="cargo_id" disabled="" required>
            <option value="">Seleccione...</option>
          </select>
        </div>

        <div class="form-group {{ $errors->has( 'password' ) ? 'has-error' : '' }}">
          <label class="control-label" for="password">Contraseña: *</label>
          <input id="password" class="form-control" type="password" minlength="6" name="password" required>
           <p class="help-block">Debe incluir minimo 6 caracteres.</p>
        </div>

        <div class="form-group {{ $errors->has( 'password_confirmation' ) ? 'has-error' : '' }}">
          <label class="control-label" for="password_confirmation">Verificar: *</label>
          <input id="password_confirmation" class="form-control" type="password" minlength="6" name="password_confirmation" required>
          <p class="help-block">Verificar contrasña.</p>
        </div>

        @if (count($errors) > 0)
          <div class="alert alert-danger alert-important">
            <ul>
              @foreach( $errors->all() as $error )
                <li>{{ $error }}</li>
              @endforeach
            </ul>  
          </div>
        @endif

        <div class="form-group text-right">
          <a class="btn btn-flat btn-default" href="{{ route( 'users.index' ) }}"><i class="fa fa-reply"></i> Atras</a>
          <button class="btn btn-flat btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section( 'scripts' )
<script type="text/javascript">
  $(document).ready( function(){

    $('#departamento').change(function(){
      var uid = $(this).val(),
          select = $('#cargo');

      select.prop('disabled', true)
      select.empty()

      $.ajax({
        method: 'POST',
        url: '{{ route( "get_departamento" ) }}',
        data: {_token: '{{ csrf_token() }}', id: uid},
        dataType: 'json',
      })
      .done(function( data ){
        select.append('<option value="">Seleccione...</option>');
        $.each(data, function(index, cargo){
          select.append('<option value="' + cargo.id + '">' + cargo.cargo + '</option>');
        });

        select.prop('disabled', false)
      })
      .fail(function(){
        select.prop('disabled', true)
      })
      .always(function(){

      });
    });

    $('#departamento').change();

  });
</script>
@endsection