<?php
require_once "php/dbconnect.php";

#require_once "php/board.php";
$method=$_SERVER['REQUEST_METHOD'];
$input=json_decode(file_get_contents('php://input'),true);

$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$resource = $request[0];

#print "\n METHOD " . $method .  "\n";

#print "\n REQUEST_BODY \n";
#print_r($input);
#print "\n REQUEST RESOURCE\n";
#print_r($resource);



if ($resource == "players") {
	if ($method == "POST") {
		print "Posting players resource";
		
	}
	if ($method == "GET") {
		print "Getting players resource";
	}
	
}

 if ($resource == "newgame") {
	if ($method == "POST") {
		print "starting new game";
		print "cards assignments";
		header('HTTP/1.1 201 Created');
	}
} 
 if ($resource == "cards") {
	if ($method == "GET") {
		if (isset($_GET["playerid"])) {
			$id = $_GET["playerid"];
			
		}else {
			print "something wrong";
			
		}
	}
		
		print "getting cards for player with id " . $id;
		
	}
	if ($method == "POST") {
		print "starting new game";
		print "cards assignments";
	}
	
	
	if ($resource == "setuser"){
		if ($method == "POST"){
			require_once "php/users.php";
			print "posting player";
			set_user($input);
		}
				
} 

	if ($resource == "getplayers"){
		if ($method == "GET"){
			require_once "php/users.php";
			print "showing all player";
			show_users();
		}
		
		
}


if ($resource == "getplayer"){
	if($method == "GET"){
		require_once "php/users.php";
		print "showing specific player";
		show_user($input);
		
	}
}
		
		

if ($resource == "handleuser"){
	require_once "php/users.php";
	handle_user("POST",$playerid,$input);
		 
}


if($resource=="resetgame"){
	if ($method=="POST"){
	require_once "php/board.php";
	reset_game();
	print "Game has been reseted";	
		
	}
}

if ($resource=="gamestatus"){
	if ($method=="GET"){
			require_once "php/board.php";
			show_status();
			echo nl2br ("Game status");
	}
	
}	

if ($resource=="showcards"){
	if($method=="GET"){
		require_once "php/board.php";
		show_cardgame($input);
		echo nl2br ("Players with theese cards");
	}
}
	
	
if ($resource=="drawcard"){
	if ($method=="POST"){
		require_once "php/board.php";
		draw_card($input);
		#echo nl2br ("draws card");
	}
}
if ($resource=="showgame"){
	if ($method=="POST"){
		require_once "php/board.php";
		show_game($input);
	}
}
		
	




//τελος γυρου και αλλγη σειρας
if($resource=="endturn"){
	if($method=="POST"){
		require_once "php/game.php";
	}
}

if($resource=="pass"){
	if($method=="POST"){
		pass();
}
}

function pass() {
        global $mysqli;
        $sql = 'call playerTurn()';
        $st = $mysqli->prepare($sql);
        $st -> execute();
        
        $sql = 'SELECT cardCode FROM discarded_cards WHERE number = (SELECT MAX(number) FROM discarded_cards)';
	$sm = $mysqli -> prepare($sql);
	$sm -> execute();
	$rem = $sm -> get_result();
	$ren = $rem -> fetch_assoc();

	show_game($ren['cardCode']);
}

?>