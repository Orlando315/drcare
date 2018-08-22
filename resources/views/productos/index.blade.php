@extends( 'layouts.app')
@section( 'title', 'Productos - '.config( 'app.name' ) )
@section( 'header', 'Productos' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li class="active"> Productos </li>
  </ol>
@endsection
@section( 'content' )
  @include( 'partials.flash' )
  <!-- Info boxes -->
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-cubes"></i></span>
        
        <div class="info-box-content">
          <span class="info-box-text">Productos</span>
          <span class="info-box-number">{{ count($productos) }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon"><i class="fa fa-file-text-o"></i></span>
        
        <div class="info-box-content">
          <span class="info-box-text">Categorias</span>
          <span class="info-box-number">{{ count($categorias) }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div><!--row-->

  <div class="row">

    <div class="col-md-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active tab-success"><a href="#productos_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"> </i>Productos</a></li>
          <li class="tab-default"><a href="#categorias_tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-file-text-o" aria-hidden="true"></i> Categorias</a></li>
        </ul>

        <div class="tab-content">

          <div class="tab-pane active" id="productos_tab">
            <div class="row">
              <div class="col-md-12">
                <span class="pull-right" style="margin-bottom: 10px">
                  <a href="{{ route( 'productos.create' ) }}" class="btn btn-flat btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo producto</a>
                </span>  
              </div>
              
              <div class="col-md-12">
                <table class="table table-products table-bordered table-hover" style="width: 100%">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th class="text-center">Categoria</th>
                      <th class="text-center">Nombre</th>
                      <th class="text-center">CPE</th>
                      <th class="text-center">Codigo de Barra</th>
                      <th class="text-center">Codigo de Producto</th>
                      <th class="text-center">Accion</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    @foreach( $productos as $d )
                      <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $d->categoria->categoria }}</td>
                        <td>{{ $d->nombre }}</td>
                        <td>{{ $d->cpe }}</td>
                        <td>{{ $d->codigo_barra }}</td>
                        <td>{{ $d->codigo_producto }}</td>
                        <td>
                          <a class="btn btn-primary btn-flat btn-sm" href="{{ route( 'productos.show', [ 'id' => $d->id ] )}}"><i class="fa fa-search"></i></a>
                          <a href="{{ route( 'productos.edit', [ 'id' => $d->id ] ) }}" class="btn btn-flat btn-success btn-sm" title="Editar"><i class="fa fa-edit"></i></a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div id="categorias_tab" class="tab-pane">
            <div class="row">
              <div class="col-md-12">
                <span class="pull-right" style="margin-bottom: 10px">
                  <a href="{{ route( 'categorias.create' ) }}" class="btn btn-flat btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nueva categoria</a>
                </span>
              </div>

              <div class="col-md-12">
                <table class="table data-table table-bordered table-hover" style="width: 100%">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th class="text-center">Categoria</th>
                      <th class="text-center">Productos</th>
                      <th class="text-center">Accion</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    @foreach( $categorias as $d )
                      <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $d->categoria }}</td>
                        <td>{{ $d->productos->count() }}</td>
                        <td>
                          <a class="btn btn-primary btn-flat btn-sm" href="{{ route( 'categorias.show', [ 'id' => $d->id ] )}}"><i class="fa fa-search"></i></a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div><!-- row -->
          
          </div><!-- .tab-pane -->

        </div><!-- tab_content -->
      </div><!-- nav-tab-custom -->

    </div><!-- col-12 -->
  </div><!-- row -->
@endsection
