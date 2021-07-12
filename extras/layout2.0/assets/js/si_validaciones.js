    function cambiacolor_over(celda){ celda.style.backgroundColor="#D8F6CE" } 
    function cambiacolor_out(celda){ celda.style.backgroundColor="#ffffff" }


    function valida(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==8){
            return true;
        }
        patron =/[0-9.-]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }

    function valida_horas_extras(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==8){
            return true;
        }
        patron =/[0-9.]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }


    function valida_abecedario(e){
        tecla = (document.all) ? e.keyCode : e.which;
          if (tecla==8){
            return true;
        }
        patron =/[qwertyuiopasdfghjklñzxcvbnmQWERTY UIOPASDFGHJKLÑZXCVBNM]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }

    function valida_abecedario_y_numeros(e){
        tecla = (document.all) ? e.keyCode : e.which;
          if (tecla==8){
            return true;
        }
        patron =/[qwertyuiopasdfghjklñzxcvbnmQWERTY UIOPASDFGHJKLÑZXCVBNM1234567890]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }

    function valida_letras_rut(e){
        tecla = (document.all) ? e.keyCode : e.which;
          if (tecla==8){
              return true;
          }
        patron =/[1234567890kK.-]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }


    function valida_numeros(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==8){
            return true;
        }
        patron =/[0-9]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }


    function valida_numeros_horas(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==8){
            return true;
        }
        patron =/[0-9:]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }

    function paralelo_fecha(){
        document.getElementById("datepicker").value = document.getElementById("fecha").value;
    }

    function paralelo_fecha_reempaque(){
        document.getElementById("fecha_reempaque").value = document.getElementById("datepicker").value;
    }

    function paralelo_fecha_merma(){
        document.getElementById("fecha_merma").value = document.getElementById("datepicker").value;
    }

    function sumar_bonos_volanteros(){
        document.getElementById("suma_total_bonos").value = document.getElementById("bonos_sumar[<?php echo $i ?>]").value + document.getElementById("bonos_sumar[<?php echo $i ?>]").value;
    }

    function paralelo_fecha2(){
        document.getElementById("fecha_hoy").value = document.getElementById("fecha").value;
    }


    function togglecheckboxes(master,group){
        var cbarray = document.getElementsByName(group);
        for(var i = 0; i < cbarray.length; i++){
            cbarray[i].checked = master.checked;
        }
    }

    function togglecheckboxes2(master,group){
        var cbarray = document.getElementById(group);
        for(var i = 0; i < cbarray.length; i++){
            cbarray[i].checked = master.checked;
        }
    }

    function SINO(cual) {
       var elElemento=document.getElementById(cual);
       if(elElemento.style.display == 'block') {
          elElemento.style.display = 'none';
       } else {
          elElemento.style.display = 'block';
       }
    }





    function confirmSubmit(){
      var b = 0, chk=document.getElementsByName("seleccionar_eliminar[]")
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

        function confirmLiquidacion(){
      var b = 0, chk=document.getElementsByName("seleccionar[]")
        for(j=0;j<chk.length;j++) {
          if(chk.item(j).checked == false) {
            b++;
          }
        }
        if(b == chk.length) {
          alert("Tiene que Seleccionar uno o varios Trabajadores a Generar Liquidacion");
            return false;
          }
            else
          {
              return true;
          }
    }



    
    function confirmSubmit_guardar() {
      var b = 0, chk=document.getElementsByName("envio_asistencia[]")
        for(j=0;j<chk.length;j++) {
          if(chk.item(j).checked == false) {
            b++;
          }
        }
      if(b == chk.length) {
        alert("Tiene que Seleccionar una o varias opciones a guardar");
          return false;
            }
            else
            {
          return true;
      }
    }



    function valida_numeros_hora(e){
        tecla = (document.all) ? e.keyCode : e.which;
          if (tecla==8){
            return true;
        }
        patron =/[1234567890:]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }

    function valida_letras(e){
        tecla = (document.all) ? e.keyCode : e.which;
          if (tecla==8){
              return true;
          }
        patron =/[01234]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }




    function divide_dos_valores(a, b, sb) {
        var valor1 = parseInt(document.getElementById(a).value);
        var valor2 = parseInt(document.getElementById(b).value);
        document.getElementById(sb).value = valor1 / valor2;
    }


   function divide_dos_valores_mermas(a, b, sb) {
        var valor1 = parseInt(document.getElementById(a).value);
        var valor2 = parseInt(document.getElementById(b).value);
        //document.getElementById(sb).value = round(valor1 / valor2);
        

        var numb = (valor1 / valor2);
        numb = numb.toFixed(2);
        document.getElementById(sb).value = numb;



    }
    function suma_dos_valores(a, b, sb) {
        var valor1 = parseInt(document.getElementById(a).value);
        var valor2 = parseInt(document.getElementById(b).value);
        document.getElementById(sb).value = valor1 + valor2;
    }

    function multiplica_dos_valores(a, b, sb) {
        var valor1 = parseInt(document.getElementById(a).value);
        var valor2 = parseInt(document.getElementById(b).value);
        document.getElementById(sb).value = valor1 * valor2;
    }


    function sumar_dos_valores_decimales(a, b, sb) {
        var valor1 = parseFloat(document.getElementById(a).value);
        var valor2 = parseFloat(document.getElementById(b).value);
        
        var valor1_listo = (valor1.toFixed(2));
        var valor2_listo = (valor2.toFixed(2));

        var sumatotal = (parseFloat(valor1_listo) + parseFloat(valor2_listo));
        var suma = (sumatotal.toFixed(2));
        document.getElementById(sb).value = suma;
    }

    function sumar_misma_columnas(c, sb) {
        var cantidad = parseInt(document.getElementById(c).value);
        var total = parseInt(document.getElementById(sb).value);
        document.getElementById(sb).value = total + cantidad;
    }



    function sumar_dos_valores(a, b, sb) {
        var valor1 = parseInt(document.getElementById(a).value);
        var valor2 = parseInt(document.getElementById(b).value);
        document.getElementById(sb).value = valor1 + valor2;
    }



    function sumar_tres_valores(a, b, c, sb) {
        var valor1 = parseInt(document.getElementById(a).value);
        var valor2 = parseInt(document.getElementById(b).value);
        var valor3 = parseInt(document.getElementById(c).value);
        document.getElementById(sb).value = valor1 + valor2 + valor3;
    }


    function sumar_cuatro_valores(a, b, c, d, sb) {
        var valor1 = parseInt(document.getElementById(a).value);
        var valor2 = parseInt(document.getElementById(b).value);
        var valor3 = parseInt(document.getElementById(c).value);
        var valor4 = parseInt(document.getElementById(d).value);
        document.getElementById(sb).value = valor1 + valor2 + valor3 + valor4;
    }


    function sumar_cinco_valores(a, b, c, d, e, sb) {
        var valor1 = parseInt(document.getElementById(a).value);
        var valor2 = parseInt(document.getElementById(b).value);
        var valor3 = parseInt(document.getElementById(c).value);
        var valor4 = parseInt(document.getElementById(d).value);
        var valor5 = parseInt(document.getElementById(e).value);
        document.getElementById(sb).value = valor1 + valor2 + valor3 + valor4 + valor5;
    }