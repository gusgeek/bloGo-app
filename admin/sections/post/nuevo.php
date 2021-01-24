<?php 
  session_start();

  if (empty($_SESSION['idusuario'])) { echo "<meta http-equiv='refresh' content='1'>"; }
  else {

?>

<script type="text/javascript">
	
	CKEDITOR.replace( 'contenido' );
	$.ajax({
	    url : './core/kernel.php?GetAllCatBlog',
	    contentType : false,
	    processData : false
	}).done(function(response){

	    var json = $.parseJSON(response);
	    var data = json.data;

	    for(var i = 0; i < data.length; i++) {
	        var obj = data[i];
	        $('#categoria').prepend("<option value='" + obj._id + "'>" + obj.title + "</option>");
	    }

        $( "#loadDiv" ).hide(); 
    	$( "#container" ).show(); 
	  
	});

	function createPost(stts){
	    var formData = new FormData($("#metaBlog").get(0));
	    var data = CKEDITOR.instances['contenido'].getData();

		    formData.append('contenido', data);
    		formData.append('status', stts);

	    var ajaxUrl = './core/kernel.php?InsertBlog';
	    $.ajax({
	      url : ajaxUrl,
	      type : "POST",
	      data : formData,
	      contentType : false,
	      processData : false
	    })
	    .done(function(response){ 
	    	var json = $.parseJSON(response);
      		$("#Activity").load('./sections/post/editar.php?id='+json.data._id);
	     })
	    .fail(function(){ alert("Hubo un problema con la carga del Dato"); }) ;
	}

</script>
<div class="container-fluid" style="display: none" id="container">
    <div class="separata"></div>
	<form id="metaBlog">
	    <div class="row">
			<div class="col-sm card">
				<div class="separata"></div>
				<h5>
					Crear Publicacion
					<div class="float-right">
					  <button type="button" class="btn btn-sm btn-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-cog" aria-hidden="true"></i>
					  </button>
					  <div class="dropdown-menu dropdown-menu-right">
					    <button class="dropdown-item" onclick="createPost(1)" type="button">Guardar</button>
					    <button class="dropdown-item" onclick="createPost(3)" type="button">Borrador</button>
					  </div>
					</div>
				</h5>
				<div class="separata"></div>
				<div class="row">
					<div class="col-md-4">
						<div class="mb-3">
							<label for="exampleInputEmail1" class="form-label">Titulo</label>
							<input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="emailHelp">
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-3">
							<label for="exampleInputEmail1" class="form-label">Keywords</label>
							<input type="text" class="form-control" name="keywords" id="keywords" aria-describedby="emailHelp">
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-3">
							<label for="exampleInputEmail1" class="form-label">Categoria</label>
							<select class="custom-select" id="categoria" name="categoria">
						  </select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label for="exampleInputEmail1" class="form-label">Nota</label>
							<textarea id="contenido" name="contenido"></textarea>
						</div>
					</div>

				
				</div>
			</div>
	    </div>
	</form>
</div>
<?php } ?>