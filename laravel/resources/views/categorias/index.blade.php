@extends( 'layouts.app')
@section( 'title', 'Departamentos - '.config( 'app.name' ) )
@section( 'header', 'Departamentos' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li class="active"> Departamentos </li>
  </ol>
@endsection
@section( 'content' )
  @include( 'partials.flash' )
  <!-- Info boxes -->
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-building"></i></span>
        
        <div class="info-box-content">
          <span class="info-box-text">Departamentos</span>
          <span class="info-box-number">{{ count($departamentos) }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div><!--row-->

  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-building"></i> Departamentos</h3>
          <span class="pull-right">
            <a href="{{ route( 'departamentos.create' ) }}" class="btn btn-flat btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo departamento</a>
          </span>
        </div>
        <div class="box-body">
          <table class="table data-table table-bordered table-hover table-condensed">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Departamento</th>
                <th class="text-center">Cargos</th>
                <th class="text-center">Usuarios</th>
                <th class="text-center">Acción</th>
              </tr>
            </thead>
            <tbody class="text-center">
              @foreach( $departamentos as $d )
                <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $d->departamento }}</td>
                  <td>{{ $d->cargos()->count() }}</td>
                  <td>{{ $d->usuarios()->count() }}</td>
                  <td>
                    <a class="btn btn-primary btn-flat btn-sm" href="{{ route( 'departamentos.show', [ 'id' => $d->id ] )}}"><i class="fa fa-search"></i></a>
                    <a href="{{ route( 'departamentos.edit', [ 'id' => $d->id ] ) }}" class="btn btn-flat btn-success btn-sm" title="Editar"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
