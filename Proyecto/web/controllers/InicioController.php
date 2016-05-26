<?php
class InicioController extends ControllerBase
{
    function __construct()
    {
		parent::__construct("Inicio");
    }
    public function __destruct() 
	{
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
        //require 'models/PruModel.php';
 
        //Creamos una instancia de nuestro "modelo"
 
        //Le pedimos al modelo todos los items
 
        //Pasamos a la vista toda la información que se desea representar
        $data['item'] = "nada";
        
		//Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre."/privado.php", $data);
    }

    public function agregar()
    {
        echo 'Aquí incluiremos nuestro formulario para insertar items';
    }
}
?>