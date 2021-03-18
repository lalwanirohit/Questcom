$(document).ready(function(){

    $('#registeruser').validate({
        rules : {
            prefix: {
                required:true,
            },
            firstname : {
                required:true,
            },
            lastname : {
                required:true,
            },
            mobilenumber : {
                required:true,
            },
            email : {
                required:true,
                email:true,
            },
            password : {
                required:true,
            },
            password2 : {
                required:true,
                equalTo:"#password", 
            },
            information : {
                required:true,
            },
            'terms[]' : {
                required:true,
            },
        },
    });
});