<?php
class CualidadController extends ControllerBase
{
    function __construct()
    {
		// A esta sección solo puede entrar los administradores.
		EstaLogueado("Administrador");
		
		$lsController = "Cualidad";
		parent::__construct($lsController);
		
		// Se incluye el modelo que corresponde
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').$lsController.'Model.php';
    }
    public function __destruct() 
	{
    }	
 
	/* Accion INDICE */
	// Petición por GET
    public function indice()
    {
        //Pasamos a la vista toda la información que se desea representar
		$data['TituloPagina'] = "Listado de cualidades";
 
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
		}
		else
		{
			$this->crear_get();
		}
    }

    private function crear_get()
    {
        //Creamos una instancia de nuestro "modelo"
        $item = $this->ObtenNewModel();
 
        //Pasamos a la vista toda la información que se desea representar
		$data['TituloPagina'] = "Añadir una cualidad";
		$data["Model"] = $item;
 
        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre."/crear.php", $data);
	}
    private function crear_post()
    {
		// Creamos una instancia de nuestro "modelo" con los parámetros que vienen por POST
		$item = $this->ObtenModelPost();
		
		// Validaciones
		if(validarTokenAntiCSRF())
		{
			if($item->IsValid())
			{
				// Guardarlos
				if($item->Añadir() > 0)
				{
					// Todo perfecto
					$this->view->show("cerrarPanel.php", null);
					return;
				}
			}
		}
		// Si llegamos aquí, no se ha guardado
		
		// Retornar la vista con el item cargado
		$data['TituloPagina'] = "Añadir una cualidad";
		$data["Model"] = $item;

        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre."/crear.php", $data);
	}
	/* Accion CREAR */
	
	/* Accion EDITAR */
    public function editar()
    {
		if($this->_Method == "POST")
		{
			$this->editar_post();
		}
		else
		{
			$this->editar_get();
		}
    }

    private function editar_get()
    {
		//Creamos una instancia de nuestro "modelo"
        $item = $this->ObtenModelPostId();
 
        //Pasamos a la vista toda la información que se desea representar
		$data['TituloPagina'] = "Editar una cualidad";
		$data["Model"] = $item;
 
        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre."/editar.php", $data);
	}
    private function editar_post()
    {
        // Creamos una instancia de nuestro "modelo" con los parámetros que vienen por POST
        $item = $this->ObtenModelPost();
		
		// Validaciones
		if(validarTokenAntiCSRF())
		{
			if($item->IsValid())
			{
				// Guardarlos
				if($item->Modificar() > 0)
				{
					// Todo perfecto
					$this->view->show("cerrarPanel.php", null);
					return;
				}
			}
		}
		// Si llegamos aquí, no se ha guardado
		
		// Retornar la vista con el item cargado
		$data['TituloPagina'] = "Editar una cualidad";
		$data["Model"] = $item;

        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre."/editar.php", $data);
	}
	/* Accion EDITAR */
	
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
        return new CualidadModel($asWhereCampo, $asWhereValor);
	}
	// Lo usaran crear_post/editar_post en las peticiones POST
	private function ObtenModelPost()
	{
        $item = new CualidadModel();
		$item->Id = sanitizar(obtenParametroArray($_POST, "Id", 0));
		$item->Nombre = sanitizar(obtenParametroArray($_POST, "Nombre", ""));
		// Sanitizarlos, porque no nos fiamos del cliente
		$item->Sanitize();
			
		return $item;
	}
	// Este método instanciara el modelo cargándolo con el Id que viene por GET
	// Lo usaran editar_get/EliminarId en las peticiones POST
	private function ObtenModelPostId()
	{
        $item = new CualidadModel();
		$Id = sanitizar(obtenParametroArray($_GET, "id", 0));
		
		// Sanitizarlos, porque no nos fiamos del cliente
		$item = $item->ObtenerItem($Id);
			
		return $item;
	}
	
}

?>