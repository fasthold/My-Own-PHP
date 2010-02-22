<?php
/**
 * 
 */


/**
 * @example: 
 *
 * $db = new Pdo_Mysql(array('host'=>'localhost','username'=>'root','password'=>'','dbname'=>'uker_access'));
 * $data = $db->fetchAll("select * from pe_article limit 10");
 * print_r($data);
 *
 *
 */
class Pdo_Mysql {
	
	protected $_params;
	
	/**
	 * PDO Object
	 *
	 * @var PDO
	 */
	private $_connection;
	
	/**
	 * Enter description here...
	 *
	 * @param array $params
	 * @return PDO
	 */
	public function __construct(array $params) {
		$this->_params = $params;
		$this->getConnection($this->_params);
	}
	
	public function getConnection() {
		if($this->_connection === null) {
			$connectionOptions = array();
			if(empty($this->_params['charset'])) {
				$this->_params['charset'] = 'gbk';
			}
			
			if(! $this->_connection = new PDO(
					'mysql:host='.$this->_params['host'].';dbname='.$this->_params['dbname'].'',
					$this->_params['username'],
					$this->_params['password'],
					array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$this->_params['charset']}")) ) {
				throw new PDOException("Can't connect to database");
			}
		}
		return $this->_connection;
	}
	
	public function fetchAll($sql) {
		$stmt = $this->_connection->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}
}