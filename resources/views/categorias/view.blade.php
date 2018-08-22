@extends( 'layouts.app' )
@section( 'title', 'Categoria - '.config( 'app.name' ) )
@section( 'header', 'Categoria' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li> Categorias </li>
    <li class="active">Ver </li>
  </ol>
@endsection
@section( 'content' )
  <section>
    <a class="btn btn-flat btn-default" href="{{ route( 'productos.index' ) }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
    <a class="btn btn-flat btn-success" href="{{ route( 'categorias.edit', [ 'id' => $categoria->id ] ) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
    <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
  </section>

  <section style="margin-top: 20px">
    <div class="row">

      <div class="col-md-3">
        <div class="box">
          <div class="box-body box-profile">
            <h3 class="profile-username text-center">{{ $categoria->categoria }}</h3>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Registrado </b> <span class="pull-right">{{ $categoria->created_at }}</span>
              </li>
              <li class="list-group-item">
                <b>Por</b>
                <span class="pull-right"><a href="{{ route('users.show', ['id' => $categoria->user->id]) }}"> {{ $categoria->user->nombre }} </a></span>
              </li>
            </ul>
          </div><!-- /.box-body -->
        </div>
      </div>

      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-cubes"></i> Productos</h3>
          </div>
          <div class="box-body">
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
                @foreach( $categoria->productos()->get() as $d )
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

    </div>
  </section>

  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="delModalLabel">Eliminar Categoria</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form class="col-md-8 col-md-offset-2" action="{{ route( 'categorias.destroy', [ $categoria->id ] ) }}" method="POST">
              {{ method_field( 'DELETE' ) }}
              {{ csrf_field() }}
              <h4 class="text-center">¿Esta seguro de eliminar esta Categoria?</h4><br>

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
@endsection