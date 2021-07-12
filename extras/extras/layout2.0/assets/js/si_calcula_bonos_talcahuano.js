function calcular_picking_antiguo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 1500)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 1500 && produccion <= 1850)
{
  document.getElementById(sb).value = Math.round(produccion * 1);
}

if (produccion > 1850)
{
  document.getElementById(sb).value = Math.round(produccion * 1.2);
}
}


function calcular_picking_nuevo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 1500)
{
  document.getElementById(sb).value = Math.round(produccion * 1.2);
}

if (produccion > 1500 && produccion <= 1850)
{
  document.getElementById(sb).value = Math.round(produccion * 1.2);
}

if (produccion > 1850)
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
  document.getElementById(sb).value = Math.round(produccion * 1.2);
}

if (produccion > 1100)
{
  document.getElementById(sb).value = Math.round(produccion * 1.5);
}
}






function calcular_licores_nuevo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 800)
{
  document.getElementById(sb).value = Math.round(produccion * 1.5);
}

if (produccion > 800 && produccion <= 1100)
{
  document.getElementById(sb).value = Math.round(produccion * 1.5);
}

if (produccion > 1100)
{
  document.getElementById(sb).value = Math.round(produccion * 2.7);
}
}




function calcular_cervezas_antiguo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 800)
{
  document.getElementById(sb).value = Math.round(produccion * 0.6);
}

if (produccion > 800 && produccion <= 1080)
{
  document.getElementById(sb).value = Math.round(produccion * 1.2);
}

if (produccion > 1080)
{
  document.getElementById(sb).value = Math.round(produccion * 1.8);
}
}





function calcular_cervezas_nuevo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 800)
{
  document.getElementById(sb).value = Math.round(produccion * 1.8);
}

if (produccion > 800 && produccion <= 1080)
{
  document.getElementById(sb).value = Math.round(produccion * 1.8);
}

if (produccion > 1080)
{
  document.getElementById(sb).value = Math.round(produccion * 2.5);
}
}





function calcular_gaseosas_antiguo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 500)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 500 && produccion <= 750)
{
  document.getElementById(sb).value = Math.round(produccion * 0.8);
}

if (produccion > 750)
{
  document.getElementById(sb).value = Math.round(produccion * 1.7);
}
}




function calcular_gaseosas_nuevo(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 500)
{
  document.getElementById(sb).value = Math.round(produccion * 1.7);
}

if (produccion > 500 && produccion <= 750)
{
  document.getElementById(sb).value = Math.round(produccion * 1.7);
}

if (produccion > 750)
{
  document.getElementById(sb).value = Math.round(produccion * 2.3);
}
}



function calcular_picking_nuevo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 200)
{
  document.getElementById(sb).value = Math.round(produccion * 1.2);
}

if (produccion > 200 && produccion <= 247)
{
  document.getElementById(sb).value = Math.round(produccion * 1.2);
}

if (produccion > 247)
{
  document.getElementById(sb).value = Math.round(produccion * 2);
}
}



function calcular_picking_antiguo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 200)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 200 && produccion <= 247)
{
  document.getElementById(sb).value = Math.round(produccion * 1);
}

if (produccion > 247)
{
  document.getElementById(sb).value = Math.round(produccion * 1.2);
}
}



function calcular_licores_nuevo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 107)
{
  document.getElementById(sb).value = Math.round(produccion * 1.5);
}

if (produccion > 107 && produccion <= 147)
{
  document.getElementById(sb).value = Math.round(produccion * 1.5);
}

if (produccion > 147)
{
  document.getElementById(sb).value = Math.round(produccion * 2.7);
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
  document.getElementById(sb).value = Math.round(produccion * 1.2);
}

if (produccion > 147)
{
  document.getElementById(sb).value = Math.round(produccion * 1.5);
}
}



function calcular_cervezas_nuevo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 107)
{
  document.getElementById(sb).value = Math.round(produccion * 1.8);
}

if (produccion > 107 && produccion <= 144)
{
  document.getElementById(sb).value = Math.round(produccion * 1.8);
}

if (produccion > 144)
{
  document.getElementById(sb).value = Math.round(produccion * 2.5);
}
}


function calcular_cervezas_antiguo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 107)
{
  document.getElementById(sb).value = Math.round(produccion * 0.6);
}

if (produccion > 107 && produccion <= 144)
{
  document.getElementById(sb).value = Math.round(produccion * 1.2);
}

if (produccion > 144)
{
  document.getElementById(sb).value = Math.round(produccion * 1.8);
}
}



function calcular_gaseosas_nuevo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 67)
{
  document.getElementById(sb).value = Math.round(produccion * 1.7);
}

if (produccion > 67 && produccion <= 100)
{
  document.getElementById(sb).value = Math.round(produccion * 1.7);
}

if (produccion > 100)
{
  document.getElementById(sb).value = Math.round(produccion * 2.3);
}
}




function calcular_gaseosas_antiguo_he(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 67)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 67 && produccion <= 100)
{
  document.getElementById(sb).value = Math.round(produccion * 0.8);
}

if (produccion > 100)
{
  document.getElementById(sb).value = Math.round(produccion * 1.7);
}
}