//slider
$(function(){
    
    //////////NIGHTMODE////////////
    function changeClassNightmode () {        
        $('.container').toggleClass('nightmode_off_white');
        $('.precedent').toggleClass('nightmode_off_black'); 
        $('.suivant').toggleClass('nightmode_off_black'); 
        $('.precedent').toggleClass('nightmode_off_rond');
        $('.suivant').toggleClass('nightmode_off_rond');
        $('.ball').toggleClass('nightmode_on_black');
        $('.select_nightmode').toggleClass('nightmode_off_white');
        $('h3, h4, h5').toggleClass('nightmode_off_black'); 
        $('th, td, label').toggleClass('nightmode_off_black');
        $('.cadre_contact p').toggleClass('nightmode_off_black');
        $('.panier_empty').toggleClass('nightmode_off_black');
        $('.caddie').toggleClass('nightmode_off_black');
        $('.link_inscription').toggleClass('nightmode_off_black');
        $('.nom_article p').toggleClass('nightmode_off_black');
        $('.article_photo').toggleClass('nightmode_off_black');
        $('.prix p').toggleClass('nightmode_off_black');
        
    }
    if (localStorage.getItem('nightmode') == 'off') {
        changeClassNightmode();
        //précocher case nightmode
        $("#nightmode").prop("checked", true);
    }
    else if (localStorage.getItem('nightmode') == 'on') {
        //décocher case nightmode
        $("#nightmode").prop("checked", false);
    }
    $('#nightmode').change(function() {
        if ($('#nightmode').is(':checked')){
            localStorage.setItem('nightmode', 'off');
        }
        else {
            localStorage.setItem('nightmode', 'on');
        }
        if (localStorage.getItem('nightmode') == 'off') {
            changeClassNightmode();
        }
        else if (localStorage.getItem('nightmode') == 'on') {
            changeClassNightmode();
        }
    });
    
    //////////////////////Slider/////////////////
    ///////////Interval
    let intervalOn = true;
    if (intervalOn == true) {
        setInterval(function(){
            $(".slideshow ul").animate({marginLeft:-450},800,function(){
               $(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));
            })
         }, 4500);
    }
    ////////////fleche precedente
    $('.precedent').on('click', function() {                   
        intervalOn = false;
        $(".slideshow ul").find("li:first").before($(".slideshow ul").find("li:last"));        
        $(".slideshow ul").css({marginLeft:-450})
        $(".slideshow ul").animate({marginLeft:0},800)
        intervalOn = true;   
    })
    ////////////fleche suivante
    $('.suivant').on('click', function() {
        intervalOn = false; 
        $(".slideshow ul").animate({marginLeft:-450},800,function(){
            $(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));
            intervalOn = true;  
        })    
    })

    /////////////////////Galerie////////////////////////
    $('.galerie_cadre').on('click', function(e) {               
        let src_target = $(e.target).attr('src');        
        $(".galerie_affichage").prepend('<div class="galerie_affichage_photo"></div>');
        let img = $('<img/>', {
        class: 'imageAfficher',
        src: src_target,
        }).appendTo($('.galerie_affichage_photo'));
        $('.galerie_affichage').css('display', 'flex'); 
        $(".galerie_affichage").prepend('<div class="galerie_overlay"></div>');
        $('.galerie_affichage_photo').prepend('<i class="fas fa-times fermer_affichage"></i>');
        $('.galerie_affichage_photo').prepend('<i class="fas fa-arrow-right galerie_suivant"></i>');
        $('.galerie_affichage_photo').prepend('<i class="fas fa-arrow-left galerie_precedent"></i>');

        ////fermer affichage/////
        $('.fermer_affichage').on('click', function() {
            $('.galerie_affichage').css('display', 'none');
            $(".galerie_affichage").empty();
        });        
    }) 
    
    /////////////////Article//////////////////
    $('.vue_photo_miniature_cadre').click(function() {
        
    })

})//jquery