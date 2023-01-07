

$(function(){
    $("#btn2").click(login_to_game);
    });




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