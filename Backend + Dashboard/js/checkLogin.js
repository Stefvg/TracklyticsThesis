$(function() {
    $.ajax({url: 'https://svg-apache.iminds-security.be/php/authentication/checkAuthentication.php', success: function(data){
        if(data=="ILLEGAL"){
            window.location.replace("https://svg-apache.iminds-security.be/login.html?error=1");
        }
    }});


    var app = location.search.split('app=')[1];
    var apps = decodeURIComponent(app);
    if(app && apps && app.length >1 && apps.length>0){
        checkIfAccess(app);
    }

});


function checkIfAccess(app) {
    $.ajax({url: 'https://svg-apache.iminds-security.be/php/authentication/checkAccess.php?app=' + app, success: function(data){
        console.log(data);

        if(data=="ILLEGAL"){
            window.location.replace("https://svg-apache.iminds-security.be/index.html?error=2");
        }
    }});

}