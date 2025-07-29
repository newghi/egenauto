<?php
class GetMeta{
	
	public $title;
	public $description;
	public $author;
	public $robots;
	public $keyword;
	public $site_title;
	public $content;
	public $style;
	public $jquery;
	public $smarteditor2;
	
	public function __construct(){
		
		$this->title = $_SESSION['mata_title'] ?? null;
		$this->description = $_SESSION['mata_description'] ?? null;
		$this->author = $_SESSION['mata_author'] ?? null;
		$this->robots = $_SESSION['mata_robots'] ?? null;
		$this->keyword = $_SESSION['mata_keyword'] ?? null;
		$this->site_title = $_SESSION['site_title'] ?? null;
		$this->content = $_SESSION['return_content'] ?? null;
		$this->style = $_SESSION['style'] ?? null;
		$this->jquery = $_SESSION['meta_jquery'] ?? null;
		$this->smarteditor2 = $_SESSION['smarteditor2'] ?? null;
		
	}
	
	public function title(){
		
		return $this->title;
		
	}

	public function description(){
	
		return $this->description;
		
	}

	public function author(){
	
		return $this->author;
		
	}

	public function robots(){
	
		return $this->robots;
		
	}

	public function keyword(){
	
		return $this->keyword;
		
	}

	public function site_title(){
	
		return $this->site_title;
		
	}

	public function content(){
	
		return $this->content;
		
	}

	public function ip() {
		
		$ipaddress = '';
			if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
			else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
			else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
			else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
			else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
			else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
			else
		$ipaddress = 'UNKNOWN';
		
		return $ipaddress;
		
	}

	public function db() {
		
		$db_host = DB_HOST; // 호스트명
		$db_user = DB_USER; // 계정명
		$db_password = DB_PASSWORD; // 비밀번호
		$db_name = DB_NAME; // 데이터베이스명
		$db_charset = "utf8mb4"; // 문자셋

		$dsn = "mysql:host={$db_host};dbname={$db_name};charset={$db_charset}";

		$options = array(
		  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		  PDO::ATTR_EMULATE_PREPARES => false
		);

		try {
		  $pdo = new PDO($dsn, $db_user, $db_password, $options);
		} catch(PDOException $e) {
		  echo "mysql 접속중 오류가 발생했습니다. ";
		  echo $e->getMessage();
		}

		return $pdo;
		
	}

	public function __destruct(){
		
	}// 함수 소멸시 자동 실행

}//GetMeta;

?>