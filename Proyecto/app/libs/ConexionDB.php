<?php
class ConexionBD extends PDO
{
    private static $instance = null;
    public function __construct()
    {
        $config = Config::GetInstance();
        parent::__construct('mysql:host='.$config->get('dbhost').';dbname='.$config->get('dbname'), $config->get('dbuser'), $config->get('dbpass'));
		//Realiza el enlace con la BD en utf-8
		parent::exec("set names utf8");
		parent::setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
	}
 
    public static function GetInstance()
    {
        if( self::$instance == null )
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
	
	// BLOQUE Valoraciones
	public function ValoracionesObtenerPagina($asWhere = array(), $aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		$lList = array();
		$_PreparePDO = null;
		$lsSQL = "";
		try
		{
			//Comprobaciones
			$lsSort = " ORDER BY ";
			$lsLimit = $this->ObtenLimit($aiPaginaActual, $aiItemsPorPagina);
			
			$validColumns = array( "nombre" );
			if(in_array(strtolower($asCampoOrdenacion), $validColumns))
			{
				$lsSort .= $asCampoOrdenacion;
			}
			else
			{
				$lsSort .= "Nombre";
			}
			$lsSort .= $this->ObtenOrder($asTipoOrdenacion);
			
			// Ojo, tenemos que procesar el asWhere para obtener un array de valores
			// y asi usar la parametrizacion de PDO
			$lsSQL = "SELECT Id, Nombre FROM Valoraciones";
			if (Count($asWhere) > 0)
			{
				$lsSQL .= " WHERE ".$asWhere->Where;
				$_PreparePDO = $asWhere->ArrayWhere;
			}
			$lsSQL .= $lsSort.$lsLimit.";";
			$lsSQL = strtolower($lsSQL);
			$result = $this->prepare($lsSQL);
			$result->execute($_PreparePDO);
		
			$cuenta = $result->rowCount();
			if ($result && $cuenta>0) {
				foreach ($result as $valor) {
					$Item = new ValoracionModel();
					$Item->Id = sanitizar(obtenParametroArray($valor, "id"));
					$Item->Nombre = sanitizar(obtenParametroArray($valor, "nombre"));
					$lList[] = $Item;
				}
			}
		}
		catch (Exception $ex)
		{
			$message = $ex->getCode()."->".$ex->getMessage()." en ".$ex->getFile().":".$ex->getLine()." Traza [".$ex->getTraceAsString()."]";
			print("Provocado error: ".$message);
		}

		return $lList;
	}

	public function ValoracionesCount($asWhere = array())
	{
		$liId = -1;
		$_PreparePDO = null;
		// Preparamos la SQL
		$lsSQL = "Select Count(1) as Cantidad FROM Valoraciones";
		if (Count($asWhere) > 0)
		{
			$lsSQL .= " WHERE ".$asWhere->Where;
			$_PreparePDO = $asWhere->ArrayWhere;
		}
		$lsSQL .= "";
		// Obtenemos el resultado del count
		$result = $this->prepare($lsSQL);
		$result->execute($_PreparePDO);
		$cuenta = $result->rowCount();
		if ($result && $result->rowCount()>0) {
			$row = $result->fetch();
			$liId = obtenParametroArray($row, "Cantidad");
		}
		return $liId;
	}

	public function ValoracionesItem($aiId)
	{
		$Item = null;
		// Montamos el WherePDO para obtener este Id
		$lWherePDO = new WherePDO();
		$lWherePDO->Where = "id=:id";
		$lWherePDO->ArrayWhere = array(":id" => $aiId);
		
		$lResultados = $this->ValoracionesObtenerPagina($lWherePDO);
		if($lResultados != null && Count($lResultados) > 0)
		{
			$Item = $lResultados[0];
		}

		return $Item;
	}
	
	public function ValoracionesAñadir($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "INSERT INTO Valoraciones (Nombre)";
			$lsSQL .= " VALUES (:Nombre);";
			$lArray = array(":Nombre" => $aItem->Nombre);

			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}
    
	public function ValoracionesModificar($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "UPDATE Valoraciones SET Nombre=:Nombre WHERE ID=:Id ";
			$lArray = array(":Nombre" => $aItem->Nombre, ":Id" => $aItem->Id);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}

	public function ValoracionesEliminar($aiId = 0)
	{
		$liRes = 0;
		if($aiId > 0)
		{
			$lsSQL = "DELETE FROM Valoraciones WHERE ID=:Id ";
			$lArray = array(":Id" => $aiId);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}
	// BLOQUE Valoraciones
	
	// BLOQUE Cualidades
	public function CualidadesObtenerPagina($asWhere = array(), $aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		$lList = array();
		$_PreparePDO = null;
		$lsSQL = "";
		try
		{
			//Comprobaciones
			$lsSort = " ORDER BY ";
			$lsLimit = $this->ObtenLimit($aiPaginaActual, $aiItemsPorPagina);
			
			$validColumns = array( "nombre" );
			if(in_array(strtolower($asCampoOrdenacion), $validColumns))
			{
				$lsSort .= $asCampoOrdenacion;
			}
			else
			{
				$lsSort .= "Nombre";
			}
			$lsSort .= $this->ObtenOrder($asTipoOrdenacion);
			
			// Ojo, tenemos que procesar el asWhere para obtener un array de valores
			// y asi usar la parametrizacion de PDO
			$lsSQL = "SELECT Id, Nombre FROM Cualidades";
			if (Count($asWhere) > 0)
			{
				$lsSQL .= " WHERE ".$asWhere->Where;
				$_PreparePDO = $asWhere->ArrayWhere;
			}
			$lsSQL .= $lsSort.$lsLimit.";";
			$lsSQL = strtolower($lsSQL);
			$result = $this->prepare($lsSQL);
			$result->execute($_PreparePDO);
		
			$cuenta = $result->rowCount();
			if ($result && $cuenta>0) {
				foreach ($result as $valor) {
					$Item = new CualidadModel();
					$Item->Id = sanitizar(obtenParametroArray($valor, "id"));
					$Item->Nombre = sanitizar(obtenParametroArray($valor, "nombre"));
					$lList[] = $Item;
				}
			}
		}
		catch (Exception $ex)
		{
			$message = $ex->getCode()."->".$ex->getMessage()." en ".$ex->getFile().":".$ex->getLine()." Traza [".$ex->getTraceAsString()."]";
			print("Provocado error: ".$message);
		}

		return $lList;
	}

	public function CualidadesCount($asWhere = array())
	{
		$liId = -1;
		$_PreparePDO = null;
		// Preparamos la SQL
		$lsSQL = "Select Count(1) as Cantidad FROM Cualidades";
		if (Count($asWhere) > 0)
		{
			$lsSQL .= " WHERE ".$asWhere->Where;
			$_PreparePDO = $asWhere->ArrayWhere;
		}
		$lsSQL .= "";
		// Obtenemos el resultado del count
		$result = $this->prepare($lsSQL);
		$result->execute($_PreparePDO);
		$cuenta = $result->rowCount();
		if ($result && $result->rowCount()>0) {
			$row = $result->fetch();
			$liId = obtenParametroArray($row, "Cantidad");
		}
		return $liId;
	}

	public function CualidadesItem($aiId)
	{
		$Item = null;
		// Montamos el WherePDO para obtener este Id
		$lWherePDO = new WherePDO();
		$lWherePDO->Where = "id=:id";
		$lWherePDO->ArrayWhere = array(":id" => $aiId);
		
		$lResultados = $this->CualidadesObtenerPagina($lWherePDO);
		if($lResultados != null && Count($lResultados) > 0)
		{
			$Item = $lResultados[0];
		}

		return $Item;
	}
	
	public function CualidadesAñadir($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "INSERT INTO Cualidades (Nombre)";
			$lsSQL .= " VALUES (:Nombre);";
			$lArray = array(":Nombre" => $aItem->Nombre);

			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}
    
	public function CualidadesModificar($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "UPDATE Cualidades SET Nombre=:Nombre WHERE ID=:Id ";
			$lArray = array(":Nombre" => $aItem->Nombre, ":Id" => $aItem->Id);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}

	public function CualidadesEliminar($aiId = 0)
	{
		$liRes = 0;
		if($aiId > 0)
		{
			$lsSQL = "DELETE FROM Cualidades WHERE ID=:Id ";
			$lArray = array(":Id" => $aiId);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}
	// BLOQUE Cualidades
	
	// BLOQUE Ciclos
	public function CiclosObtenerPagina($asWhere = array(), $aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		$lList = array();
		$_PreparePDO = null;
		$lsSQL = "";
		try
		{
			//Comprobaciones
			$lsSort = " ORDER BY ";
			$lsLimit = $this->ObtenLimit($aiPaginaActual, $aiItemsPorPagina);
			
			$validColumns = array( "nombre", "descripcion" );
			if(in_array(strtolower($asCampoOrdenacion), $validColumns))
			{
				$lsSort .= $asCampoOrdenacion;
			}
			else
			{
				$lsSort .= "Nombre";
			}
			$lsSort .= $this->ObtenOrder($asTipoOrdenacion);
			
			// Ojo, tenemos que procesar el asWhere para obtener un array de valores
			// y asi usar la parametrizacion de PDO
			$lsSQL = "SELECT Id, Nombre, Descripcion FROM Ciclos";
			if (Count($asWhere) > 0)
			{
				$lsSQL .= " WHERE ".$asWhere->Where;
				$_PreparePDO = $asWhere->ArrayWhere;
			}
			$lsSQL .= $lsSort.$lsLimit.";";
			$lsSQL = strtolower($lsSQL);
			$result = $this->prepare($lsSQL);
			$result->execute($_PreparePDO);
		
			$cuenta = $result->rowCount();
			if ($result && $cuenta>0) {
				foreach ($result as $valor) {
					$Item = new CicloModel();
					$Item->Id = sanitizar(obtenParametroArray($valor, "id"));
					$Item->Nombre = sanitizar(obtenParametroArray($valor, "nombre"));
					$Item->Descripcion = sanitizar(obtenParametroArray($valor, "descripcion"));
					$lList[] = $Item;
				}
			}
		}
		catch (Exception $ex)
		{
			$message = $ex->getCode()."->".$ex->getMessage()." en ".$ex->getFile().":".$ex->getLine()." Traza [".$ex->getTraceAsString()."]";
			print("Provocado error: ".$message);
		}

		return $lList;
	}

	public function CiclosCount($asWhere = array())
	{
		$liId = -1;
		$_PreparePDO = null;
		// Preparamos la SQL
		$lsSQL = "Select Count(1) as Cantidad FROM Ciclos";
		if (Count($asWhere) > 0)
		{
			$lsSQL .= " WHERE ".$asWhere->Where;
			$_PreparePDO = $asWhere->ArrayWhere;
		}
		$lsSQL .= "";
		// Obtenemos el resultado del count
		$result = $this->prepare($lsSQL);
		$result->execute($_PreparePDO);
		$cuenta = $result->rowCount();
		if ($result && $result->rowCount()>0) {
			$row = $result->fetch();
			$liId = obtenParametroArray($row, "Cantidad");
		}
		return $liId;
	}

	public function CiclosItem($aiId)
	{
		$Item = null;
		// Montamos el WherePDO para obtener este Id
		$lWherePDO = new WherePDO();
		$lWherePDO->Where = "id=:id";
		$lWherePDO->ArrayWhere = array(":id" => $aiId);
		
		$lResultados = $this->CiclosObtenerPagina($lWherePDO);
		if($lResultados != null && Count($lResultados) > 0)
		{
			$Item = $lResultados[0];
		}

		return $Item;
	}
	
	public function CiclosAñadir($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "INSERT INTO Ciclos (Nombre, Descripcion)";
			$lsSQL .= " VALUES (:Nombre,:Descripcion);";
			$lArray = array(":Nombre" => $aItem->Nombre, ":Descripcion" => $aItem->Descripcion);

			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}
    
	public function CiclosModificar($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "UPDATE Ciclos SET Nombre=:Nombre, Descripcion=:Descripcion WHERE ID=:Id ";
			$lArray = array(":Nombre" => $aItem->Nombre, ":Descripcion" => $aItem->Descripcion, ":Id" => $aItem->Id);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}

	public function CiclosEliminar($aiId = 0)
	{
		$liRes = 0;
		if($aiId > 0)
		{
			$lsSQL = "DELETE FROM Ciclos WHERE ID=:Id ";
			$lArray = array(":Id" => $aiId);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}
	// BLOQUE Ciclos
	
	// BLOQUE Grupos
	public function GruposObtenerPagina($asWhere = array(), $aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		$lList = array();
		$_PreparePDO = null;
		$lsSQL = "";
		try
		{
			//Comprobaciones
			$lsSort = " ORDER BY ";
			$lsLimit = $this->ObtenLimit($aiPaginaActual, $aiItemsPorPagina);
			
			$validColumns = array( "nombre", "ciclo" );
			$campoOrdenacion = strtolower($asCampoOrdenacion);
			if(in_array($campoOrdenacion, $validColumns))
			{
				if($campoOrdenacion == "ciclo"){
					$lsSort .= "b.Nombre";
				}
				else{
					$lsSort .= "a.".$asCampoOrdenacion;
				}
			}
			else
			{
				$lsSort .= "a.Nombre";
			}
			$lsSort .= $this->ObtenOrder($asTipoOrdenacion);
			
			// Ojo, tenemos que procesar el asWhere para obtener un array de valores
			// y asi usar la parametrizacion de PDO
			$lsSQL = "SELECT A.Id, A.Nombre, A.IdCiclo, B.Nombre as Ciclo FROM Grupos A LEFT JOIN Ciclos B ON A.IdCiclo = B.Id";
			if (Count($asWhere) > 0)
			{
				$lsSQL .= " WHERE ".$asWhere->Where;
				$_PreparePDO = $asWhere->ArrayWhere;
			}
			$lsSQL .= $lsSort.$lsLimit.";";
			$lsSQL = strtolower($lsSQL);
			$result = $this->prepare($lsSQL);
			$result->execute($_PreparePDO);

			$cuenta = $result->rowCount();
			if ($result && $cuenta>0) {
				foreach ($result as $valor) {
					$Item = new GrupoModel();
					$Item->Id = sanitizar(obtenParametroArray($valor, "id"));
					$Item->Nombre = sanitizar(obtenParametroArray($valor, "nombre"));
					$Item->IdCiclo = sanitizar(obtenParametroArray($valor, "idciclo"));
					$Item->Ciclo = sanitizar(obtenParametroArray($valor, "ciclo"));
					$lList[] = $Item;
				}
			}
		}
		catch (Exception $ex)
		{
			$message = $ex->getCode()."->".$ex->getMessage()." en ".$ex->getFile().":".$ex->getLine()." Traza [".$ex->getTraceAsString()."]";
			print("Provocado error: ".$message);
		}

		return $lList;
	}

	public function GruposCount($asWhere = array())
	{
		$liId = -1;
		$_PreparePDO = null;
		// Preparamos la SQL
		$lsSQL = "Select Count(1) as Cantidad FROM Grupos A LEFT JOIN Ciclos B ON A.IdCiclo = B.Id";
		if (Count($asWhere) > 0)
		{
			$lsSQL .= " WHERE ".$asWhere->Where;
			$_PreparePDO = $asWhere->ArrayWhere;
		}
		$lsSQL .= "";
		
		// Obtenemos el resultado del count
		$result = $this->prepare($lsSQL);
		$result->execute($_PreparePDO);
		$cuenta = $result->rowCount();
		if ($result && $result->rowCount()>0) {
			$row = $result->fetch();
			$liId = obtenParametroArray($row, "Cantidad");
		}
		return $liId;
	}

	public function GruposItem($aiId)
	{
		$Item = null;
		// Montamos el WherePDO para obtener este Id
		$lWherePDO = new WherePDO();
		$lWherePDO->Where = "a.id=:id";
		$lWherePDO->ArrayWhere = array(":id" => $aiId);
		
		$lResultados = $this->GruposObtenerPagina($lWherePDO);
		if($lResultados != null && Count($lResultados) > 0)
		{
			$Item = $lResultados[0];
		}

		return $Item;
	}
	
	public function GruposAñadir($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "INSERT INTO Grupos (IdCiclo, Nombre)";
			$lsSQL .= " VALUES (:IdCiclo,:Nombre);";
			$lArray = array(":IdCiclo" => $aItem->IdCiclo, ":Nombre" =>$aItem->Nombre );
/*
echo "SQL: ".$lsSQL."<br>";
echo "p: ".var_dump($lArray)."<br>";			
die;
*/
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}
    
	public function GruposModificar($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "UPDATE Grupos SET IdCiclo=:IdCiclo, Nombre=:Nombre WHERE ID=:Id ";
			$lArray = array(":IdCiclo" => $aItem->IdCiclo, ":Nombre" => $aItem->Nombre, ":Id" => $aItem->Id);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}

	public function GruposEliminar($aiId = 0)
	{
		$liRes = 0;
		if($aiId > 0)
		{
			$lsSQL = "DELETE FROM Grupos WHERE ID=:Id ";
			$lArray = array(":Id" => $aiId);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}
	// BLOQUE Grupos
	
	
	
	// usados por la propia clase para obtener el order y el limit en las select
	private function ObtenOrder($asOrder = "")
	{
		$lsRes = " asc";
		if ($asOrder != null && $asOrder != "")
		{
			if (strtolower($asOrder) == "asc" || strtolower($asOrder) == "desc")
			{
				$lsRes = " ".$asOrder;
			}
		}
		return $lsRes;
	}
	private function ObtenLimit($aiPA, $aiIP)
	{
		$lsRes = " LIMIT ";
		if ($aiIP < 1)
		{
			$aiIP = 10;
		}
		if ($aiPA < 1)
		{
			$lsRes = "";
		}
		else
		{
			$lsRes .= ($aiIP * ($aiPA - 1)).", ".$aiIP;
		}
		return $lsRes;
	}
	//
}


// Clase usada por los modelos para generar los parámetros usados por PDO para parametrizar los WHERE
class WherePDO {
	var $Where = "";
	var $ArrayWhere = array();
} 

?>