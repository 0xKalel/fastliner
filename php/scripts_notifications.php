<script type="text/javascript">
$(".button").click(function(){
        var date=$(this).parent().parent().find("#date_vignette").html();
        var pere=$(this).parent().parent();
        var id=$(this).attr("id");
        var table=$(this).attr("table");
        var element="date_vignette";
        var param={"id":id,"table":table,"element":element,"date":date};
        $.post("notification/ajax/reglage.php",param,function(result){

            if(result==1){
                pere.hide(300);
                notifications_restants=$("#tableau_notifications tbody tr").length;
                $("#regler_notifications,#tableau_notifications").hide()
                $(".notifications_regle").show()
            }else{
                alert(result)
            }
        }).error(function(){
                alert("erreur serveur")
                cacher_loader()
            })
    })
    $("#scroll5").mCustomScrollbar({
        theme:"3d-dark"
    });
    $("#regler_notifications").click(function(){
        var pere=$(this).parent();
        var table=$(this).attr("table");
        var element=$(this).attr("element");
        var param={"table":table,element:element};
        $.post("notification/ajax/regler_tout.php",param,function(result){
            var result = jQuery.parseJSON(result);
            if(result==1){
                $("#regler_notifications").hide()
                $(".notifications_regle").show()
            }
        })
    })
</script>