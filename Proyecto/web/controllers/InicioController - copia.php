<?php
class InicioController
{
	private $_Nombre = "inicio";
	
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
    }
 
    public function indice()
    {
        //Incluye el modelo que corresponde
        //require 'models/ItemsModel.php';
 
        //Creamos una instancia de nuestro "modelo"
        //$items = new ItemsModel();
 
        //Le pedimos al modelo todos los items
        //$listado = $items->listadoTotal();
 
        //Pasamos a la vista toda la informaci�n que se desea representar
        //$data['listado'] = $listado;
		$data['ltitulo'] = "Hola melon";
 
        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre . "/indice.php", $data);
    }
 
    public function agregar()
    {
        echo 'Aqu� incluiremos nuestro formulario para insertar items';
    }
}
?>