<?php
/*
 El uso es bastante sencillo:
 $vista = new View();
 $vista->show('listado.php', array("Prueba" => "Patata"));
*/
class View
{
    function __construct()
    {
    }
    public function show($name, $vars = array())
    {
        //$name es el nombre de nuestra plantilla, por ej, listado.php
        //$vars es el contenedor de nuestras variables, es un arreglo del tipo llave => valor, opcional.

        //Traemos una instancia de nuestra clase de configuracion.
        $config = Config::GetInstance();
 
        // Montamos la ruta a la plantilla
        $path = $config->get('Ruta').$config->get('viewsFolder').$name;
 
        //Si no existe el fichero en cuestion, mostramos un 404
        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
 
        //Si hay variables para asignar, las pasamos una a una.
        if(is_array($vars))
        {
			foreach ($vars as $key => $value)
			{
				// Ojo al doble dollar, para crear la variable con el nombre de la variable
				$$key = $value;
			}
		}
 
        //Finalmente, incluimos la plantilla.
        include($path);
    }
}
?>