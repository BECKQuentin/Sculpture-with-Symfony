$(function() {

    $('#adresse').on('input', function(e) {
        e.preventDefault()
        $.ajax( {
            method: 'GET',
            url: 'https://api-adresse.data.gouv.fr/search/',
            data: {
                q: $('#adresse').val(),
                limit: 10,
            },
            beforeSend: function() {
                console.log('-------Début------');
                $('#loader img').show();
            },
        })
        .done( function(data) {
            console.log(data);
            $.each(data.features, function(index, valeur) {
                $('#content').append ('<p>' + valeur.properties.label + '</p>');                
            })
        })
        .fail(function(jqHXR) {} )
        .always(function() {
            $('#loader img').hide();            
        })
    })


})//JQuery