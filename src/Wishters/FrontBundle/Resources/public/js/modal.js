$(document ).ready(function() {
    // Validateur pour le formulaire d'ajout d'annonce
    $("#formAddAnnonce").validate({
        rules: {
            "annonce[hashtag]": {
                "required": true,
                "minlength": 2
            },
            "annonce[title]": {
                "required": true,
                "minlength": 3
            },
            "annonce[content]":{
                "required" : true,
                "minlength": 3
            },
            "annonce[price]":{
                "required" : true,
                "number": true
            }
        }});
    // Validateur pour le formulaire d'ajout de message blog
    $("#formAddMessage").validate({
        rules:{
            "blog[content]": {
                "required": true,
                "minlength": 3
            }
        }
    });
    // Validateur pour le formulaire d'identification
    $("#formPersoLogin").validate({
        rules:{
            "_username": {"required": true},
            "_password": {"required": true}
        }
    });

    $.extend($.validator.messages, {
        required: "Ce champs est requis",
        remote: "Votre message",
        email: "votre message",
        url: "votre message",
        date: "votre message",
        dateISO: "votre message",
        number: "Ne peu contenir que des chiffres",
        digits: "Votre message",
        creditcard: "votre message",
        equalTo: "votre message",
        accept: "votre message",
        maxlength: $.validator.format("{0} caractéres maximum."),
        minlength: $.validator.format("{0} caractéres minimum."),
        rangelength: $.validator.format("votre message  entre {0} et {1} caractéres."),
        range: $.validator.format("votre message doit etre compris entre {0} et {1}."),
        max: $.validator.format("votre message  inférieur ou égal à {0}."),
        min: $.validator.format("votre message  supérieur ou égal à {0}.")
    });

    $('.showBlogModal').on('click', function() {
        var rel = $(this).attr('rel');
        $.ajax({
            url: Routing.generate('wishters_front_blog_resume'),
            type: 'get',
            data: {
                user: rel
            },
            beforeSend: function(){
                $('.modal-content-blog-resume').html('<div class="row modal-body"><div class="col-xs-12"><h4>Chargement en cours....</h4></div></div>');
            },
            success: function(data){
                $('.modal-content-blog-resume').html(data.message);
            },
            error: function(){
                $('.modal-content-blog-resume').html('<div class="row modal-body"><div class="col-xs-12"><h4>Oups....Y\'a une erreur là, désolé.</h4></div></div>');
            }
        });
    });

    $('#modalAddAnnonceShow').on('click', function(){

        $.ajax({
            url: Routing.generate('wishters_front_annonce_add'),
            type: 'get',
            beforeSend:function(){
                $('.addAnnonce').html('<h4 class="text-center">Chargement en cours....</h4>');
            },
            success: function(data){
                $('.addAnnonce').html(data.message);
            },
            error: function(){
                $('.addAnnonce').html('<h4 class="text-center">Oups....On à une erreur la.</h4>');
            }
        });
    });

    $('#modalAddBlogShow').on('click', function(){

        $.ajax({
            url: Routing.generate('wishters_front_blog_add'),
            type: 'get',
            beforeSend:function(){
                $('.addBlog').html('<h4 class="text-center">Chargement en cours....</h4>');
            },
            success: function(data){
                $('.addBlog').html(data.message);
            },
            error: function(){
                $('.addBlog').html('<h4 class="text-center">Oups....On à une erreur la.</h4>');
            }
        });
    });

});