var places = require('places.js');

(function() {
    var placesAutocomplete = places({
        appId: 'plEON2OM6ISI',
        apiKey: 'a2b925736823f0cf3a776a6602f2b27e',
        container: document.querySelector('.js-address'),
        templates: {
            value: function(suggestion) {
                return suggestion.name;
            }
        }
    }).configure({
        type: 'address'
    });

    placesAutocomplete.on('change', function resultSelected(e) {
        console.log(e);
        document.querySelector('.js-address').value = e.suggestion.name || '';
        document.querySelector('.js-country').value = e.suggestion.country || '';
        document.querySelector('.js-region').value = e.suggestion.administrative || '';
        document.querySelector('.js-department').value = e.suggestion.county || '';
        document.querySelector('.js-city').value = e.suggestion.city || '';
        document.querySelector('.js-postcode').value = e.suggestion.postcode || '';
        document.querySelector('.js-lng').value = e.suggestion.latlng.lng || '';
        document.querySelector('.js-lat').value = e.suggestion.latlng.lat || '';
    });
})();