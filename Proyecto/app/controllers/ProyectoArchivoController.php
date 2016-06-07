<?php
class ProyectoArchivoController extends ControllerBase
{
	private $Usuario;
	
    function __construct()
    {
		// A esta sección solo puede entrar los administradores.
		EstaLogueado();
		
		$lsController = "ProyectoArchivo";
		parent::__construct($lsController);
		
		global $usuario;
		$this->Usuario = $usuario;
		
		// Se incluye el modelo que corresponde
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').$lsController.'Model.php';
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').'ProyectoArchivoTipoModel.php';
    }
    public function __destruct() 
	{
    }	
 
	/* Accion INDICE */
	// Petición por GET
    public function indice()
    {
        //Pasamos a la vista toda la información que se desea representar
		$data['TituloPagina'] = "Listado de proyectos";
		if($this->Usuario->isInRol("Administrador Profesor")){
			$data['Completo'] = true;
		}else{
			$data['Completo'] = false;
		}
		
        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre."/indice.php", $data);
    }
 	// Petición por POST a través de AJAX
	public function ObtenerDatos()
	{
		// Obtiene los parámetros que vienen por POST desde el grid del cliente
		$lParametros = new ParametrosObtenerDatos("Nombre");

        //Creamos una instancia de nuestro "modelo", pasandole los parámetros para montar el where
        $item = $this->ObtenNewModel($lParametros->_whereCampo, $lParametros->_whereValor);
 
		// Instanciamos el objetos que se retornara como JSON
		$lRes = new DatosGrid();
		$lRes->total = $item->CountItems();
		$lRes->rows = $item->ObtenerPagina($lParametros->_page, $lParametros->_rows, $lParametros->_sort, $lParametros->_order);
		
		header ("content-type: application/json; charset=utf-8");
		echo json_encode($lRes);
	}
	/* Accion INDICE */

	/* Accion CREAR */
    public function crear()
    {
		if($this->_Method == "POST")
		{
			$this->crear_post();
		}else{
			$this->crear_get();
		}
    }

    private function crear_get()
    {
        // Obtenemos el id del proyecto
        $IdProyecto = sanitizar(obtenParametroArray($_GET, "IdProyecto", 0));;
		$item = new ProyectoArchivoModel();
		$item->IdProyecto = $IdProyecto;

		$lModelTipo = new ProyectoArchivoTipoModel(); 
        //Pasamos a la vista toda la información que se desea representar
		$data['TituloPagina'] = "Añadir un archivo";
		$data["Model"] = $item;
		$data["ComboTipos"] = $lModelTipo->ObtenerTodosTexto();

		//Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre."/crear.php", $data);
	}
    private function crear_post()
    {
		// Obtenemos los datos del nuevo fichero
		$Tipo = sanitizar(obtenParametroArray($_POST, "Tipo", ""));
		$IdProyecto = sanitizar(obtenParametroArray($_POST, "IdProyecto", 0));
		$File = obtenParametroArray($_FILES, 'Fichero', null);
		
		// Validaciones
		if(validarTokenAntiCSRF())
		{
			if( $Tipo != "" && $IdProyecto != 0 && $File != null)
			{
				// Guardarlo en la BD
				$item = new ProyectoArchivoModel();
				$item->IdProyecto = $IdProyecto;
				$item->Tipo = $Tipo;
				$item->AddFile($File);
				
				if($item->Añadir()>0){
					echo "Ok";
					return;
				}
			}
		}
		// Si llegamos aquí, no se ha guardado
		echo "No se ha guardado el fichero";
		return;
	}
	/* Accion CREAR */
	
	/* Accion BORRAR */
	public function EliminarId()
	{
		header ("content-type: application/json; charset=utf-8");
		if($this->_Method == "POST")
		{
			// Validaciones
			if(validarTokenAntiCSRF("_JS"))
			{
				//Creamos una instancia de nuestro "modelo"
				$item = $this->ObtenModelPostId();
				if($item->Eliminar())
				{
					echo json_encode( array("Estado"=>1) );
				}
				else
				{
					echo json_encode( array("Estado"=>0, "Error"=>"No guardado" ) );
				}
			}
			else
			{
				echo json_encode( array("Estado"=>0, "Error"=>"No permitido, por fallo de Token anti CSRF." ) );
			}
		}
		else
		{
			echo json_encode( array("Estado"=>0, "Error"=>"No permitido, solo por POST.") );
		}
	}
	/* Accion BORRAR */
	

	
	// Este método instanciara el modelo cargándolo con los datos que viene por POST
	private function ObtenNewModel($asWhereCampo = null, $asWhereValor = null)
	{
        return new ProyectoArchivoModel($asWhereCampo, $asWhereValor);
	}
	// Este método instanciara el modelo cargándolo con el Id que viene por GET
	// Lo usaran editar_get/EliminarId en las peticiones POST
	private function ObtenModelPostId()
	{
        $item = new ProyectoArchivoModel();
		$Id = sanitizar(obtenParametroArray($_GET, "id", 0));
		
		// Sanitizarlos, porque no nos fiamos del cliente
		$item = $item->ObtenerItem($Id);
			
		return $item;
	}
}
?>