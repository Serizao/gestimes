 <?php
 class bdd
  {
     //variable de connexion a la bdd
    private $_host = "127.0.0.1";
    private $_user = "root";
    private $_pass = "root";
    private $_base = "time"; 


	public function __construct() //connection a la base de donnée dans la classe
	{
		$this->_pdo = new PDO(
		'mysql:host='.$this->_host.';dbname='.$this->_base,
		$this->_user,
		$this->_pass);

	}

    public function tab($sql, $data)
    {
		$i=0;
		if(isset($data) and !empty($data))
		{
			$stmt = $this->_pdo->prepare($sql);
			$taille=count($data);
			for($s=0;$s<$taille;$s++)
			{
				$i++;
				$stmt->bindParam($i, $data[$s], PDO::PARAM_STR);
			}
			$stmt->execute();
			$result[]=$stmt->fetchAll();
			$result[]=$stmt;
			return $result;
		}
		else
		{

			$stmt = $this->_pdo->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetchAll();
			return $result;
		}
    }

    public function lastid()
    {
		return  $this->_pdo->lastInsertId();
    }
	public function countcol($i)
	{
		return $i->columnCount();
	}
	public function countrow($i)
	{
		return $i->rowCount();
	}


  }
  ?>