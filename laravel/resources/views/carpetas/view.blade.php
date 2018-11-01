@extends( 'layouts.app' )
@section( 'title', 'Producto - '.config( 'app.name' ) )
@section( 'header', 'Producto > ' . $carpeta->carpeta )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li><a href="{{ route('productos.show', ['id'=>$carpeta->producto_id]) }}"> Producto </a></li>
    <li class="active"> {{ $carpeta->carpeta }} </li>
  </ol>
@endsection
@section( 'content' )
  <section>
    <a class="btn btn-flat btn-default" href="{{ route( 'productos.show', ['id' => $carpeta->producto_id] ) }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>

    @if( Auth::user()->role == 'Admin')
    <a class="btn btn-flat btn-success" href="{{ route( 'carpetas.edit', [ 'id' => $carpeta->id ] ) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
    <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
    @endif
  </section>

  <section style="margin-top: 20px">
    <div class="row">

      <div class="col-md-3">
        @include(' partials.productosInfo ')
      </div>

      <div class="col-md-9" style="padding: 0">
        @include('partials.flash')

        @if( Auth::user()->role == 'Admin')
        <div class="col-md-12" style="padding:0">
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
          @forelse( $carpeta->artes()->get() as $arte )
            {!! $arte->generateThumb() !!}
          @empty
            <h4 class="text-center text-muted">No se encontraron registros.</h4>
          @endforelse
        </div>

      </div><!-- col-md-8 -->
    </div><!-- row -->
  </section>

  @if( Auth::user()->role == 'Admin')
  <div id="delFileModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delFileModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="delFileModalLabel">Eliminar archivo</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form id="delete-file-form" class="col-md-8 col-md-offset-2" action="#" method="POST">
              {{ method_field( 'DELETE' ) }}
              {{ csrf_field() }}
              <h4 class="text-center">¿Esta seguro de eliminar este archivo?</h4><br>

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
          <h4 class="modal-title" id="delModalLabel">Eliminar Carpeta</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form class="col-md-8 col-md-offset-2" action="{{ route( 'carpetas.destroy', [ $carpeta->id ] ) }}" method="POST">
              {{ method_field( 'DELETE' ) }}
              {{ csrf_field() }}
              <h4 class="text-center">¿Esta seguro de eliminar esta Carpeta y su contenido?</h4><br>

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
  @if( Auth::user()->role == 'Admin')
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
                '<p class="text-center" style="word-wrap: break-word"><small>'+ file.nombre +'</small></p>'+
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

        $('#delete-file-form').attr('action', action);
      });

      $('#delete-file-form').submit(deleteFile);

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
      formData.append('carpeta_id', '{{$carpeta->id}}');

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

            var icon = r.file.mime == 'application/postscript' ? illustratorIcon : r.file.mime == 'application/pdf' ? pdfIcon : '{{ url("/") }}/laravel/public/uploads/' + r.file.path ;

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