$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip()
    $('.fileinput').fileinput()

    $('.flash-success').each(function(){
        $(this).css('top', 65 * $(this).index() + 'px');
        $(this).animate({'right': '0px' });
        $(this).delay(6000).animate({'right': '-350px' });
    });

    $('.flash-success').click(function(){
        $(this).hide();
    });

    $('#change-avatar-btn').hide();

    $('#fos-user-edit-avatar').hover(function(){
        $('#change-avatar-btn').removeClass('hidden').toggle();
    })

    $('input#wishters_frontbundle_search_content').on('keyup', function(){

        var currlength = $(this).val().length;
        var search      = $(this).val();
        var url         = 'http://wishters/app_dev.php/annonce/';
        if(currlength > 2){

            $('.result').empty();
            $.ajax({
                type: "GET",
                url: Routing.generate('wishters_ajax_search', { 'search': search }),
                dataType: 'json',
                beforeSend: function() {
                    console.log('BeforeSend en cours...');
                },
                success: function(data){
                    $.each(data.actu, function(index, value){
                        $('.result').append($("<a class='list-group-item' href="+url+value.id+"> </a>").html( '<span class="text-danger">'+value.author+'</span> : '+value.title+' <span class=" label label-success pull-right">'+value.price+'€</span>')
                        );
                    });

                    $('.result').on('mouseleave', function(){
                        $('.result').empty();
                    });

                },
                error: function(){
                    console.log('Error en cours...');
                }
            });

        }

    });

    $('.add-abonnement-btn').on('click', function () {

        $.ajax({

            url: Routing.generate('wishters_front_relation_add', { id: $(this).attr('rel') }),
            type: 'get',
            beforeSend: function(){
                console.log('Ajout de relation en cours..');
            },
            success: function(){
                console.log('Ajout de relation validé..');
                $('.add-abonnement-btn').removeClass('btn-success').addClass('btn-info').html('<i class="fa fa-check"></i> Abonné');
            },
            error: function(){
                console.log('Y\'a une erreur lors de l\'ajout de relation');
            }

        });

    });

    $('.remove-abonnement-btn').on('hover', function(){
        $(this).removeClass('btn-info').addClass('btn-danger').text('Se désabonner');
    });

    $('.remove-abonnement-btn').on('click', function () {

        $.ajax({

            url: Routing.generate('wishters_front_relation_remove', { id: $(this).attr('rel') }),
            type: 'get',
            beforeSend: function(){
                console.log('Annulation de relation en cours..');
            },
            success: function(){
                console.log('Annulation de relation validé..');
                $('.remove-abonnement-btn').removeClass('btn-info').addClass('btn-success').html('<i class="fa fa-check"></i> S\'abonner');
            },
            error: function(){
                console.log('Y\'a une erreur lors de l\'annulation de relation');
            }

        });

    });

    $('.remove-abonnement-btn-blog').on('click', function () {

        var data = $(this).attr('rel');

        $.ajax({

            url: Routing.generate('wishters_front_relation_remove', { id: $(this).attr('rel') }),
            type: 'get',
            beforeSend: function(){
                console.log('Annulation de relation en cours..');
            },
            success: function(){
                console.log('Annulation de relation validé..');
                $('.remove-abonnement-btn-blog[rel='+ data +']').parent().parent().slideUp();
            },
            error: function(){
                console.log('Y\'a une erreur lors de l\'annulation de relation');
            }

        });

    });


});
