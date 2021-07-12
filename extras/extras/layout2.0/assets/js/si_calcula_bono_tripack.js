function calcular_bono_tripack(c, sb) {
var produccion = parseInt(document.getElementById(c).value);
if (produccion <= 299)
{
  document.getElementById(sb).value = Math.round(produccion * 0);
}

if (produccion > 299)
{
  document.getElementById(sb).value = Math.round(produccion * 3.5);
}
}