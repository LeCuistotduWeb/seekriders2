// any CSS you require will output into a single css file (app.scss in this case)
require('../css/bootstrap.min.css');
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
let $ = require('jquery');
require('popper.js');
require('bootstrap');

$(function() {
    // active alert bootstrap
    $(".alert").alert();
});