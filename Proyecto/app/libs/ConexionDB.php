<?php
class ConexionBD extends PDO
{
    private static $instance = null;
    private static $_Config = null;
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

        $config = Config::GetInstance();
		self::$instance->_Config = $config;
        return self::$instance;
    }
	
	
	// BLOQUE Utiles
	public static function ObtenerSioNo($asTexto){
		$asTexto = strtolower($asTexto);
		$lsRes = 0;
		if($asTexto == "si" || $asTexto == "yes" || $asTexto == "ok" || $asTexto == "true" || $asTexto == "1"){
			$lsRes = 1;
		}
		return $lsRes;
	}
	// BLOQUE Utiles
	
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
	
	// BLOQUE Modulos
	public function ModulosObtenerPagina($asWhere = array(), $aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		$lList = array();
		$_PreparePDO = null;
		$lsSQL = "";
		try
		{
			//Comprobaciones
			$lsSort = " ORDER BY ";
			$lsLimit = $this->ObtenLimit($aiPaginaActual, $aiItemsPorPagina);
			
			$validColumns = array( "nombre", "ciclo", "descripcion" );
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
			$lsSQL = "SELECT A.Id, A.Nombre, A.Descripcion, A.IdCiclo, B.Nombre as Ciclo FROM Modulos A LEFT JOIN Ciclos B ON A.IdCiclo = B.Id";
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
					$Item = new ModuloModel();
					$Item->Id = sanitizar(obtenParametroArray($valor, "id"));
					$Item->Nombre = sanitizar(obtenParametroArray($valor, "nombre"));
					$Item->Descripcion = sanitizar(obtenParametroArray($valor, "descripcion"));
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

	public function ModulosCount($asWhere = array())
	{
		$liId = -1;
		$_PreparePDO = null;
		// Preparamos la SQL
		$lsSQL = "Select Count(1) as Cantidad FROM Modulos A LEFT JOIN Ciclos B ON A.IdCiclo = B.Id";
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

	public function ModulosItem($aiId)
	{
		$Item = null;
		// Montamos el WherePDO para obtener este Id
		$lWherePDO = new WherePDO();
		$lWherePDO->Where = "a.id=:id";
		$lWherePDO->ArrayWhere = array(":id" => $aiId);
		
		$lResultados = $this->ModulosObtenerPagina($lWherePDO);
		if($lResultados != null && Count($lResultados) > 0)
		{
			$Item = $lResultados[0];
		}

		return $Item;
	}
	
	public function ModulosAñadir($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "INSERT INTO Modulos (IdCiclo, Nombre, Descripcion)";
			$lsSQL .= " VALUES (:IdCiclo,:Nombre,:Descripcion);";
			$lArray = array(":IdCiclo" => $aItem->IdCiclo, ":Nombre" =>$aItem->Nombre, ":Descripcion" =>$aItem->Descripcion );

			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}
    
	public function ModulosModificar($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "UPDATE Modulos SET IdCiclo=:IdCiclo, Nombre=:Nombre, Descripcion=:Descripcion WHERE ID=:Id ";
			$lArray = array(":IdCiclo" => $aItem->IdCiclo, ":Nombre" => $aItem->Nombre, ":Descripcion" => $aItem->Descripcion, ":Id" => $aItem->Id);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}

	public function ModulosEliminar($aiId = 0)
	{
		$liRes = 0;
		if($aiId > 0)
		{
			$lsSQL = "DELETE FROM Modulos WHERE ID=:Id ";
			$lArray = array(":Id" => $aiId);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}
	// BLOQUE Modulos
	
	// BLOQUE Usuarios
	public function UsuariosObtenerTodos($asWhere = array(), $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		$lList = array();
		$_PreparePDO = null;
		$lsSQL = "";
		try
		{
			//Comprobaciones
			$lsSort = " ORDER BY ";
			
			$validColumns = array( "usuario", "nombre", "email", "fecha_alta", "activo", "roles" );
			$campoOrdenacion = strtolower($asCampoOrdenacion);
			if(in_array($campoOrdenacion, $validColumns))
			{
				if($campoOrdenacion == "roles"){
					$lsSort .= "b.roles";
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
			
			$lsSQL = "SELECT A.Id, A.Usuario, A.clave, A.Nombre, A.Email, A.fecha_alta, A.foto, A.activo, A.borrado, B.Roles FROM Usuarios A LEFT JOIN ";
			$lsSQL .= "(SELECT A.idusuario, GROUP_CONCAT(b.nombre SEPARATOR ', ') AS Roles FROM usuariosroles A left join roles B on A.idrol = b. id GROUP BY A.idusuario) B ON A.Id = B.IdUsuario";
			
			$lsSQL .= " WHERE A.Borrado=0";
			
			if (Count($asWhere) > 0)
			{
				$lsSQL .= " AND ".$asWhere->Where;
				$_PreparePDO = $asWhere->ArrayWhere;
			}
			$lsSQL .= $lsSort.";";
			$lsSQL = strtolower($lsSQL);
			$result = $this->prepare($lsSQL);
			$result->execute($_PreparePDO);

			$cuenta = $result->rowCount();
			if ($result && $cuenta>0) {
				foreach ($result as $valor) {
					$Item = new UsuarioModel();
					$Item->Id = sanitizar(obtenParametroArray($valor, "id"));
					$Item->Usuario = sanitizar(obtenParametroArray($valor, "usuario"));
					$Item->Clave = sanitizar(obtenParametroArray($valor, "clave"));
					$Item->Nombre = sanitizar(obtenParametroArray($valor, "nombre"));
					$Item->EMail = sanitizar(obtenParametroArray($valor, "email"));
					$Item->Fecha_Alta = sanitizar(obtenParametroArray($valor, "fecha_alta"));
					$Item->Foto = sanitizar(obtenParametroArray($valor, "foto"));
					$Item->Activo = ConexionBD::ObtenerSioNo(sanitizar(obtenParametroArray($valor, "activo")));
					$Item->Borrado = ConexionBD::ObtenerSioNo(sanitizar(obtenParametroArray($valor, "borrado")));
					// Y los roles por determinar
					$Item->Roles = sanitizar(obtenParametroArray($valor, "roles"));
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

	public function UsuariosObtenerPagina($asWhere = array(), $aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		$lList = array();
		$_PreparePDO = null;
		$lsSQL = "";
		try
		{
			//Comprobaciones
			$lsSort = " ORDER BY ";
			$lsLimit = $this->ObtenLimit($aiPaginaActual, $aiItemsPorPagina);
			
			$validColumns = array( "usuario", "nombre", "email", "fecha_alta", "activo", "roles" );
			$campoOrdenacion = strtolower($asCampoOrdenacion);
			if(in_array($campoOrdenacion, $validColumns))
			{
				if($campoOrdenacion == "roles"){
					$lsSort .= "b.roles";
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
			
			$lsSQL = "SELECT A.Id, A.Usuario, A.clave, A.Nombre, A.Email, A.fecha_alta, A.foto, A.activo, A.borrado, B.Roles FROM Usuarios A LEFT JOIN ";
			$lsSQL .= "(SELECT A.idusuario, GROUP_CONCAT(b.nombre SEPARATOR ', ') AS Roles FROM usuariosroles A left join roles B on A.idrol = b. id GROUP BY A.idusuario) B ON A.Id = B.IdUsuario";
			
			$lsSQL .= " WHERE A.Borrado=0";
			
			// No es admin
			if(!$this->_Config->get('Usuario')->isInRol("Administrador")){
				$lsSQL .= " AND B.Roles like '%Alumno%'";
			}
			
			if (Count($asWhere) > 0)
			{
				$lsSQL .= " AND ".$asWhere->Where;
				$_PreparePDO = $asWhere->ArrayWhere;
			}
			$lsSQL .= $lsSort.$lsLimit.";";
			$lsSQL = strtolower($lsSQL);
			$result = $this->prepare($lsSQL);
			$result->execute($_PreparePDO);

			$cuenta = $result->rowCount();
			if ($result && $cuenta>0) {
				foreach ($result as $valor) {
					$Item = new UsuarioModel();
					$Item->Id = sanitizar(obtenParametroArray($valor, "id"));
					$Item->Usuario = sanitizar(obtenParametroArray($valor, "usuario"));
					$Item->Clave = sanitizar(obtenParametroArray($valor, "clave"));
					$Item->Nombre = sanitizar(obtenParametroArray($valor, "nombre"));
					$Item->EMail = sanitizar(obtenParametroArray($valor, "email"));
					$Item->Fecha_Alta = sanitizar(obtenParametroArray($valor, "fecha_alta"));
					$Item->Foto = sanitizar(obtenParametroArray($valor, "foto"));
					$Item->Activo = ConexionBD::ObtenerSioNo(sanitizar(obtenParametroArray($valor, "activo")));
					$Item->Borrado = ConexionBD::ObtenerSioNo(sanitizar(obtenParametroArray($valor, "borrado")));
					// Y los roles por determinar
					$Item->Roles = sanitizar(obtenParametroArray($valor, "roles"));
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

	public function UsuariosCount($asWhere = array())
	{
		$liId = -1;
		$_PreparePDO = null;
		// Preparamos la SQL
		$lsSQL = "Select Count(1) as Cantidad FROM Usuarios A ";
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

	public function UsuariosItem($aiId)
	{
		$Item = null;
		// Montamos el WherePDO para obtener este Id
		$lWherePDO = new WherePDO();
		$lWherePDO->Where = "a.id=:id";
		$lWherePDO->ArrayWhere = array(":id" => $aiId);
		
		$lResultados = $this->UsuariosObtenerPagina($lWherePDO);
		if($lResultados != null && Count($lResultados) > 0)
		{
			$Item = $lResultados[0];
		}

		return $Item;
	}
	
	public function UsuariosAñadir($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "INSERT INTO Usuarios (Usuario, Clave, Nombre, EMail)";
			$lsSQL .= " VALUES (:Usuario,:Clave,:Nombre,:EMail);";
			$lArray = array(":Usuario" => $aItem->Usuario, ":Clave" => md5(getToken(10)), ":Nombre" =>$aItem->Nombre, ":EMail" =>$aItem->EMail );

			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
			//Eliminar los roles de este usuario y asignar los nuevos
			$this->UsuariosAsignarRoles($this->lastInsertId(), $aItem->Roles);
			
		}
		return $liRes;
	}
    
	public function UsuariosModificar($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "UPDATE Usuarios SET Usuario=:Usuario, Nombre=:Nombre, EMail=:EMail, Activo=b'$aItem->Activo' WHERE ID=:Id ";
			$lArray = array(":Usuario" => $aItem->Usuario, ":Nombre" => $aItem->Nombre, ":EMail" => $aItem->EMail, ":Id" => $aItem->Id);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);

			//Eliminar los roles de este usuario y asignar los nuevos
			$liRes = $result->rowCount() + $this->UsuariosAsignarRoles($aItem->Id, $aItem->Roles);
		}
		return $liRes;
	}

	public function UsuariosEliminar($aiId = 0)
	{
		$liRes = 0;
		if($aiId > 0)
		{
			$lsSQL = "UPDATE Usuarios SET Borrado=1 WHERE ID=:Id ";
			$lArray = array(":Id" => $aiId);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}

	public function UsuariosAsignarRoles($aiIdUser = 0, $asRoles = "")
	{
		$liRes = 0;
		if($aiIdUser > 0)
		{
			// Eliminamos sus roles
			$lsSQL = "DELETE FROM usuariosRoles WHERE IdUsuario=:IdUsuario";
			$lArray = array(":IdUsuario" => $aiIdUser);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			// Ahora obtenemos la lista de ids de los roles
			//$lsLista = explode(",", $asRoles);
			//$lsSQL = "SELECT nombre FROM roles where nombre in (:Roles)";
			$lsSQL = "INSERT INTO usuariosRoles (IdUsuario, IdRol) SELECT $aiIdUser, id FROM roles where FIND_IN_SET(nombre, :Roles)";
			$lArray = array(":Roles" => $asRoles);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);

			$liRes = $result->rowCount();
		}
		return $liRes;
	}
	// BLOQUE Usuarios

	// BLOQUE Proyectos
	public function ProyectosObtenerPagina($asWhere = array(), $aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		$lList = array();
		$_PreparePDO = null;
		$lsSQL = "";
		try
		{
			//Comprobaciones
			$lsSort = " ORDER BY ";
			$lsLimit = $this->ObtenLimit($aiPaginaActual, $aiItemsPorPagina);
			
			$validColumns = array( "id", "titulo", "alumno", "tutor", "fecha", "curso", "ciclo", "grupo", "valoracion", "modulos", "cualidades" );
			$campoOrdenacion = strtolower($asCampoOrdenacion);
			if(in_array($campoOrdenacion, $validColumns))
			{
				if($campoOrdenacion == "alumno"){
					$lsSort .= "b.nombre";
				}
				else if($campoOrdenacion == "tutor"){
					$lsSort .= "c.nombre";
				}
				else if($campoOrdenacion == "modulos"){
					//$lsSort .= "c.nombre";
				}
				else if($campoOrdenacion == "cualidades"){
					//$lsSort .= "c.nombre";
				}
				else
				{
					$lsSort .= "a.".$asCampoOrdenacion;
				}
			}
			else
			{
				$lsSort .= "a.titulo";
			}
			$lsSort .= $this->ObtenOrder($asTipoOrdenacion);
			
			// Ojo, tenemos que procesar el asWhere para obtener un array de valores
			// y asi usar la parametrizacion de PDO
			
			$lsSQL = "SELECT A.Id, A.Titulo, A.Fecha, A.IdAlumno, B.Nombre as Alumno, A.IdTutor, C.Nombre as Tutor, A.Curso, A.Ciclo, A.Grupo, A.Resumen, A.Herramientas,";
			$lsSQL .= " A.Comentarios, A.Valoracion, A.Borrado, D.Cualidades, E.Modulos, D.idCualidades, E.idModulos";
			$lsSQL .= " FROM proyectos A";
			$lsSQL .= " LEFT JOIN Usuarios B ON A.IdAlumno = B.Id"; 
			$lsSQL .= " LEFT JOIN Usuarios C ON A.IdTutor = C.Id"; 
			$lsSQL .= " LEFT JOIN (SELECT A.idproyecto, GROUP_CONCAT(b.id SEPARATOR ',') AS idCualidades, GROUP_CONCAT(b.nombre SEPARATOR ',') AS Cualidades FROM ProyectosCualidades A left join Cualidades B on A.idCualidad = b.id GROUP BY A.idProyecto) D ON D.IdProyecto = A.Id";
			$lsSQL .= " LEFT JOIN (SELECT A.idproyecto, GROUP_CONCAT(b.id SEPARATOR ',') AS idModulos, GROUP_CONCAT(b.nombre SEPARATOR ',') AS Modulos FROM ProyectosModulos A left join Modulos B on A.idModulo = b.id GROUP BY A.idProyecto) E ON E.IdProyecto = A.Id";
			
			$lsSQL .= " WHERE A.Borrado=0";
			
			if (Count($asWhere) > 0)
			{
				$lsSQL .= " AND ".$asWhere->Where;
				$_PreparePDO = $asWhere->ArrayWhere;
			}
			$lsSQL .= $lsSort.$lsLimit.";";
			$lsSQL = strtolower($lsSQL);
			$result = $this->prepare($lsSQL);
			$result->execute($_PreparePDO);

			$cuenta = $result->rowCount();
			if ($result && $cuenta>0) {
				foreach ($result as $valor) {
					$Item = new ProyectoModel();
					$Item->Id = sanitizar(obtenParametroArray($valor, "id"));
					$Item->IdAlumno = sanitizar(obtenParametroArray($valor, "idalumno"));
					$Item->Alumno = sanitizar(obtenParametroArray($valor, "alumno"));
					$Item->IdTutor = sanitizar(obtenParametroArray($valor, "idtutor"));
					$Item->Tutor = sanitizar(obtenParametroArray($valor, "tutor"));
					$Item->Titulo = sanitizar(obtenParametroArray($valor, "titulo"));
					$Item->Fecha = sanitizar(obtenParametroArray($valor, "fecha"));
					$Item->Curso = sanitizar(obtenParametroArray($valor, "curso"));
					$Item->Ciclo = sanitizar(obtenParametroArray($valor, "ciclo"));
					$Item->Grupo = sanitizar(obtenParametroArray($valor, "grupo"));
					$Item->Resumen = sanitizar(obtenParametroArray($valor, "resumen"), true);
					$Item->Herramientas = sanitizar(obtenParametroArray($valor, "herramientas"), true);
					$Item->Comentarios = sanitizar(obtenParametroArray($valor, "comentarios"), true);
					$Item->Valoracion = sanitizar(obtenParametroArray($valor, "valoracion"));
					// 
					$Item->Cualidades = sanitizar(obtenParametroArray($valor, "cualidades"));
					$Item->IdCualidades = sanitizar(obtenParametroArray($valor, "idcualidades"));
					$Item->Modulos = sanitizar(obtenParametroArray($valor, "modulos"));
					$Item->IdModulos = sanitizar(obtenParametroArray($valor, "idmodulos"));
					$Item->Borrado = ConexionBD::ObtenerSioNo(sanitizar(obtenParametroArray($valor, "borrado")));
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

	public function ProyectosCount($asWhere = array())
	{
		$liId = -1;
		$_PreparePDO = null;
		// Preparamos la SQL
		$lsSQL = "SELECT Count(1) as Cantidad";
		$lsSQL .= " FROM proyectos A";
		$lsSQL .= " LEFT JOIN Usuarios B ON A.IdAlumno = B.Id"; 
		$lsSQL .= " LEFT JOIN Usuarios C ON A.IdTutor = C.Id"; 
		$lsSQL .= " LEFT JOIN (SELECT A.idproyecto, GROUP_CONCAT(b.nombre SEPARATOR ',') AS Cualidades FROM ProyectosCualidades A left join Cualidades B on A.idCualidad = b.id GROUP BY A.idProyecto) D ON D.IdProyecto = A.Id";
		$lsSQL .= " LEFT JOIN (SELECT A.idproyecto, GROUP_CONCAT(b.nombre SEPARATOR ',') AS Modulos FROM ProyectosModulos A left join Modulos B on A.idModulo = b.id GROUP BY A.idProyecto) E ON E.IdProyecto = A.Id";

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

	public function ProyectosItem($aiId)
	{
		$Item = null;
		// Montamos el WherePDO para obtener este Id
		$lWherePDO = new WherePDO();
		$lWherePDO->Where = "a.id=:id";
		$lWherePDO->ArrayWhere = array(":id" => $aiId);
		
		$lResultados = $this->ProyectosObtenerPagina($lWherePDO);
		if($lResultados != null && Count($lResultados) > 0)
		{
			$Item = $lResultados[0];
		}

		return $Item;
	}
	
	public function ProyectosAñadir($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "INSERT INTO Proyectos (Titulo, IdAlumno, IdTutor, Curso, Ciclo, Grupo, Resumen, Herramientas, Comentarios, Valoracion)";
			$lsSQL .= " VALUES (:Titulo, :IdAlumno, :IdTutor, :Curso, :Ciclo, :Grupo, :Resumen, :Herramientas, :Comentarios, :Valoracion);";
			$lArray = array(":Titulo" => $aItem->Titulo, ":IdAlumno" => $aItem->IdAlumno, ":IdTutor" =>$aItem->IdTutor, ":Curso" =>$aItem->Curso, ":Ciclo" =>$aItem->Ciclo, ":Grupo" =>$aItem->Grupo, ":Resumen" =>$aItem->Resumen, ":Herramientas" =>$aItem->Herramientas, ":Comentarios" =>$aItem->Comentarios, ":Valoracion" =>$aItem->Valoracion );

			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
			//Eliminar los roles de este usuario y asignar los nuevos
			$aItem->Id = $this->lastInsertId();
			$this->ProyectosAsignarCualidades($aItem->Id, $aItem->Cualidades) + $this->ProyectosAsignarModulos($aItem->Id, $aItem->Modulos);
			
		}
		return $liRes;
	}
    
	public function ProyectosModificar($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "UPDATE Proyectos SET Titulo=:Titulo, IdAlumno=:IdAlumno, IdTutor=:IdTutor, Curso=:Curso, Ciclo=:Ciclo, Grupo=:Grupo, Resumen=:Resumen, Herramientas=:Herramientas, Comentarios=:Comentarios, Valoracion=:Valoracion WHERE ID=:Id ";
			$lArray = array(":Titulo" => $aItem->Titulo, ":IdAlumno" => $aItem->IdAlumno, ":IdTutor" => $aItem->IdTutor, ":Curso" => $aItem->Curso, ":Ciclo" => $aItem->Ciclo, ":Grupo" => $aItem->Grupo, ":Resumen" => $aItem->Resumen, ":Herramientas" => $aItem->Herramientas, ":Comentarios" => $aItem->Comentarios, ":Valoracion" => $aItem->Valoracion, ":Id" => $aItem->Id);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);

			//Eliminar los roles de este usuario y asignar los nuevos
			$liRes = $result->rowCount() + $this->ProyectosAsignarCualidades($aItem->Id, $aItem->Cualidades) + $this->ProyectosAsignarModulos($aItem->Id, $aItem->Modulos);
		}
		return $liRes;
	}

	public function ProyectosEliminar($aiId = 0)
	{
		$liRes = 0;
		if($aiId > 0)
		{
			$lsSQL = "UPDATE Proyectos SET Borrado=1 WHERE ID=:Id ";
			$lArray = array(":Id" => $aiId);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}

	
	public function ProyectosAsignarCualidades($aiId = 0, $asCualidades = "")
	{
		$liRes = 0;
		if($aiId > 0)
		{
			// Eliminamos 
			$lsSQL = "DELETE FROM ProyectosCualidades WHERE IdProyecto=:IdProyecto";
			$lArray = array(":IdProyecto" => $aiId);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);

			// Ahora obtenemos la lista de ids 
			$lsSQL = "INSERT INTO ProyectosCualidades (IdProyecto, IdCualidad) SELECT $aiId, id FROM Cualidades where FIND_IN_SET(id, :Cualidades)";
			$lArray = array(":Cualidades" => $asCualidades);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);

			$liRes = $result->rowCount();
		}
		return $liRes;
	}
	public function ProyectosAsignarModulos($aiId = 0, $asModulos = "")
	{
		$liRes = 0;
		if($aiId > 0)
		{
			// Eliminamos 
			$lsSQL = "DELETE FROM ProyectosModulos WHERE IdProyecto=:IdProyecto";
			$lArray = array(":IdProyecto" => $aiId);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			// Ahora obtenemos la lista de ids 
			$lsSQL = "INSERT INTO ProyectosModulos (IdProyecto, IdModulo) SELECT $aiId, id FROM Modulos where FIND_IN_SET(id, :Modulos)";
			$lArray = array(":Modulos" => $asModulos);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);

			$liRes = $result->rowCount();
		}
		return $liRes;
	}
	// BLOQUE Proyectos

	// BLOQUE ProyectosArchivos
	public function ProyectosArchivosObtenerPagina($asWhere = array(), $aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		$lList = array();
		$_PreparePDO = null;
		$lsSQL = "";
		try
		{
			//Comprobaciones
			$lsSort = " ORDER BY ";
			$lsLimit = $this->ObtenLimit($aiPaginaActual, $aiItemsPorPagina);
			
			$validColumns = array( "id", "idproyecto", "tipo", "ruta" );
			if(in_array(strtolower($asCampoOrdenacion), $validColumns))
			{
				$lsSort .= $asCampoOrdenacion;
			}
			else
			{
				$lsSort .= "id";
			}
			$lsSort .= $this->ObtenOrder($asTipoOrdenacion);
			
			// Ojo, tenemos que procesar el asWhere para obtener un array de valores
			// y asi usar la parametrizacion de PDO
			$lsSQL = "SELECT Id, IdProyecto, Tipo, Ruta FROM ProyectosArchivos";
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
					$Item = new ProyectoArchivoModel();
					$Item->Id = sanitizar(obtenParametroArray($valor, "id"));
					$Item->IdProyecto = sanitizar(obtenParametroArray($valor, "idproyecto"));
					$Item->Tipo = sanitizar(obtenParametroArray($valor, "tipo"));
					$Item->Ruta = sanitizar(obtenParametroArray($valor, "ruta"));
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

	public function ProyectosArchivosCount($asWhere = array())
	{
		$liId = -1;
		$_PreparePDO = null;
		// Preparamos la SQL
		$lsSQL = "Select Count(1) as Cantidad FROM ProyectosArchivos";
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

	public function ProyectosArchivosItem($aiId)
	{
		$Item = null;
		// Montamos el WherePDO para obtener este Id
		$lWherePDO = new WherePDO();
		$lWherePDO->Where = "id=:id";
		$lWherePDO->ArrayWhere = array(":id" => $aiId);
		
		$lResultados = $this->ProyectosArchivosObtenerPagina($lWherePDO);
		if($lResultados != null && Count($lResultados) > 0)
		{
			$Item = $lResultados[0];
		}

		return $Item;
	}

	public function ProyectosArchivosAñadir($aItem = null)
	{
		$liRes = 0;
		if($aItem != null)
		{
			$lsSQL = "INSERT INTO ProyectosArchivos (IdProyecto, Tipo, Ruta)";
			$lsSQL .= " VALUES (:IdProyecto, :Tipo, :Ruta);";
			$lArray = array(":IdProyecto" => $aItem->IdProyecto, ":Tipo" => $aItem->Tipo, ":Ruta" => $aItem->Ruta);

			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}

	public function ProyectosArchivosEliminar($aiId = 0)
	{
		$liRes = 0;
		if($aiId > 0)
		{
			$lsSQL = "DELETE FROM ProyectosArchivos WHERE ID=:Id ";
			$lArray = array(":Id" => $aiId);
			$result = $this->prepare($lsSQL);
			$result->execute($lArray);
			
			$liRes = $result->rowCount();
		}
		return $liRes;
	}
	
	// BLOQUE ProyectosArchivos

	// BLOQUE ProyectosArchivosTipos
	public function ProyectosArchivosTiposObtenerPagina($asWhere = array(), $aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
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
			$lsSQL = "SELECT Id, Nombre FROM ProyectosArchivosTipos";
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
					$Item = new ProyectoArchivoTipoModel();
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

	public function ProyectosArchivosTiposCount($asWhere = array())
	{
		$liId = -1;
		$_PreparePDO = null;
		// Preparamos la SQL
		$lsSQL = "Select Count(1) as Cantidad FROM ProyectosArchivosTipos";
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

	public function ProyectosArchivosTiposItem($aiId)
	{
		$Item = null;
		// Montamos el WherePDO para obtener este Id
		$lWherePDO = new WherePDO();
		$lWherePDO->Where = "id=:id";
		$lWherePDO->ArrayWhere = array(":id" => $aiId);
		
		$lResultados = $this->ProyectosArchivosTiposObtenerPagina($lWherePDO);
		if($lResultados != null && Count($lResultados) > 0)
		{
			$Item = $lResultados[0];
		}

		return $Item;
	}
	// BLOQUE ProyectosArchivosTipos

	
	// BLOQUE PlantillaCorreo
	public function PlantillaCorreoObtenerPlantilla($asPlantilla = "")
	{
		$lList = array();
		$lsSQL = "";
		try
		{
			//Comprobaciones
			// y asi usar la parametrizacion de PDO
			$lsSQL = "SELECT Id, Nombre, Asunto, Descripcion FROM PlantillasCorreo";
			$lsSQL .= " WHERE Nombre ='".$asPlantilla."'";
			$lsSQL = strtolower($lsSQL);
			$result = $this->prepare($lsSQL);

			$result->execute();
		
			$cuenta = $result->rowCount();
			if ($result && $cuenta>0) {
				foreach ($result as $valor) {
					$Item = new PlantillaCorreoModel();
					$Item->Id = sanitizar(obtenParametroArray($valor, "id"));
					$Item->Nombre = sanitizar(obtenParametroArray($valor, "nombre"));
					$Item->Asunto = sanitizar(obtenParametroArray($valor, "asunto"),true);
					$Item->Descripcion = obtenParametroArray($valor, "descripcion");
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
	// BLOQUE PlantillaCorreo

	
	
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