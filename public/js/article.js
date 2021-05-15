$(function(){

    var getArticleImage;

    /////////////////Article//////////////////
    $('.vue_article_miniature').click(function() {
                
        getArticleImage = $(this).data('getArticleImage');

        console.log(getArticleImage);
        
        $('.vue_article_return img').attr('src', getArticleImage);

    })

})//Jquery