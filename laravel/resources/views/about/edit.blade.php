@extends( 'layouts.app' )
@section( 'title', 'Sobre Dr.Care - '.config( 'app.name' ) )
@section( 'header','Sobre Dr.Care' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li><a href="{{ route( 'about.index' ) }}" title="Sobre Dr.Care"> Sobre Dr.Care </a></li>
    <li class="active">Editar</li>
  </ol>
@endsection
@section('content')
  <!-- Formulario -->
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form class="" action="{{ route('about.update', [ 'id' => $about->id ] ) }}" method="POST" enctype="multipart/form-data">

        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <h4>Sobre Dr.Care</h4>

        <div class="col-md-4">
          <div class="form-group {{ $errors->has( 'email' ) ? 'has-error' : '' }}">
            <label class="control-label" for="email">Email de notificación: *</label>
            <input id="email" class="form-control" type="text" name="email" value="{{ old( 'email' ) ? old( 'email' ) : $about->email }}" placeholder="Email de notificación" required>
          </div>
        </div>

        <div class="col-md-12"></div>

        <div class="col-md-4">
          <div class="form-group {{ $errors->has( 'rif' ) ? 'has-error' : '' }}">
            <label class="control-label" for="rif">RIF:</label>
            <input id="rif" type="file" name="rif" accept="application/pdf">
            <span class="help-block">Formato admitido: PDF</span>
          </div>
          <div class="form-group {{ $errors->has( 'rif_expiracion' ) ? 'has-error' : '' }}">
            <label class="control-label" for="rif_expiracion">Fecha de expiración:</label>
            <input id="rif_expiracion" class="form-control" type="text" name="rif_expiracion" value="{{ old( 'rif_expiracion' ) ? old( 'rif_expiracion' ) : $about->rif_expiracion }}" placeholder="Expiración" {{$about->rif ? '' : 'disabled' }}>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group {{ $errors->has( 'registro_mercantil' ) ? 'has-error' : '' }}">
            <label class="control-label" for="registro_mercantil">Registro Mercantil:</label>
            <input id="registro_mercantil" type="file" name="registro_mercantil" accept="application/pdf">
            <span class="help-block">Formato admitido: PDF</span>
          </div>
          <div class="form-group {{ $errors->has( 'registro_mercantil_expiracion' ) ? 'has-error' : '' }}">
            <label class="control-label" for="registro_mercantil_expiracion">Fecha de expiración:</label>
            <input id="registro_mercantil_expiracion" class="form-control" type="text" name="registro_mercantil_expiracion" value="{{ old( 'registro_mercantil_expiracion' ) ? old( 'registro_mercantil_expiracion' ) : $about->registro_mercantil_expiracion }}" placeholder="Expiración" {{$about->registro_mercantil ? '' : 'disabled' }}>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group {{ $errors->has( 'patente_industria' ) ? 'has-error' : '' }}">
            <label class="control-label" for="patente_industria">Patente de Industria:</label>
            <input id="patente_industria" type="file" name="patente_industria" accept="application/pdf">
            <span class="help-block">Formato admitido: PDF</span>
          </div>
          <div class="form-group {{ $errors->has( 'patente_industria_expiracion' ) ? 'has-error' : '' }}">
            <label class="control-label" for="patente_industria_expiracion">Fecha de expiración:</label>
            <input id="patente_industria_expiracion" class="form-control" type="text" name="patente_industria_expiracion" value="{{ old( 'patente_industria_expiracion' ) ? old( 'patente_industria_expiracion' ) : $about->patente_industria_expiracion }}" placeholder="Expiración" {{$about->patente_industria ? '' : 'disabled' }}>
          </div>
        </div>

        <div class="col-md-12"></div>

        <div class="col-md-4">
          <div class="form-group {{ $errors->has( 'racda' ) ? 'has-error' : '' }}">
            <label class="control-label" for="racda">Racda:</label>
            <input id="racda" type="file" name="racda" accept="application/pdf">
            <span class="help-block">Formato admitido: PDF</span>
          </div>
          <div class="form-group {{ $errors->has( 'racda_expiracion' ) ? 'has-error' : '' }}">
            <label class="control-label" for="racda_expiracion">Fecha de expiración:</label>
            <input id="racda_expiracion" class="form-control" type="text" name="racda_expiracion" value="{{ old( 'racda_expiracion' ) ? old( 'racda_expiracion' ) : $about->racda_expiracion }}" placeholder="Expiración" {{$about->racda ? '' : 'disabled' }}>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group {{ $errors->has( 'solvencia_ss' ) ? 'has-error' : '' }}">
            <label class="control-label" for="solvencia_ss">Solvencia Seguro Social:</label>
            <input id="solvencia_ss" type="file" name="solvencia_ss" accept="application/pdf">
            <span class="help-block">Formato admitido: PDF</span>
          </div>
          <div class="form-group {{ $errors->has( 'solvencia_ss_expiracion' ) ? 'has-error' : '' }}">
            <label class="control-label" for="solvencia_ss_expiracion">Fecha de expiración:</label>
            <input id="solvencia_ss_expiracion" class="form-control" type="text" name="solvencia_ss_expiracion" value="{{ old( 'solvencia_ss_expiracion' ) ? old( 'solvencia_ss_expiracion' ) : $about->solvencia_ss_expiracion }}" placeholder="Expiración" {{$about->solvencia_ss ? '' : 'disabled' }}>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group {{ $errors->has( 'solvencia_ince' ) ? 'has-error' : '' }}">
            <label class="control-label" for="solvencia_ince">Solvencia Ince:</label>
            <input id="solvencia_ince" type="file" name="solvencia_ince" accept="application/pdf">
            <span class="help-block">Formato admitido: PDF</span>
          </div>
          <div class="form-group {{ $errors->has( 'solvencia_ince_expiracion' ) ? 'has-error' : '' }}">
            <label class="control-label" for="solvencia_ince_expiracion">Fecha de expiración:</label>
            <input id="solvencia_ince_expiracion" class="form-control" type="text" name="solvencia_ince_expiracion" value="{{ old( 'solvencia_ince_expiracion' ) ? old( 'solvencia_ince_expiracion' ) : $about->solvencia_ince_expiracion }}" placeholder="Expiración" {{$about->solvencia_ince ? '' : 'disabled' }}>
          </div>
        </div>

        <div class="col-md-12">
          @if (count($errors) > 0)
          <div class="alert alert-danger alert-important">
            <ul>
              @foreach($errors->all() as $error)
                 <li>{{ $error }}</li>
               @endforeach
            </ul>  
          </div>
          @endif
        </div>

        <div class="col-md-12 text-right">
          <a class="btn btn-flat btn-default" href="{{ route( 'about.index' ) }}"><i class="fa fa-reply"></i> Atras</a>
          <button class="btn btn-flat btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section( 'scripts' )
<script type="text/javascript">
  $(document).ready( function(){
    $('#rif_expiracion, #declaracion_jurada_expiracion, #registro_mercantil_expiracion, #patente_industria_expiracion, #racda_expiracion, #solvencia_ss_expiracion, #solvencia_ince_expiracion').datepicker({
      format: 'dd-mm-yyyy',
      startDate: 'today',
      language: 'es',
      keyboardNavigation: false,
      autoclose: true
    });

    //Asignar evento al cargar una imagen
    $('#rif, #declaracion_jurada, #registro_mercantil, #patente_industria, #racda, #solvencia_ss, #solvencia_ince').change(preview);
  });

  //Preview IMG
  function preview(){
    //Input
    var input = $(this),
        file  = this.files[0],
        id = input.attr('id') + '_expiracion';

    if(file.type === 'application/pdf'){
      $('#' + id).prop({'disabled':false, 'required':true});
    }else{
      input.val('');
      $('#' + id).prop({'disabled':true, 'required':false});
    }
  }//Preview-----------------------------------------------------------------------------------
</script>
@endsection