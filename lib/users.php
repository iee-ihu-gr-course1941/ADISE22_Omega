<?php
function set_user($input) {
    if(!isset($input['username']) || $input['username']=='') {
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg'=>"No username given."]);
        exit;
    }
    $username = $input['username'];
    global $mysqli;
    $sql = 'SELECT COUNT() AS num FROM players WHERE username IS NOT NULL';
    $st = $mysqli -> prepare($sql);
    $st -> execute();
    $res = $st -> get_result();
    $r = $res -> fetch_all(MYSQLI_ASSOC); 
    if($r[0]['num']==2) {
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg'=>"Player number is full"]);
        exit;
    }
        $sql = 'UPDATE players SET username = ?, token = MD5(concat(?,NOW()) WHERE username IS NULL';
        $st2 = $mysqli -> prepare($sql);
        $st2 -> bind_param('ss', $username,$username);
        $st2 -> execute();

        update_game_status();
    $sql = 'select from players where username = ?';
        $st = $mysqli->prepare($sql);
    $st->bind_param('s',$username);
    $st->execute();
    $res = $st->get_result();
    header('Content-type: application/json');
    print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

} 


function show_users() {
    global $mysqli;
    $sql = 'select username,playerId from players';
    $st = $mysqli->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    header('Content-type: application/json');
    print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}


function handle_user($method, $pId, $input) {
    if($method=='GET') {
        show_user($pId);
    } else if($method=='PUT') {
        set_user($input);
    }
}


?>