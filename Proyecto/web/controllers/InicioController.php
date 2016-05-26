<?php
class InicioController
{
	private $_Nombre = "inicio";
	private $_db;
	private $_Method;
	
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
		$this->_db = conectarDB(null);
		$this->_Method = $_SERVER['REQUEST_METHOD'];
    }
    public function __destruct() {
        desconectarDB($this->_db);
    }	
 
    public function indice()
    {
        //Incluye el modelo que corresponde
        //require 'models/ItemsModel.php';
 
        //Creamos una instancia de nuestro "modelo"
        //$items = new ItemsModel();
 
        //Le pedimos al modelo todos los items
        //$listado = $items->listadoTotal();
 
        //Pasamos a la vista toda la información que se desea representar
        //$data['listado'] = $listado;
		$data['ltitulo'] = "Hola melon";
 
        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre . "/indice.php", $data);
    }
 
    public function privado()
    {
        //Incluye el modelo que corresponde
        //require 'models/ItemsModel.php';
 
        //Creamos una instancia de nuestro "modelo"
        //$items = new ItemsModel();
 
        //Le pedimos al modelo todos los items
        //$listado = $items->listadoTotal();
 
        //Pasamos a la vista toda la información que se desea representar
        //$data['listado'] = $listado;
		$data['ltitulo'] = "Hola melon";
 
        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre . "/privado.php", $data);
    }

    public function agregar()
    {
        echo 'Aquí incluiremos nuestro formulario para insertar items';
    }
}
?>