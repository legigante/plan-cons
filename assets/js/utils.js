/**
 * bordel de fonctions utiles
 */

function mpAjax(url, method, json, cb) {
    $.ajax({
        url: url,
        data: json,
        dataType: 'json',
        method: method,
        success: function (res) {
            cb(0, res);
        },
        error: function (res) {
            console.log('error ' + res.status + ' ' + res.statusText);
            console.log(res.responseText);
            cb(1, res.responseText);
        }
    });
}


function loading(show){
    var s = show ? 'block' : 'none';
    document.getElementById('mpCache').style.display = s;
    document.getElementById('mpLoading').style.display = s;
}



