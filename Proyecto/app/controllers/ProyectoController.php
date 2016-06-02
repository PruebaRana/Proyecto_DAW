<?php
class ProyectoController extends ControllerBase
{
	private $Usuario;
	
    function __construct()
    {
		// A esta sección solo puede entrar los administradores.
		EstaLogueado();
		
		$lsController = "Proyecto";
		parent::__construct($lsController);
		
		global $usuario;
		$this->Usuario = $usuario;
		
		// Se incluye el modelo que corresponde
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').$lsController.'Model.php';
		// Depende tambien 
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').'UsuarioModel.php';
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').'CicloModel.php';
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').'GrupoModel.php';
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').'CualidadModel.php';
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').'ModuloModel.php';
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').'ValoracionModel.php';
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
		// Solo los profesores y los administradores pueden crear/modificar o borrar proyectos
		EstaLogueado("Administrador Profesor");
		
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
		// Los dependientes
		$lModelUsuario = new UsuarioModel(); 
		$lModelCiclo = new CicloModel(); 
		$lModelGrupo = new GrupoModel(); 
		$lModelModulo = new ModuloModel(); 
		$lModelCualidad = new CualidadModel(); 
		$lModelValoracion = new ValoracionModel(); 

        //Pasamos a la vista toda la información que se desea representar
		$data['TituloPagina'] = "Añadir un proyecto";
		$data["Model"] = $item;

		$data["ComboAlumnos"] = $lModelUsuario->ObtenerTodosAlumnos();
		$data["ComboTutores"] = $lModelUsuario->ObtenerTodosProfesores();
		$data["ComboCiclos"] = $lModelCiclo->ObtenerTodosTexto();
		$data["ComboGrupos"] = $lModelGrupo->ObtenerTodosTexto();
		$data["ComboModulos"] = $lModelModulo->ObtenerTodos();
		$data["ComboCualidades"] = $lModelCualidad->ObtenerTodos();
		$data["ComboValoraciones"] = $lModelValoracion->ObtenerTodosTexto();
		
        //Finalmente presentamos nuestra plantilla
		header ("content-type: application/json; charset=utf-8");
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

		$lModelUsuario = new UsuarioModel(); 
		$lModelCiclo = new CicloModel(); 
		$lModelGrupo = new GrupoModel(); 
		$lModelModulo = new ModuloModel(); 
		$lModelCualidad = new CualidadModel(); 
		$lModelValoracion = new ValoracionModel(); 
		// Retornar la vista con el item cargado
		$data['TituloPagina'] = "Añadir un proyecto";
		$data["Model"] = $item;

		$data["ComboAlumnos"] = $lModelUsuario->ObtenerTodosAlumnos();
		$data["ComboTutores"] = $lModelUsuario->ObtenerTodosProfesores();
		$data["ComboCiclos"] = $lModelCiclo->ObtenerTodosTexto();
		$data["ComboGrupos"] = $lModelGrupo->ObtenerTodosTexto();
		$data["ComboModulos"] = $lModelModulo->ObtenerTodos();
		$data["ComboCualidades"] = $lModelCualidad->ObtenerTodos();
		$data["ComboValoraciones"] = $lModelValoracion->ObtenerTodosTexto();
		
        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre."/crear.php", $data);
	}
	/* Accion CREAR */
	
	/* Accion EDITAR */
    public function editar()
    {
		// Solo los profesores y los administradores pueden crear/modificar o borrar proyectos
		EstaLogueado("Administrador Profesor");

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
 
		$lModelUsuario = new UsuarioModel(); 
		$lModelCiclo = new CicloModel(); 
		$lModelGrupo = new GrupoModel(); 
		$lModelModulo = new ModuloModel(); 
		$lModelCualidad = new CualidadModel(); 
		$lModelValoracion = new ValoracionModel(); 
        //Pasamos a la vista toda la información que se desea representar
		$data['TituloPagina'] = "Editar un proyecto";
		$data["Model"] = $item;
 
		$data["ComboAlumnos"] = $lModelUsuario->ObtenerTodosAlumnos();
		$data["ComboTutores"] = $lModelUsuario->ObtenerTodosProfesores();
		$data["ComboCiclos"] = $lModelCiclo->ObtenerTodosTexto();
		$data["ComboGrupos"] = $lModelGrupo->ObtenerTodosTexto();
		$data["ComboModulos"] = $lModelModulo->ObtenerTodos();
		$data["ComboCualidades"] = $lModelCualidad->ObtenerTodos();
		$data["ComboValoraciones"] = $lModelValoracion->ObtenerTodosTexto();

        //Finalmente presentamos nuestra plantilla
		header ("content-type: application/json; charset=utf-8");
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
				}else{
					$data['Error'] = "No se ha guardado";		
				}
			}else{
				$data['Error'] = "Modelo no valido";		
			}
		}else{
			$data['Error'] = "Fallo de token";		
		}
		// Si llegamos aquí, no se ha guardado
		
		$lModelUsuario = new UsuarioModel(); 
		$lModelCiclo = new CicloModel(); 
		$lModelGrupo = new GrupoModel(); 
		$lModelModulo = new ModuloModel(); 
		$lModelCualidad = new CualidadModel(); 
		$lModelValoracion = new ValoracionModel(); 
		// Retornar la vista con el item cargado
		$data['TituloPagina'] = "Editar un proyecto";
		$data["Model"] = $item;

		$data["ComboAlumnos"] = $lModelUsuario->ObtenerTodosAlumnos();
		$data["ComboTutores"] = $lModelUsuario->ObtenerTodosProfesores();
		$data["ComboCiclos"] = $lModelCiclo->ObtenerTodosTexto();
		$data["ComboGrupos"] = $lModelGrupo->ObtenerTodosTexto();
		$data["ComboModulos"] = $lModelModulo->ObtenerTodos();
		$data["ComboCualidades"] = $lModelCualidad->ObtenerTodos();
		$data["ComboValoraciones"] = $lModelValoracion->ObtenerTodosTexto();

        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre."/editar.php", $data);
	}
	/* Accion EDITAR */
	
	/* Accion BORRAR */
	public function EliminarId()
	{
		// Solo los profesores y los administradores pueden crear/modificar o borrar proyectos
		EstaLogueado("Administrador Profesor");

		header ("content-type: application/json; charset=utf-8");
		if($this->_Method == "POST")
		{
			// Validaciones
			if(validarTokenAntiCSRF("_JS"))
			{
				//Creamos una instancia de nuestro "modelo"
				$item = $this->ObtenModelPostId();
				if($item != null && $item->Eliminar())
				{
					echo json_encode( array("Estado"=>1) );
				}
				else
				{
					echo json_encode( array("Estado"=>0, "Error"=>"No eliminado" ) );
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
        return new ProyectoModel($asWhereCampo, $asWhereValor);
	}
	// Lo usaran crear_post/editar_post en las peticiones POST
	private function ObtenModelPost()
	{
        $item = new ProyectoModel();
		$item->Id = sanitizar(obtenParametroArray($_POST, "Id", 0));
		$item->Titulo = sanitizar(obtenParametroArray($_POST, "Titulo", 0));
		$item->IdAlumno = sanitizar(obtenParametroArray($_POST, "IdAlumno", 0));
		$item->IdTutor = sanitizar(obtenParametroArray($_POST, "IdTutor", 0));
		$item->Curso = sanitizar(obtenParametroArray($_POST, "Curso", ""));
		$item->Ciclo = sanitizar(obtenParametroArray($_POST, "Ciclo", ""));
		$item->Grupo = sanitizar(obtenParametroArray($_POST, "Grupo", ""));

		$item->Resumen = sanitizar(obtenParametroArray($_POST, "Resumen", ""), true);
		$item->Herramientas = sanitizar(obtenParametroArray($_POST, "Herramientas", ""), true);
		$item->Comentarios = sanitizar(obtenParametroArray($_POST, "Comentarios", ""), true);
		$item->Valoracion = sanitizar(obtenParametroArray($_POST, "Valoracion", ""));
		$item->Borrado = sanitizar(obtenParametroArray($_POST, "Borrado", 0));

		$item->Cualidades = sanitizar(obtenParametroArray($_POST, "Cualidades", ""));
		$item->Modulos = sanitizar(obtenParametroArray($_POST, "Modulos", ""));

		// Sanitizarlos, porque no nos fiamos del cliente
		$item->Sanitize();
			
		return $item;
	}
	// Este método instanciara el modelo cargándolo con el Id que viene por GET
	// Lo usaran editar_get/EliminarId en las peticiones POST
	private function ObtenModelPostId()
	{
        $item = new ProyectoModel();
		$Id = sanitizar(obtenParametroArray($_GET, "id", 0));
		
		// Sanitizarlos, porque no nos fiamos del cliente
		$item = $item->ObtenerItem($Id);
			
		return $item;
	}
}
?>