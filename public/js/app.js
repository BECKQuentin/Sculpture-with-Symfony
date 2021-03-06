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
        $('.contact_right_texte_info p').toggleClass('nightmode_off_black');
        $('.contact_bottom_texte p').toggleClass('nightmode_off_black');
        $('.empty_command_title').toggleClass('nightmode_off_black');
        $('.member_infos').toggleClass('nightmode_off_black');
        $('.member_button').toggleClass('nightmode_off_black');
        $('.add_article').toggleClass('nightmode_off_black');
        $('.confirm_command').toggleClass('nightmode_off_black');        
        $('.nbr_command').toggleClass('nightmode_off_black');        
        
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

})//jquery