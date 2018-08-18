@extends( 'layouts.app' )
@section( 'title','Inicio - '.config( 'app.name' ) )
@section( 'header','Inicio' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li class="active"><i class="fa fa-home" aria-hidden="true"></i> Inicio</li>
  </ol>
@endsection

@section( 'content' )
  <div class="row">
    @if( Auth::user()->role === 'Admin' )
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-user-plus"></i></span>
        
        <div class="info-box-content">
          <span class="info-box-text">Solicitudes</span>
          <span class="info-box-number">{{ count( $notUsers ) }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    @endif
  </div>

  <div class="row">

    @if( Auth::user()->role === 'Admin' )
    <div class="col-md-12">
      <div id="solicitudes" class="col-md-12">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-users"></i> Solicitudes de ingreso</h3>
          </div>
          <div class="box-body">
            <table class="table data-table table-bordered table-hover">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Cedula</th>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Departamento</th>
                  <th class="text-center">Cargo</th>
                  <th class="text-center">Accion</th>
                </tr>
              </thead>
              <tbody class="text-center">
                @foreach( $notUsers as $d )
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $d->cedula() }}</td>
                    <td>{{ $d->nombre }}</td>
                    <td>{{ $d->departamento->departamento }}</td>
                    <td>{{ $d->cargo->cargo }}</td>
                    <td>
                      <a class="btn btn-primary btn-flat btn-sm" href="{{ route( 'users.show', [ 'id' => $d->id ] )}}"><i class="fa fa-search"></i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    @endif
    
  </div>
@endsection
