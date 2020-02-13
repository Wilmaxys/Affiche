/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

let $ = require( 'jquery' );
require('select2');
require('datatables.net');
require('../js/fontAwesome.min.js');

require('select2/dist/css/select2.css');
require('../css/app.css');
require('../css/nozAffiche.css');

$( document ).ready(function () {

    $('#closeModal').click(function () {
        $(this).parents('.modal-container').toggleClass("dp-none");
    });

    $('#commande').click(function () {
        $('#commandeModal').toggleClass("dp-none");
    });

    $('.input-select2').select2();

    console.log("test");
    $('table').DataTable( {
        "lengthChange": false,
        "language": {
            "lengthMenu": "Afficher _MENU_ enregistrements par page",
            "search": "Rechercher :",
            "zeroRecords": "Aucun enregistrement trouvé.",
            "info": "Page _PAGE_ sur _PAGES_",
            "infoEmpty": "Aucun enregistrement disponible.",
            "infoFiltered": "(Filtré à partir de _MAX_ enregistrements)"
        }
    } );

    $('.header-profil-owerview-theme').click(function (){
        $('body').toggleClass('light dark');
    })

    $('.input-textBox').focusin(function () {
        if (!$(this).val()) {
            $(this).parent('.input-container').toggleClass('active');
        }
    }).focusout(function () {
        if (!$(this).val()) {
            $(this).parent('.input-container').toggleClass('active');
        }
    })

    // Mises en places de la sidebar

    $('#sidebar-grow-button').click(function () {
        $('.sidebar').toggleClass('sidebar-minimized');
        $('.sidebar-item').toggleClass('sidebar-item-minimized');

        if (localStorage.getItem('menuCollapse') !== "Collapse") {
            localStorage.setItem('menuCollapse', "Collapse");
        }
        else
        {
            localStorage.setItem('menuCollapse', "NotCollapse");
        }
    });

    $('.item-grow').click(function () {
        $(this).next().toggleClass('dp-none');
    })

    $('a').click(function () {
        var item = $(this);
        if (!item.hasClass('item-grow') && (item.attr('id') != "sidebar-grow-button")) {
            (item.hasClass('sidebar-item')) ? localStorage.setItem('currentActive', item.attr('id')) : localStorage.setItem('currentActive', undefined);
        }
    })

    $('.tab-title').click(function () {
        var forDiv = $(this).attr('for');

        $(this).parents('.tabs-container').find('.tab-content').each(function () {
            if (!$(this).hasClass('dp-none')) {
                $(this).toggleClass('dp-none');
            }
        });

        $(this).parents('.tabs-container').find('.tab-title').each(function () {
            if ($(this).hasClass('active')) {
                $(this).toggleClass('active');
            }
        });

        $(this).parents('.tabs-container').find('#' + forDiv).toggleClass('dp-none');
        $(this).toggleClass('active');
    });


    if (localStorage.getItem('menuCollapse') === "Collapse") {
        $('.sidebar').toggleClass('sidebar-minimized');
        $('.sidebar-item').toggleClass('sidebar-item-minimized');
    }

    if(localStorage.getItem('currentActive'))
    {
        var currentObject = $('#' + localStorage.getItem('currentActive'));
        if (currentObject) {
            currentObject.toggleClass('active');
            currentObject.parents('.sidebar-subbed').toggleClass('dp-none');
        }
    }

    $('.tabs-container').each(function (){
        $(this).find('.tab-content').toggleClass('dp-none');
        $(this).find('.tab-content').first().toggleClass('dp-none');
        $(this).find('.tab-title').first().toggleClass('active');
    });

    $('.header-profil').click(function (event) {
        if (!$(event.target).parents('#header-profil-owerview').length > 0) {
            $('#header-profil-owerview').toggleClass('dp-none');
        }
    });

    $('body').click(function (event)
    {
        if(!$(event.target).closest('#header-profil-owerview').length && !$(event.target).is('#header-profil-owerview') && !($(event.target).parents('.header-profil').length > 0)) {
            if (!$("#header-profil-owerview").hasClass('dp-none')) {
                $("#header-profil-owerview").toggleClass('dp-none');
            }
        }
    });

    // Pin system

    $('#sidebar-pin-button').click( function() {
        $(this).toggleClass('active');
        $('.content').toggleClass('content-pin');

        if (!$(this).hasClass('active')) {
            localStorage.setItem('pinDesactivated', "true");
        }
        else{
            localStorage.setItem('pinDesactivated', undefined);
        }
    });

    if (localStorage.getItem('pinDesactivated') == "true") {
        $('.sidebar').addClass('sidebar-invisible');
    }
    else{
        $('#sidebar-pin-button').addClass('active');
    }

    $('.sidebar').hover(function () {
        if (localStorage.getItem('pinDesactivated') == "true") {
            $(this).toggleClass('sidebar-invisible');
            var currentObject = $('#' + localStorage.getItem('currentActive'));
            if (currentObject && !currentObject.hasClass('active')) {
                currentObject.addClass('active');
            }
        }
    }, function () {
        if (localStorage.getItem('pinDesactivated') == "true") {
            $(this).toggleClass('sidebar-invisible');
            var currentObject = $('#' + localStorage.getItem('currentActive'));
            if (currentObject) {
                currentObject.removeClass('active');
            }
        }
    });

    // Show item when all the element are initialized

    $('.sidebar').toggleClass('dp-none');
    $('.tabs-container').toggleClass('dp-none');
})

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
