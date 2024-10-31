(function( $ ) {
	
/* Bulk Mail Plain */
	spm_plain_bulksend_func = function(order_ids,part) {
		
		var plain_inputs = [];
			$('.spm-plain-live-inner-inputs input[type="checkbox"]:checked').each(
				function() {
					plain_inputs.push( $(this).attr('name') + '__spm__' + $(this).val() );
				}
			);
			

			$('.spm-plain-live-inner-inputs input[type="text"]').each(
				function() {
					plain_inputs.push( $(this).attr('name') + '__spm__' + $(this).val() );
				}
			);
			

			$('.spm-plain-live-inner-inputs textarea').each(
				function() {
					plain_inputs.push( $(this).attr('name') + '__spm__' + $(this).val().replace(/\n/g,'<br>') );
				}
			);
			
			
			var data = {
				'action': 'sendprebuiltemails_secure_sendmail_action',
				'identifier': 'plain',
				'order_ids': order_ids,
				'inputs': plain_inputs,
				'type': part,
				'nonce': spm_ajax_object.spm_ajax_nonce,
            };
			

			var respond_div = document.getElementById('sendprebuiltemails_bulkrespond_here_id');	


		var sendmaillayer = '<div class="spm-bg-layer"></div><div class="s-spm-ajax-wrap-full"><div class="s-spm-ajax-wrap"><div class="spm-s-sendsuccess"><div class="thinleek-progress" id="spm_id_load_id" style="margin-bottom:-4px;"><div class="thinleek-indeterminate"></div></div><div style="padding:20px"><div class="spm-s-sendsuccess-flex"><div class="spm-success-icon"><span class="dashicons dashicons-airplane"></span></div><p id="sendprebuiltemails-success-txt-id"><b>' + spm_lang_object.spm_sending + '</b><br><span style="visibility:hidden"> 1 of 1 E-Mail send successfully.</span><br><span style="visibility:hidden" class="thinleek-desc">Prebuilt E-Mail</span></p></div><div style="visibility:hidden" class="spm-s-sendsuccess_footer"><a onclick="sendpbm_close_popup()" id="spm_okay_btn_id_hidden" class="button button-primary">OKAY</a></div></div></div></div></div>';
		respond_div.innerHTML = sendmaillayer;
		
		
		jQuery.ajax({
        type: 'POST',
        url: spm_ajax_object.spm_ajax_url,
        data: data,
        success: function (response) {
            
			if (response.indexOf('_spmexplodespm_') > 0) {
				
				var splitres = response.split('_spmexplodespm_');
				respond_div.innerHTML = splitres[0];
				var updated_orders = splitres[1].split('spm');
				
				if ( part == 'orderbulk' ) {
					for ( i=0; i<updated_orders.length; i++ ) {
						var rowid = 'post-' + updated_orders[i];
						var row = document.getElementById(rowid);
						row.getElementsByClassName("column-sendprebuiltemails_column_log_id")[0].innerHTML = splitres[2];
					}
				}
				
				
				if ( part == 'orderedit' ) {	
					if ( splitres[3] !== 'none' ) {
						$( '#woocommerce-order-notes ul.order_notes' ).prepend( splitres[3] );
					}
				}
				
				if ( splitres[4].length > 10 ) {
					document.getElementById('sendprebuiltemail_okay_button_id').innerHTML = splitres[4];
					location.reload();
				}
			}
			else {
				respond_div.innerHTML = response;
			}
			
        },
        error: function (response) {
			
			respond_div.innerHTML = '';
			alert('unexpected error, please try again');
			
        }
		
		});
		
	}
	/* END Bulk Mail Plain */
	




spm_show_all_placeholders_func = function() {
		
		
		var data = {
		'action': 'sendprebuiltemails_allplaceholder_action_plain',
		'nonce': spm_ajax_object.spm_ajax_nonce,
		};
		
		
		jQuery.ajax({
		type: 'POST',
		url: spm_ajax_object.spm_ajax_url,
		data: data,
		success: function (response) {			
			document.getElementById('sendprebuiltemails_placeholder_plains').innerHTML = response;
			
		},
		error: function (response) {			
			document.getElementById('sendprebuiltemails_placeholder_plains').innerHTML = 'unexpected error';
		}
				
		});
		
		
		// This return prevents the submit event to refresh the page.
		return false;
		
    }
	
	
	
spm_plain_live_prev_func = function(prevosend,order_ids) {
		
		document.getElementById('sendprebuiltemails_iframe_id_div_two').style.display = 'none';
		
		
		var plain_inputs = [];
			$('.spm-plain-live-inner-inputs input[type="checkbox"]:checked').each(
				function() {
					plain_inputs.push( $(this).attr('name') + '__spm__' + $(this).val() );
				}
			);
			

			$('.spm-plain-live-inner-inputs input[type="text"]').each(
				function() {
					plain_inputs.push( $(this).attr('name') + '__spm__' + $(this).val() );
				}
			);
			

			$('.spm-plain-live-inner-inputs textarea').each(
				function() {
					plain_inputs.push( $(this).attr('name') + '__spm__' + $(this).val().replace(/\n/g,'<br>') );
				}
			);
			

		
		var data = {
		'action': 'sendprebuiltemails_preview_action',
		'identifier': 'plain',
		'order': 'plain',
		'inputs': plain_inputs,
		'nonce': spm_ajax_object.spm_ajax_nonce,
		};
		
		
		jQuery.ajax({
		type: 'POST',
		url: spm_ajax_object.spm_ajax_url,
		data: data,
		success: function (response) {	

			
				document.getElementById('sendprebuiltemails_iframe_id_div').innerHTML = response;
				document.getElementById('sendprebuiltemails_iframe_id_div').style.overflowY = 'scroll';
			
			
		},
		error: function (response) {
			
				document.getElementById('sendprebuiltemails_iframe_id_div').innerHTML = 'unexpected error';
				document.getElementById('sendprebuiltemails_iframe_id_div').style.overflowY = 'scroll';
			
		}
				
		});
		
		
		// This return prevents the submit event to refresh the page.
		return false;
		
    }
	
	




})( jQuery );


function spm_layer_for_writemail(order_id) {
	
		var sendenval = spm_lang_object.spm_sendmail;
		
		var ausgabe_div = document.getElementById('sendprebuiltemails_bulkrespond_here_id');
	
	
		var contentindiv = '<div class="spm-bg-layer"></div><div class="spm-ajax-wrap-full"><div class="spm-ajax-wrap">';
		var contentindiv = contentindiv + '<div class="sendpbm_ajax_ausgabe_inner"><div class="spm-ajax-header">';
		var contentindiv = contentindiv + '<div class="spm-head-txt">' + spm_lang_object.spm_blank + '</div>';
		var contentindiv = contentindiv + '<span onclick="sendpbm_close_popup()" class="dashicons dashicons-no-alt spm-close-icon">';
		var contentindiv = contentindiv + '</span></div>';
		var contentindiv = contentindiv + '<div class="spm-ajax-footer">';
				
		var contentindiv = contentindiv + '<div class="spm-plain-notice"><div class="spm-plain-notice-item" style="text-align:left;">';
		var contentindiv = contentindiv + '<span id="spmplainicon_subject" class="dashicons dashicons-dismiss"></span>' + spm_lang_object.spm_subject + '</div>';
		var contentindiv = contentindiv + '<div class="spm-plain-notice-item" style="float:left;">';
		var contentindiv = contentindiv + '<span id="spmplainicon_content" class="dashicons dashicons-dismiss"></span>' + spm_lang_object.spm_content + '</div></div>';
				
		var contentindiv = contentindiv + '<input type="text" onclick="spm_plain_func_layer_orderedit()" id="spmplainliveprevid" class="button-secondary button" value="' + spm_lang_object.spm_preview + '" disabled readonly>';
		var contentindiv = contentindiv + '<input onclick="spm_run_bulksend_ajax(\'' + order_id + '\',\'orderedit\')" id="spmplain_id_send" value="' + sendenval + '" type="submit" style="margin-left:10px" class="button-primary button" disabled></div>'; 
				
		// start form
		var contentindiv = contentindiv + '<div class="pspm-ajax-body">';
		var contentindiv = contentindiv + '<div style="height:100%;width:100%;display:none" id="sendprebuiltemails_iframe_id_div"></div>';
		var contentindiv = contentindiv + '<div style="height:100%;width:100%" id="sendprebuiltemails_iframe_id_div_two">';
		
		var contentindiv = contentindiv + '<div class="spm-plain-live-wrap"><div class="spm-plain-live-inner">';
		var contentindiv = contentindiv + '<div class="spm-plain-live" style="margin-bottom:0px!important;">';
		var contentindiv = contentindiv + '<label id="spm-placeholder-anchor" style="display:inline!important">' + spm_lang_object.spm_placeholder + '</label>';
		var contentindiv = contentindiv + '<p class="thinleek-copied-txt" style="visibility:hidden;display:inline;margin-left:10px;vertical-align:bottom;">' + spm_lang_object.spm_placecopied + '</p></div>';
		
		var contentindiv = contentindiv + '<div id="sendprebuiltemails_placeholder_plains">';
		
		
		
		var contentindiv = contentindiv + '<div style="display:none" id="sendprebuiltemails-loading-screen-two">';
		var contentindiv = contentindiv + '<div class="thinleek-progress"><div class="thinleek-indeterminate"></div></div></div>';
		
		var contentindiv = contentindiv + '<div id="sendprebuiltemails_hide_placeholders">';
		
		var contentindiv = contentindiv + '<input value="{order-number}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<input value="{order-total}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<input value="{order-status}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<input value="{order-date_created}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<input value="{order-customer_id}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<input value="{billing-first_name}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<input value="{billing-last_name}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<a onclick="spm_run_allplaces_ajax()" class="spm-plain-allplaces">' + spm_lang_object.spm_allplace + '</a>';
		var contentindiv = contentindiv + '</div>';
		
		var contentindiv = contentindiv + '</div>';
		
		
		var contentindiv = contentindiv + '<div class="spm-plain-live-inner-inputs">';
		var contentindiv = contentindiv + '<input name="first_order" value="' + order_id + '" type="text" style="display:none!important">';
		var contentindiv = contentindiv + '<input name="order_count" value="1" type="text" style="display:none!important">';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><label>' + spm_lang_object.spm_subject + '</label><input id="spmplain_id_subject" onchange="spmplainicon_valid_check()" onkeyup="spmplainicon_valid_check()" class="sendprebuiltemails-live-inputs" type="text" name="subject" autocomplete="nope"></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><label>' + spm_lang_object.spm_heading + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="heading" autocomplete="nope"></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><label>' + spm_lang_object.spm_content + '</label><textarea id="spmplain_id_content" onchange="spmplainicon_valid_check()" onkeyup="spmplainicon_valid_check()" class="sendprebuiltemails-live-inputs" name="content"></textarea></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><input class="sendprebuiltemails-live-inputs" value="orderdetails" name="orderdetails" type="checkbox"><span>' + spm_lang_object.spm_orderdetails + '</span></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><input class="sendprebuiltemails-live-inputs" value="address" name="address" type="checkbox"><span>' + spm_lang_object.spm_address + '</span></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><label>' + spm_lang_object.spm_additional + '</label><textarea class="sendprebuiltemails-live-inputs" style="height:100px!important" name="contenttwo"></textarea></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><input class="sendprebuiltemails-live-inputs" value="footer" name="footer" type="checkbox"><span>' + spm_lang_object.spm_footer + '</span></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live" id="mail-header-settings"><span class="spm-plain-more" onclick="spm_plain_toggle()"><span id="spm-plain-live-plus-id">+</span>' + spm_lang_object.spm_fromto + '</span></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live" id="spm-plain-live-more-id" style="display: none;">';
		var contentindiv = contentindiv + '<label>' + spm_lang_object.spm_from_name + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="from_name" autocomplete="nope">';
		var contentindiv = contentindiv + '<label>' + spm_lang_object.spm_from_mail + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="from_email" autocomplete="nope">';
		var contentindiv = contentindiv + '<label>' + spm_lang_object.spm_to + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="to_email" value="{billing-email}" autocomplete="nope">';
		var contentindiv = contentindiv + '<label>' + spm_lang_object.spm_replyto_name + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="reply_to_name" autocomplete="nope">';
		var contentindiv = contentindiv + '<label>' + spm_lang_object.spm_replyto_mail + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="reply_to_email" autocomplete="nope">';
		var contentindiv = contentindiv + '<label>cc</label><input class="sendprebuiltemails-live-inputs" type="text" name="cc" autocomplete="nope">';
		var contentindiv = contentindiv + '<label>bcc</label><input class="sendprebuiltemails-live-inputs" type="text" name="bcc" autocomplete="nope">';
		var contentindiv = contentindiv + '</div></div></div></div></div>"';
		
		var contentindiv = contentindiv + '</div>';

		
		

		var contentindiv = contentindiv + '</div></div></div></div>';
				
		ausgabe_div.innerHTML = contentindiv;
		
}



function spm_run_allplaces_less() {
	
		var contentindiv = '<div style="display:none" id="sendprebuiltemails-loading-screen-two">';
		var contentindiv = contentindiv + '<div class="thinleek-progress"><div class="thinleek-indeterminate"></div></div></div>';
		
		var contentindiv = contentindiv + '<div id="sendprebuiltemails_hide_placeholders">';
		
		var contentindiv = contentindiv + '<input value="{order-number}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<input value="{order-total}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<input value="{order-status}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<input value="{order-date_created}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<input value="{order-customer_id}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<input value="{billing-first_name}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<input value="{billing-last_name}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small pspm-placeholder">';
		var contentindiv = contentindiv + '<a onclick="spm_run_allplaces_ajax()" class="spm-plain-allplaces">' + spm_lang_object.spm_allplace + '</a>';
		var contentindiv = contentindiv + '</div>';
		
		document.getElementById('sendprebuiltemails_placeholder_plains').innerHTML = contentindiv;
				
		var anchor = 'spm-placeholder-anchor';
		window.location.href = "#" + anchor;
		
		
}

function spm_run_bulksend_ajax(order_ids,part) {	
spm_plain_bulksend_func(order_ids,part);
}

function spm_run_allplaces_ajax() {
	
		spm_show_all_placeholders_func();
		document.getElementById('sendprebuiltemails-loading-screen-two').style.display = '';
		document.getElementById('sendprebuiltemails_hide_placeholders').style.visibility = 'hidden';
    
  }
  
  
function spm_plain_func_layer_orderedit() {
	
	var btn = document.getElementById('spmplainliveprevid');
	var btntxt = btn.value;
	
	
	if ( btntxt.indexOf(' ') > 0 ) {
		btn.value = spm_lang_object.spm_preview;
		document.getElementById('sendprebuiltemails_iframe_id_div').style.display = 'none';
		document.getElementById('sendprebuiltemails_iframe_id_div_two').style.display = '';
		
	}
	else {
		btn.value = spm_lang_object.spm_closeprev;
		spm_plain_live_prev_func('prev',0);
		document.getElementById('sendprebuiltemails_iframe_id_div_two').style.display = 'none';
		document.getElementById('sendprebuiltemails_iframe_id_div').style.display = '';
		var contentindiv = '<div id="sendprebuiltemails-loading-screen">';
		var contentindiv = contentindiv + '<div class="thinleek-progress"><div class="thinleek-indeterminate"></div></div>';
		var contentindiv = contentindiv + '<p style="text-align:left">' + spm_lang_object.spm_loading + '</p></div>';
		document.getElementById('sendprebuiltemails_iframe_id_div').innerHTML = contentindiv;
	}
    
  }

  
  
function spm_plain_func_layer() {
	
	var btn = document.getElementById('spmplainliveprevid');
	var btntxt = btn.value;
	
	
	if ( btntxt.indexOf(' ') > 0 ) {
		btn.value = spm_lang_object.spm_preview;
		document.getElementById('sendprebuiltemails_plain_head_blank_txt').style.display = '';
		document.getElementById('sendprebuiltemails_plain_head_select_txt').style.display = 'none';
		document.getElementById('sendprebuiltemails_iframe_id_div').style.display = 'none';
		document.getElementById('sendprebuiltemails_iframe_id_div_two').style.display = '';
		
	}
	else {
		btn.value = spm_lang_object.spm_closeprev;
		spm_bulkaction_preview_func('plain','plain','plain','plain','plain');
		document.getElementById('sendprebuiltemails_iframe_id_div_two').style.display = 'none';
		document.getElementById('sendprebuiltemails_iframe_id_div').style.display = '';
		document.getElementById('sendprebuiltemails_plain_head_blank_txt').style.display = 'none';
		document.getElementById('sendprebuiltemails_plain_head_select_txt').style.display = '';
		var contentindiv = '<div id="sendprebuiltemails-loading-screen">';
		var contentindiv = contentindiv + '<div class="thinleek-progress"><div class="thinleek-indeterminate"></div></div>';
		var contentindiv = contentindiv + '<p style="text-align:left">' + spm_lang_object.spm_loading + '</p></div>';
		document.getElementById('sendprebuiltemails_iframe_id_div').innerHTML = contentindiv;
	}
    
  }


function spm_plain_toggle() {
	var toggleobj = document.getElementById("spm-plain-live-more-id");
	var toggleplus = document.getElementById("spm-plain-live-plus-id");
	var anchor = "mail-header-settings";
		
	if ( toggleobj.style.display == "none" ) {
		toggleobj.style.display = "";
		toggleplus.innerHTML = "-";
		window.location.href = "#" + anchor;
	}
	else {
		toggleobj.style.display = "none";
		toggleplus.innerHTML = "+";
	}
}

function sendprebuiltemails_copy(buttonel) {
	var copyText = buttonel;
	copyText.select();

	document.execCommand("copy");
			   
	var copiedtxts = document.getElementsByClassName("thinleek-copied-txt");
			  
	for ( i=0; i<copiedtxts.length; i++ ) {
		copiedtxts[i].style.visibility = "";
		copiedtxts[i].innerHTML = "<b>" + copyText.value + "</b> kopiert.";
	}
}
			
			
function spm_plain_tab_content() {

	document.getElementById("spm-tab-content").style.opacity = "1";	
	document.getElementById("spm-tab-prev").style.opacity = "0.6";	
				
}
function spm_plain_tab_prev() {
				
	document.getElementById("spm-tab-content").style.opacity = "0.6";	
	document.getElementById("spm-tab-prev").style.opacity = "1";	
				
}
function spmplainicon_valid_check() {

	var contenticon = document.getElementById('spmplainicon_content');
	var subjecticon = document.getElementById('spmplainicon_subject');
	
	var sendbtn = document.getElementById('spmplain_id_send');
	var prevbtn = document.getElementById('spmplainliveprevid');
	
	var subject = document.getElementById('spmplain_id_subject').value;
	var content = document.getElementById('spmplain_id_content').value;
	
	if ( subject.length > 2 ) {
		subjecticon.classList.remove('dashicons-dismiss');
		subjecticon.classList.add('dashicons-yes-alt');
	}
	else {
		subjecticon.classList.remove('dashicons-yes-alt');
		subjecticon.classList.add('dashicons-dismiss');
	}
	
	if ( content.length > 2 ) {
		contenticon.classList.remove('dashicons-dismiss');
		contenticon.classList.add('dashicons-yes-alt');
	}
	else {
		contenticon.classList.remove('dashicons-yes-alt');
		contenticon.classList.add('dashicons-dismiss');
	}
	
	
	if ( subject.length > 2 && content.length > 2 ) {
		sendbtn.disabled = false;
		prevbtn.disabled = false;
	}
	else {
		sendbtn.disabled = true;
		prevbtn.disabled = true;
	}
}

