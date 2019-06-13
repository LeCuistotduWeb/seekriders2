// any CSS you require will output into a single css file (app.scss in this case)
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
import '../css/app.scss';
import 'popper.js';
import 'bootstrap-datepicker';
import 'bootstrap';
import Map from './modules/map';
import $ from 'jquery';
import axios from 'axios';

Map.init();

// active alert bootstrap
$(function() {
    $(".alert").fadeTo(3000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });
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


