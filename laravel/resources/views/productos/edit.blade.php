@extends( 'layouts.app' )
@section( 'title', 'Productos - '.config('app.name') )
@section( 'header', 'Productos' )
@section( 'breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li><a href="{{ route( 'productos.index' ) }}" title="Productos"> Productos </a></li>
    <li class="active">Agregar</li>
  </ol>
@endsection
@section('content')
  <!-- Formulario -->
  <div class="row">
    <div class="col-md-12">
      <form class="" action="{{ route('productos.update', [ 'id' => $producto->id ] ) }}" method="POST" enctype="multipart/form-data">
        {{ method_field( 'PATCH' ) }}
        {{ csrf_field() }}

        <h4>Agregar Producto</h4>

        <fieldset class="col-md-12">
          <legend class="col-md-12">Información General</legend>
          
          <div class="col-md-6">
            <div class="form-group {{ $errors->has( 'categoria' ) ? 'has-error' : '' }}">
              <label class="control-label" for="categoria">Categoria: *</label>
              <select id="categoria" class="form-control" name="productos_categorias_id" required>
                <option value="">Seleccione...</option>
                @foreach($categorias as $categoria)
                  <option value="{{ $categoria->id }}" {{ old( 'productos_categorias_id' ) == $categoria->id ? 'selected' : $producto->productos_categorias_id == $categoria->id ? 'selected':'' }}>{{ $categoria->categoria }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group {{ $errors->has( 'nombre' ) ? 'has-error' : '' }}">
              <label class="control-label" for="nombre">Nombre: *</label>
              <input id="nombre" class="form-control" type="text" name="nombre" maxlength="100" value="{{ old( 'nombre' ) ? old( 'nombre' ) : $producto->nombre }}" placeholder="Nombre" required>
            </div>
          </div>
          
          <div class="col-md-12" style="padding: 0">
            <div class="col-md-6">
              <div class="form-group {{ $errors->has( 'imagen' ) ? 'has-error' : '' }}">
                <label class="control-label" for="imagen">Imagen: </label>
                <div class="imageUploadWidget">
                  <div class="imageArea">
                    <img class="upload-image" src="{{ asset( '/laravel/public/uploads/' . $producto->imagen ) }}" alt="{{ asset( '/laravel/public/uploads/' . $producto->imagen ) }}" previous="">
                    <img class="spinner-image" src="{{ asset('images/spinner.gif') }}">
                  </div>
                  <div class="btnArea">
                    <input id="imagen" type="file" name="imagen" accept="image/jpeg,image/png">
                    <span class="help-block">Formato admitido: JPEG, JPG, PNG </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group {{ $errors->has( 'etiqueta' ) ? 'has-error' : '' }}">
                <label class="control-label" for="etiqueta">Etiqueta: </label>
                <div class="imageUploadWidget">
                  <div class="imageArea">
                    <img class="upload-image" src="{{ asset( '/laravel/public/uploads/' . $producto->etiqueta ) }}" alt="{{ asset( '/laravel/public/uploads/' . $producto->etiqueta ) }}" previous="">
                    <img class="spinner-image" src="{{ asset('images/spinner.gif') }}">
                  </div>
                  <div class="btnArea">
                    <input id="etiqueta" type="file" name="etiqueta" accept="image/jpeg,image/png">
                    <span class="help-block">Formato admitido: JPEG, JPG, PNG </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group {{ $errors->has( 'descripcion' ) ? 'has-error' : '' }}">
              <label class="control-label" for="descripcion">Descipcion: *</label>
              <textarea id="descripcion" class="form-control" type="text" name="descripcion" maxlength="500" row="3" placeholder="Descripcion..." required>{{ old( 'descripcion' ) ? old( 'descripcion' ) : $producto->descripcion }}</textarea>
              <span class="help-block">Caracteres restantes: <span id="descripcion-counter">300</span></span>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group {{ $errors->has( 'indicaciones' ) ? 'has-error' : '' }}">
              <label class="control-label" for="indicaciones">Indicaciones: *</label>
              <textarea id="indicaciones" class="form-control" type="text" name="indicaciones" maxlength="500" row="3" placeholder="Indicaciones..." required>{{ old( 'indicaciones' ) ? old( 'indicaciones' ) : $producto->descripcion }}</textarea>
              <span class="help-block">Caracteres restantes: <span id="indicaciones-counter">300</span></span>
            </div>
          </div>

          <div class="col-md-12">
            <h4 class="text-center" style="margin-top: 20px">Códigos</h4>
          </div>
          
          <div class="col-md-12">
            <div class="col-md-3">
              <div class="form-group {{ $errors->has( 'codigo_barra' ) ? 'has-error' : '' }}">
                <label class="control-label" for="codigo_barra">Código de barra: *</label>
                <input id="codigo_barra" class="form-control" type="text" name="codigo_barra" maxlength="30" value="{{ old( 'codigo_barra' ) ? old( 'codigo_barra' ) : $producto->codigo_barra }}" placeholder="Código de barra" required>
              </div>

              <div class="form-group {{ $errors->has( 'codigo_barra_imagen' ) ? 'has-error' : '' }}">
                <input id="codigo_barra_imagen" type="file" name="codigo_barra_imagen" accept="image/jpeg,image/png">
                <span class="help-block">Formato admitido: JPEG, JPG, PNG</span>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group {{ $errors->has( 'codigo_producto' ) ? 'has-error' : '' }}">
                <label class="control-label" for="codigo_producto">Código de producto: *</label>
                <input id="codigo_producto" class="form-control" type="text" name="codigo_producto" maxlength="30" value="{{ old( 'codigo_producto' ) ? old( 'codigo_producto' ) : $producto->codigo_producto }}" placeholder="Código de producto" required>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <h4 class="text-center" style="margin-top: 20px">Hojas</h4>
          </div>

          <div class="col-md-6">
            <div class="form-group {{ $errors->has( 'hoja_tecnica_seguridad' ) ? 'has-error' : '' }}">
              <label class="control-label" for="hoja_tecnica_seguridad">Hoja ténica y de seguridad: </label>
              <input id="hoja_tecnica_seguridad" type="file" name="hoja_tecnica_seguridad" accept="application/pdf">
              <span class="help-block">Formato admitido: PDF</span>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group {{ $errors->has( 'permiso_sanitario' ) ? 'has-error' : '' }}">
              <label class="control-label" for="permiso_sanitario">Permsio sanitario: </label>
              <input id="permiso_sanitario" type="file" name="permiso_sanitario" accept="application/pdf">
              <span class="help-block">Formato admitido: PDF</span>
            </div>
          </div>

          <div class="col-md-12">
            <h4 class="text-center" style="margin-top: 20px">Producción</h4>
          </div>

          <div class="col-md-4">
            <div class="form-group {{ $errors->has( 'peso' ) ? 'has-error' : '' }}">
              <label class="control-label" for="peso">Peso: *</label>
              <input id="peso" class="form-control" type="number" min="0" max="999999" step="0.01" name="peso" placeholder="0.00" value="{{ old( 'peso' ) ? old( 'peso' ) : $producto->peso }}" required>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group {{ $errors->has( 'volumen' ) ? 'has-error' : '' }}">
              <label class="control-label" for="volumen">Volumen: *</label>
              <input id="volumen" class="form-control" type="number" min="0" max="999999" step="0.01" name="volumen" placeholder="0.00" value="{{ old( 'volumen' ) ? old( 'volumen' ) : $producto->volumen }}" required>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group {{ $errors->has( 'cantidad_paleta' ) ? 'has-error' : '' }}">
              <label class="control-label" for="cantidad_paleta">Cant. por paleta: *</label>
              <input id="cantidad_paleta" class="form-control" type="number" min="0" max="999999" step="1" name="cantidad_paleta" value="{{ old( 'cantidad_paleta' ) ? old( 'cantidad_paleta' ) : $producto->cantidad_paleta }}" placeholder="0" required>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group {{ $errors->has( 'subempaque' ) ? 'has-error' : '' }}">
              <label class="control-label" for="subempaque">Subempaque: *</label>
              <input id="subempaque" class="form-control" type="text" name="subempaque" maxlength="30" value="{{ old( 'subempaque' ) ? old( 'subempaque' ) : $producto->subempaque }}" placeholder="Subempaque" required>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group {{ $errors->has( 'empaque_master' ) ? 'has-error' : '' }}">
              <label class="control-label" for="empaque_master">Empaque master: *</label>
              <input id="empaque_master" class="form-control" type="text" name="empaque_master" maxlength="30" value="{{ old( 'empaque_master' ) ? old( 'empaque_master' ) : $producto->empaque_master }}" placeholder="Empaque master" required>
            </div>
          </div>

        </fieldset>

        <fielset class="col-md-12" style="margin-top: 20px">
          <legend>Permisología</legend>

          <div class="col-md-12">
            <h4 class="text-center" style="margin-top: 20px">Nacional</h4>
          </div>

          <div class="col-md-3">
            <div class="form-group {{ $errors->has( 'declaracion_jurada' ) ? 'has-error' : '' }}">
              <label class="control-label" for="declaracion_jurada">Declaración jurada: *</label>
              <input id="declaracion_jurada" type="file" name="declaracion_jurada" accept="application/pdf">
              <span class="help-block">Formato admitido: PDF</span>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group {{ $errors->has( 'cpe' ) ? 'has-error' : '' }}">
              <label class="control-label" for="cpe">CPE: *</label>
              <input id="cpe" type="file" name="cpe" accept="application/pdf">
              <span class="help-block">Formato admitido: PDF</span>
            </div>
            <div class="checkbox">
              <label>
                <input id="cpe_limit" type="checkbox" name="cpe_limit"  {{ $producto->cpe_expiracion ? 'checked' : ''}}> Plazo limitado
              </label>
            </div>
            <div class="form-group {{ $errors->has( 'cpe_expiracion' ) ? 'has-error' : '' }}" {!!$producto->cpe_expiracion ? '' : 'style="display: none"'!!}>
              <label class="control-label" for="cpe_expiracion">Fecha de expiración: *</label>
              <input id="cpe_expiracion" class="form-control" type="text" name="cpe_expiracion" value="{{ old( 'cpe_expiracion' ) ? old( 'cpe_expiracion' ) : $producto->cpe_expiracion }}" placeholder="Expiración" {{ $producto->cpe_expiracion ? '' : 'disabled'}}>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group {{ $errors->has( 'codigo_arancelario' ) ? 'has-error' : '' }}">
              <label class="control-label" for="codigo_arancelario">Código arancelario: *</label>
              <input id="codigo_arancelario" type="file" name="codigo_arancelario" accept="application/pdf">
              <span class="help-block">Formato admitido: PDF</span>
            </div>
          </div>
        </fielset>
        
        <div class="col-md-12">
          @if (count($errors) > 0)
            <div class="alert alert-danger alert-important">
              <ul>
                @foreach( $errors->all() as $error )
                  <li>{{ $error }}</li>
                @endforeach
              </ul>  
            </div>
          @endif
        </div>

        <div class="form-group text-right">
          <a class="btn btn-flat btn-default" href="{{ route( 'productos.index' ) }}"><i class="fa fa-reply"></i> Atras</a>
          <button class="btn btn-flat btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function(){
    $('#descripcion, #indicaciones').keyup(counter);

    //Asignar evento al cargar una imagen
    $('#imagen, #etiqueta').change(preview);

    $('#cpe_expiracion').datepicker({
      format: 'dd-mm-yyyy',
      startDate: 'today',
      language: 'es',
      keyboardNavigation: false,
      autoclose: true
    });

    $('#cpe_limit').on('click', function(){
      $('#cpe_expiracion').closest('.form-group').toggle(this.checked)
      $('#cpe_expiracion').prop({'required':this.checked, 'disabled':!this.checked})

      if(!this.checked){
        $('#cpe_expiracion').val('');
      }
      
    })
  });

  function counter(){
    input   = $(this);
    counter = $('#' + this.id + '-counter');
    count   = input.val().length;

    counter.text( 300 - count );
  }

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
    var error_span = $('<span class="help-block help-block-error"></span>');
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
      load.hide();
      error_span.text( error_message );
      group.append(error_span);
    }else{
      group.removeClass('has-error');
      group.find('.help-block.help-block-error').remove();
    }
  }//Preview-----------------------------------------------------------------------------------
</script>
@endsection