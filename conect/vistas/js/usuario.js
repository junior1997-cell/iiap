var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);

	})

	$("#imagenmuestra").hide();

	//Mostramos los permisos
	$.post("../ajax/usuario.php?op=permisos",function(r){
	        $("#permisos").html(r);
	});

	$('#mAcceso').addClass("treeview active");
    $('#lUsuarios').addClass("active");

     
 
	 
}


//Función limpiar
function limpiar(){
	 
	$("#nombres").val("");
	$("#apellidoMatPat").val("");	 
	$("#login").val("");
	$("#clave").val("");	 
	$('#id_cargo').selectpicker('refresh');	 
	$("#imagenmuestra").hide();
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#imagen").val("");
	$("#idusuario").val("");
	$("#antigua_clave").hide();	
	$("#id").val("");	 	
	$("#nombres").val("");
	$("#apellidoMatPat").val("");				
	$("#login").val("");
	$("#clave_actual").val("");
	$("#imagenactual").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag){	 
		$("#antigua_clave").show();	     
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#nuevo_cargo").hide();
		$("#nueva_clave").hide();
		  
	}else{
		 
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnGuardar").show();
		$("#btnagregar").show();
	}
}



//Función cancelarform
function cancelarform()
{	
	limpiar();
	  
	 $("#antigua_clave").show();
	 $("#antiguo_cargo").show();
	 $("#antiguo_distrito").show();
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/usuario.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "buttons": {
            "copyTitle": "Tabla Copiada",
            "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	console.log(formData);
	$.ajax({
		url: "../ajax/usuario.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	 
	          console.log(datos);         
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}
 

function mostrar(id)
{

	sexo(id);
	console.log(id);
	$.post("../ajax/usuario.php?op=mostrar",{id : id}, function(data, status)
	{
		mostrarform(true);

		data = JSON.parse(data);	
		tipo = typeof data;
		console.log(tipo);
		console.log(data);

		
		$("#antigua_clave").hide();
		$("#nueva_clave").show();
		$("#id").val(data['Detalle'][0]['idpersona']);
		$("#dni").val(data['Detalle'][0]['num_doc_persona']);
		var ap =data['Detalle'][0]['apellidos_persona'];

		if(data['Detalle'][0]['apellidos_persona']==""){
			// mostramos datos de sunat				 
			$("#nombres").prop("disabled",true);       		 
		}else{
			// mostramos datos de reniec
			$("#nombres").show();
			$("#apellidoMatPat").show();
			$("#nombres").val(data['Detalle'][0]['nombre_persona']);
			$("#apellidoMatPat").val(data['Detalle'][0]['apellidos_persona']);			 
			$("#nombres").prop("disabled",false);       		 
		}
		 
		$("#login").val(data['Detalle'][0]['email']);
		$("#clave_actual").val(data['Detalle'][0]['password']);		 
		$("#id_cargo").val(data['Detalle'][0]['id_cargo']);
		$("#id_cargo").selectpicker('refresh');
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/"+data['Detalle'][0]['imagen_persona']);
		$("#imagenactual").val(data['Detalle'][0]['imagen_persona']); 
 	});

 	$.post("../ajax/usuario.php?op=permisos&id="+id,function(r){
	        $("#permisos").html(r);
	});
}

//Función para desactivar registros
function desactivar(id)
{
	console.log(id);
	bootbox.confirm("¿Está Seguro de desactivar el usuario?", function(result){
		if(result)
        {
        	$.post("../ajax/usuario.php?op=desactivar", {id : id}, function(e){

        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id)
{
	bootbox.confirm("¿Está Seguro de activar el Usuario?", function(result){
		if(result)
        {
        	$.post("../ajax/usuario.php?op=activar", {id : id}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

 

init();