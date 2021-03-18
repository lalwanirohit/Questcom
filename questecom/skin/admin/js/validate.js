$(document).ready(function(){

    $('#loginuser').validate({
        rules : {
            email : {
                required:true,
                email:true,
            },
            password : {
                required:true,
            },
        },
    });
});