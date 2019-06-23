// any CSS you require will output into a single css file (app.scss in this case)
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// import 'bootstrap/scss/bootstrap.scss';
import '../css/app.scss';
import $ from 'jquery';
import 'jquery.easing';
import 'popper.js';
import 'bootstrap';
import 'bootstrap-datepicker';
import 'bootstrap4-datetimepicker';
import Map from './modules/map';
import axios from 'axios';

Map.init();

// active alert bootstrap
$(function() {
    $(".alert").fadeTo(3000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });
});

"use strict"; // Start of use strict

// Toggle the side navigation
$("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
        $('.sidebar .collapse').collapse('hide');
    };
});

// Close any open menu accordions when window is resized below 768px
$(window).resize(function() {
    if ($(window).width() < 768) {
        $('.sidebar .collapse').collapse('hide');
    };
});

// Prevent the content wrapper from scrolling when the fixed side navigation hovered over
$('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
        var e0 = e.originalEvent,
            delta = e0.wheelDelta || -e0.detail;
        this.scrollTop += (delta < 0 ? 1 : -1) * 30;
        e.preventDefault();
    }
});

// Scroll to top button appear
$(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
        $('.scroll-to-top').fadeIn();
    } else {
        $('.scroll-to-top').fadeOut();
    }
});

// Smooth scrolling using jQuery easing
$(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
        scrollTop: ($($anchor.attr('href')).offset().top)
    }, 750, 'easeInOutExpo');
    e.preventDefault();
});

// datepicker birthday
$( function() {
    $( "#account_birthdayAt" ).datepicker({
        format: "yyyy-mm-dd",
        startDate: "-100y",
        endDate: "-14y",
        language: "fr",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });
});

// datetime picker
//http://eonasdan.github.io/bootstrap-datetimepicker/
$(function () {
    $('.js-datetime-picker').datetimepicker({
        inline: false,
        sideBySide: true,
        format: "YYYY-MM-DD HH:mm",
        locale: 'fr',
        minDate: new Date(),
    });
});

// DELETE  picture
document.querySelectorAll('[data-delete]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault();
        axios(a.getAttribute('href'), {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({'_token': a.dataset.token})
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    a.parentNode.parentNode.removeChild(a.parentNode)
                } else {
                    console.log('Une erreur s\'est produite')
                }
            })
            .catch(e => alert(e))
    })
});

// spot like
document.querySelectorAll('a[data-spotLike]').forEach(a => {
    a.addEventListener('click', (event) => {
        event.preventDefault();
        const url = a.href;
        const icon = a.querySelector('i');

        axios.get(url)
            .then(function (response) {
                if(response.status === 200){
                    if (icon.classList.contains('fas')){
                        icon.classList.replace('fas','far')
                    }else{
                        icon.classList.replace('far','fas')
                    }
                }
            })
            .catch(function (error) {
                if(error.response.status === 403){
                    window.alert("Vous devez être connecté pour ajouter un spot en favoris !")
                }
            });
    });
});

// add participant to session
document.querySelectorAll('a[data-sessionParticipant]').forEach(a => {
    a.addEventListener('click', (event) => {
        event.preventDefault();
        const url = a.href;
        console.log(a);
        axios.get(url)
            .then(function (response) {
                if(response.status === 200){
                    if (a.classList.contains('btn-danger')){
                        a.classList.add('btn-primary');
                        a.classList.remove('btn-danger');
                        a.innerHTML = 'Participer';
                    }else{
                        a.classList.add('btn-danger');
                        a.classList.remove('btn-primary');
                        a.innerHTML = 'Ne plus participer';
                    }
                }
            })
            .catch(function (error) {
                if(error.response.status === 403){
                    window.alert("Vous devez être connecté pour ajouter un spot en favoris !")
                }
            });
    });
});