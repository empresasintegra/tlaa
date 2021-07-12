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