$(function() {
    // efecto en jurados y noticias
    $('a.more').toggle(function(){
        hidd = $(this).attr('rel');
        $('.hidden'+hidd).slideDown();
    //$('.hidden').show();
    }, function() {
        $('.hidden'+hidd).slideUp();
    });
    $('#carousel').cycle({
        fx:     'fade',
        speed:  'fast',
        timeout: 0,
        next:   '#next2',
        prev:   '#prev2'
    });
    Socialite.setup({
        facebook: {
            lang : 'es_LA'
        },
        twitter: {
            lang : 'es'
        },
        googleplus: {
            lang : 'es-419'
        }

    });
    Socialite.load();
});