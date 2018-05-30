var loc = window.location.href;
var dir = loc.substring(0, loc.lastIndexOf('/'));

var xmlhttp;
xmlhttp = new XMLHttpRequest();

function connect(){
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementById('result').innerHTML= xmlhttp.responseText;
        }
    };
    if(document.getElementById('mysql').checked){
        xmlhttp.open('GET', dir+'/controller/connect_db.php', true);
    }else{
        xmlhttp.open('GET', dir+'/controller/connect_db_pg.php', true);
    }
    xmlhttp.send();
}

function check_table_coins(){
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementById('table_coins_status').innerHTML= xmlhttp.responseText;
        }
    };
    if(document.getElementById('mysql').checked){
        xmlhttp.open('GET', dir+'/controller/check_table_coins.php', true);
    }else{
        xmlhttp.open('GET', dir+'/controller/check_table_coins_pg.php', true);
    }
    xmlhttp.send();
}

function check_table_data(){
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementById('table_data_status').innerHTML= xmlhttp.responseText;
        }
    };
    if(document.getElementById('mysql').checked){
        xmlhttp.open('GET', dir+'/controller/check_table_data.php', true);
    }else{
        xmlhttp.open('GET', dir+'/controller/check_table_data_pg.php', true);
    }
    xmlhttp.send();
}

function create_table_coins(){
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementById('create_coins_status').innerHTML= xmlhttp.responseText;
        }
    };
    if(document.getElementById('mysql').checked){
        xmlhttp.open('GET', dir+'/controller/create_table_coins.php', true);
    }else{
        xmlhttp.open('GET', dir+'/controller/create_table_coins_pg.php', true);
    }
    xmlhttp.send();
}

function create_table_data(){
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementById('create_data_status').innerHTML= xmlhttp.responseText;
        }
    };
    if(document.getElementById('mysql').checked){
        xmlhttp.open('GET', dir+'/controller/create_table_data.php', true);
    }else{
        xmlhttp.open('GET', dir+'/controller/create_table_data_pg.php', true);
    }
    xmlhttp.send();
}


function fill_table_coins(){
    if(document.getElementById('mysql').checked){
        window.location.assign(dir+'/controller/fill_table_coins.php');
    }else{
        window.location.assign(dir+'/controller/fill_table_coins_pg.php');
    }
}


function fill_table_data(){
    if(document.getElementById('mysql').checked){
        window.location.assign(dir+'/controller/fill_table_data.php');
    }else{
        window.location.assign(dir+'/controller/fill_table_data_pg.php');
    }
}


function drop_table_coins(){
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementById('drop_coins_status').innerHTML= xmlhttp.responseText;
        }
    };
    if(document.getElementById('mysql').checked){
        xmlhttp.open('GET', dir+'/controller/drop_table_coins.php', true);
    }else{
        xmlhttp.open('GET', dir+'/controller/drop_table_coins_pg.php', true);
    }
    xmlhttp.send();
}

function drop_table_data(){
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementById('drop_data_status').innerHTML= xmlhttp.responseText;
        }
    };
    if(document.getElementById('mysql').checked){
        xmlhttp.open('GET', dir+'/controller/drop_table_data.php', true);
    }else{
        xmlhttp.open('GET', dir+'/controller/drop_table_data_pg.php', true);
    }
    xmlhttp.send();
}


function data_status(){
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementById('data_status').innerHTML= xmlhttp.responseText;
        }
    };
    if(document.getElementById('mysql').checked){
        xmlhttp.open('GET', dir+'/controller/data_status.php', true);
    }else{
        xmlhttp.open('GET', dir+'/controller/data_status_pg.php', true);
    }
    xmlhttp.send();
}

function data_atualize(){
    if(document.getElementById('mysql').checked){
        window.location.assign(dir+'/controller/data_atualize.php');
    }else{
        window.location.assign(dir+'/controller/data_atualize_pg.php');
    }
}

function plot(pair){
        var w = 1000;
        var h = 500;
        var left = Number((window.innerWidth/2)-(w/2));
        var tops = Number((window.innerHeight/2)-(h/2));

winops = window.open("query_db_plot.php/?pair="+pair, '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+tops+', left='+left);
winops.focus();
}

function run(){

    if(document.getElementById('mysql').checked){
        window.location.assign(dir+'/controller/loop_table.php');
    }else{
        window.location.assign(dir+'/controller/loop_table_pg.php');
    }
}