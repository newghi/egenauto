<?php
class EchoMeta{
	
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
		
		echo $this->title;
		
	}
	public function description(){
		
		echo $this->description;
		
	}
	public function author(){
		
		echo $this->author;
		
	}
	public function robots(){
		
		echo $this->robots;
		
	}
	public function keyword(){
		
		echo $this->keyword;
		
	}
	public function site_title(){
		
		echo $this->site_title;
		
	}
	public function content(){
		
		echo $this->content;
		
	}

	// 메뉴를 출력 한다.
	public function menu($ul = '', $li = '', $a = ''){//보류
	
	if ($ul != '') {$ul = ' '.$ul;}
	if ($li != '') {$li = ' '.$li;}	
	if ($a != '') {$a = ' '.$a;}

	//디비연결
    error_reporting(1);
    ini_set("display_errors", 1);
    
    $db_connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    /* DB 연결 확인 */
    if(mysqli_connect_error())
    {
        echo "mysql 접속중 오류가 발생했습니다. ";
        echo mysqli_connect_error();
    }

	$query_board = "SELECT * FROM `egb_board` where board_mark = 'menu' order by board_menu_number";
	$result_board = mysqli_query( $db_connect, $query_board);

	echo '<ul'.$ul.'>';

	while($sql_board =  mysqli_fetch_array( $result_board )){

		echo "<li".$li."><a ".$a."href='".$sql_board['board_url']."'>".$sql_board['board_post_title']."</a></li>";
		
	}

	echo '</ul>';

	mysqli_close($db_connect);
		
	}

	// 메뉴를 출력 한다.
	public function ad($ad_number = '', $css = ''){//보류
		
	if ($css != '') {$css = ' '.$css;}
	
	//디비연결
    error_reporting(1);
    ini_set("display_errors", 1);
    
    $db_connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    /* DB 연결 확인 */
    if(mysqli_connect_error())
    {
        echo "mysql 접속중 오류가 발생했습니다. ";
        echo mysqli_connect_error();
    }

	$query_board = "SELECT * FROM `egb_board` where board_mark = 'ad' and board_menu_number= '$ad_number'";
	$result_board = mysqli_query( $db_connect, $query_board);

	echo '<div '.$css.'>';

	while($sql_board =  mysqli_fetch_array( $result_board )){

		echo $sql_board['board_post_content'];
		
	}

	echo '</div>';

	mysqli_close($db_connect);
		
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
		
		echo $ipaddress;
	}


}//EchoMeta;

function egb_get($info, $var1 = '', $var2 = '', $var3 = ''){
	
	$meta = new GetMeta();
	
	return $meta->$info($var1, $var2, $var3);
	
}//egb_get($info, $var1 = '', $var2 = '', $var3 = '');

function egb_echo($info, $var1 = '', $var2 = '', $var3 = ''){
	
	$meta = new EchoMeta();
	
	return $meta->$info($var1, $var2, $var3);
	
}//egb_echo($info, $var1 = '', $var2 = '', $var3 = '');

?>