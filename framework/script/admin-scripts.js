// Themple Framework admin scripts
jQuery(document).ready(function($) {

	"use strict";

/*
TABLE OF CONTENTS
-----------------

1. Variable definition
2. Scripts for single data types
	2.1 Image
	2.2 Color
	2.3 Select
	2.4 TinyMCE
	2.5 Date
	2.6 Boolean
3. Scripts for repeater fields
	3.1 Repeater Previews
4. Common settings
	4.1 Tabs in the backend
5. Conditional settings

*/




/*

	1. DEFINING THE VARIABLES NECESSARY FOR THIS SCRIPT
	===================================================

*/

	// Needed for the Image data type
    var custom_uploader;

	// Needed for the Select data type
	// Basic settings for all types of dropdowns
	TPL_Admin.basic_select2_settings = {
		escapeMarkup: function(m) {
			return m;
		},
		width: "100%",
	}

	// General settings for simple select dropdowns
	var select2_settings = $.extend( {
		minimumResultsForSearch: 10,
	}, TPL_Admin.basic_select2_settings );

	// Font Awesome dropdown settings
	var fa_icon_settings = $.extend( {
		templateSelection: tpl_fa_icon_template,
		templateResult: tpl_fa_icon_template,
		formatSelection: tpl_fa_icon_template,
		formatResult: tpl_fa_icon_template,
		minimumResultsForSearch: 10,
	}, TPL_Admin.basic_select2_settings );

	// Do an initial row arrangement, just in case...
	tpl_arrange_rows();

	// Remove the dummy editor from the TO/FO DOM after initialization
	$('#wp-dummy_editor-wrap').remove();




/*

	2. SCRIPTS FOR SINGLE DATA TYPES
	================================

	2.1 IMAGE DATA TYPE
	-------------------

*/

	// Main uploader popup handler
    $('body').on('click', '.tpl-uploader .button, .tpl-uploader .tpl-uploaded-image, .tpl-img-placeholder', function(e) {

        e.preventDefault();
		var imgurl = $(this).parent().find('.tpl-uploaded-image');
		var current_item = imgurl.closest('.tpl-field');

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: TPL_Admin.uploader_title,
            button: {
                text: TPL_Admin.uploader_button
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
			if ( typeof attachment.sizes.thumbnail !== 'undefined' ) {
				imgurl.attr('src', attachment.sizes.thumbnail.url);
			}
			else {
				imgurl.attr('src', attachment.sizes.full.url);
			}
			imgurl.show();
			current_item.find('.tpl-img_id').val(attachment.id).trigger('change');
			current_item.find('.tpl-img-placeholder').hide();
			current_item.find('.tpl-closer').show();
			tpl_set_repeater_headers();
        });

        //Open the uploader dialog
        custom_uploader.open();

    });


	// Clear the uploaded picture with the "X" icon
	$('body').on('click', '.tpl-uploader .tpl-closer', function(){

		var imgurl = $(this).parent().find('.tpl-uploaded-image');
		var current_item = imgurl.closest('.tpl-field');
		imgurl.attr('src', '');
		current_item.find('.tpl-img-placeholder').show();
        current_item.find('.tpl-uploaded-image').hide();
		$(this).closest('.tpl-field').find('.tpl-img_id').val('').trigger('change');
		$(this).hide();
		tpl_set_repeater_headers();

	});




/*

	2.2 COLOR DATA TYPE
	-------------------

*/

	// Common color picker settings used by all instances
	var color_picker_settings = {
		width : 258,
		change : function(event,ui){
			$(this).val($(this).wpColorPicker('color'));
			tpl_condition_updater();
			tpl_set_repeater_headers();
		}
	}

	// Color picker script
    $('body .tpl-color-field').each(function(){
		$(this).wpColorPicker( color_picker_settings );
	});





/*

	2.3 SELECT DATA TYPE
	--------------------

*/

	// Select scripts
	function tpl_select2_init(){
		$('body .tpl-dt-select').each(function(){
			if ( $(this).has('.select2').length < 1 && !$(this).hasClass('no-select2') && !$(this).parents('#tpl_repeater_bank').length ) {

				if ( $(this).is('.tpl-dt-font_awesome') ) {
					$(this).find('select').select2( fa_icon_settings );
				}
				else {
					$(this).find('select').select2( select2_settings );
				}

			}
		});
	}
	tpl_select2_init();

	// Font Awesome select field template
	function tpl_fa_icon_template(data) {
		if ( data.id != '' ) {
			return data.text;
		}
		else {
			return data.text.name;
		}
	}

	// Handle the Font Awesome preview with the FA5 update
	$('.tpl-dt-font_awesome select').change(function(){
		var data = $(this).select2('data');
		var found = data[0].text.match(/ data-type="([^"]*)"/);
		$(this).closest('.tpl-field').find('.tpl-preview-3').val(found[1]);
		$(this).closest('.tpl-field').find('.tpl-preview-3').attr(found[1]);
	});





/*

	2.4 TINYMCE DATA TYPE
	---------------------

*/

	// Settings for the TinyMCE editor
	function tpl_tinymce_init() {
		$( 'body .tpl-field.tpl-dt-tinymce' ).not( $('body .tpl-field.tpl-dt-tinymce.tpl-admin-hide') ).each(function(){
			var id = $(this).find('textarea').attr('id');
			tinyMCE.execCommand( 'mceAddEditor', false, id );
		});
		$( 'body .tpl-field.tpl-dt-tinymce.tpl-admin-hide').each(function(){
			var id = $(this).find('textarea').attr('id');
			tinyMCE.execCommand( 'mceRemoveEditor', false, id );
		});
	}




	/*

		2.5 DATE DATA TYPE
		------------------

	*/

	// Date picker for the Date type
	if ($.datepicker !== undefined) {
		$('body .tpl-field.tpl-dt-date input.tpl-date-field').datepicker({
			dateFormat: 'yy-mm-dd',
			firstDay: TPL_Admin.date_starts_with
		});
	}




	/*

		2.6 BOOLEAN DATA TYPE
		---------------------

	*/

	// Setting the value for the boolean DT
	$('body').on('click', '.tpl-field.tpl-dt-boolean label', function(){
		var old_value = parseInt( $('input', this).val() );
		if ( old_value == 1 ) {
			var new_value = 0;
		}
		if ( old_value == 0 || isNaN( old_value ) ) {
			var new_value = 1;
		}
		$('input', this).val( new_value ).trigger('change');
		$(this).attr('class', 'checked-' + new_value );
	});





/*

	3. REPEATER FIELDS
	==================

*/

	// Post metaboxes and settings pages use different containers, that's why we need this function
	function tpl_repeat_set_container( elem ){

		var url = window.location.href;

		// Primary Options page (e.g. Plugin Settings)
		if ( url.indexOf('themes.php') > -1 || url.indexOf('options-general.php') > -1 || url.indexOf('admin.php') > -1 ) {
			if ( elem.parent().prev().hasClass('tpl-subitem-repeat-wrapper') ) {
				var container = elem.parent().prev('.tpl-subitem-repeat-wrapper');
			}
			else {
				var container = elem.closest('tr').prev().find('td');
			}
		}
		// Post options branch
		if ( url.indexOf('post.php') > -1 || url.indexOf('post-new.php') > -1 ) {
			if ( elem.parent().prev().hasClass('tpl-subitem-repeat-wrapper') ) {
				var container = elem.parent().prev('.tpl-subitem-repeat-wrapper');
			}
			else {
				var container = elem.parent().prev('.tpl-meta-option-wrapper');
			}
		}

		return container;

	}



	// Add rows to repeater
	$('body').on('click', 'button.tpl-repeat-add', function(e){
		e.preventDefault();
		var container = tpl_repeat_set_container( $(this) );
		tpl_add_row( container, $(this).attr('data-for') );
	});

	// Adds a repeater row into the container picking the fields connected with data_name
	function tpl_add_row( container, data_name ) {

		var donor = $("#tpl_repeater_bank .tpl-field[data-name='" + data_name + "']").clone();
		container.append(donor);

		tpl_repeater_refresh(container);

		tpl_arrange_rows();

		tpl_condition_updater();

		// Launch color picker
		if ( $('.tpl-dt-color').length > 0 ) {
			$('body .tpl-color-field').wpColorPicker( color_picker_settings );
		}

		// Launch Select2 on select fields
		tpl_select2_init();

		// Launch date picker
		if ($.datepicker !== undefined) {
			$('body .tpl-field.tpl-dt-date input.tpl-date-field').datepicker({
				dateFormat: 'yy-mm-dd',
				firstDay: TPL_Admin.date_starts_with
			});
		}

		tpl_tinymce_init();
		tpl_set_repeater_headers();

	}


	// Remove rows from repeater
	$('body').on('click', '.tpl-remover', function(){
		tpl_remove_row( $(this) );
	});

	// elem is the remover icon, then this function finds what to remove
	function tpl_remove_row( elem ) {

		var container = $(elem).closest('.tpl-repeater');
		var remove = confirm( TPL_Admin.remover_confirm_text );

		if ( remove == true ) {
			$(elem).closest('.tpl-field').remove();
			tpl_repeater_refresh(container);
		}

	};


	// Arrange rows
	function tpl_arrange_rows(){
		$('.tpl-repeat').each(function(){
			$(this).parent().addClass('tpl-repeater');
		});
		if ( typeof $.ui.sortable != 'undefined' ) {
			$('.tpl-repeater').sortable({
				handle : '.tpl-arranger',
				update : function( event, ui ) {
					tpl_repeater_refresh( $(this) );
				},
				start : function( event, ui ){
					ui.placeholder.height( ui.item.height() );

					ui.item.closest('.tpl-repeater').find('.tpl-field.tpl-dt-tinymce textarea').each(function(){
						var id = $(this).attr('id');
						tinyMCE.execCommand('mceRemoveEditor', false, id);
					});

				},
				stop: function(event, ui) { // re-initialize TinyMCE when sort is completed
					tpl_tinymce_init();
				}
			});
		}
	}


	// Update order numbers after repeater item added, removed or rearranged
	function tpl_repeater_refresh(container){

		var url = window.location.href;
		var i = [];
		i[0] = 0;
		var name = '';

		container.find('.tpl-field').each(function(){

			// Setting up levels + instances for the current field
			var level = parseInt($(this).attr('data-level'));
			var name_array = $(this).attr('data-name').split('/');

			if ( level > 0 ) {

				for (var k=0; k<level; k++) {
					var data_name = '';

					for (var l=0; l<=k; l++) {
						data_name += name_array[l];
						if ( l < k ) {
							data_name += '/';
						}
					}

					i[k] = parseInt( $(this).parents('.tpl-field[data-name="'+ data_name +'"]').last().attr('data-instance') );
				}

			}

			// If a new sort of item is found
			var inum = parseInt( $(this).prev('.tpl-field[data-name="'+ $(this).attr('data-name') +'"]').attr('data-instance') );

			if ( isNumeric(inum) ) {
				i[level] = inum + 1;
			}
			else {
				i[level] = 0;
			}

			$(this).attr('data-instance', i[level]);
			$(this).find('.tpl-header-title-instance').html('(#'+i[level]+')');
			if ( level == 0 ) {
				for (var j=1; j<i.length; j++) {
					i[j] = 0;
				}
			}

			$('input, select, textarea', this).each(function(){
				var oldname = $(this).attr('id');
				if ( typeof oldname !== 'undefined' ) {
					var oldname_array = oldname.split('[');
					var newname = oldname_array[0];
					for (var j=0; j<name_array.length; j++) {
						if ( j < name_array.length - 1 || name_array.length == 1 ) {
							if ( ( url.indexOf('post.php') > -1 || url.indexOf('post-new.php') > -1 ) && j == 0 ) {
								newname += '[' + i[j] + ']';
							}
							else {
								newname += '[' + name_array[j] + '][' + i[j] + ']';
							}
						}
						else {
							if ( $(this).closest('.tpl-field').hasClass('tpl-repeat') ) {
								newname += '[' + name_array[j] + '][' + i[j] + ']';
							}
							else {
								newname += '[' + name_array[j] + ']';
							}
						}
					}

					$(this).attr('name', newname);
					$(this).attr('id', newname);
					$(this).closest('.tpl-field').prevAll('label').attr('for', newname);

				}
			});

		});

	}


	// Show / hide block
	$('body').on('click', '.tpl-toggle-close', function(){
		$(this).closest('.tpl-repeat').children('.tpl-field-inner').addClass('tpl-admin-hide');
		$(this).closest('.tpl-repeat-header').addClass('tpl-repeat-header-closed');
		$(this).attr('title', TPL_Admin.Repeat_Maximize);
		$(this).removeClass('tpl-toggle-close');
		$(this).addClass('tpl-toggle-open');
	});
	$('body').on('click', '.tpl-toggle-open', function(){
		$(this).closest('.tpl-repeat').children('.tpl-field-inner').removeClass('tpl-admin-hide');
		$(this).closest('.tpl-repeat-header').removeClass('tpl-repeat-header-closed');
		$(this).attr('title', TPL_Admin.Repeat_Minimize);
		$(this).addClass('tpl-toggle-close');
		$(this).removeClass('tpl-toggle-open');
	});




/*

		3.1 REPEATER PREVIEWS
		---------------------

*/

	// Gets the Data Type class (tpl-dt-xxx) out of the .tpl-field element
	function tpl_get_type_class(tpl_field){
		var class_names = tpl_field.attr('class').split(/\s+/);
		var ret = '';
		$.each(class_names, function(index, item) {
			if ( item.indexOf( "tpl-dt-" ) == 0 && item != 'tpl-dt-combined' ) {
				ret = item;
			}
		});
		return ret;
	}


	// Get the preview value of an element
	function tpl_get_preview_value(tpl_preview_field){
		var pure_preview = '';

		if ( typeof tpl_preview_field.attr('data-preview-value') !== 'undefined' ) {
			pure_preview = tpl_preview_field.attr('data-preview-value');
		}
		else {
			var tag = tpl_preview_field.prop("tagName").toLowerCase();
			switch (tag) {
				case 'select':
				if ( tpl_preview_field.closest('.tpl-dt-select').is('.tpl-select-preview-key') ) {
					pure_preview = tpl_preview_field.val();
				}
				else {
					pure_preview = tpl_preview_field.closest('.tpl-dt-select').find('.select2-selection__rendered').html();
				}
				break;
				case 'span':
				pure_preview = tpl_preview_field.html();
				break;
				case 'textarea':
				pure_preview = tpl_preview_field.html().replace( /&lt;([\s\S]*?)&gt;/g, '' );
				break;
				case 'img':
				pure_preview = tpl_preview_field.attr('src');
				break;
				default:
				pure_preview = tpl_preview_field.val();
			}
		}

		return pure_preview;

	}


	// Get the parent data name
	function tpl_get_data_name_parent(data_name){
		data_name = data_name.split('/');
		var res = '';
		for (var i=0;i<data_name.length-1;i++){
			res += data_name[i];
			if (i<data_name.length-2){
				res += '/';
			}
		}
		return res;
	}


	$(window).load(function(){
		tpl_set_repeater_headers();
	});

	// Sets up the headers of the repeater field instances
	function tpl_set_repeater_headers(){

		$('.tpl-repeat').each(function(){
			var preview = '';
			var dt_class= '';
			var data_name = '';
			var orig_repeat = this;

			// Setting up the class names in case we have to use preview templates
			if ( typeof TPL_Admin[$(this).attr('data-name')+'_preview-template'] !== 'undefined' ) {
				dt_class = $(this).attr('data-name') + '_preview-template';
			}
			else {
				dt_class = tpl_get_type_class($(this)) + '_preview-template';
			}

			// Single field
			if ( !$(this).is('.tpl-dt-combined') ) {

				// If have a template, use it
				if ( typeof TPL_Admin[dt_class] !== 'undefined' ) {
					preview = TPL_Admin[dt_class];
					$('*[class*=tpl-preview-]', this).each(function(index){
						preview = preview.replace( '[tpl-preview-'+index+']', tpl_get_preview_value($(this)) );
					});
				}

				// Else put the values after each other
				else {
					$('*[class*=tpl-preview-]', this).each(function(index){
						preview += tpl_get_preview_value($(this));
					});
				}
			}


			// Combined field
			else {

				// If the combined field has a main template, use it
				if ( typeof TPL_Admin[dt_class] !== 'undefined' ) {
					preview = TPL_Admin[dt_class];
					var to_change = preview.match(/\[.*?tpl-preview-\w*\]/g);
					$('.tpl-field', this).each(function(){
						data_name = $(this).attr('data-name');
						var ch_arr = data_name.split('/');
						var cfield = this;
						$.each(to_change, function(i, item){
							var ii = item.split('/tpl-preview-');
							ii[0] = ch_arr[0] + '/' + ii[0].substring(1);
							ii[1] = ii[1].slice(0,-1);
							$('*[class*=tpl-preview-]', cfield).each(function(index){
								if ( ii[0] == data_name && $(this).hasClass('tpl-preview-'+ii[1]) ) {
									if (
										tpl_get_data_name_parent(data_name).search('/') > -1
										&& $('[data-name="'+tpl_get_data_name_parent(data_name)+'"]').is('.tpl-repeat')
										&& $(this).closest('[data-name="'+tpl_get_data_name_parent(data_name)+'"]').parent().find('[data-name="'+tpl_get_data_name_parent(data_name)+'"]').length > parseInt($(this).closest('[data-name="'+tpl_get_data_name_parent(data_name)+'"]').attr('data-instance')) + 1
										&& parseInt($(cfield).attr('data-level')) < 3
										&& $(orig_repeat).is('.tpl-preview-multi')
									) {
										preview = preview.replace( item, tpl_get_preview_value($(this)) ) + ' / '+item;
									}
									else {
										preview = preview.replace( item, tpl_get_preview_value($(this)) );
									}
								}
							});
						});
					});
					// Clean up the remaining shortcodes
					$.each(to_change, function(i, item){
						preview = preview.replace( item, '' );
					});
				}

				// If not, add the subitems' templates one-by-one
				else {
					var l = $('.tpl-field', this).length;
					$('.tpl-field', this).each(function(i){
						data_name = $(this).attr('data-name');
						dt_class = tpl_get_type_class($(this)) + '_preview-template';

						// If have a template, use it
						if ( typeof TPL_Admin[dt_class] !== 'undefined' ) {
							preview += TPL_Admin[dt_class];
							$('*[class*=tpl-preview-]', this).each(function(index){
								preview = preview.replace( '[tpl-preview-'+index+']', tpl_get_preview_value($(this)) );
							});

						}

						// Else put the values after each other
						else {
							$('*[class*=tpl-preview-]', this).each(function(index){
								preview += tpl_get_preview_value($(this));
							});
						}

						if ( i < (l-1) ) {
							preview += ' / ';
						}

					});
				}
			}

			// Finally, setting up the repeater header
			$('.tpl-header-title-preview', this).html(preview);


		});

	}





/*

	4. COMMON SETTINGS
	==================

	4.1 TABS IN THE BACKEND
	-----------------------

*/

	// Tabs in Plugin Settings
	if (typeof $.ui.tabs !== 'undefined') {

		$('#tpl-settings-tabs').tabs();

		if (typeof Storage !== "undefined" && $('#tpl-settings-tabs').length != 0) {

			// Set the active tab if present in sessionStorage
			var tabName = $('#tpl-settings-tabs').attr('data-store');
			var tabValue = sessionStorage.getItem(tabName);

			if (typeof tabValue !== "undefined") {
				$('#tpl-settings-tabs').tabs('option', 'active', tabValue);
			}

			// Save the active tab to sessionStorage for future use
			$('#tpl-settings-tabs .nav-tab').click(function(){
				var tabName = $('#tpl-settings-tabs').attr('data-store');
				var tabValue = $('#tpl-settings-tabs').tabs('option', 'active');
				sessionStorage.setItem(tabName, tabValue);
			});
		}

	}





/*

	5. CONDITIONAL SETTINGS
	=======================

*/


	// Retrieves (name) parameter's value from (url)
	function tpl_get_url_param(name, url) {
	    if (!url) url = window.location.href;
	    name = name.replace(/[\[\]]/g, "\\$&");
	    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	        results = regex.exec(url);
	    if (!results) return null;
	    if (!results[2]) return '';
	    return decodeURIComponent(results[2].replace(/\+/g, " "));
	}


	// Checks the current post type in admin
	function tpl_get_post_type(){
		var attrs, attr, post_type;
		post_type = null;

		attrs = $( 'body' ).attr( 'class' ).split( ' ' );
		$( attrs ).each(function() {
			if ( 'post-type-' === this.substr( 0, 10 ) ) {
				post_type = this.split( 'post-type-' );
				post_type = post_type[ post_type.length - 1 ];
				return;
			}
		});

		return post_type;
	}


	// Checks if a variable is numeric
	function isNumeric(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}


	// Updates the state of the conditional options. Use it after every change in the conditions.
	function tpl_condition_updater() {
		var url = window.location.href;

		$('body .tpl-field, body .tpl-subitem-repeat-wrapper, body .tpl-meta-option').each(function(){

			// Primary Options page (e.g. Plugin Settings)
			if ( url.indexOf('themes.php') > -1 || url.indexOf('options-general.php') > -1 || url.indexOf('admin.php') > -1 ) {
				var section = tpl_get_url_param('page', url);
				var container = 'tr';
			}
			// Post options branch
			if ( url.indexOf('post.php') > -1 || url.indexOf('post-new.php') > -1 ) {
				var section = '';
				var container = '.tpl-meta-option';
			}

			var option_name = $(this).attr('data-name');
			var data_connected = $(this).attr('data-connected');

			if ( $(this).hasClass('tpl-subitem-repeat-wrapper') || $(this).hasClass('tpl-meta-option') ) {
				option_name = data_connected;
			}

			// Section is different when we're dealing with a post option
			if ( section == '' ) {
				section = $(this).closest('.postbox').attr('id');
			}


			// Do things only if the condition is registered in the Conditions object
			if ( TPL_Admin.Conditions !== undefined && TPL_Admin.Conditions[option_name] !== undefined ) {

				var Olength = Object.keys(TPL_Admin.Conditions[option_name]).length;
				var ci;
				var matches = [];

				for ( ci = 0; ci < Olength; ci++ ) {


					if ( typeof TPL_Admin.Conditions[option_name][ci] !== 'undefined' ) {

						var condition_type = TPL_Admin.Conditions[option_name][ci]["type"];
						var condition_name = TPL_Admin.Conditions[option_name][ci]["name"];
						var condition_relation = TPL_Admin.Conditions[option_name][ci]["relation"];
						var condition_value = TPL_Admin.Conditions[option_name][ci]["value"];
						var base_id = '';
						var base_val = '';
						var cname_array = [];
						var c_array = [];
						var dname_array = [];

						// If the condition is an option
						if ( condition_type == 'option' ) {

							// Modifications on the name if it's a cobined field
							if ( condition_name.indexOf( '/' ) > -1 ) {

								cname_array = condition_name.split("/");
								dname_array = option_name.split("/");

								// If the base of the condition is a sibling field of the current one
								if ( cname_array[0] == "_THIS_" ) {

									for ( var j = 0; j < dname_array.length - 1; j++ ) {
										c_array[2*j] = dname_array[j];

										var current_data_name = '';
										for ( var k = 0; k <= j; k++ ) {
											current_data_name += dname_array[k];
											if ( k < j ) {
												current_data_name += '/';
											}
										}

										c_array[2*j+1] = $(this).closest('.tpl-field[data-name="'+ current_data_name +'"]').attr('data-instance');
									}

									c_array.push( cname_array[cname_array.length-1] );

								}

								// If the base of the condition is an absolute path
								else {

									c_array = cname_array;

								}

							}

							// Condition is a single variable
							else {

								c_array[0] = condition_name;
								c_array[1] = 0;

							}

							base_id = '#' + section;
							if ( url.indexOf('post.php') > -1 || url.indexOf('post-new.php') > -1 ) {
								base_id += '_' + c_array[0];
							}
							for ( var l = 0; l < c_array.length; l++ ) {
								if ( url.indexOf('post.php') > -1 || url.indexOf('post-new.php') > -1 ) {
									if ( l > 0 ) {
										base_id += '\\[' + c_array[l] + '\\]';
									}
								}
								else {
									base_id += '\\[' + c_array[l] + '\\]';
								}
							}

							// base_val: the base element's value
							base_val = $(base_id).val();

						}


						// If the condition is a post type
						if ( condition_type == 'post' ) {

							// In this case base_val is the post type caught from the current post
							if ( condition_name == 'type' ) {

								base_val = tpl_get_post_type();

							}

							// In this case base_val is the ID of a specific post
							if ( condition_name == 'id' ) {

								base_val = tpl_get_url_param( 'post', url );

							}

						}


						// If the condition is a page template
						if ( condition_type == 'page' ) {

							// In this case base_val is the post type caught from the current post
							if ( condition_name == 'template' ) {

								base_val = $('#page_template').val();

							}

						}


						// If the condition is a taxonomy
						if ( condition_type == 'taxonomy' ) {

							// Post formats are a special case
							if ( condition_name == 'post_format' ) {

								$('#post-formats-select input').each(function(){
									if ( $(this).is(':checked') ) {
										base_val = $(this).attr('id').replace( 'post-format-', '' );
									}
								});

							}

							// Other taxonomies work in the same way (except tags - they are not supported at the moment)
							else {

								var base_val = [];
								var cat_no = 0;
								$('#' + condition_name + 'checklist li').each(function(){
									cat_no = $(this).attr('id').replace( condition_name + '-', '' );
									if ( $('input', this).is(':checked') ) {
										base_val.push( cat_no );
									}
								});

							}

						}


						// Setting up the results of the relations
						switch ( condition_relation ) {
							case '=':
								if ( $.isArray( base_val ) ) {
									if ( $.inArray( condition_value, base_val ) > -1 ) {
										matches.push( true );
									}
									else {
										matches.push( false );
									}
								}
								else {
									if ( base_val == condition_value ) {
										matches.push( true );
									}
									else {
										matches.push( false );
									}
								}
								break;
							case '!=':
								if ( $.isArray( base_val ) ) {
									if ( $.inArray( condition_value, base_val ) < 0 ) {
										matches.push( true );
									}
									else {
										matches.push( false );
									}
								}
								else {
									if ( base_val != condition_value ) {
										matches.push( true );
									}
									else {
										matches.push( false );
									}
								}
								break;
							case '<':
								if ( base_val < condition_value ) {
									matches.push( true );
								}
								else {
									matches.push( false );
								}
								break;
							case '>':
								if ( base_val > condition_value ) {
									matches.push( true );
								}
								else {
									matches.push( false );
								}
								break;
						}

					}


				} // Conditions FOR cycle


				// Now displaying it or not based on the results
				var met = false;
				var logic = 'and';

				if ( TPL_Admin.Conditions[option_name]["logic"] !== undefined ) {
					var logic = TPL_Admin.Conditions[option_name]["logic"];
				}

				// If logic is (AND) and there is no FALSE result in the matches array, then the condition is met
				if ( logic == 'and' && $.inArray( false, matches ) < 0 ) {
					met = true;
				}

				// If logic is (OR) and there is at least one TRUE result in the matches array, then the condition is met
				if ( logic == 'or' && $.inArray( true, matches ) > -1 ) {
					met = true;
				}


				// Now show or hide the option based on the (met) variable
				data_connected = data_connected.replace('/', '\/');

				// Showing elements
				if ( met == true ) {

					if ( typeof data_connected !== "undefined" ) {
						$(this).parent().parent().parent().find('[data-connected="'+ data_connected +'"]').removeClass('tpl-admin-hide');
						if ( container == 'tr' && $(this).attr('data-level') == '0' ) {
							$(this).closest(container).next(container).has('.tpl-optiondesc').removeClass('tpl-admin-hide');
							$(this).closest(container).removeClass('tpl-admin-hide');
						}
						else {
							$(this).closest(container).next('p.tpl-optiondesc').removeClass('tpl-admin-hide');
						}
						$(this).find('input, select, textarea').each(function(){
							$(this).attr('name', $(this).attr('id'));
						});
					}

				}

				// Hiding elements
				else {

					if ( typeof data_connected !== "undefined" ) {
						$(this).parent().parent().parent().find('[data-connected="'+ data_connected +'"]').addClass('tpl-admin-hide');
						if ( container == 'tr' && $(this).attr('data-level') == '0' ) {
							$(this).closest(container).next(container).has('.tpl-optiondesc').addClass('tpl-admin-hide');
							$(this).closest(container).addClass('tpl-admin-hide');
						}
						else {
							$(this).closest(container).next('p.tpl-optiondesc').addClass('tpl-admin-hide');
						}
						$(this).find('input, select, textarea').removeAttr('name');

						$(this).closest(container).find('.tpl-field.tpl-dt-tinymce.tpl-admin-hide textarea').each(function(){
							var editor_id = $(this).attr('id');
							tinymce.execCommand('mceRemoveEditor', false, editor_id);
						});
					}

				}

			} // Closing check for the Conditions object

		});

		$('.postbox').each(function(){
			var meta_hide = [];
			$('.tpl-meta-option', this).each(function(){
				if ( $(this).hasClass('tpl-admin-hide') ) {
					meta_hide.push( true );
				}
				else {
					meta_hide.push( false );
				}
			});
			if ( $.inArray( true, meta_hide ) > -1 && $.inArray( false, meta_hide ) < 0 ) {
				$(this).addClass('tpl-admin-hide');
			}
			else {
				$(this).removeClass('tpl-admin-hide');
			}
		});


	}

	tpl_condition_updater();
	tpl_tinymce_init();

	$('body').on('change', 'select, input, textarea', function(){
		tpl_condition_updater();
		tpl_set_repeater_headers();
	});

	$('body').on('keyup', 'input, textarea', function(){
		// Because the condition updater is a resource-heavy operation, run it only if the value length is 0 or 1
		if ( $(this).val().length < 2 ) {
			tpl_condition_updater();
		}
	});


});
