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
    
    @if( $user->status != 'Rechazado' )
    <a class="btn btn-flat btn-success" href="{{ route( 'users.edit', [ 'id' => $user->id ] ) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
    @endif

    @if( $user->status == 'Activo' || $user->status == 'Inactivo' )
    <button class="btn btn-flat btn-primary" data-toggle="modal" data-target="#passModal"><i class="fa fa-lock" aria-hidden="true"></i> Cambiar contraseña</button>
    @endif
    
    @if( Auth::user()->id != $user->id )
      @if( $user->status == 'Activo' )
      <button id="btn-activar" class="btn btn-flat btn-poison" data-toggle="modal" data-target="#activarModal" data-status="Inactivo"><i class="fa fa-close" aria-hidden="true"></i> Inactivar usuario</button>
      @endif

      @if( $user->status == 'Inactivo' )
      <button id="btn-activar" class="btn btn-flat btn-poison" data-toggle="modal" data-target="#activarModal" data-status="Activo"><i class="fa fa-check" aria-hidden="true"></i> Activar usuario</button>
      @endif

      <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
    @endif
  </section>

  <section style="margin-top: 20px">
    @include( 'partials.flash' )

    <div class="row">
      
      <div class="col-md-3 col-sm-12">
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
      
      @if( $user->status != 'Procesando' )
      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-header with-border">
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
                @foreach( $user->productos()->get() as $d )
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $d->categoria->categoria }}</td>
                    <td>{{ $d->nombre }}</td>
                    <td>{{ $d->cpe }}</td>
                    <td>{{ $d->codigo_barra }}</td>
                    <td>{{ $d->codigo_producto }}</td>
                    <td>
                      <a class="btn btn-primary btn-flat btn-sm" href="{{ route( 'productos.show', [ 'id' => $d->id ] )}}"><i class="fa fa-search"></i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endif
      
      @if( $user->status == 'Procesando' )
      <div class="col-md-8 col-sm-12">
        <h2 class="text-center">¿Desea aceptar o rechazar la petición de acceso?</h2>
        <form id="form-access" action="{{ route( 'users.change_status', ['id' => $user->id] ) }}" method="POST">
          <input id="input-access" type="hidden" name="status" value="">
          {{ method_field( 'PATCH' ) }}
          {{ csrf_field() }}

          <center>
            <button class="btn btn-flat btn-access btn-success" type="button" data-status="Activo"><i class="fa fa-check" aria-hidden="true"></i> Aceptar</button>
            <button class="btn btn-flat btn-access btn-danger" type="button" data-status="Rechazado"><i class="fa fa-user-times" aria-hidden="true"></i> Rechazar</button>
          </center>
        </form>

      </div>
      @endif
    
    </div>
  </section>

  @if( $user->status == 'Activo' || $user->status == 'Inactivo' )
  <div id="activarModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="activarModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Cambiar Status</h4>
        </div>
        <div class="modal-body">
          <form id="activar-user" action="{{ route( 'users.change_status', ['id' => $user->id] ) }}" method="post">
            <input id="status-value" type="hidden" name="status" value="">
            {{ method_field( 'PATCH' ) }}
            {{ csrf_field() }}

            <h4 class="text-center">Cambiar el estado a <b><span id="modal-status"></span></b>.</h4><br>

            <center>
              <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Cerrar</button>
              <button class="btn btn-flat btn-primary" type="submit">Guardar</button>
            </center>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="passModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="passModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="passModalLabel">Cambiar contraseña</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form id="password-form" class="col-md-8 col-md-offset-2" action="{{ route('users.change_password', ['id' => $user->id ]) }}" method="POST">
              {{ method_field( 'PATCH' ) }}
              {{ csrf_field() }}

              <div class="form-group">
                <label class="control-label" for="password">Contraseña: *</label>
                <input id="password" class="form-control" type="password" name="password" minlength="6" placeholder="Contraseña" required>
                <p class="help-block">Debe incluir minimo 6 caracteres.</p>
              </div>

              <div class="form-group">
                <label class="control-label" for="verificar">Verificar: *</label>
                <input id="verificar" class="form-control" type="password" minlength="6" placeholder="Verificar contraseña" required>
                <p class="help-block">Verificar contrasña.</p>
              </div>

              <div class="alert alert-danger" style="display: none">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong class="text-center">Las contraseñas no coinciden.</strong> 
              </div>

              <center>
                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-flat btn-primary" type="submit">Guardar</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="delModalLabel">Eliminar usuario</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form class="col-md-8 col-md-offset-2" action="{{ route('users.destroy', ['id' => $user->id] ) }}" method="POST">
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

@section( 'scripts' )
  <script type="text/javascript">
    $(document).ready(function(){

      $('#activarModal').on('show.bs.modal',function(event){
        var button = $(event.relatedTarget);
        var status = button.data('status');
        var modal  = $(this);

        modal.find('#modal-status').text(status);
        modal.find('.modal-body #status-value').val(status);
      });

      $('#password-form').submit(function(e){

        var password = $('#password');
            verificar = $('#verificar');

        if( password.val() != verificar.val() ){
          e.preventDefault();

          $( '.alert' ).show().slideUp( 3000 );
          verificar.val('');
          
          return false;
        }

      });

      $('.btn-access').click(function(e){
        var button = $(this),
            status = button.data('status');

        $('#input-access').val( status );
        $('#form-access').submit();
      });

    });
  </script>
@endsection
