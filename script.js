
var root = document.querySelector(':root');
var lightbtn = document.getElementsByClassName('fa-sun-o')[0];
var darkbtn = document.getElementsByClassName('fa-moon-o')[0];

function setCookie(cname, cvalue, exdays){
    var d = new Date();
    d.setTime(d.getTime() + exdays*24*60*60*1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires;
}

function getCookie(cname){
    var mode = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++){
        var c = ca[i].trim();
        if (c.indexOf(mode)==0) return c.substring(mode.length,c.length);
    }
    return "";
}

function dark(){
    root.classList.add("dark");
    setCookie('mode','dark',30);
}
function light(){
    root.classList.remove("dark");
    setCookie('mode','light',30);
}

function Cookie(){
    var mode = getCookie('mode');
    if(mode==""){
        setCookie('mode','light',30);
    }else{
        if(mode=="light"){
            light();
        }else{
            dark();
        };
    }
}

lightbtn.addEventListener('click', light);
darkbtn.addEventListener('click', dark);

window.onload = Cookie;
