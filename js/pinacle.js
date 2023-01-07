var gameui ='<div class="container" id="mainContainer">'+
' <div style="text-align: center;">' +
    ' <h1> <b>PINNACLE</b> </h1> </div>' +
    ' <div id="game" style="text-align: center;"> <div id="playerOne">' +
    ' <div id="playerOneName"> </div> <br> <table class="table" id="player1hand">' +
    ' </table> <div id="btns" style="padding: 5px;">' +
    ' <button type="button" onclick="pass()" disabled>Pass</button> ' +
    '<select name="cars" id="cars"> <option value="1card" id="cardtype" ondblclick="">1card</option>  <option value="3samecards" onclick="">3cards</option> + <option value="4samecards">4cards</option> <option value="sequence">sequence</option></select>'
    ' </div> <div class="col" id="playerTwo"> <div id="playerTwoName"></div> <br>' +
    ' <table id="player2hand"> </table> <div id="success"></div>' +
    ' <div id="colors_div"> </div>';
//θα πρέπει να δημιουργητε το ui του παιχνιδιου

$(function(){
    $("#btn2").click(login_to_game);
    });


   //kanei reset to paixnidi
function resetgame(){
    document.getElementById('success').innerHTML='new game has started'<br>
    $.ajax({
        type:'DELETE',
        url: "index.php/game/",
       
    });

} 


//PASS
function pass(){
    if(player.turn==1)
    $.ajax({
        url: "pinacle.php/game/play/",
        method:'PUT'
        
    });
}


function login_to_game(){
    if($('#username').val()==''){
        alert('No username given');
        return;
    }
    var txt = $('#username').val();
    $.ajax({
        url: "index.php/players/",
        method : 'POST',
        dataType : "json",
        contentType : 'application/json',
        data : JSON.stringify ({username : $('#username').val()}),
        success : $("#par").show()
        
    });
}

function login_result(data){
    console.log(data);
}
