<?php
class PlantillaCorreoModel extends ModelBase
{
	/* Propiedades */
    public $Id;
    public $Nombre;
    public $Asunto;
    public $Descripcion;

	private $_WherePDO = null;
	/* Propiedades */
	
	/* Magicos, contructor destructor acceso y seteo */
    //public function __construct()
    //{
	//	parent::__construct();
    //}
	/* Magicos, contructor destructor acceso y seteo */

	
	/* Metodos principales */
	public function ObtenerPlantilla($asPlantilla)
	{
		return $this->_db->PlantillaCorreoObtenerPlantilla($asPlantilla);
	}
	/* Metodos principales */
}
?>