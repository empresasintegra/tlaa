
function valida_numeros_mnts(e){
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8){
        return true;
    }
    patron =/[0-9:]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}


function valida_numeros_horas_extras(e){
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8){
        return true;
    }
    patron =/[0-9.]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

function valida_letras(e){
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8){
        return true;
    }
    patron =/[qwertyuiopasdfghjklñzxcvbnmQWERTYUIOPASDFGHJKLÑZXCVBNM1234567890 ]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

function confirmSubmit()
{
  var b = 0, chk=document.getElementsByName("select_eliminar[]")
    for(j=0;j<chk.length;j++) {
      if(chk.item(j).checked == false) {
        b++;
      }
    }
if(b == chk.length) {
  alert("Tiene que Seleccionar una o varias opciones a eliminar");
    return false;
  }
    else
  {
    var agree=confirm("Está seguro de eliminar este registro?");
      if (agree)
      return true;
      else
      return false;
  }
}

function multiplica(c, p, sb) {
var cantidad = parseInt(document.getElementById(c).value);
var unidades = parseInt(document.getElementById(p).value);
document.getElementById(sb).value = cantidad * unidades;
}






function multiplicar_series_productos() {
	var m1 = new Array(2)
	var m2 = new Array(2)
	var r = new Array(2)
m1[0] = document.getElementsByName("tamano").value;
m2[0] = document.getElementsByName("unidades").value;

r= (m1 * m2);
document.getElementsByName("total").value = r;
}



function suma_clasificadores(a, b, c, d, e, f, g, sb) {
var clasificadores = parseInt(document.getElementById(a).value);
var grueros_clasif = parseInt(document.getElementById(b).value);
var revision_pallet = parseInt(document.getElementById(c).value);
var pernord_ricard_clasif = parseInt(document.getElementById(d).value);
var reempaque = parseInt(document.getElementById(e).value);
var control_merma_clasif = parseInt(document.getElementById(f).value);
var supervisores_clasif = parseInt(document.getElementById(g).value);
document.getElementById(sb).value = clasificadores + grueros_clasif + revision_pallet + pernord_ricard_clasif + reempaque + control_merma_clasif + supervisores_clasif;
}


function suma_picking(a, b, c, d, e, f, g, sb) {
var pickeadores = parseInt(document.getElementById(a).value);
var volanteros = parseInt(document.getElementById(b).value);
var grueros_picking = parseInt(document.getElementById(c).value);
var parrilleros = parseInt(document.getElementById(d).value);
var control_merma_picking = parseInt(document.getElementById(e).value);
var pernord_ricard_picking = parseInt(document.getElementById(f).value);
var supervisores_picking = parseInt(document.getElementById(g).value);
document.getElementById(sb).value = pickeadores + volanteros + grueros_picking + parrilleros + control_merma_picking + pernord_ricard_picking + supervisores_picking;
}


function multiplicar_dos_valores(a, b, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
document.getElementById(sb).value = valor1 * valor2;
}



function calculo_no_clasificadas(a, b, c, d, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
var valor3 = parseInt(document.getElementById(c).value);
var valor4 = parseInt(document.getElementById(d).value);
document.getElementById(sb).value = valor1 + valor2 - valor3 - valor4;
}



function dividir_dos_valores(a, b, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
document.getElementById(sb).value = Math.round(valor1 / valor2);
}


function calcular_mnts_empleados(a, b, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
document.getElementById(sb).value = Math.round(((valor1 - valor2)*24*60) / 24);
}

function sumar_dos_valores(a, b, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
document.getElementById(sb).value = valor1 + valor2;
}


function dividir_dos_valores_2(a, b, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
document.getElementById(sb).value = Math.round(valor1 / (valor2));
}



function dividir_dos_valores(a, b, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
document.getElementById(sb).value = Math.round((valor1 / valor2) * 100);
}

function dividir_dos_valores1(a, b, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
document.getElementById(sb).value = Math.round(valor1 / valor2);
}


function sumar_tres_valores(a, b, c, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
var valor3 = parseInt(document.getElementById(c).value);
document.getElementById(sb).value = valor1 + valor2 + valor3;
}


function sumar_nueve_valores(a, b, c, d, e, f, g, h, i, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
var valor3 = parseInt(document.getElementById(c).value);
var valor4 = parseInt(document.getElementById(d).value);
var valor5 = parseInt(document.getElementById(e).value);
var valor6 = parseInt(document.getElementById(f).value);
var valor7 = parseInt(document.getElementById(g).value);
var valor8 = parseInt(document.getElementById(h).value);
var valor9 = parseInt(document.getElementById(i).value);
document.getElementById(sb).value = valor1 + valor2 + valor3 + valor4 + valor5 + valor6 + valor7 + valor8 + valor9;
}

function sumar_once_valores(a, b, c, d, e, f, g, h, i, j, k, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
var valor3 = parseInt(document.getElementById(c).value);
var valor4 = parseInt(document.getElementById(d).value);
var valor5 = parseInt(document.getElementById(e).value);
var valor6 = parseInt(document.getElementById(f).value);
var valor7 = parseInt(document.getElementById(g).value);
var valor8 = parseInt(document.getElementById(h).value);
var valor9 = parseInt(document.getElementById(i).value);
var valor10 = parseInt(document.getElementById(j).value);
var valor11 = parseInt(document.getElementById(k).value);
document.getElementById(sb).value = valor1 + valor2 + valor3 + valor4 + valor5 + valor6 + valor7 + valor8 + valor9 + valor10 + valor11;
}


function sumar_catorce_valores(a, b, c, d, e, f, g, h, i, j, k, l, m, n, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
var valor3 = parseInt(document.getElementById(c).value);
var valor4 = parseInt(document.getElementById(d).value);
var valor5 = parseInt(document.getElementById(e).value);
var valor6 = parseInt(document.getElementById(f).value);
var valor7 = parseInt(document.getElementById(g).value);
var valor8 = parseInt(document.getElementById(h).value);
var valor9 = parseInt(document.getElementById(i).value);
var valor10 = parseInt(document.getElementById(j).value);
var valor11 = parseInt(document.getElementById(k).value);
var valor12 = parseInt(document.getElementById(l).value);
var valor13 = parseInt(document.getElementById(m).value);
var valor14 = parseInt(document.getElementById(n).value);
document.getElementById(sb).value = valor1 + valor2 + valor3 + valor4 + valor5 + valor6 + valor7 + valor8 + valor9 + valor10 + valor11 + valor12 + valor13 + valor14;
}




function sumar_nueve_valores(a, b, c, d, e, f, g, h, i, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
var valor3 = parseInt(document.getElementById(c).value);
var valor4 = parseInt(document.getElementById(d).value);
var valor5 = parseInt(document.getElementById(e).value);
var valor6 = parseInt(document.getElementById(f).value);
var valor7 = parseInt(document.getElementById(g).value);
var valor8 = parseInt(document.getElementById(h).value);
var valor9 = parseInt(document.getElementById(i).value);
document.getElementById(sb).value = valor1 + valor2 + valor3 + valor4 + valor5 + valor6 + valor7 + valor8 + valor9;
}



function calcula_picking_efectivo(a, b, sb) {
var valor1 = parseInt(document.getElementById(a).value);
var valor2 = parseInt(document.getElementById(b).value);
document.getElementById(sb).value = valor1 - valor2;
}





/*
function sumar_al_recargar()
{
document.getElementById("promedio_cajas_semanal").value = + (document.getElementById("ingreso_cajas_gaseosas").value + document.getElementById("ingreso_cajas_cervezas").value);

}
*/
