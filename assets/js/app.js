/**
 * main
 */

// librairies
require('bootstrap-sass');

// customed css
require('../css/app.scss');

// date picker
require('flatpickr');
require('flatpickr/dist/l10n/fr.js');

// customed libraries
import MP_frise from './frise.js';

// customed scripts
require('./login.js');
require('./utils.js');

// on document ready
$(function () {

    var oFrise = new MP_frise.init();

	/**
     * flatpickr : https://flatpickr.js.org/
     * @type {*|Instance|Instance[]}
     */
    const fp = flatpickr(".flatpickr", {
        locale: document.documentElement.lang,
        allowInput: false,
        // on met à jour les champs cachés à la sélection d'une date
        onChange: function(selectedDates, dateStr, instance){
            var d = selectedDates[0];
            var elName = instance.input.name;
            document.getElementById(elName+'_day').value = d.getDate();
            document.getElementById(elName+'_month').value = d.getMonth()+1;
            document.getElementById(elName+'_year').value = d.getFullYear();
        }
    });
    $('#mpFlash').fadeIn(1000);
    setTimeout(function(){
        $('#mpFlash').fadeOut(2000);
    },5000);



});