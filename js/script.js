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
    // xmlhttp.onreadystatechange = function(){
    //     if(xmlhttp.readyState==4 && xmlhttp.status==200){
    //     document.getElementById('fill_coins_status').innerHTML= xmlhttp.responseText;
    //     }
    // };
    // if(document.getElementById('mysql').checked){
    //     xmlhttp.open('GET', dir+'/controller/fill_table_coins.php', true);
    // }else{
    //     xmlhttp.open('GET', dir+'/controller/fill_table_coins_pg.php', true);
    // }
    // xmlhttp.send();
window.location.assign(dir+'/controller/fill_table_coins.php');
}


function fill_table_data(){
//     xmlhttp.onreadystatechange = function(){
//         if(xmlhttp.readyState==4 && xmlhttp.status==200){
//         document.getElementById('fill_data_status').innerHTML= xmlhttp.responseText;
//         }
//     };
//     if(document.getElementById('mysql').checked){
//         xmlhttp.open('GET', dir+'/controller/fill_table_data.php', true);
//     }else{
//         xmlhttp.open('GET', dir+'/controller/fill_table_data_pg.php', true);
//     }
//     xmlhttp.send();


window.location.assign(dir+'/controller/fill_table_data.php');
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