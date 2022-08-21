$(document).ready(function(){

    $("#text-area").on("submit", function(e){
        data = {
            sender:$("input[name=sender]", $(this)).val(),
            reciever:$("input[name=reciever]", $(this)).val(),
            text:$("input[name=text]", $(this)).val(),
            message:'',
        }
        $.ajax({
            url: "../logic/chat.php",
            type: "POST",
            data: data,
            success: function(data){
                console.log(data)
                $("input[name=text]").val('')
            },
            error: function(rep){
                console.log(rep);
            }
        });
        e.preventDefault();
    });


    data = {
        sender:$("input[name=sender]", $(this)).val(),
        reciever:$("input[name=reciever]", $(this)).val(),
    }
    setInterval(function(){
        $.ajax({
            url: "../logic/chat.php",
            type: "GET",
            data: data,
            success: function(data){
                $("#user-chat").html(data)
            },
            error: function(rep){
                console.log(rep);
            }
        });
    }, 500)
});