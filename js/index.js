$(function(){
    $("form").on("submit",function(event){
        event.preventDefault();
 
        $.ajax({
            type:'post',
            url:'php/login.php',
            /*beforeSend:function(){
                $("#result").append("loading");
            },*/
            data:$('form').serialize(),
 
            success:function(data){
                alert(data['result']);
                //alert(data['result2']); 
                $(location).attr('href', data.gotoPage);
                
                
            },
            error:function(err){
                console.log(err);
            }
        })
    })
 })