@extends( 'layouts.app' )
@section( 'title', 'Sobre Dr.Care - '.config( 'app.name' ) )
@section( 'header','Sobre Dr.Care' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li><a href="{{ route( 'about.index' ) }}" title="Sobre Dr.Care"> Sobre Dr.Care </a></li>
    <li class="active">Representantes</li>
  </ol>
@endsection
@section('content')
  <!-- Formulario -->
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <form class="" action="{{ route('representantes.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        <h4>Representante legal</h4>
        <div class="col-md-12">
          <div class="form-group {{ $errors->has( 'cedula' ) ? 'has-error' : '' }}">
            <label class="control-label" for="cedula">Cedula: *</label>
            <div class="imageUploadWidget">
              <div class="imageArea">
                <img class="upload-image" src="" alt="" previous="">
                <img class="spinner-image" src="{{ asset('images/spinner.gif') }}">
              </div>
              <div class="btnArea">
                <input id="cedula" type="file" name="cedula" accept="image/jpeg,image/png" required>
                <span class="help-block">Formato admitido: JPEG, JPG, PNG </span>
              </div>
            </div>
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
    //Asignar evento al cargar una imagen
    $('#cedula').change(preview);
  });

  //Preview IMG
  function preview(){
    //Input
    var input = $(this);
    //El archivo
    var file  = this.files[0];
    //Tippo de archivo
    var type  = file.type;
    //Contar errores
    var error = 0;
    //container
    var group = input.closest('.form-group');
    //Imagen
    var img   = group.find('.upload-image');
    //Imagen anterior
    var prev  = img.attr('src');
    //Imagen loading
    var load = group.find('.spinner-image');
    //
    var error_span = $('<span class="help-block"></span>');
    //Guardar imagen anterior
    img.attr('previous', prev);
    //Ocultar imagen
    img.hide();
    //Mostar cargando
    load.show();
    if(file){
      if(file.size<2000000){
        if(type == "image/jpeg" || type == "image/png" || type == "image/jpg"){

          var reader = new FileReader();

          reader.onload = function (e) {
            img.attr('src', e.target.result);
            load.hide();
            img.show('slow');
          }

          reader.readAsDataURL(file);

        }else{
          error_message = 'Archivo no admitido.';
          error++;
        }
      }else{
        error_message = 'La imagen supera el tamaño permitido: 20MB.';
        error++;
      }
    }

    if(error>0){
      group.addClass('has-error');
      input.val('');
      group.append(error_span);
    }else{
      group.removeClass('has-error');
      group.find('.help-block').remove();
    }
  }//Preview-----------------------------------------------------------------------------------
</script>
@endsection