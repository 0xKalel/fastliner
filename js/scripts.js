function actualiser_champ_filtre(){
 if($("#selection_filtres").val()=="receptionne"){
  $("#filtre_2").show().removeAttr("disabled")
  $("#filtre_1").hide().attr("disabled","disabled")
}
else{
  $("#filtre_2").hide().attr("disabled","disabled")
  $("#filtre_1").show().removeAttr("disabled")
}
}
function total_tableau(array){
  if(array.length!=0)
    total=array.reduce(function(a, b) {
      return parseInt(a, 10) + parseInt(b, 10);
    })
  else
    total=0;
  return total;
}
function ouvrir_avances(element){
  $("#cadre_avances").fadeIn(400);
  $("#cadre_avances form input[name='id']").val($(element).parent().parent().attr("id"));
  switch(Cle_actuelle){
    case("routes"):
    case("etats"):{
      $("#cadre_avances .valeur_nfr").html($(element).parent().parent().find(".nfr").text());
      Prix_actuel=f_($(element).parent().parent().find(".prix").text());

    }
    break;
    case("projets"):{
      $("#cadre_avances .valeur_nfr").html($(element).parent().parent().find(".projet").text());
      Prix_actuel=f_($(element).parent().parent().find(".prix").text());

    }
    break;
    case("creances_personnel"):
    case("dettes_personnel"):{
      $("#cadre_avances .valeur_nfr").html($(element).parent().parent().find(".objet").text());
      Prix_actuel=f_($(element).parent().parent().find(".somme").text());
    }
    break;
  }
}
function afficher_loader(selecteur){
  if(!selecteur)
    selecteur="body";
  loader="<div class='fond_gris'><div class='conteneur_loader'><img src='elements/chargement.gif' alt='chargement...'/></div></div>"
  $(selecteur).append(loader).find(".fond_gris").hide().fadeIn(300)
}
function cacher_loader(){
  $(".fond_gris").fadeOut(300,function(){
    $(this).remove()
  })
}
function afficher_nouvelle_ligne(resultat){
  if(resultat==1)
  {
    $( ".reussi" ).show().html("Enregistrement réussi").fadeOut(2000);
    Sort="id";Ordre="DESC";Filtre=[];Interval_date={min:"0",max:"0"};Page=1;
    filtrer(function(){
      $("#tableau_elements tr:eq(1)").hide().toggle(500).toggleClass("dernier_ajoute");
      setTimeout(function(){
        $("#tableau_elements tr:eq(1)").toggleClass("dernier_ajoute");      
      },2000)
    })
  }
  else
    alert(resultat)
  cacher_loader()
}
//la fonction f formatte le prix afin de le rendre plus lisible
function f(prix){
  n=prix+"";
  n=n.replace(/./g, function(c, i, a) {
    return i && c !== "." && !((a.length - i) % 3) ? '.' + c : c;
  })
  return n+Suffixe;
}
// la fonction f_ fait exactement le contraire de la fonction f
function f_(prix){
  n=prix+"";
  n=n.replace(Suffixe,"")
  n=n.replace(/\./g,"")
  return n;
}
function extraire_filtres_choisis(filtre) {
  filtres_choisis = [];
  if (filtre.length > 0)
    for (var i = 0; i < filtre.length; i++) {
      filtre_actuel = filtre[i];
      filtres_choisis.push(Object.keys(filtre_actuel)[0])
    }
    return filtres_choisis;
  }

  function arr_diff(a1, a2) {
    var a = [],
    diff = [];
    for (var i = 0; i < a1.length; i++)
      a[a1[i]] = true;
    for (var i = 0; i < a2.length; i++)
      if (a[a2[i]]) delete a[a2[i]];
    for (var k in a)
      diff.push(k);
    return diff;
  }

  function supprimer_filtre(element) {
    var filtre_supprime = $(element).parent().attr("filtre")
    if (filtre_supprime != "date") {
      if (Filtre.length > 0)
        for (var i = 0; i < Filtre.length; i++) {
          if (Filtre[i][filtre_supprime]) {
            Filtre.splice(i, 1);
            break;
          }
        }
      } else
      Interval_date = {
        min: 0,
        max: 0
      }
      if ((Filtre.length > 0) || (Interval_date.min != 0))
        $(element).parent().remove();
      else
        $("#entete_recherche").html("");
      afficher_page(1, function() {
        recharger_selection();
        recharger_entete_recherche();
      });
    }

    function recharger_selection() {
      var selections = "";
      a_afficher = arr_diff(Champs_a_afficher, Champs_omis_selection)
      if(Cle_actuelle=="routes"){
        var index_r = Filtres_choisis.indexOf("receptionne");
        Champs_omis_selection_temp=a_afficher;
        if (index_r <0) {
          var index = Champs_omis_selection_temp.indexOf("receptionne");
          if (index > -1) {
            Champs_omis_selection_temp.splice(index, 1);
          }
          Champs_omis_selection_temp.push("receptionne")
        }
        for (i = 0; i < Champs_omis_selection_temp.length; i++){
          if(Champs_omis_selection_temp[i]=="receptionne")
            selections += "<option class='" + Champs_omis_selection_temp[i] + "' value='" +Champs_omis_selection_temp[i] + "' >Réceptionné</option>";
          else
            selections += "<option class='" + Champs_omis_selection_temp[i] + "' value='" +Champs_omis_selection_temp[i] + "' >" + Champs[Champs_omis_selection_temp[i]] + "</option>";
        }
      }
      else
        for (i = 0; i < a_afficher.length; i++)
          selections += "<option class='" + a_afficher[i] + "' value='" + a_afficher[i] + "' >" + Champs[a_afficher[i]] + "</option>";
        $("#selection_filtres").html(selections)
        actualiser_champ_filtre()
      }

      function recharger_entete_recherche() {
        filtres_tableau = [];
        if ((Filtre.length > 0) || (Interval_date.min != 0)) {
          entete = "<span style='margin-left: 10px;'>Resultat pour: &nbsp&nbsp</span>";
          if (Filtre.length > 0) {
            for (var i = 0; i < Filtre.length; i++)
              filtres_tableau[Object.keys(Filtre[i])] = (eval("Filtre[i]." + Object.keys(Filtre[i])));
            for (i = 0; i < Filtres_choisis.length; i++) {
              if(Filtres_choisis[i]=="receptionne"){
               valeurs_receptionne=[]
               valeurs_receptionne[0]="Non";
               valeurs_receptionne[1]="Oui";
               entete += "<span class='filtre_text' filtre='" + Filtres_choisis[i] + "' >Réceptionné : " + valeurs_receptionne[filtres_tableau[Filtres_choisis[i]]] + "<a href='javascript:' class='bouton_fermer'>x</a></span>";
             }
             else
              entete += "<span class='filtre_text' filtre='" + Filtres_choisis[i] + "' >" + Champs[Filtres_choisis[i]] + ": " + filtres_tableau[Filtres_choisis[i]] + "<a href='javascript:' class='bouton_fermer'>x</a></span>";
          }
        }
        if (Interval_date.min != 0)
          entete += "<span class='filtre_text' filtre='date'><span style='color:gray'>du&nbsp</span>" + Interval_date.min + "<span style='color:gray'>&nbspau&nbsp</span>" + Interval_date.max + "<a href='javascript:' class='bouton_fermer'>x</a></span>"
        $("#entete_recherche").show().html(entete);
        $("#entete_recherche .bouton_fermer").click(function() {
          supprimer_filtre($(this))
        })
      }
    }

    function filtrer(fonction_supplementaire) {
      var valeur = $(".filtre").not(":disabled").val();
      if (valeur != "") {
        var element = {};
        var champ = $("#selection_filtres").val();
        element[champ] = valeur;
        Filtre.push(element)
      }
      if(Cle_actuelle!="vehicules"){

        min_date = $("#date_min").val();
        max_date = $("#date_max").val();
        if ((min_date != "") && (max_date != "")) {
          Interval_date = {
            min: $("#date_min").val(),
            max: $('#date_max').val()
          }
          $("#date_min").val("")
          $('#date_max').val("")
        }
      }
      afficher_page(1, function() {
        recharger_selection();
        recharger_entete_recherche();
        $(".filtre").val("");
        if(fonction_supplementaire)
          fonction_supplementaire();
      });
    }

    function ordre_routes(champs, ordre) {

      Sort =champs;
      Ordre = ordre;
      charger_elements(champs, ordre, Filtre, Interval_date, Page);
    }

    function voir_feuille(element) {
      id=$(element).parent().parent().attr("id");
      window.open('route/' + id);
    }
    function voir_etats_projet(element) {
      projet=$(element).parent().parent().find(".projet").html();
      projet=projet.replace(/ /g,"__")
      window.open('etats/' + projet);
    }

    function reglage(elem, elem1) {
      $("." + elem).toggleClass(elem);
      $(elem1).toggleClass(elem);
      var elem = $(elem1).val();
      sow_all();
    }

    function cacher(elem) {
      var valeur = elem;
      if (valeur != "0") {
        $(".selections option#" + valeur).hide();
      }
    }


    function affiche(num) {
      var element = ".ajous" + num;
      $(element).show();
      $("div " + element).toggleClass("filtres");
      $(".plus").one("click", function() {
        press(num);
      });
    }

    function press(num) {
      if (num < 3) {
        num = num + 1;
        affiche(num);
      };
    };

    function fleche(element) {

      if (initialisation(element)) {
        ordre_routes($(element).attr('champ'), "ASC");
        i=1;
      } else {
        ordre_routes($(element).attr('champ'), "DESC");
        i=2;
      }
    }

    function initialisation(element) {
      var t=element.attr('champ');
      if ((Sort==t)&&(Ordre=="DESC"))
        return true;
      else
        return false;
    }

    var Page = 1,
    Nbr_page = 5;

    function afficher_pagination(nombre_pages) {
      var P = [""];
      var a = 5;
      var n = 1;
      Nbr_page = nombre_pages;
      for (var i = parseInt(-(a / 2)); i <= (a / 2); i++) {
        if (((Page + i) > 0) && ((Page + i) <= Nbr_page)) {
          var t = Page + i;
          P[n] = t;
          n++;
        }
      }
      $("#pagination_page thead").html("");
      if (P[P.length - 1] > 1) {
        $("#pagination_page thead").append("<td id='1'><span ids='1'>Premier</span></td>");
        for (var i = 1; i < P.length; i++) {
          $("#pagination_page thead").append("<td id='" + P[i] + "'><span ids='" + P[i] + "'>" + P[i] + "</span></td>");
        }
        nbr_page = parseInt(Nbr_page)
        $("#pagination_page thead").append("<td id='" + nbr_page + "'><span ids='" + nbr_page + "'>Dernier</span></td>");
        $("#pagination_page thead span").click(function() {
          PAGE = parseInt($(this).attr("ids"));
          afficher_page(PAGE);
        })
      }
    }

    function afficher_page(page, fonction_supplementaire) {
      Page = page;
      if(Cle_actuelle=="routes")
      {
        if (typeof idfacture != 'undefined'){
         param = {
          cle_actuelle: Cle_actuelle,
          filtre: Filtre,
          interval_date: Interval_date,
          projet:projet
        }
      }
      else{
        param = {
          cle_actuelle: Cle_actuelle,
          filtre: Filtre,
          interval_date: Interval_date,
        } 
      }
    }
    else
    {
      param = {
        cle_actuelle: Cle_actuelle,
        filtre: Filtre,
        interval_date: Interval_date
      }
    }
    $.post("ajax/chargement/charger_nombre_page.php", param, function(resultat) {

      var nbr_page = parseInt(jQuery.parseJSON(resultat));
      var test = parseFloat(jQuery.parseJSON(resultat) % Limite);
      if (test > 0)
        Nbr_page = parseInt(nbr_page / Limite) + 1;
      else
        Nbr_page = parseInt(nbr_page / Limite);
      afficher_pagination(Nbr_page);
      $("#pagination_page td[id=" + page + "]").toggleClass("active")
      if (!fonction_supplementaire)
        charger_elements(Sort, Ordre, Filtre, Interval_date, page);
      else
        charger_elements(Sort, Ordre, Filtre, Interval_date, page, fonction_supplementaire);
    })
  }

  function cacher_filtre() {
    var champ2 = $("table #" + Champ);
    champ2.hide();
    var nom = $('#filtre_1').val()
    $(".filtres input").html(
      $("#filtre_1").val()
      )
    if (champs_selectionne == " ") {
      champs_selectionne += Champ + " : " + nom;
    } else {

      champs_selectionne += " et " + Champ + " : " + nom;
    }
    $("#entete_tableau").html("<h2 style='text-align: center; width: 100%;' >listes des camions pour " + champs_selectionne + "</h2>")
  }
  function recharger_autocomplete(Lettre){
    champ=$("#selection_filtres").find("option:selected").val();
    $.post("ajax/chargement/charger_autocomplete.php",{Lettre:Lettre,champ:champ,filtre:Filtre,interval_date:Interval_date,table:Cle_actuelle},function(resultas){
      results=jQuery.parseJSON(resultas)
      $( "input" ).autocomplete({source:eval(results)});

    })
  }
  function charger_projets(){
    $.post("ajax/chargement/charger_nom_projet.php",function(resultat){
      var resultat = jQuery.parseJSON(resultat);
      for(var i=0;i<resultat.length;i++)
      {
        $("#idprojet select").append("<option value ='"+resultat[i].id+"'>"+resultat[i].projet+"</option>");  
      }
    })
  }
  function charger_itineraires(idprojet,fonction_supplementaire){
   if(($("#idprojets").val()!='')||($("#conteneur_modification #idprojets").val()!=''))
   { 
    $("#iditineraire select").html('');
    $.post("ajax/chargement/charger_itineraires.php",{idprojet:idprojet},function(resultat){
      var resultat = jQuery.parseJSON(resultat);
      for(var i=0;i<resultat.length;i++)
      {
        $("#iditineraire select").append("<option value ='"+resultat[i].id+"'>"+resultat[i].depart+"-"+resultat[i].destination+"</option>");  
      }
      if(fonction_supplementaire)
        fonction_supplementaire()
    })
  }
  else alert("erreur"); 
}
function charger_nfr(val){
  if(($("#idprojets").val()!='')||($("#conteneur_modification #idprojets").val()!=''))
  { 
    valeur=val
    $.post("ajax/chargement/charger_nfr.php",{valeur:valeur},function(resultat){
      var resultat = jQuery.parseJSON(resultat);
      $("#nfrs #nfr").html();
      valeur=parseInt(resultat)+1
      if(isNaN(valeur))
      {
        $("#nfrs #nfr").val(1);
      } else
      $("#nfrs #nfr").val(valeur);

    })
  }
  else alert("erreur");
}
function charger_prix(val){
  if(val!='')
  { 
    valeur=val;
    $.post("ajax/chargement/charger_prix.php",{valeur:valeur},function(resultat){
      var resultat = jQuery.parseJSON(resultat);
      $("#prix input").html();
      valeur=parseInt(resultat)
      if(isNaN(valeur))
      {
        $("#prix input").val(1);
      } else
      $("#prix input").val(valeur);
    })
  }
  else console.log("erreur");
}
$(document).ready(function() {
  $("#cadre_reglage .bouton_fermer").on("click",function(){
    $("#cadre_reglage").css({"display": "none","visibility": "hidden"});
  })
  $("#cadre_facturation .bouton_fermer").on("click",function(){
    $("#cadre_facturation").css({"display": "none","visibility": "hidden"});
  })
  if((Cle_actuelle=="etats")||(Cle_actuelle=="routes")||(Cle_actuelle=="creances")||(Cle_actuelle=="dettes")||(Cle_actuelle=="creances_personnel")||(Cle_actuelle=="dettes_personnel")){
  $("#tableau_elements").delegate(".checkbox","change",function(){
      if($(this).is(':checked'))
      {
        if(Cle_actuelle=="creances")
        {
          reste=f_($(this).parent().parent().find("td.creances").html())
          tableau_reste.push(reste)
        }
        else
          if(Cle_actuelle=="dettes_personnel")
          {
            reste=f_($(this).parent().parent().find("td.dette").html());
            tableau_reste.push(reste)
          }
          else
            if(Cle_actuelle=="creances_personnel")
            {
              reste=f_($(this).parent().parent().find("td.creance").html());
              tableau_reste.push(reste) 
            }
            else
              if(Cle_actuelle=="routes")
              {
                if (typeof tableau_facturation != 'undefined'){
                  reste=parseFloat(f_($(this).parent().parent().find("td.price").html()));
                  tableau_reglage.push($(this).attr("id"))
                  console.log(tableau_reglage)
                } else{
                  reste=f_($(this).parent().parent().find("td.price").html());
                  tableau_reglage.push(reste)
                }
              }
              else
              {
                reste=f_($(this).parent().parent().find("td.reste").html());
                tableau_reste.push(reste)
              }
              console.log(Montant)
              console.log(reste)
              Montant+=parseFloat(reste);
              if(Cle_actuelle=="routes"){
                restant=prix-parseFloat(Montant);  
                $("#tableau_reglage #restant").html(f(restant))
              }
              $("#tableau_reglage #montant_reglage").html(f(Montant))
              $("#tableau_elements tr#"+$(this).attr("id")).toggleClass("a_regler");
            }
            else{
              if(Cle_actuelle=="creances")
               teste=f_($(this).parent().parent().find("td.creances").html())
             else
              if(Cle_actuelle=="creances_personnel")
               teste=f_($(this).parent().parent().find("td.creance").html())
             else
              if(Cle_actuelle=="dettes_personnel")
                teste=f_($(this).parent().parent().find("td.dette").html())
              if(Cle_actuelle=="routes"){
                teste=f_($(this).parent().parent().find("td.price").html())
              }
              else
                teste=f_($(this).parent().parent().find("td.reste").html())
              if(Cle_actuelle!="routes"){
              tableau_reste.splice($.inArray(teste, tableau_reglage),1);
              reste=$("#tableau_elements #"+$(this).attr("id")+" td.reste").html()
              reste=f_(reste);
              Montant-=parseFloat(reste);
              }else{
              tableau_reglage.splice($.inArray($(this).attr("id"),tableau_reglage),1);
              Montant-=parseFloat(teste);
              console.log(tableau_reglage) 
              }
                $("#tableau_reglage #montant_reglage").html(f(Montant))
                if(Cle_actuelle=="routes"){
                restant=prix-parseFloat(Montant);  
                $("#tableau_reglage #restant").html(f(restant))
              }
              $("#tableau_elements tr#"+$(this).attr("id")).toggleClass("a_regler");
              }
              if(tableau_reglage.length>0)
                $("#tableau_reglage #confirmation").removeClass("non_cliquable")
              else $("#tableau_reglage #confirmation:not(.non_cliquable)").addClass("non_cliquable")
            })
if(Cle_actuelle!="routes")
  {
$("#tableau_totaux").delegate("#confirmation","click",function(){
  var param={tableau_reglage:tableau_reglage,Cle_actuelle:Cle_actuelle,tableau_reste:tableau_reste};
  if(tableau_reglage.length>0)
  {
    afficher_loader()
    $.post("ajax/enregistrement/regler_check.php",param,function(resultat){
      cacher_loader();
      if(resultat==1){
        Test_reglage=0;
        Montant=0;
        filtrer();
        $("#tableau_elements tr#"+$(this).attr("id")).toggleClass("a_regler");
        $(".mode_reglage").toggleClass("mode_reglage")
      }
    })
  }else
  alert("veuillez selectionner les feuilles de routes a regler avant de confirmer")
})
} else{
 $("#tableau_reglage").delegate("#confirmation","click",function(){
  var param={tableau_reglage:tableau_reglage,Cle_actuelle:Cle_actuelle,idfacture:idfacture};
  if(tableau_reglage.length>0)
  {
    afficher_loader()
    $.post("ajax/enregistrement/regler_check.php",param,function(resultat){
      cacher_loader();
      if(resultat==1){
        filtrer();
      }
    })
  }else
  alert("veuillez selectionner les feuilles de routes a regler avant de confirmer")
}) 
}
$("#bouton_annuler").live("click",function(){
  Test_reglage=0;
  Montant=0;
  $("#tableau_elements tr#"+$(this).attr("id")).toggleClass("a_regler");
  $(".mode_reglage").toggleClass("mode_reglage")
  tableau_reste=[];
  tableau_reglage=[];
  filtrer();
})
$("#check_box").click(function(){
  filtrer(function(){
    Test_reglage=1;
  });
  $("#tableau_elements:not(.mode_reglage").toggleClass("mode_reglage"); 
    $("#cadre_reglage").fadeOut(200)
    var tableau_reglage =[];
  })
$("#check_box_facturation").click(function(){
  filtrer(function(){
    Test_facturation=1;
  });
  $("#tableau_elements:not(.mode_facturation)").toggleClass("mode_facturation"); 
    $("#cadre_facturation").fadeOut(200)
    var tableau_facturation =[];
  })
}
$("#ouvrir_formulaire").click(function(){$("#formulaire").slideToggle(500,function(){
  if($("#ouvrir_formulaire.fermer").length>0)
    $("#ouvrir_formulaire.fermer").html($("#ouvrir_formulaire.fermer").attr("message_afficher")).toggleClass("fermer").attr("title",$("#ouvrir_formulaire").attr('title1'));
  else
    $("#ouvrir_formulaire:not(.fermer)").attr("message_afficher",$("#ouvrir_formulaire:not(.fermer)").text()).html("Fermer").toggleClass("fermer").attr("title",$("#ouvrir_formulaire").attr('title2'));
  $('html, body').animate({
    scrollTop: $("#formulaire input:eq(0)").position().top-40
  }, 400);
})});
if(jQuery.validator)
{
  jQuery.validator.addMethod("exactlength", function(value, element, param) {
    return this.optional(element) || (value.length >=8 && value.length <= param);
  }, jQuery.format("veuillez saisir une date valide."));
  if((Cle_actuelle=="creances_personnel")||(Cle_actuelle=="dettes_personnel")||(Cle_actuelle=="projets")||(Cle_actuelle=="routes"))
  {
    $.validator.addMethod(
      "test_avance",function(){
        somme=0;
        somme=$("#cadre_modification form input[name='somme'],#cadre_modification form #prix input[name='prix']").val()
        somme=parseFloat(somme);
        var Test_succee=false;
        if (avances>somme)
        {
          Test_succee=false;
        }
        else
          Test_succee=true;
        return (Test_succee);
      }, "avance supperieur au prix");
  }
}
$("#formulaire input[name='date']").datepicker();
$("#selection_filtres").change(function(){
 actualiser_champ_filtre()
})
$(".filtre").autocomplete().bind("focus keyup",function(){
  Lettre=$(".filtre").val();
  recharger_autocomplete(Lettre);
})

$("#form_filtre").submit(function() {
  filtrer();
  return false;
})

$(".bloc_bouttons input:text").datepicker();
afficher_page(1, function() {
  recharger_selection()
  if (typeof tableau_facturation != 'undefined')
  for(var i=0;i<tableau_reglage.length;i++){
  Montant=Montant+parseFloat(f_($("#"+tableau_reglage[i]+" .price").html()));
  console.log(tableau_reglage)
  }
});
notification();

})
