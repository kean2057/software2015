$(document).ready(function(){
        $("customdropdown").change(function(){
            $( "customdropdown option:selected").each(function(){
                if($(this).attr("value")=="Clothing"){
                    $(".box").hide();
                    $(".red").show();
                }
                if($(this).attr("value")=="Housewares"){
                    $(".box").hide();
                    $(".green").show();
                }
                if($(this).attr("value")=="Accessories"){
                    $(".box").hide();
                    $(".blue").show();
                }
            });
        }).change();
    });