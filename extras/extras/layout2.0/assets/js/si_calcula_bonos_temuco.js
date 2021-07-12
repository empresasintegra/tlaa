function calcular_picking_antiguo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 1250)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 1250 && produccion < 1400)
{
  document.getElementById(sb).value = Math.round(produccion * 0.5);
}

if (produccion >= 1400)
{
  document.getElementById(sb).value = Math.round(produccion * 1);
}
}


function calcular_picking_nuevo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 1250)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 1250 && produccion <= 2000)
{
  document.getElementById(sb).value = Math.round(produccion * ((0.001335 * produccion) + (-0.6702)));
}

if (produccion > 2000)
{
  document.getElementById(sb).value = Math.round(produccion * 2);
}
}



function calcular_licores_antiguo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 800)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 800 && produccion <= 1100)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 1100)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}
}






function calcular_licores_nuevo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 800)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 800 && produccion <= 1100)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 1100)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}
}




function calcular_cervezas_antiguo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 1050)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 1050 && produccion <= 1400)
{
  document.getElementById(sb).value = Math.round(produccion * 0.5);
}

if (produccion > 1400)
{
  document.getElementById(sb).value = Math.round(produccion * 1);
}
}





function calcular_cervezas_nuevo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 1100)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 1100 && produccion <= 1500)
{
  document.getElementById(sb).value = Math.round(produccion * ((0.0025 * produccion) + (-1.75)));

}

if (produccion > 1500)
{
  document.getElementById(sb).value = Math.round(produccion * 2);
}
}





function calcular_gaseosas_antiguo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 800)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 800 && produccion <= 1000)
{
  document.getElementById(sb).value = Math.round(produccion * 0.5);
}

if (produccion > 1000)
{
  document.getElementById(sb).value = Math.round(produccion * 1);
}
}




function calcular_gaseosas_nuevo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 600)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 600 && produccion <= 2000)
{
  document.getElementById(sb).value = Math.round(produccion * ((0.002770 * produccion) + (-0.6648)));

}

if (produccion > 2000)
{
  document.getElementById(sb).value = Math.round(produccion * 2);
}
}



function calcular_picking_antiguo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 333)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 333 && produccion <= 427)
{
  document.getElementById(sb).value = Math.round(produccion * 0.5);
}

if (produccion > 427)
{
  document.getElementById(sb).value = Math.round(produccion * 1);
}
}



function calcular_picking_nuevo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 333)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 333 && produccion <= 533)
{
  document.getElementById(sb).value = Math.round(produccion * ((0.005006 * produccion) + (-0.6702)));

}

if (produccion > 533)
{
  document.getElementById(sb).value = Math.round(produccion * 2);
}
}



function calcular_licores_nuevo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 107)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 107 && produccion <= 147)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 147)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}
}



function calcular_licores_antiguo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 107)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 107 && produccion <= 147)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 147)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}
}



function calcular_cervezas_antiguo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 280)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 280 && produccion <= 373)
{
  document.getElementById(sb).value = Math.round(produccion * 0.5);
}

if (produccion > 373)
{
  document.getElementById(sb).value = Math.round(produccion * 1);
}
}


function calcular_cervezas_nuevo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 293)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 293 && produccion <= 400)
{
  document.getElementById(sb).value = Math.round(produccion * ((0.009375 * produccion) + (-1.75)));
}

if (produccion > 400)
{
  document.getElementById(sb).value = Math.round(produccion * 2);
}
}



function calcular_gaseosas_antiguo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 213)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 213 && produccion <= 267)
{
  document.getElementById(sb).value = Math.round(produccion * 0.5);
}

if (produccion > 267)
{
  document.getElementById(sb).value = Math.round(produccion * 1);
}
}




function calcular_gaseosas_nuevo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 160)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 160 && produccion <= 257)
{
  document.getElementById(sb).value = Math.round(produccion * ((0.010387 * produccion) + (-0.6648)));
}

if (produccion > 257)
{
  document.getElementById(sb).value = Math.round(produccion * 2);
}
}


