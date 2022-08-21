$(document).ready(function(){
    setInterval(function(){
        $.ajax({
            url: "../logic/users.php",
            type: "GET",
            success: function(data){
                $("#all-users").html(data);
            },
            error: function(rep){
                console.log(rep);
            }
    
        });
    }, 500)
});