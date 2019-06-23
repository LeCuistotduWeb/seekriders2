import algoliasearch from 'algoliasearch/dist/algoliasearch'
let appId = 'plEON2OM6ISI';
let apikey = 'a2b925736823f0cf3a776a6602f2b27e';

// input algolia places search
const placesAutocomplete = places({
    appId: appId,
    apiKey: apikey,
    container: document.querySelector('#address-input'),
});
placesAutocomplete.on('change', function resultSelected(e) {
    document.querySelector('#address-input').value = e.suggestion.value || '';
    document.querySelector('.js-address').value = e.suggestion.name || '';
    document.querySelector('.js-country').value = e.suggestion.country || '';
    document.querySelector('.js-region').value = e.suggestion.administrative || '';
    document.querySelector('.js-department').value = e.suggestion.county || '';
    document.querySelector('.js-city').value = e.suggestion.city || '';
    document.querySelector('.js-postcode').value = e.suggestion.postcode || '';
    document.querySelector('.js-lng').value = e.suggestion.latlng.lng || '';
    document.querySelector('.js-lat').value = e.suggestion.latlng.lat || '';
});

// getMyPosition
(function() {
    let places = algoliasearch.initPlaces(appId,apikey);

    function updateForm(response) {
        let hits = response.hits;
        let suggestion = hits[0];

        if (suggestion && suggestion.locale_names && suggestion.city) {
            document.querySelector('#address-input').value = suggestion.locale_names.default || '';
            document.querySelector('.js-address').value = suggestion.locale_names.default || '';
            document.querySelector('.js-country').value = suggestion.country.default || '';
            document.querySelector('.js-region').value = suggestion.county.default || '';
            document.querySelector('.js-department').value = suggestion.administrative || '';
            document.querySelector('.js-city').value = suggestion.city.default || '';
            document.querySelector('.js-postcode').value = suggestion.postcode || '';
            document.querySelector('.js-lng').value = suggestion._geoloc.lng || '';
            document.querySelector('.js-lat').value = suggestion._geoloc.lat || '';
        }
    }

    let lat, lng;
    let $button = document.querySelector('#locateMe');
    let $latInput = document.querySelector('.js-lat');
    let $lngInput = document.querySelector('.js-lng');

    $latInput.addEventListener('change', function(e) {
        e.preventDefault()
        try {
            lat = parseFloat(e.target.value);

            if (typeof lat !== 'undefined' && typeof lng !== 'undefined') {
                places.reverse({
                    aroundLatLng: lat + ',' + lng,
                    hitsPerPage: 1,
                }).then(updateForm);
            }
        } catch (e) {
            lat = undefined;
        }
    });

    $lngInput.addEventListener('change', function(e) {
        try {
            lng = parseFloat(e.target.value);

            if (typeof lat !== 'undefined' && typeof lng !== 'undefined') {
                places.reverse({
                    aroundLatLng: lat + ',' + lng,
                    hitsPerPage: 1,
                }).then(updateForm);
            }
        } catch (e) {
            lng = undefined;
        }
    });

    $button.addEventListener('click', function() {
        navigator.geolocation.getCurrentPosition(function(response) {
            var coords = response.coords;
            lat = coords.latitude.toFixed(6);
            lng = coords.longitude.toFixed(6);

            $latInput.value = lat;
            $lngInput.value = lng;

            places.reverse({
                aroundLatLng: lat + ',' + lng,
                hitsPerPage: 1
            }).then(updateForm);
        });
    });
})();