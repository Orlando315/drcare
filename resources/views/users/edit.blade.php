@extends( 'layouts.app' )
@section( 'title', 'Usuarios - '.config( 'app.name' ) )
@section( 'header','Usuarios' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li><a href="{{ route( 'users.index' ) }}" title="Usuarios"> Usuarios </a></li>
    <li class="active">Editar</li>
  </ol>
@endsection
@section('content')
  <!-- Formulario -->
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <form class="" action="{{ route('users.update', [ 'id' => $user->id ] ) }}" method="POST">

        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <h4>Editar Usuario</h4>

        <div class="form-group {{ $errors->has( 'role' ) ? 'has-error' : '' }}">
          <label class="control-label" class="form-control" for="role">Role: *</label>
          <select id="role" class="form-control" name="role" required>
            <option value="">Seleccione...</option>
            <option value="Usuario" {{ old( 'role' ) == 'Usuario' ? 'selected' : $user->role == 'Usuario' ? 'selected' : '' }}>Usuario</option>
            <option value="Operativo" {{ old( 'role' ) == 'Operativo' ? 'selected' : $user->role == 'Operativo' ? 'selected' : '' }}>Operativo</option>
            <option value="Admin" {{ old( 'role' ) == 'Admin' ? 'selected' : $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
          </select>
        </div>

        <div class="form-group {{ $errors->has( 'status' ) ? 'has-error' : '' }}">
          <label class="control-label" class="form-control" for="status">Status: *</label>
          <select id="status" class="form-control" name="status" required>
            <option value="">Seleccione...</option>
            <option value="Inactivo"{{ old( 'status' ) == 'Inactivo' ? 'selected' : $user->status == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
            <option value="Activo"{{ old( 'status' ) == 'Activo' ? 'selected' : $user->status == 'Activo' ? 'selected' : '' }}>Activo</option>
          </select>
        </div>

        <div class="form-group {{ $errors->has('nombre') ? 'has-error' : '' }}">
          <label class="control-label" for="nombre">Nombre: *</label>
          <input id="nombre" class="form-control" type="text" name="nombre" value="{{ old( 'nombre' ) ? old( 'nombre' ) : $user->nombre }}" placeholder="Nombres">
        </div>

        <div class="form-group {{ $errors->has( 'tipo_cedula' ) ? 'has-error' : '' }}">
          <label class="control-label" class="form-control" for="tipo_cedula">Tipo de documento: *</label>
          <select id="tipo_cedula" class="form-control" name="tipo_cedula" required>
            <option value="">Seleccione...</option>
            <option value="V"{{ old( 'tipo_cedula' ) == 'V' ? 'selected' : $user->tipo_cedula == 'V' ? 'selected' : '' }}> V </option>
            <option value="E"{{ old( 'tipo_cedula' ) == 'E' ? 'selected' : $user->tipo_cedula == 'E' ? 'selected' : '' }}> E </option>
          </select>
        </div>

        <div class="form-group {{ $errors->has( 'cedula ' ) ? 'has-error' : '' }}">
          <label class="control-label" for="cedula">Cedula: *</label>
          <input id="cedula" class="form-control" type="text" name="cedula" minlength="6" maxlength="10" value="{{ old( 'cedula' ) ? old( 'cedula' ) : $user->cedula }}" placeholder="Email" required>
          <p class="help-block">No incluir puntos.</p>
        </div>

        <div class="form-group {{ $errors->has( 'departamento' ) ? 'has-error' : '' }}">
          <label class="control-label" class="form-control" for="Departamento">Departamento: *</label>
          <select id="departamento" class="form-control" name="departamento_id" required>
            <option value="">Seleccione...</option>
            @foreach($departamentos as $departamento)
              <option value="{{ $departamento->id }}" {{ old( 'departamento_id' ) == $departamento->id ? 'selected' : $user->departamento_id == $departamento->id ? 'selected' : '' }}>{{ $departamento->departamento }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group {{ $errors->has( 'cargo' ) ? 'has-error' : '' }}">
          <label class="control-label" for="cargo">Cargo: *</label>
          <select id="cargo" class="form-control" name="cargo_id" required>
            <option value="">Seleccione...</option>
          </select>
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
          selected = {{ old('cargo_id') ? old('cargo_id') : $user->cargo_id }} == cargo.id ? 'selected' : '';

          select.append('<option value="' + cargo.id + '" ' + selected + '>' + cargo.cargo + '</option>');
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