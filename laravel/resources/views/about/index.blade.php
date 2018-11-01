@extends( 'layouts.app' )
@section( 'title', 'Sobre Dr.Care - '.config( 'app.name' ) )
@section( 'header', 'Sobre Dr.Care' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li class="active"> Sobre Dr.Care</li>
  </ol>
@endsection
@section( 'content' )

  <div class="row">
    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
      <div class="box box-solid">
        <div class="box-body">
          <h3 class="text-center">
            Misión
          </h3>
          <p>
            Ser líderes en el mercado de productos, bienes y servicios automotrices, con la excelencia que añade valor a la inversión, brinda confort y seguridad al usuario y protege el medio ambiente.
          </p>
        </div>
      </div>
    </div>
    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
      <div class="box box-solid">
        <div class="box-body">
          <h3 class="text-center">
            Visión
          </h3>
          <p>
            Queremos generar bienestar y confort a los usuarios de nuestros productos y servicios. Comprometidos con nuestros trabajadores, clientes, proveedores, medio ambiente y sobre todo, con el desarrollo del país, generando dividendos a socios, accionistas, clientes, trabajadores y relacionados. Más que un listado de productos, ofrecemos un paquete comercial generador de beneficios para la cadena de comercialización.
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12" style="padding: 0">
      <div class="col-md-12">
        <h3 class="text-center">
          Representantes legales
          @if( Auth::user()->role == 'Admin')
          <span class="pull-right">
            <a class="btn btn-flat btn-primary btn-sm" href="{{ route( 'representantes.create' ) }}"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</a>
          </span>
          @endif
        </h3>
      </div>

      <div class="col-md-12">
        @forelse($representantes as $representante)
          {!! $representante->generateThumb() !!}
        @empty
          <h4 class="text-center text-muted">No se encontraron registros.</h4>
        @endforelse
      </div>

      <div class="col-md-12">
        <h3 class="text-center">
          Documentos
          @if( Auth::user()->role == 'Admin')
          <span class="pull-right">
            <a class="btn btn-flat btn-success btn-sm" href="{{ route( 'about.edit', [ 'id' => $about->id ] ) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
          </span>
          @endif
        </h3>
      </div>

      @if( Auth::user()->role == 'Admin')
      <div class="col-md-12">
        <p><b>Email de notificación:</b> {{ $about->email }}</p>
      </div>
      @endif
      
      <div class="col-md-4">
        <h4 class="text-center" style="margin-top: 0">RIF</h4>
        <div class="info-box">
          <a title="Ver documento" href="{{ $about->rif ? url( 'laravel/public/uploads/' . $about->rif ) : '#' }}" target="_blank">
            <div class="info-box-icon {{$about->rif ? 'bg-red' : ''}}">
              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>    
            </div>
          </a>
          <div class="info-box-content">
            @if($about->rif)
              <a title="Descargar documento" href="{{ route( 'about.getFile', ['file' => 'rif'] ) }}">
                Descargar <i class="fa fa-download" aria-hidden="true"></i>
              </a>
              <p><b>Vencimiento:</b> {{$about->rif_expiracion}}</p>
            @else
              <p class="text-muted">No asignado</p>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <h4 class="text-center" style="margin-top: 0">Registro Mercantil</h4>
        <div class="info-box">
          <a title="Ver documento" href="{{ $about->registro_mercantil ? url( 'laravel/public/uploads/' . $about->registro_mercantil ) : '#' }}" {{ $about->registro_mercantil ? 'target="_blank"' : '' }}>
            <div class="info-box-icon {{$about->registro_mercantil ? 'bg-red' : ''}}">
              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>    
            </div>
          </a>
          <div class="info-box-content">
            @if($about->registro_mercantil)
              <a title="Descargar documento" href="{{ route( 'about.getFile', ['file' => 'registro_mercantil'] ) }}">
                Descargar <i class="fa fa-download" aria-hidden="true"></i>
              </a>
              <p><b>Vencimiento:</b> {{$about->registro_mercantil_expiracion}}</p>
            @else
              <p class="text-muted">No asignado</p>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <h4 class="text-center" style="margin-top: 0">Patente de Industria</h4>
        <div class="info-box">
          <a title="Ver documento" href="{{ $about->patente_industria ? url( 'laravel/public/uploads/' . $about->patente_industria ) : '#' }}" {{ $about->patente_industria ? 'target="_blank"' : '' }}>
            <div class="info-box-icon {{$about->patente_industria ? 'bg-red' : ''}}">
              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>    
            </div>
          </a>
          <div class="info-box-content">
            @if($about->patente_industria)
              <a title="Descargar documento" href="{{ route( 'about.getFile', ['file' => 'patente_industria'] ) }}">
                Descargar <i class="fa fa-download" aria-hidden="true"></i>
              </a>
              <p><b>Vencimiento:</b> {{$about->patente_industria_expiracion }}</p>
            @else
              <p class="text-muted">No asignado</p>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <h4 class="text-center" style="margin-top: 0">Racda</h4>
        <div class="info-box">
          <a title="Ver documento" href="{{ $about->racda ? url( 'laravel/public/uploads/' . $about->racda ) : '#' }}" {{ $about->racda ? 'target="_blank"' : '' }}>
            <div class="info-box-icon {{$about->racda ? 'bg-red' : ''}}">
              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>    
            </div>
          </a>
          <div class="info-box-content">
            @if($about->racda)
              <a title="Descargar documento" href="{{ route( 'about.getFile', ['file' => 'racda'] ) }}">
                Descargar <i class="fa fa-download" aria-hidden="true"></i>
              </a>
              <p><b>Vencimiento:</b> {{$about->racda_expiracion}}</p>
            @else
              <p class="text-muted">No asignado</p>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <h4 class="text-center" style="margin-top: 0">Solvencia Seguro Social</h4>
        <div class="info-box">
          <a title="Ver documento" href="{{ $about->solvencia_ss ? url( 'laravel/public/uploads/' . $about->solvencia_ss ) : '#' }}" {{ $about->solvencia_ss ? 'target="_blank"' : '' }}>
            <div class="info-box-icon {{$about->solvencia_ss ? 'bg-red' : ''}}">
              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>    
            </div>
          </a>
          <div class="info-box-content">
            @if($about->solvencia_ss)
              <a title="Descargar documento" href="{{ route( 'about.getFile', ['file' => 'solvencia_ss'] ) }}">
                Descargar <i class="fa fa-download" aria-hidden="true"></i>
              </a>
              <p><b>Vencimiento:</b> {{$about->solvencia_ss_expiracion}}</p>
            @else
              <p class="text-muted">No asignado</p>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <h4 class="text-center" style="margin-top: 0">Solvencia Ince</h4>
        <div class="info-box">
          <a title="Ver documento" href="{{ $about->solvencia_ince ? url( 'laravel/public/uploads/' . $about->solvencia_ince ) : '#' }}" {{ $about->solvencia_ince ? 'target="_blank"' : '' }}>
            <div class="info-box-icon {{$about->solvencia_ince ? 'bg-red' : ''}}">
              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>    
            </div>
          </a>
          <div class="info-box-content">
            @if($about->solvencia_ince)
              <a title="Descargar documento" href="{{ route( 'about.getFile', ['file' => 'solvencia_ince'] ) }}">
                Descargar <i class="fa fa-download" aria-hidden="true"></i>
              </a>
              <p><b>Vencimiento:</b> {{$about->solvencia_ince_expiracion}}</p>
            @else
              <p class="text-muted">No asignado</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>


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
              <h4 class="text-center">¿Esta seguro de eliminar este representante?</h4><br>

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

@section('scripts')
  @if( Auth::user()->role == 'Admin')
 <script type="text/javascript">
   $(document).ready(function(){
    $('#delFileModal').on('show.bs.modal', function(e){
      var button = $(e.relatedTarget),
          file   = button.data('file'),
          action = '{{ route("representantes.index") }}/' + file;

      console.log(action);

      $('#delete-file-form').attr('action', action);
    });
   })
 </script>
 @endif
@endsection