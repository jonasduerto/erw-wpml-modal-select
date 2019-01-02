var $ = jQuery.noConflict();
jQuery(document).ready(function($) {
	
	var text_en             = $('#text_en');
	var text_es             = $('#text_es');

	var btn_en             = $('#btn_en');
	var btn_es             = $('#btn_es');
	var current_lang        = icl_vars.current_language;
	var cookie_current_lang = Cookies.get('languageSelector');
	// console.log(icl_vars);
	// console.log('Current language = '+current_lang);
	// console.log(curent_slug);
	// console.log('Cookies language = '+cookie_current_lang);



	if (getLangCode == 'en') {
		text_en.addClass('active');
		text_es.removeClass('active');
	} else {
		text_es.addClass('active');
		text_en.removeClass('active');
	};

	$('#btn_en').on('hover', function(event) {
		event.preventDefault();
		text_en.addClass('active');
		text_es.removeClass('active');
	});
	$('#btn_es').on('hover', function(event) {
		event.preventDefault();
		text_es.addClass('active');
		text_en.removeClass('active');
	});

	console.log(Cookies.get('languageSelector'));
	console.log(cookie_current_lang);
  


	if (
		// ( ( cookie_current_lang == "es"  &&  current_lang != 'es') && showMSL == 1 ) ||
		// ( ( cookie_current_lang == "en"  &&  current_lang != 'en') && showMSL == 1 ) ||
		( cookie_current_lang == null  &&  showMSL == 1  )
	   ) { 
		$('#languageSelector').modal({
			show:true,
			backdrop: 'static', 
			keyboard: false
		})   
	};


	$( "#btn_en" ).on('click', function(event) {
		// event.preventDefault();
		Cookies.set('languageSelector', 'en', { expires: 1 }
		);
	});
	$( "#btn_es" ).on('click', function(event) {
		// event.preventDefault();
		Cookies.set('languageSelector', 'es', { expires: 1 }
		);
	});
});