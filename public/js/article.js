$(function(){

    var getArticleImage;
    var getCreationImage;
    var getCreationTitle;
    var getMessageText;

    /////////////////Article//////////////////
    $('.vue_article_miniature').click(function() {
                
        getArticleImage = $(this).data('getArticleImage');
        
        $('.vue_article_return img').attr('src', getArticleImage);

    })

    //////////////Command/////////////



    /////////////Creation/////////////
    $('.galerie_cadre a').click(function() {
                
        getCreationImage = $(this).data('getCreationImage');        
        getCreationTitle = $(this).data('getCreationTitle'); 
        
        $('.modal-content').attr('src', getCreationImage);
        $('.creation_modal_title').text(getCreationTitle);
    })

    /////////////Message/////////////
    $('#see_message a').click(function() {

        getMessageText = $(this).data('getMessageText');

        $('#message_modal_body p').text(getMessageText);
    })
    
})//Jquery