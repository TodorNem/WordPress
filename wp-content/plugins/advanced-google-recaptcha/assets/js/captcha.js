function agr_load() { // jshint ignore:line
	var recaptcha = document.getElementsByClassName('agr-recaptcha-wrapper');

	for (var i = 0; i < recaptcha.length; i++) {
		grecaptcha.render(recaptcha.item(i), {'sitekey' : agrRecaptcha.site_key});
	}
}

function agr_v3() { // jshint ignore:line
	grecaptcha
	  .execute(agrRecaptcha.site_key, {
	    action: 'validate_recaptchav3'
	  })
	  .then(function(token) {
	    document
	      .querySelectorAll('.g-recaptcha-response')
	      .forEach(function(elem){
	      	elem.value = token;
	      })
	    ;
	  });
}
