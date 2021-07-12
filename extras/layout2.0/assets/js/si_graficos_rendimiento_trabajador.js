window.onload = function () {
  //Cajas de Texto Meses
    var valormes1 = document.getElementById("mes1");
    var valormes2 = document.getElementById("mes2");
    var valormes3 = document.getElementById("mes3");
  //Cajas de Texto Indice Picking
    var valorindice_picking1 = document.getElementById("indice_picking1");
    var valorindice_picking2 = document.getElementById("indice_picking2");
    var valorindice_picking3 = document.getElementById("indice_picking3");
  //Cajas de Texto Indice Clasificacion
    var valorindice_clasif1 = document.getElementById("indice_clasif1");
    var valorindice_clasif2 = document.getElementById("indice_clasif2");
    var valorindice_clasif3 = document.getElementById("indice_clasif3");
  //Cajas de Texto Permisos
    var valorpermiso1 = document.getElementById("permiso1");
    var valorpermiso2 = document.getElementById("permiso2");
    var valorpermiso3 = document.getElementById("permiso3");
    //Cajas de Texto Fallas
    var valorfalla1 = document.getElementById("falla1");
    var valorfalla2 = document.getElementById("falla2");
    var valorfalla3 = document.getElementById("falla3");
    //Cajas de Texto Licencias
    var valorlicencia1 = document.getElementById("licencia1");
    var valorlicencia2 = document.getElementById("licencia2");
    var valorlicencia3 = document.getElementById("licencia3");
     //Cajas de Texto Amonestaciones
    var valoramonestacion1 = document.getElementById("amonestacion1");
    var valoramonestacion2 = document.getElementById("amonestacion2");
    var valoramonestacion3 = document.getElementById("amonestacion3");



     if (valormes1 == null){
      var indice_picking1 = 0;
      var indice_clasif1 = 0;
      var permiso1 = 0;
      var falla1 = 0;
      var licencia1 = 0;
      var amonestacion1 = 0;
      var mes1 = " ";
    }else{
      var indice_picking1 = document.getElementById('indice_picking1').value;
      var indice_clasif1 = document.getElementById('indice_clasif1').value;
      var permiso1 = document.getElementById('permiso1').value;
      var falla1 = document.getElementById('falla1').value;
      var licencia1 = document.getElementById('licencia1').value;
      var amonestacion1 = document.getElementById('amonestacion1').value;
      var mes1 = document.getElementById('mes1').value;
    }

    if (valormes2 == null){
      var indice_picking2 = 0;
      var indice_clasif2 = 0;
      var permiso2 = 0;
      var falla2 = 0;
      var licencia2 = 0;
      var amonestacion2 = 0;
      var mes2 = " ";
    }else{
      var indice_picking2 = document.getElementById('indice_picking2').value;
      var indice_clasif2 = document.getElementById('indice_clasif2').value;
      var permiso2 = document.getElementById('permiso2').value;
      var falla2 = document.getElementById('falla2').value;
      var licencia2 = document.getElementById('licencia2').value;
      var amonestacion2 = document.getElementById('amonestacion2').value;
      var mes2 = document.getElementById('mes2').value;
    }

    if (valormes3 == null){
      var indice_picking3 = 0;
      var indice_clasif3 = 0;
      var permiso3 = 0;
      var falla3 = 0;
      var licencia3 = 0;
      var amonestacion3 = 0;
      var mes3 = " ";
    }else{
      var indice_picking3 = document.getElementById('indice_picking3').value;
      var indice_clasif3 = document.getElementById('indice_clasif3').value;
      var permiso3 = document.getElementById('permiso3').value;
      var falla3 = document.getElementById('falla3').value;
      var licencia3 = document.getElementById('licencia3').value;
      var amonestacion3 = document.getElementById('amonestacion3').value;
      var mes3 = document.getElementById('mes3').value;
    }
    


    var chart = new CanvasJS.Chart("chartContainer",
    {      
      theme:"theme3",
      title:{
        text: "Rendimiento del Trabajador"
      },
      animationEnabled: true,
      axisY :{
        includeZero: false,
        // suffix: " k",
        valueFormatString: "#.",
        suffix: ""
        
      },
      toolTip: {
        shared: "true"
      },
      data: [
      {        
        type: "spline", 
        showInLegend: true,
        name: "Indice Picking",
        // markerSize: 0,        
        // color: "rgba(54,158,173,.6)",
        dataPoints: [

        {label: mes1, y: Number(indice_picking1)},
        {label: mes2, y: Number(indice_picking2)},
        {label: mes3, y: Number(indice_picking3)},
        ]
      },
      {        
        type: "spline", 
        showInLegend: true,
        name: "Indice Clasificacion",
        dataPoints: [
        {label: mes1, y: Number(indice_clasif1)},
        {label: mes2, y: Number(indice_clasif2)},
        {label: mes3, y: Number(indice_clasif3)},
        ]
      }
      

      ],
      legend:{
        cursor:"pointer",
        itemclick : function(e) {
          if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible ){
          	e.dataSeries.visible = false;
          }
          else {
            e.dataSeries.visible = true;
          }
          chart.render();
        }
        
      },
    });
chart.render();



var chart = new CanvasJS.Chart("chartContainer2",
    {      
      theme:"theme3",
      title:{
        text: "Recursos Humanos"
      },
      animationEnabled: true,
      axisY :{
        includeZero: false,
        // suffix: " k",
        valueFormatString: "#.",
        suffix: ""
        
      },
      toolTip: {
        shared: "true"
      },
      data: [
      {        
        type: "spline", 
        showInLegend: true,
        name: "Permisos",
        // markerSize: 0,        
        // color: "rgba(54,158,173,.6)",
        dataPoints: [
        {label: mes1, y: Number(permiso1)},
        {label: mes2, y: Number(permiso2)},
        {label: mes3, y: Number(permiso3)},
        ]
      },
      {        
        type: "spline", 
        showInLegend: true,
        name: "Fallas",
        // markerSize: 0,        
        // color: "rgba(54,158,173,.6)",
        dataPoints: [
        {label: mes1, y: Number(falla1)},
        {label: mes2, y: Number(falla2)},
        {label: mes3, y: Number(falla3)},
        ]
      },
      {        
        type: "spline", 
        showInLegend: true,
        name: "Licencias",
        // markerSize: 0,        
        // color: "rgba(54,158,173,.6)",
        dataPoints: [
        {label: mes1, y: Number(licencia1)},
        {label: mes2, y: Number(licencia2)},
        {label: mes3, y: Number(licencia3)},
        ]
      },
      {        
        type: "spline", 
        showInLegend: true,
        name: "Amonestaciones",
        // markerSize: 0,        
        // color: "rgba(54,158,173,.6)",
        dataPoints: [
        {label: mes1, y: Number(amonestacion1)},
        {label: mes2, y: Number(amonestacion2)},
        {label: mes3, y: Number(amonestacion3)},
        ]
      },
      

      ],
      legend:{
        cursor:"pointer",
        itemclick : function(e) {
          if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible ){
            e.dataSeries.visible = false;
          }
          else {
            e.dataSeries.visible = true;
          }
          chart.render();
        }
        
      },
    });
chart.render();
}






   

/*
    if (picking2 == null){
          var valorpicking2 = 0;
          var valorclasif2 = 0;
          var valormerma2 = 0;
          var valorfecha2 = " ";
    }else{
          var valorpicking2 = document.getElementById('picking[2]').value;
          var valorclasif2 = document.getElementById('clasif[2]').value;
          var valormerma2 = document.getElementById('merma[2]').value;
          var valorfecha2 = document.getElementById('fecha[2]').value;
    }


    if (picking3 == null){
          var valorpicking3 = 0;
          var valorclasif3 = 0;
          var valormerma3 = 0;
          var valorfecha3 = " ";
    }else{
          var valorpicking3 = document.getElementById('picking[3]').value;
          var valorclasif3 = document.getElementById('clasif[3]').value;
          var valormerma3 = document.getElementById('merma[3]').value;
          var valorfecha3 = document.getElementById('fecha[3]').value;
    }

    if (picking4 == null){
          var valorpicking4 = 0;
          var valorclasif4 = 0;
          var valormerma4 = 0;
          var valorfecha4 = " ";
    }else{
          var valorpicking4 = document.getElementById('picking[4]').value;
          var valorclasif4 = document.getElementById('clasif[4]').value;
          var valormerma4 = document.getElementById('merma[4]').value;
          var valorfecha4 = document.getElementById('fecha[4]').value;
    }

    if (picking5 == null){
          var valorpicking5 = 0;
          var valorclasif5 = 0;
          var valormerma5 = 0;
          var valorfecha5 = " ";
    }else{
          var valorpicking5 = document.getElementById('picking[5]').value;
          var valorclasif5 = document.getElementById('clasif[5]').value;
          var valormerma5 = document.getElementById('merma[5]').value;
          var valorfecha5 = document.getElementById('fecha[5]').value;
    }

    if (picking6 == null){
          var valorpicking6 = 0;
          var valorclasif6 = 0;
          var valormerma6 = 0;
          var valorfecha6 = " ";
    }else{
          var valorpicking6 = document.getElementById('picking[6]').value;
          var valorclasif6 = document.getElementById('clasif[6]').value;
          var valormerma6 = document.getElementById('merma[6]').value;
          var valorfecha6 = document.getElementById('fecha[6]').value;
    }

    if (picking7 == null){
          var valorpicking7 = 0;
          var valorclasif7 = 0;
          var valormerma7 = 0;
          var valorfecha7 = " ";
    }else{
          var valorpicking7 = document.getElementById('picking[7]').value;
          var valorclasif7 = document.getElementById('clasif[7]').value;
          var valormerma7 = document.getElementById('merma[7]').value;
          var valorfecha7 = document.getElementById('fecha[7]').value;
    }

    if (picking8 == null){
          var valorpicking8 = 0;
          var valorclasif8 = 0;
          var valormerma8 = 0;
          var valorfecha8 = " ";
    }else{
          var valorpicking8 = document.getElementById('picking[8]').value;
          var valorclasif8 = document.getElementById('clasif[8]').value;
          var valormerma8 = document.getElementById('merma[8]').value;
          var valorfecha8 = document.getElementById('fecha[8]').value;
    }

    if (picking9 == null){
          var valorpicking9 = 0;
          var valorclasif9 = 0;
          var valormerma9 = 0;
          var valorfecha9 = " ";
    }else{
          var valorpicking9 = document.getElementById('picking[9]').value;
          var valorclasif9 = document.getElementById('clasif[9]').value;
          var valormerma9 = document.getElementById('merma[9]').value;
          var valorfecha9 = document.getElementById('fecha[9]').value;
    }

    if (picking10 == null){
          var valorpicking10 = 0;
          var valorclasif10 = 0;
          var valormerma10 = 0;
          var valorfecha10 = " ";
    }else{
          var valorpicking10 = document.getElementById('picking[10]').value;
          var valorclasif10 = document.getElementById('clasif[10]').value;
          var valormerma10 = document.getElementById('merma[10]').value;
          var valorfecha10 = document.getElementById('fecha[10]').value;
    }

    if (picking11 == null){
          var valorpicking11 = 0;
          var valorclasif11 = 0;
          var valormerma11 = 0;
          var valorfecha11 = " ";
    }else{
          var valorpicking11 = document.getElementById('picking[11]').value;
          var valorclasif11 = document.getElementById('clasif[11]').value;
          var valormerma11 = document.getElementById('merma[11]').value;
          var valorfecha11 = document.getElementById('fecha[11]').value;
    }

    if (picking12 == null){
          var valorpicking12 = 0;
          var valorclasif12 = 0;
          var valormerma12 = 0;
          var valorfecha12 = " ";
    }else{
          var valorpicking12 = document.getElementById('picking[12]').value;
          var valorclasif12 = document.getElementById('clasif[12]').value;
          var valormerma12 = document.getElementById('merma[12]').value;
          var valorfecha12 = document.getElementById('fecha[12]').value;
    }

    if (picking13 == null){
          var valorpicking13 = 0;
          var valorclasif13 = 0;
          var valormerma13 = 0;
          var valorfecha13 = " ";
    }else{
          var valorpicking13 = document.getElementById('picking[13]').value;
          var valorclasif13 = document.getElementById('clasif[13]').value;
          var valormerma13 = document.getElementById('merma[13]').value;
          var valorfecha13 = document.getElementById('fecha[13]').value;
    }

    if (picking14 == null){
          var valorpicking14 = 0;
          var valorclasif14 = 0;
          var valormerma14 = 0;
          var valorfecha14 = " ";
    }else{
          var valorpicking14 = document.getElementById('picking[14]').value;
          var valorclasif14 = document.getElementById('clasif[14]').value;
          var valormerma14 = document.getElementById('merma[14]').value;
          var valorfecha14 = document.getElementById('fecha[14]').value;
    }

    if (picking15 == null){
          var valorpicking15 = 0;
          var valorclasif15 = 0;
          var valormerma15 = 0;
          var valorfecha15 = " ";
    }else{
          var valorpicking15 = document.getElementById('picking[15]').value;
          var valorclasif15 = document.getElementById('clasif[15]').value;
          var valormerma15 = document.getElementById('merma[15]').value;
          var valorfecha15 = document.getElementById('fecha[15]').value;
    }

    if (picking16 == null){
          var valorpicking16 = 0;
          var valorclasif16 = 0;
          var valormerma16 = 0;
          var valorfecha16 = " ";
    }else{
          var valorpicking16 = document.getElementById('picking[16]').value;
          var valorclasif16 = document.getElementById('clasif[16]').value;
          var valormerma16 = document.getElementById('merma[16]').value;
          var valorfecha16 = document.getElementById('fecha[16]').value;
    }
    if (picking17 == null){
          var valorpicking17 = 0;
          var valorclasif17 = 0;
          var valormerma17 = 0;
          var valorfecha17 = " ";
    }else{
          var valorpicking17 = document.getElementById('picking[17]').value;
          var valorclasif17 = document.getElementById('clasif[17]').value;
          var valormerma17 = document.getElementById('merma[17]').value;
          var valorfecha17 = document.getElementById('fecha[17]').value;
    }
    if (picking18 == null){
          var valorpicking18 = 0;
          var valorclasif18 = 0;
          var valormerma18 = 0;
          var valorfecha18 = " ";
    }else{
          var valorpicking18 = document.getElementById('picking[18]').value;
          var valorclasif18 = document.getElementById('clasif[18]').value;
          var valormerma18 = document.getElementById('merma[18]').value;
          var valorfecha18 = document.getElementById('fecha[18]').value;
    }
    if (picking19 == null){
          var valorpicking19 = 0;
          var valorclasif19 = 0;
          var valormerma19 = 0;
          var valorfecha19 = " ";
    }else{
          var valorpicking19 = document.getElementById('picking[19]').value;
          var valorclasif19 = document.getElementById('clasif[19]').value;
          var valormerma19 = document.getElementById('merma[19]').value;
          var valorfecha19 = document.getElementById('fecha[19]').value;
    }
    if (picking20 == null){
          var valorpicking20 = 0;
          var valorclasif20 = 0;
          var valormerma20 = 0;
          var valorfecha20 = " ";
    }else{
          var valorpicking20 = document.getElementById('picking[20]').value;
          var valorclasif20 = document.getElementById('clasif[20]').value;
          var valormerma20 = document.getElementById('merma[20]').value;
          var valorfecha20 = document.getElementById('fecha[20]').value;
    }
    if (picking21 == null){
          var valorpicking21 = 0;
          var valorclasif21 = 0;
          var valormerma21 = 0;
          var valorfecha21 = " ";
    }else{
          var valorpicking21 = document.getElementById('picking[21]').value;
          var valorclasif21 = document.getElementById('clasif[21]').value;
          var valormerma21 = document.getElementById('merma[21]').value;
          var valorfecha21 = document.getElementById('fecha[21]').value;
    }
    if (picking22 == null){
          var valorpicking22 = 0;
          var valorclasif22 = 0;
          var valormerma22 = 0;
          var valorfecha22 = " ";
    }else{
          var valorpicking22 = document.getElementById('picking[22]').value;
          var valorclasif22 = document.getElementById('clasif[22]').value;
          var valormerma22 = document.getElementById('merma[22]').value;
          var valorfecha22 = document.getElementById('fecha[22]').value;
    }
    if (picking23 == null){
          var valorpicking23 = 0;
          var valorclasif23 = 0;
          var valormerma23 = 0;
          var valorfecha23 = " ";
    }else{
          var valorpicking23 = document.getElementById('picking[23]').value;
          var valorclasif23 = document.getElementById('clasif[23]').value;
          var valormerma23 = document.getElementById('merma[23]').value;
          var valorfecha23 = document.getElementById('fecha[23]').value;
    }
    if (picking24 == null){
          var valorpicking24 = 0;
          var valorclasif24 = 0;
          var valormerma24 = 0;
          var valorfecha24 = " ";
    }else{
          var valorpicking24 = document.getElementById('picking[24]').value;
          var valorclasif24 = document.getElementById('clasif[24]').value;
          var valormerma24 = document.getElementById('merma[24]').value;
          var valorfecha24 = document.getElementById('fecha[24]').value;
    }
    if (picking25 == null){
          var valorpicking25 = 0;
          var valorclasif25 = 0;
          var valormerma25 = 0;
          var valorfecha25 = " ";
    }else{
          var valorpicking25 = document.getElementById('picking[25]').value;
          var valorclasif25 = document.getElementById('clasif[25]').value;
          var valormerma25 = document.getElementById('merma[25]').value;
          var valorfecha25 = document.getElementById('fecha[25]').value;
    }
    if (picking26 == null){
          var valorpicking26 = 0;
          var valorclasif26 = 0;
          var valormerma26 = 0;
          var valorfecha26 = " ";
    }else{
          var valorpicking26 = document.getElementById('picking[26]').value;
          var valorclasif26 = document.getElementById('clasif[26]').value;
          var valormerma26 = document.getElementById('merma[26]').value;
          var valorfecha26 = document.getElementById('fecha[26]').value;
    }
    if (picking27 == null){
          var valorpicking27 = 0;
          var valorclasif27 = 0;
          var valormerma27 = 0;
          var valorfecha27 = " ";
    }else{
          var valorpicking27 = document.getElementById('picking[27]').value;
          var valorclasif27 = document.getElementById('clasif[27]').value;
          var valormerma27 = document.getElementById('merma[27]').value;
          var valorfecha27 = document.getElementById('fecha[27]').value;
    }
    if (picking28 == null){
          var valorpicking28 = 0;
          var valorclasif28 = 0;
          var valormerma28 = 0;
          var valorfecha28 = " ";
    }else{
          var valorpicking28 = document.getElementById('picking[28]').value;
          var valorclasif28 = document.getElementById('clasif[28]').value;
          var valormerma28 = document.getElementById('merma[28]').value;
          var valorfecha28 = document.getElementById('fecha[28]').value;
    }
    if (picking29 == null){
          var valorpicking29 = 0;
          var valorclasif29 = 0;
          var valormerma29 = 0;
          var valorfecha29 = " ";
    }else{
          var valorpicking29 = document.getElementById('picking[29]').value;
          var valorclasif29 = document.getElementById('clasif[29]').value;
          var valormerma29 = document.getElementById('merma[29]').value;
          var valorfecha29 = document.getElementById('fecha[29]').value;
    }
    if (picking30 == null){
          var valorpicking30 = 0;
          var valorclasif30 = 0;
          var valormerma30 = 0;
          var valorfecha30 = " ";
    }else{
          var valorpicking30 = document.getElementById('picking[30]').value;
          var valorclasif30 = document.getElementById('clasif[30]').value;
          var valormerma30 = document.getElementById('merma[30]').value;
          var valorfecha30 = document.getElementById('fecha[30]').value;
    }
    if (picking31 == null){
          var valorpicking31 = 0;
          var valorclasif31 = 0;
          var valormerma31 = 0;
          var valorfecha31 = " ";
    }else{
          var valorpicking31 = document.getElementById('picking[31]').value;
          var valorclasif31 = document.getElementById('clasif[31]').value;
          var valormerma31 = document.getElementById('merma[31]').value;
          var valorfecha31 = document.getElementById('fecha[31]').value;
    }
    */