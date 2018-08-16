@extends( 'layouts.app' )

@section( 'title', 'Perfil - '.config( 'app.name' ) )
@section( 'header', 'Perfil' )
@section( 'breadcrumb' )
	<ol class="breadcrumb">
	  <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
	  <li class="active"> Perfil </li>
	</ol>
@endsection
@section( 'content' )
  <section>
    <a class="btn btn-flat btn-default" href="{{ route( 'dashboard' ) }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
    <a class="btn btn-flat btn-success" href="{{ route( 'perfil_edit' ) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
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
            </ul>
          </div><!-- /.box-body -->
        </div>
      </div>
    
    </div>
  </section>
@endsection

@section( 'script' )
 	<script type="text/javascript">
 	$(document).ready(function(){
 			$("#pp").click(function(event) {
	 		var bool = this.checked;
	 		if(bool === true){
	 			$("#password_fields").show();
	 			$("#password,#password_confirmation").prop('required',true);
	 		}else{
	 			$("#password_fields").hide();
	 			$("#password,#password_confirmation").prop('required',false).val('');
	 		}
	 	});
 	});
 	</script>
@endsection
