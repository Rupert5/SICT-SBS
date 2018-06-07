function img_preview(source,display){
    
    var reader = new FileReader();
    reader.onload = function(){   display.src = reader.result;}
    
    if(source.files[0]) reader.readAsDataURL(source.files[0]);
    else display.src = null;
}
function $$(selector,context){
    context = context || document;
    var elements = context.querySelectorAll(selector);
    return Array.prototype.slice.call(elements);
}

function getAjax(url, success){
    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xhr.open('GET',url);
    xhr.onreadystatechange = function (){if(xhr.readyState>3 && xhr.status==200) success(xhr.responseText);};
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send();
    return xhr;
}
function postAjax(url,data, success){
    var params = typeof data == 'string' ? data : Object.keys(data).map(function(k){return encodeURIComponent(k)+'='+encodeURIComponent(data[k])}).join('&');
    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xhr.open('POST',url);
    xhr.onreadystatechange = function (){if(xhr.readyState>3 && xhr.status==200) success(xhr.responseText);};
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(params);
    return xhr;
}