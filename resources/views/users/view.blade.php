@extends( 'layouts.app' )
@section( 'title', 'Usuario - '.config( 'app.name' ) )
@section( 'header', 'Usuario' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li> Usuarios </li>
    <li class="active">Ver </li>
  </ol>
@endsection
@section( 'content' )
  <section>
    <a class="btn btn-flat btn-default" href="{{ route( 'users.index' ) }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
    <a class="btn btn-flat btn-success" href="{{ route( 'users.edit', [ 'id' => $user->id ] ) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
    
    @if( Auth::user()->id != $user->id )
    <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
    @endif
  </section>

  <section style="margin-top: 20px">
    <div class="row">
      
      <div class="col-md-3">
        <div class="box box-danger">
          <div class="box-body box-profile">
            <h3 class="profile-username text-center">{{ $user->nombre }}</h3>
            <p class="text-muted text-center">{{ $user->role }}</p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Registrado </b> <span class="pull-right">{{ $user->created_at }}</span>
              </li>
              <li class="list-group-item">
                <b>Departamento</b>
                <span class="pull-right"> {{ $user->departamento->departamento }} </span>
              </li>
              <li class="list-group-item">
                <b>Cargo</b>
                <span class="pull-right"> {{ $user->cargo->cargo }} </span>
              </li>
              <li class="list-group-item">
                <b>Cedula</b>
                <span class="pull-right"> {!! $user->cedula() !!} </span>
              </li>
              <li class="list-group-item">
                <b>Status</b>
                <span class="pull-right"> {!! $user->status() !!} </span>
              </li>
            </ul>
          </div><!-- /.box-body -->
        </div>
      </div>
    
    </div>
  </section>

  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="delModalLabel">Eliminar usuario</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form class="col-md-8 col-md-offset-2" action="{{ route('users.destroy',[$user->id])}}" method="POST">
              {{ method_field( 'DELETE' ) }}
              {{ csrf_field() }}
              <h4 class="text-center">¿Esta seguro de eliminar este usuario?</h4><br>

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