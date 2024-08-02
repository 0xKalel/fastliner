$(".ui-tabs-panel[aria-hidden='false'] #tableau_notifications .button").click(function(){
        var date=$(this).parent().parent().find(".date_notification").html();
        var pere=$(this).parent().parent();
        var id=$(this).attr("id");
        var table=$(this).attr("table");
        var element=$(".ui-tabs-panel[aria-hidden='false'] #regler_notifications").attr("element");
        console.log(element)
        var param={"id":id,"table":table,"element":element,"date":date};
        $.post("notification/ajax/reglage.php",param,function(result){
            if(result==1){
                // pere.hide(300);
                // notifications_restants=$(".ui-tabs-panel[aria-hidden='false'] #tableau_notifications tbody tr").length;
                // if(notifications_restants==1){
                //     $(".ui-tabs-panel[aria-hidden='false'] #regler_notifications,.ui-tabs-panel[aria-hidden='false'] #tableau_notifications").hide()
                //     $(".ui-tabs-panel[aria-hidden='false'] .notifications_regle").show()
                //     $("ul li.ui-state-active").toggleClass("incliquable")
                // }
                //     $(pere).remove()
                var current_index = $("#tabs").tabs("option","active");
                $("#tabs").tabs('load',current_index);
            }else{
                alert(result)
            }
        })
    })
    $(".scroll").mCustomScrollbar({
        theme:"3d-dark",scrollInertia:0
    });
    $(".ui-tabs-panel[aria-hidden='false'] #regler_notifications").click(function(){
        var pere=$(this).parent();
        var table=$(this).attr("table");
        var element=$(this).attr("element");
        var fin=$(this).attr("fin");
        var param={"table":table,element:element,fin:fin};
        $.post("notification/ajax/regler_tout.php",param,function(result){
            var result = jQuery.parseJSON(result);
            if(result==0){
                var current_index = $("#tabs").tabs("option","active");
                $("#tabs").tabs('load',current_index);
                // $(".ui-tabs-panel[aria-hidden='false'] #regler_notifications,.ui-tabs-panel[aria-hidden='false'] #tableau_notifications").hide()
                // $(".ui-tabs-panel[aria-hidden='false'] .notifications_regle").show()
                // $("ul li.ui-state-active").toggleClass("incliquable")
            }
        })
    })