<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro | {{ config( 'app.name' ) }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset( 'css/font-awesome.css' ) }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset( 'css/AdminLTE.min.css' ) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset( 'css/glyphicons.css' ) }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset( 'css/_all-skins.min.css' ) }}">
    <link rel="shortcut icon" href="{{ asset( 'img/logo.png' ) }}">
  </head>
  <body class="login-page">

    <div class="login-logo">
      <center><img class="img-responsive" src="{{ asset( 'images/logo.png' ) }}" alt="Logo" style="height:75px"></center>
    </div><!-- /.login-logo -->

    @include( 'partials.flash' )

    <div class="row">
      <div class="col-md-4 col-md-offset-4 col-sm-12">
        <form class="" action="{{ route( 'store_publico' ) }}" method="POST" enctype="multipart/form-data">

          {{ method_field( 'POST' ) }}
          {{ csrf_field() }}

          <h4>Solicitud de ingreso</h4>

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
            <a class="btn btn-flat btn-default" href="{{ route( 'login' ) }}"><i class="fa fa-reply"></i> Atras</a>
            <button class="btn btn-flat btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
          </div>
        </form>
      </div>
    </div>


    <!-- jQuery 2.1.4 -->
    <script type="text/javascript" src="{{ asset( 'js/jQuery-2.1.4.min.js' ) }}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script type="text/javascript" src="{{ asset( 'js/bootstrap.min.js' ) }}"></script>

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

  </body>
</html>