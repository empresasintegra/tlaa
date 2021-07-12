var ancho , alto , cCeldas , celdas , pasoH , pasoV;

function iniciar(){
celdas0 = document.getElementById("encCol").getElementsByTagName("td").length;
celdas1 = document.getElementById("contenido").getElementsByTagName("td").length;

for (i=0; i<celdas0;i++){
cCeldas = document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML;
document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML = cCeldas+"<img class=\"rell\">";
}

for (j=0; j<celdas1;j++){
cCeldas = document.getElementById("contenido").getElementsByTagName("td").item(j).innerHTML;
document.getElementById("contenido").getElementsByTagName("td").item(j).innerHTML = cCeldas+"<img class=\"rell\">";
}
}

function desplaza(){
pasoH = document.getElementById("contenedor").scrollLeft;
pasoV = document.getElementById("contenedor").scrollTop;
document.getElementById("contEncCol").scrollLeft = pasoH;
document.getElementById("contEncFil").scrollTop = pasoV;
}