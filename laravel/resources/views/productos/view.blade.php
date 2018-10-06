@extends( 'layouts.app' )
@section( 'title', 'Producto - '.config( 'app.name' ) )
@section( 'header', 'Producto' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li> Productos </li>
    <li class="active">Ver </li>
  </ol>
@endsection
@section( 'content' )
  <section>
    <a class="btn btn-flat btn-default" href="{{ route( 'productos.index' ) }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>

    @if( Auth::user()->role == 'Admin' || Auth::user()->role == 'Operativo' )
    <a class="btn btn-flat btn-success" href="{{ route( 'productos.edit', [ 'id' => $producto->id ] ) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
    <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
    @endif
  </section>

  <section style="margin-top: 20px">
    <div class="row">

      <div class="col-md-3">
        <div class="box box-success">
          <div class="box-body box-profile">
            <h3 class="profile-username text-center">{{ $producto->nombre }}</h3>
            <p class="text-muted text-center">Imagen</p>

            <a title="Descargar documento" href="{{ route( 'get_file', ['producto' => $producto->id, 'file' => 'imagen']  ) }}">
              <img class="img-responsive pad" src="{{ asset( $producto->imagen ) }}" alt="{{ $producto->nombre }}" style="margin:0 auto; max-height:150px;">
            </a>
            

            <p class="text-muted text-center">Etiqueta</p>
            <a title="Descargar documento" href="{{ route( 'get_file', ['producto' => $producto->id, 'file' => 'etiqueta']  ) }}">
              <img class="img-responsive pad" src="{{ asset( 'storage/' . $producto->etiqueta ) }}" alt="{{ $producto->nombre }}" style="margin:0 auto; max-height:150px;">
            </a>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Registrado </b> <span class="pull-right">{{ $producto->created_at }}</span>
              </li>
              @if( Auth::user()->role == 'Admin' || Auth::user()->role == 'Operativo' )
              <li class="list-group-item">
                <b>Por</b>
                <span class="pull-right">
                  <a href="{{ route('users.show', ['id' => $producto->user->id]) }}">
                    {{ $producto->user->nombre }}
                  </a>
                </span>
              </li>
              @endif
              <li class="list-group-item">
                <b>Categoria </b> <span class="pull-right">{{ $producto->categoria->categoria }}</span>
              </li>
              <li class="list-group-item">
                <b>CPE</b>
                <span class="pull-right"> {{ $producto->cpe }} </span>
              </li>
              <li class="list-group-item">
                <b>Código de producto</b>
                <span class="pull-right"> {{ $producto->codigo_producto }} </span>
              </li>
              <li class="list-group-item">
                <b>Código de barra</b>
                <span class="pull-right"> {{ $producto->codigo_barra }} </span>
              </li>
              <li class="list-group-item">
                <b>Código arancelario</b>
                <span class="pull-right"> {{ $producto->codigo_arancelario }} </span>
              </li>
              <li class="list-group-item">
                <b>Peso</b>
                <span class="pull-right"> {{ $producto->peso }} </span>
              </li>
              <li class="list-group-item">
                <b>Volumen</b>
                <span class="pull-right"> {{ $producto->volumen }} </span>
              </li>
              <li class="list-group-item">
                <b>Subempaque</b>
                <span class="pull-right"> {{ $producto->subempaque }} </span>
              </li>
              <li class="list-group-item">
                <b>Empaque Master</b>
                <span class="pull-right"> {{ $producto->empaque_master }} </span>
              </li>
              <li class="list-group-item">
                <b>Cantidad por paleta</b>
                <span class="pull-right"> {{ $producto->cantidad_paleta }} </span>
              </li>
            </ul>
          </div><!-- /.box-body -->
        </div>
      </div>

      <div class="col-md-9" style="padding: 0">
        <div class="col-md-12" style="padding: 0">
          <div class="col-md-6">
            <h4 class="text-center" style="margin-top: 0">Descipción</h4>
            <blockquote>
              <p>{{ $producto->descripcion }}</p>
            </blockquote>
          </div>
          <div class="col-md-6">
            <h4 class="text-center" style="margin-top: 0">Indicaciones</h4>
            <blockquote>
              <p>{{ $producto->indicaciones }}</p>
            </blockquote>
          </div>
        </div>
        <div class="col-md-4">
          <h4 class="text-center" style="margin-top: 0">Hoja técnica y de seguridad</h4>
          <div class="info-box">
            <a title="Ver documento" href="{{ asset( 'storage/' . $producto->hoja_tecnica_seguridad ) }}" target="_blank">
              <div class="info-box-icon bg-red">
                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>    
              </div>
            </a>
            <div class="info-box-content">
              <a title="Descargar documento" href="{{ route( 'get_file', ['producto' => $producto->id, 'file' => 'hoja_tecnica_seguridad']  ) }}">
                Descargar <i class="fa fa-download" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <h4 class="text-center" style="margin-top: 0">Permiso sanitario</h4>
          <div class="info-box">
            <a title="Ver documento" href="{{ url( 'storage/' . $producto->permiso_sanitario ) }}" target="_blank">
              <div class="info-box-icon bg-red">
                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>    
              </div>
            </a>
            <div class="info-box-content">
              <a title="Descargar documento" href="{{ route( 'get_file', ['producto' => $producto->id, 'file' => 'permiso_sanitario']  ) }}">
                Descargar <i class="fa fa-download" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <h4 class="text-center" style="margin-top: 0">Declaración jurada</h4>
          <div class="info-box">
            <a title="Ver documento" href="{{ url( 'storage/' . $producto->declaracion_jurada ) }}" target="_blank">
              <div class="info-box-icon bg-red">
                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>    
              </div>
            </a>
            <div class="info-box-content">
              <a title="Descargar documento" href="{{ route( 'get_file', ['producto' => $producto->id, 'file' => 'declaracion_jurada']  ) }}">
                Descargar <i class="fa fa-download" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
        
        @if( Auth::user()->role == 'Admin' || Auth::user()->role == 'Operativo' )
        <div class="col-md-12" style="padding:0">
          <h4 class="text-center">Imagenes / Artes</h4>
          <div class="col-md-12">
            <form id="form-add-files" action="{{ route( 'artes.store', ['id' => $producto->id] ) }}" method="POST">
              <input id="dropzone-input" type="file" accept="image/jpeg,image/png,application/postscript,application/pdf" name="files[]" multiple style="display:none">
              {{ csrf_field() }}

              <div class="dropzone text-center">
                <div class="dropzone-no-uploads">
                  <div class="dropzone-drag">
                    <h2>
                      Arrastrar y soltar archivos aqui
                    </h2>
                    <p>O</p>
                  </div>

                  <button id="btn-select-files" class="btn btn-flat btn-default" type="button"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Seleccione archivos</button>
                  <span class="help-block">Formato admitido: JPEG, JPG, PNG, PDF, AI </span>
                </div>
                
                <div class="row dropzone-thumbs-container">
                </div><!--dropzone-thumbs-container-->

              </div>
            </form>
          </div>
        </div>

        <div class="col-md-6 col-md-offset-3" style="margin-top: 30px; display:none">
          <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong class="text-center">Ha ocurrido un error al intentar eliminar el archivo.</strong> 
          </div>
        </div>
        @endif

        <div id="product-gallery" class="col-md-12" style="padding:0;margin-top:30px">
          @foreach( $producto->artes()->get() as $arte )
            {!! $arte->generateThumb() !!}
          @endforeach
        </div>

      </div><!-- col-md-8 -->
    </div><!-- row -->
  </section>

  @if( Auth::user()->role == 'Admin' || Auth::user()->role == 'Operativo' )
  <div id="delFileModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delFileModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="delFileModalLabel">Eliminar archivo</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form id="delelte-file-form" class="col-md-8 col-md-offset-2" action="#" method="POST">
              {{ method_field( 'DELETE' ) }}
              {{ csrf_field() }}
              <h4 class="text-center">¿Esta seguro de eliminar este Producto?</h4><br>

              <center>
                <button class="btn btn-flat btn-danger" type="submit">Eliminar</button>
                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Cerrar</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="delModalLabel">Eliminar Producto</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form class="col-md-8 col-md-offset-2" action="{{ route( 'productos.destroy', [ $producto->id ] ) }}" method="POST">
              {{ method_field( 'DELETE' ) }}
              {{ csrf_field() }}
              <h4 class="text-center">¿Esta seguro de eliminar este Producto?</h4><br>

              <center>
                <button class="btn btn-flat btn-danger" type="submit">Eliminar</button>
                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Cerrar</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

@endsection

@section( 'scripts' )
<script type="text/javascript">
  @if( Auth::user()->role == 'Admin' || Auth::user()->role == 'Operativo' )
  var $form = $('#form-add-files'),
      $photos = $form.find('#dropzone-input'),
      $dropzone = $form.find('.dropzone'),
      uploadFilesList = null,
      illustratorIcon = '{{ asset("images/illustrator_icon.png") }}',
      pdfIcon = '{{ asset("images/pdf_icon.png") }}',
      uploading   = false;

    //Create preview image thumbs markup in dropzone
    var thumbs =  function(id, thumb){
        return  '<div class="col-md-3 col-sm-3 col-xs-6" style="margin-bottom:5px">'+
                '<div id="thumb-'+id+'" class="dropzone-thumbs thumb-uploading">'+
                '<img class="img-responsive" src="'+thumb+'">'+
                '<div class="dropzone-thumbs-progress">'+
                '<div class="progress">'+
                '<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">'+
                '<span class="progress-loaded"></span>'+
                '</div></div></div></div></div>';
      };

    //Create image thumbs markup in gallery
    var gallery = function(file, icon, download){

        return  '<div id="file-' + file.id + '" class="col-md-3 col-xs-12" style="margin-bottom: 5px"><div class="gallery-item">'+
                '<button type="button" title="Remove photo" data-file="' + file.id + '" class="btn btn-flat btn-danger btn-remove-gallery" data-action="remove_photo" data-toggle="modal" data-target="#delFileModal"><i class="fa fa-times"></i></button>'+
                '<a href="' + download + '">'+
                '<img class="img-responsive" src="' + icon + '" alt="' + icon + '">'+
                '</a>'+
                '</div>'+
                '<p class="text-center"><small>'+ file.nombre +'</small></p>'+
                '</div>';
      };

    //Check if browser support Drag and Drop uploads
    var isAdvancedUpload = function() {
      var div = document.createElement('div');
      return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
    }();

    $(document).ready(function(){

      $('#btn-select-files').click(function(){
        $('#dropzone-input').click();
      });

      //Photos upload by input
      $photos.change(function(){
        uploadFilesList = this.files;
        preview();
      });

      //Check if browser support Drag and Drop
      if (isAdvancedUpload) {
        $dropzone.addClass('has-advanced-upload');

        $form.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
          e.preventDefault();
          e.stopPropagation();
        })
        .on('dragover dragenter', function() {
          $dropzone.addClass('is-dragover');
        })
        .on('dragleave dragend drop', function() {
          $dropzone.removeClass('is-dragover');
        })
        .on('drop', function(e) {
          uploadFilesList = e.originalEvent.dataTransfer.files;
          preview();
        });
      }else{

      }// IsAdvancedUpload

      $('#delFileModal').on('show.bs.modal', function(e){
        var button = $(e.relatedTarget),
            file   = button.data('file'),
            alert  = $('.alert'),
            action = '{{ route("artes.index") }}/' + file;

        $('#delelte-file-form').attr('action', action);
      });

      $('#delelte-file-form').submit(deleteFile);

    });// Ready

    function deleteFile(e){
      e.preventDefault();

      var form = $(this),
          action = form.attr('action');

      $.ajax({
        type: 'POST',
        url: action,
        data: form.serialize(),
        dataType: 'json',
      }).
      done(function(r){
        if(r.response){
          $('#file-' + r.id).remove();
          $('#delFileModal').modal('hide');
        }else{
          $('.alert').show().delay(7000).hide('slow');
        }
      })
      .fail(function(){
          $('.alert').show().delay(7000).hide('slow');
      })
    }

    function uploadSingleFile(file, i){
      // ajax for modern browserss
      var photoThumb = $dropzone.find('.thumb-uploading').first(),
          next = ( i + 1),
          formData = new FormData();

      formData.append('_token', '{{ csrf_token() }}');
      formData.append('file', file);

      $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        // Custom XMLHttpRequest
        xhr: function() {
          var myXhr = $.ajaxSettings.xhr();
          if (myXhr.upload) {
            // For handling the progress of the upload
            myXhr.upload.addEventListener('progress', function(e){
              loaded = ( ( 100 * e.loaded ) / e.total ).toFixed(0);

              if(e.lengthComputable){
                photoThumb.find('.progress-bar')
                  .attr({
                    'aria-valuenow': loaded,
                    style: 'width:'+loaded+'%;'
                  });

                photoThumb.find('.progress-loaded').text(loaded+'%');

                if(e.loaded === e.total){
                  photoThumb.find('.progress-bar').removeClass('progress-bar-striped active').addClass('progress-bar-success');
                  photoThumb.find('.progress-loaded').text('Procesing...');
                }
              }
            }, false);
            //Error Listener
            myXhr.addEventListener('error', function (e) {
              photoThumb.addClass('thumb-error');
              photoThumb.find('.progress-bar').removeClass('progress-bar-striped active').addClass('progress-bar-danger');
              photoThumb.find('.progress-loaded').text('Error');
            }, false);
          }
          return myXhr;
        },
        success: function(r) {
          if(r.response){

            photoThumb.parent().remove();

            var icon = r.file.mime == 'application/postscript' ? illustratorIcon : r.file.mime == 'application/pdf' ? pdfIcon : '{{ url("/") }}/storage/' + r.file.path ;

            thumb_img = gallery(r.file, icon, r.download);
            $('#product-gallery').append(thumb_img);
          }else{
            photoThumb.addClass('thumb-error');
            photoThumb.find('.progress-bar').removeClass('progress-bar-striped active').addClass('progress-bar-danger');
            photoThumb.find('.progress-loaded').text('Error');
          }
        },
        error: function() {
          photoThumb.addClass('thumb-error');
          photoThumb.find('.progress-bar').removeClass('progress-bar-striped active').addClass('progress-bar-danger');
          photoThumb.find('.progress-loaded').text('Error');
        },
        complete: function() {
          photoThumb.removeClass('thumb-uploading');
          uploading = false;
          uploadFiles(next);
        }
      });
    }//uploadSingleFile

    function uploadFiles(i = 0){

      if(!uploadFilesList[i] || uploading) return false;

      uploading = true;

      uploadSingleFile(uploadFilesList[i], i);
    }//uploadPhotos

    //Preview files when uploaded or Droped
    function preview(){
      var thumbsCount = checkPreviewCount();

      $.each(uploadFilesList, function(i, file){
        //Tippo de archivo
        var type  = file.type;

        if(file){
          if(file.size < 30000000){

            mime = $.inArray( type, ['image/jpeg', 'image/png', 'image/jpg', 'application/postscript', 'application/pdf'] );

            if( mime !== -1 ){
              nextCount = ( thumbsCount + ( i + 1 ) );
              if( mime >= 0 && mime < 3 ){
                var reader = new FileReader();
                reader.onload = function (e) {
                  var thumb = thumbs(nextCount, e.target.result);
                  $('.dropzone-thumbs-container').append(thumb);
                  uploadFiles();
                }
                reader.readAsDataURL(file);
              }else{
                var icon = mime === 3 ? illustratorIcon : pdfIcon;

                var thumb = thumbs(nextCount, icon);
                $('.dropzone-thumbs-container').append(thumb);
                uploadFiles();
              }
            }
          }
        }
      })//EACH
    }//Preview-----------------------------------------------------------------------------------

    //Check if there's any file uploaded in Dropzone
    function checkPreviewCount(){
      return $('.dropzone-thumbs-container .dropzone-thumbs').length;
    }
    @endif
  </script>
@endsection