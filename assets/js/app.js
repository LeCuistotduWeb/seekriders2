// any CSS you require will output into a single css file (app.scss in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
let $ = require('jquery');
require('popper.js');
require('bootstrap');
require('bootstrap-datepicker');

let axios = require('axios');

// active alert bootstrap
$(function() {
    // $(".alert").fadeTo(2000, 500).slideUp(500, function(){
    //     $("#success-alert").slideUp(500);
    // });
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
        e.preventDefault()
        fetch(a.getAttribute('href'), {
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
                if(response.status == 200){
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
    })
});

    //     fetch(a.getAttribute('href'), {
    //         headers: {
    //             'X-Requested-With': 'XMLHttpRequest',
    //             'Content-Type': 'application/json'
    //         },
    //     }).then(response => response.json())
    //         .then(data => {
    //             if (data.code == 200 ) {
    //
    //             } else {
    //                 console.log('Une erreur s\'est produite')
    //             }
    //         })
    //         .catch(e => alert(e))
    // })