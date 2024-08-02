function objetvertableau(resulta) {
    resulta=resulta[0];
    result= new Array();
    result["assurance"] = resulta.date_assurance;
    result["vignette"] = resulta.date_vignette;
    result["scanner"] = resulta.date_scanner;
    result["controle_tecnique"] = resulta.controle_technique;
    result["paye"] = resulta.date_chauffeur;
    result["assurance_chauffeur"] = resulta.date_assurance_chauffeur;
    return result;
}
function calculer_notifications(resultat){
    resultat=resultat[0];
    somme=parseFloat(resultat.date_assurance)+parseFloat(resultat.date_vignette)+parseFloat(resultat.date_scanner)+parseFloat(resultat.controle_technique)+parseFloat(resultat.date_chauffeur)+parseFloat(resultat.date_assurance_chauffeur);
    return somme;
}
function notification() {
    $.post("ajax/chargement/notification.php", function(resultat) {
        var resultat = jQuery.parseJSON(resultat);
        var nombre_notifications = calculer_notifications(resultat);
        var test = 0;
        $("#notification").html(nombre_notifications);
        if (nombre_notifications >= 1) {
            $("#notification").not(".non_vide").toggleClass("non_vide")
        } else {
            $("#notification.non_vide").removeClass("non_vide");
            $("#notification").addClass("notif_0");
        };
        $("#notif").click( function() {
            $("#tabs ul li").each(function() {
                $(this).removeClass("non");
                var num_A = $(this).find("a").attr("id");
                var objet = "#" + $(this).attr("id");
                var i = nombre_notifications;
                var result =nombre_notifications;
                var champ = $(this).attr("id");
                result = objetvertableau(resultat);
                if (result[champ] == 0) {
                    $("#tabs ul li" + objet).addClass("incliquable")
                } else {
                    $(this).removeClass("incliquable")
                    if (test == 0) {
                        num = num_A;
                        test = 1;
                        $("#tabs").tabs("option", "active", num);
                        $(".ui-tabs-active").removeClass("nonactive");
                    }
                }

            })



        })

        $(".non_vide").click(function() {
                $(this).toggleClass("non_vide_click");
                $("#fond").delay(800).show("slide", 100);
               
            }

        )

        $(".non_vide").one("click", function() {
            $.post("notification/ajax/chargement/assurance.php", {}, function(resultat) {

                $("#tabs #ui-tabs-1").html(resultat);

            })
        })
    })
}
