$(document).ready(function(){
    
    $(".pick_normal").focusout(function(){
        var aux_sum = 0;
        $(".pick_normal").each(function(){
            aux_sum = aux_sum + parseInt($(this).val());
        });
        $("#total_picking_normal").val(aux_sum);
    });


    $(".licores_normal").focusout(function(){
        var aux_sum = 0;
        $(".licores_normal").each(function(){
            aux_sum = aux_sum + parseInt($(this).val());
        });
        $("#total_licores_normal").val(aux_sum);
    });

       $(".calaf_normal").focusout(function(){
        var aux_sum = 0;
        $(".calaf_normal").each(function(){
            aux_sum = aux_sum + parseInt($(this).val());
        });
        $("#total_calaf_normal").val(aux_sum);
    });

        $(".cervezas_normal").focusout(function(){
        var aux_sum = 0;
        $(".cervezas_normal").each(function(){
            aux_sum = aux_sum + parseInt($(this).val());
        });
        $("#total_cervezas_normal").val(aux_sum);
    });

        $(".gaseosas_normal").focusout(function(){
        var aux_sum = 0;
        $(".gaseosas_normal").each(function(){
            aux_sum = aux_sum + parseInt($(this).val());
        });
        $("#total_gaseosas_normal").val(aux_sum);
    });

        $(".picking_he").focusout(function(){
        var aux_sum = 0;
        $(".picking_he").each(function(){
            aux_sum = aux_sum + parseInt($(this).val());
        });
        $("#total_picking_he").val(aux_sum);
    });

    $(".licores_he").focusout(function(){
        var aux_sum = 0;
        $(".licores_he").each(function(){
            aux_sum = aux_sum + parseInt($(this).val());
        });
        $("#total_licores_he").val(aux_sum);
    });


    $(".calaf_he").focusout(function(){
        var aux_sum = 0;
        $(".calaf_he").each(function(){
            aux_sum = aux_sum + parseInt($(this).val());
        });
        $("#total_calaf_he").val(aux_sum);
    });


    $(".cervezas_he").focusout(function(){
        var aux_sum = 0;
        $(".cervezas_he").each(function(){
            aux_sum = aux_sum + parseInt($(this).val());
        });
        $("#total_cervezas_he").val(aux_sum);
    });


    $(".gaseosas_he").focusout(function(){
        var aux_sum = 0;
        $(".gaseosas_he").each(function(){
            aux_sum = aux_sum + parseInt($(this).val());
        });
        $("#total_gaseosas_he").val(aux_sum);
    });






});