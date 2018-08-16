@extends( 'layouts.app' )
@section( 'title', 'Usuarios - '.config( 'app.name' ) )
@section( 'header','Usuarios' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li><a href="{{ route( 'perfil' ) }}" title="Usuarios"> Perfil </a></li>
    <li class="active">Editar</li>
  </ol>
@endsection
@section('content')
  <!-- Formulario -->
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <form class="" action="{{ route( 'update_perfil' ) }}" method="POST">

        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <h4>Editar Perfil</h4>

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

        <div class="form-group">
          <div class="checkbox">
            <label>
              <input id="pp" type="checkbox" name="checkbox" value="Yes"> Cambiar contraseña?
            </label>
          </div>
        </div>
        
        <section id="password_fields" style="display:none">
          <div class="form-group">
            <label>Contraseña nueva: *</label>
            <input id="password" class="form-control" type="password" name="password" minlength="6" disabled>
            <p class="help-block">Debe incluir minimo 6 caracteres.</p>
          </div>
          <div class=" form-group">
            <label>Verificar: *</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" minlength="6" disabled>
            <p class="help-block">Verificar contrasña.</p>
          </div>
        </section>

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
          <a class="btn btn-flat btn-default" href="{{ route( 'perfil' ) }}"><i class="fa fa-reply"></i> Atras</a>
          <button class="btn btn-flat btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section( 'scripts' )
  <script type="text/javascript">
  $(document).ready(function(){
      $("#pp").click(function(event) {
      var bool = this.checked;
      if(bool === true){
        $("#password_fields").show();
        $("#password,#password_confirmation").prop({'required':true,'disabled':false});
      }else{
        $("#password_fields").hide();
        $("#password,#password_confirmation").prop({'required':false,'disabled':true}).val('');
      }
    });
  });
  </script>
@endsection
