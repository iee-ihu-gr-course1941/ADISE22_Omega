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
draw_empty_board();
    $("#btn2").click(function(){
        fill_board();
    });
});

function draw_empty_board() {
    var t='<table id="card_deck">';
    for(var i=0;i<1;i++) {
        t += '<tr>';
        for(var j=1;j<53;j++) {
            t += '<td class="cardDeck" id="cardCode">' + j +'</td>';
        }
        t+='</tr>';
    }
    t+='</table>';
    $('#div1').html(t);
    }
  

function fill_board() {
	$.ajax(
        {url: "pinacle.php/cards/", 
		success: $("#div1").text("hello") 
        }
    );
}

function fill_board_by_data(data){
    for(var i=0;i<data.length;i++) {
        var o = data[i];
    }    
}

function fill_game() {
    $.ajax({
        type: 'DELETE',
        url: "index.php/gamestatus/",
        
    });
}

function resetgame(){
    document.getElementById('success').innerHTML='new game has started'<br>
    $.ajax({
        type:'DELETE',
        url: "index.php/game/",
        success: fill_game_by_data
    });

}


function drawcard(){
    $.ajax({
    type:'POST',
    url: "pinacle.php/game/draw",
    success:fill_game_by_data
    });

}


 
function pass(){
    if(player.turn==1)
    $.ajax({
        url: "pinacle.php/game/play/",
        method:'PUT'
        
    });
}

function playcard(){
    var card = document.getElementById("cardtype");
    var selectedValue = card.options[card.selectedIndex].value;
    if (selectedValue == "1card"){
        $.ajax({
            type: 'POST',
            url: "index.php/playcard/",
            data: JSON.stringify({
                x: username.value
            }), 
        })
   
}
 }
 function generateGame() { //ftiaxnei to ui, kai kanei update info
    document.getElementById('mainContainer').innerHTML = gameUI;
    updateInfo();
}
