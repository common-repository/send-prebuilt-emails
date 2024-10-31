(function( $ ) {

	

/* mail send are you sure */
$(document).ready(function(){
$('#doaction, #doaction2').click(function (event) {
	
	var actionselected = $(this).attr('id').substr(2);
	var action = $('select[name="' + actionselected + '"]').val();
	if (action.indexOf('sendprebuiltemails') != -1) {
		
		event.preventDefault();
		
		var checked = [];
		$('tbody th.check-column input[type="checkbox"]:checked').each(
			function() {
				checked.push($(this).val());
			}
		);
		
		
		var spm_is_premium = 0;
		
		
		
			if (!checked.length) {
				
				var contentindiv = '<div class="spm-bg-layer"></div><div class="s-spm-ajax-wrap-full">';
				var contentindiv = contentindiv + '<div class="s-spm-ajax-wrap"><div class="spm-s-sendsuccess">';
				var contentindiv = contentindiv + '<div style="padding:20px"><div class="spm-s-sendsuccess-flex">';
				var contentindiv = contentindiv + '<div class="spm-success-icon"><span class="dashicons dashicons-bell"></span>';
				var contentindiv = contentindiv + '</div><p id="sendprebuiltemails-success-txt-id">';
				var contentindiv = contentindiv + '<b>No order selected.</b><br><span>You have to select at least 1 order</span><br>';
				var contentindiv = contentindiv + '<span class="thinleek-desc-bright" style="visibility:hidden">please select</span>';
				var contentindiv = contentindiv + '</p></div><div class="spm-s-sendsuccess_footer">';
				var contentindiv = contentindiv + '<a onclick="sendpbm_close_popup_bulk()" class="button button-primary">OKAY</a>';
				var contentindiv = contentindiv + '</div></div></div></div></div>';
			
				var newdiv = '<div id="sendprebuiltemails_bulkrespond_here_id">' + contentindiv + '</div>';
				
				
				if ( $('#sendprebuiltemails_bulkrespond_here_id' ).length ) {
					$( '#sendprebuiltemails_bulkrespond_here_id' ).html( contentindiv );
				}
				else {
					$( '#wpbody' ).prepend( newdiv );
				}
				//alert('You have to select order(s) first!');
				return;
			}
			else if (checked.length > 10 && spm_is_premium < 1 ) { // premium check
				
				var contentindiv = '<div class="spm-bg-layer"></div><div class="s-spm-ajax-wrap-full">';
				var contentindiv = contentindiv + '<div class="s-spm-ajax-wrap"><div class="spm-s-sendsuccess">';
				var contentindiv = contentindiv + '<div style="padding:20px"><div class="spm-s-sendsuccess-flex">';
				var contentindiv = contentindiv + '<div class="spm-success-icon"><span class="dashicons dashicons-bell"></span>';
				var contentindiv = contentindiv + '</div><p id="sendprebuiltemails-success-txt-id">';
				var contentindiv = contentindiv + '<b>' + spm_lang_object.spm_maxallowed + '</b><br><span>' + spm_lang_object.spm_pleaseupgrade + '</span><br>';
				var contentindiv = contentindiv + '<span class="thinleek-desc-bright" style="visibility:hidden">please select</span>';
				var contentindiv = contentindiv + '</p></div><div class="spm-s-sendsuccess_footer">';
				var contentindiv = contentindiv + '<a onclick="sendpbm_close_popup_bulk()" class="button button-secondary" style="width:49%;float:left;">' + spm_lang_object.spm_cancel + '</a>';
				var contentindiv = contentindiv + '<a href="admin.php?page=prebuilt-emails-orders-pricing" class="button button-primary" style="width:49%">UPGRADE NOW</a>';
				var contentindiv = contentindiv + '</div></div></div></div></div>';
			
				var newdiv = '<div id="sendprebuiltemails_bulkrespond_here_id">' + contentindiv + '</div>';
				
				
				if ( $('#sendprebuiltemails_bulkrespond_here_id' ).length ) {
					$( '#sendprebuiltemails_bulkrespond_here_id' ).html( contentindiv );
				}
				else {
					$( '#wpbody' ).prepend( newdiv );
				}
				//alert('You have to select order(s) first!');
				return;
			}
	
		
		
		var template_name_get = $('select[name="' + actionselected + '"]').find('option:selected').text();
		var template_name_split = template_name_get.split('"');
		var template_name = 'Prebuilt E-Mail "' + template_name_split[1] + '"';

		
		var splitaction = action.split('_');
		var type = 'orderbulk';
		var identifier = splitaction[1];
		
		if ( identifier == 'plain' ) {
			spm_bulkaction_confimed_func(action);
		}
		else {
		
			var template = action;
			var checked = [];
			$('tbody th.check-column input[type="checkbox"]:checked').each(
				function() {
					checked.push($(this).val());
				}
			);
			
			
			
			var order_count = checked.length;
			var order_first = checked[0];
			var order_ids = checked.join('spm');
		
			
			var sendenval = spm_lang_object.spm_sendplural;
			var question = spm_lang_object.spm_areyousures;
			if ( order_count == 1 ) {
				var sendenval = spm_lang_object.spm_sendsing;
				var question = spm_lang_object.spm_areyousure;
			}
			var sendenval = sendenval.replace('ordercount', order_count);
			var question = question.replace('ordercount', order_count);
		
			var contentindiv = '<div class="spm-bg-layer"></div><div class="s-spm-ajax-wrap-full">';
			var contentindiv = contentindiv + '<div class="s-spm-ajax-wrap"><div class="spm-s-sendsuccess">';
			var contentindiv = contentindiv + '<div style="padding:20px"><div class="spm-s-sendsuccess-flex">';
			var contentindiv = contentindiv + '<div class="spm-success-icon"><span class="dashicons dashicons-bell"></span>';
			var contentindiv = contentindiv + '</div><p id="sendprebuiltemails-success-txt-id">';
			var contentindiv = contentindiv + '<b>' + question + '</b><br><span>' + template_name + '</span><br>';
			var contentindiv = contentindiv + '<span class="thinleek-desc-bright" style="visibility:hidden">template</span>';
			var contentindiv = contentindiv + '</p></div><div class="spm-s-sendsuccess_footer">';
			var contentindiv = contentindiv + '<a onclick="sendpbm_close_popup_bulk()" class="button button-secondary" style="width:120px;float:left;background:#fff;border-color:#fff;">' + spm_lang_object.spm_cancel + '</a>';
			var contentindiv = contentindiv + '<a onclick="spm_bulkaction_preview_func(\'' + order_first + '\',\'' + order_count + '\',\'' + identifier + '\',\'' + action + '\',\'prev\')" class="button button-secondary" style="width:120px;margin-right:10px">' + spm_lang_object.spm_preview + '</a>';
			var contentindiv = contentindiv + '<a onclick="spm_bulkaction_confimed_func(\'' + action + '\')" class="button button-primary" style="width:120px">' + spm_lang_object.spm_send + '</a>';
			var contentindiv = contentindiv + '</div></div></div></div></div>';
		
			var newdiv = '<div id="sendprebuiltemails_bulkrespond_here_id">' + contentindiv + '</div>';
			
			
			if ( $('#sendprebuiltemails_bulkrespond_here_id' ).length ) {
				$( '#sendprebuiltemails_bulkrespond_here_id' ).html( contentindiv );
			}
			else {
				$( '#wpbody' ).prepend( newdiv );
			}
		
		}
		
	}		
});
});		
/* END mail send are you sure */


/* preview in bulk */
spm_bulkaction_preview_func = function(order_id,order_count,identifier,action,prev) {
	
	var plain_inputs = 'no';
	
	if ( identifier == 'plain' ) {
		var checked = [];
			$('tbody th.check-column input[type="checkbox"]:checked').each(
				function() {
					checked.push($(this).val());
				}
			);
			
			
			var order_count = checked.length;
			var order_id = checked[0];
			var identifier = 'plain';
			var action = 'sendprebuiltemails_plain';
			
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
			
	}
	
	
	if ( prev == 'newprev' ) {
		var order_id = $( "#sendprebuiltemails_select_id_bulk_prev" ).val();
	}
	
		
	var sendenval = spm_lang_object.spm_sendmail;
	if ( order_count > 1 ) {
		var sendenval = spm_lang_object.spm_sendplural;
	}
	
	var sendenval = sendenval.replace('ordercount', order_count);
	
	var preview_txt = spm_lang_object.spm_prevorder;
	
	var geturl = window.location.href;		
	if (geturl.indexOf('users.php') > 0) {
		var preview_txt = spm_lang_object.spm_prevuser;
	}
	
	
	
	
	var contentindiv = '<div class="spm-bg-layer"></div><div class="spm-ajax-wrap-full"><div class="spm-ajax-wrap">';
	var contentindiv = contentindiv + '<div class="sendpbm_ajax_ausgabe_inner"><div class="spm-ajax-header">';
	var contentindiv = contentindiv + '<div class="spm-head-txt">' + preview_txt;
		
	var contentindiv = contentindiv + '<select onchange="spm_bulkaction_preview_func(\'getit\',\'' + order_count + '\',\'' + identifier + '\',\'' + action + '\',\'newprev\')" id="sendprebuiltemails_select_id_bulk_prev"></select></div></div>';
		
	var contentindiv = contentindiv + '<div class="pspm-ajax-body"><div id="sendprebuiltemails-loading-screen">';
	var contentindiv = contentindiv + '<div class="thinleek-progress"><div class="thinleek-indeterminate"></div></div>';
	var contentindiv = contentindiv + '<p style="text-align:left">' + spm_lang_object.spm_loading + '</p></div><div class="spm-ajax-footer">';
				
			
	var contentindiv = contentindiv + '<input type="submit" onclick="sendpbm_close_popup_order()" id="spmplainliveprevid" class="button-secondary button" value="' + spm_lang_object.spm_close + '">';
	var contentindiv = contentindiv + '<input onclick="spm_bulkaction_confimed_func(\'' + action + '\')" id="spmplain_id_send" value="' + sendenval + '" type="submit" style="margin-left:10px" class="button-primary button"></div>'; 
		
	var contentindiv = contentindiv + '<div style="height:100%;width:100%">';
	var contentindiv = contentindiv + '<div id="sendprebuiltemails_iframe_id_div"></div>';
	var contentindiv = contentindiv + '</div>';
		
		
	var contentindiv = contentindiv + '</div></div></div></div>';
		
		
	if ( prev !== 'newprev' && identifier !== 'plain' ) {
			
	document.getElementById('sendprebuiltemails_bulkrespond_here_id').innerHTML = contentindiv;
		
		
		$('tbody th.check-column input[type="checkbox"]:checked').each(
			function() {
				$('#sendprebuiltemails_select_id_bulk_prev').append(new Option('#' + $(this).val(), $(this).val()))
			}
		);
	
			
	}
	
	if ( identifier !== 'plain' ) {
		document.getElementById('sendprebuiltemails-loading-screen').style.display = '';
		document.getElementById('sendprebuiltemails_iframe_id_div').innerHTML = '';
	}
	
	if ( prev == 'newprev' && identifier == 'plain' ) {
		var contentindiv = '<div id="sendprebuiltemails-loading-screen"><div class="thinleek-progress">';
		var contentindiv = contentindiv + '<div class="thinleek-indeterminate"></div></div>';
		var contentindiv = contentindiv + '<p style="text-align:left">' + spm_lang_object.spm_loading + '</p></div>';
		document.getElementById('sendprebuiltemails_iframe_id_div').innerHTML = contentindiv;
	}
	else if ( identifier == 'plain' ) {
		document.getElementById('sendprebuiltemails_select_id_bulk_prev').value = order_id;
	}

	
	document.getElementById('sendprebuiltemails_iframe_id_div').style.overflowY = '';
		

	var data = {
		'action': 'sendprebuiltemails_preview_action',
		'identifier': identifier,
		'order': order_id,
		'inputs': plain_inputs,
		'ordercount': order_count,
		'nonce': spm_ajax_object.spm_ajax_nonce,
    };
	
	jQuery.ajax({
        type: 'POST',
        url: spm_ajax_object.spm_ajax_url,
        data: data,
        success: function (response) {
			
			var to_response_div = document.getElementById('sendprebuiltemails_iframe_id_div');
			
			if (typeof(to_response_div) != 'undefined' && to_response_div != null) {
				to_response_div.innerHTML = response;
				to_response_div.style.overflowY = 'scroll';
				
				if ( identifier !== 'plain' ) {
					document.getElementById('sendprebuiltemails-loading-screen').style.display = 'none';
				}
			}
				
        },
        error: function (response) {
			
			var to_response_div = document.getElementById('sendprebuiltemails_iframe_id_div');
			
			if (typeof(to_response_div) != 'undefined' && to_response_div != null) {
				to_response_div.innerHTML = 'unexpected error';
				to_response_div.style.overflowY = 'scroll';
			}
			
		}
	});
		

	
}
/* END preview in bulk */

/* bulk edit */
spm_bulkaction_confimed_func = function(action) {

		
		if (action.indexOf('sendprebuiltemails') != -1) {

			var checked = [];
			$('tbody th.check-column input[type="checkbox"]:checked').each(
				function() {
					checked.push($(this).val());
				}
			);
			
			
			var order_count = checked.length;
			var order_first = checked[0];
			var order_ids = checked.join('spm');
			
			
			// js start
			var splitaction = action.split('_');
			var type = 'orderbulk';
			var identifier = splitaction[1];
			
			
			var contentindiv = '<div class="spm-bg-layer"></div><div class="s-spm-ajax-wrap-full">';
			var contentindiv = contentindiv + '<div class="s-spm-ajax-wrap"><div class="spm-s-sendsuccess">';
			var contentindiv = contentindiv + '<div class="thinleek-progress" style="margin-bottom:-4px;">';
			var contentindiv = contentindiv + '<div class="thinleek-indeterminate"></div></div>';
			var contentindiv = contentindiv + '<div style="padding:20px"><div class="spm-s-sendsuccess-flex">';
			var contentindiv = contentindiv + '<div class="spm-success-icon"><span class="dashicons dashicons-airplane"></span>';
			var contentindiv = contentindiv + '</div><p id="sendprebuiltemails-success-txt-id">';
			var contentindiv = contentindiv + '<b>' + spm_lang_object.spm_sending + '</b><br><span style="visibility:hidden">';
			var contentindiv = contentindiv + '1 von 1 E-Mail erfolgreich versendet.</span><br>';
			var contentindiv = contentindiv + '<span style="visibility:hidden" class="thinleek-desc">Prebuilt E-Mail</span>';
			var contentindiv = contentindiv + '</p></div><div style="visibility:hidden" class="spm-s-sendsuccess_footer">';
			var contentindiv = contentindiv + '<a onclick="sendpbm_close_popup()" class="button button-primary">OKAY</a>';
			var contentindiv = contentindiv + '</div></div></div></div></div>';
			
			var newdiv = '<div id="sendprebuiltemails_bulkrespond_here_id">' + contentindiv + '</div>';
			
			
			if ( $('#sendprebuiltemails_bulkrespond_here_id' ).length ) {
				$( '#sendprebuiltemails_bulkrespond_here_id' ).html( contentindiv );
			}
			else {
				$( '#wpbody' ).prepend( newdiv );
			}
			
			
	if ( identifier == 'plain' ) {
		
		var sendenval = spm_lang_object.spm_sendplural;
		if ( order_count == 1 ) {
			var sendenval = spm_lang_object.spm_sendsing;
		}
		var sendenval = sendenval.replace('ordercount', order_count);
		
		var pageurl = window.location.protocol;
		var pageurl = pageurl + '//...';
		
		var contentindiv = '<div class="spm-bg-layer"></div><div class="spm-ajax-wrap-full"><div class="spm-ajax-wrap">';
		var contentindiv = contentindiv + '<div class="sendpbm_ajax_ausgabe_inner"><div class="spm-ajax-header">';
		var contentindiv = contentindiv + '<div id="sendprebuiltemails_plain_head_select_txt" style="display:none" class="spm-head-txt">' + spm_lang_object.spm_prevorder + '<select onchange="spm_bulkaction_preview_func(\'getit\',\'' + order_count + '\',\'' + identifier + '\',\'' + action + '\',\'newprev\')" id="sendprebuiltemails_select_id_bulk_prev"></select></div>';
		var contentindiv = contentindiv + '<div id="sendprebuiltemails_plain_head_blank_txt" class="spm-head-txt">' + spm_lang_object.spm_blank + '</div>';
		var contentindiv = contentindiv + '<span onclick="sendpbm_close_popup_order()" class="dashicons dashicons-no-alt spm-close-icon">';
		var contentindiv = contentindiv + '</span></div>';
		var contentindiv = contentindiv + '<div class="spm-ajax-footer">';
				
		var contentindiv = contentindiv + '<div class="spm-plain-notice"><div class="spm-plain-notice-item" style="text-align:left;">';
		var contentindiv = contentindiv + '<span id="spmplainicon_subject" class="dashicons dashicons-dismiss"></span>' + spm_lang_object.spm_subject + '</div>';
		var contentindiv = contentindiv + '<div class="spm-plain-notice-item" style="float:left;">';
		var contentindiv = contentindiv + '<span id="spmplainicon_content" class="dashicons dashicons-dismiss"></span>' + spm_lang_object.spm_content + '</div></div>';
				
		var contentindiv = contentindiv + '<input type="submit" onclick="spm_plain_func_layer()" id="spmplainliveprevid" class="button-secondary button" value="' + spm_lang_object.spm_preview + '" disabled readonly>';
		var contentindiv = contentindiv + '<input onclick="spm_run_bulksend_ajax(\'' + order_ids + '\',\'orderbulk\')" id="spmplain_id_send" value="' + sendenval + '" type="submit" style="margin-left:10px" class="button-primary button" disabled></div>'; 
				
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
		var contentindiv = contentindiv + '<input name="first_order" value="' + order_first + '" type="text" style="display:none!important">';
		var contentindiv = contentindiv + '<input name="order_count" value="' + order_count + '" type="text" style="display:none!important">';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><label>' + spm_lang_object.spm_subject + '</label><input id="spmplain_id_subject" onchange="spmplainicon_valid_check()" onkeyup="spmplainicon_valid_check()" class="sendprebuiltemails-live-inputs" type="text" name="subject" autocomplete="nope"></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><label>' + spm_lang_object.spm_heading + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="heading" autocomplete="nope"></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><label>' + spm_lang_object.spm_content + '</label><textarea id="spmplain_id_content" onchange="spmplainicon_valid_check()" onkeyup="spmplainicon_valid_check()" class="sendprebuiltemails-live-inputs" name="content"></textarea></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><input class="sendprebuiltemails-live-inputs" value="orderdetails" name="orderdetails" type="checkbox"><span>' + spm_lang_object.spm_orderdetails + '</span></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><input class="sendprebuiltemails-live-inputs" value="address" name="address" type="checkbox"><span>' + spm_lang_object.spm_address + '</span></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><label>' + spm_lang_object.spm_additional + '</label><textarea class="sendprebuiltemails-live-inputs" style="height:100px!important" name="contenttwo"></textarea></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live"><input class="sendprebuiltemails-live-inputs" value="footer" name="footer" type="checkbox"><span>' + spm_lang_object.spm_footer + '</span></div>';
		
		var contentindiv = contentindiv + '<div class="spm-plain-live"><label>' + spm_lang_object.spm_attachment + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="attachment_a">';
		var contentindiv = contentindiv + '<span class="thinleek-desc">' + pageurl + '</span></div>';
		
		var contentindiv = contentindiv + '<div class="spm-plain-live" id="mail-header-settings"><span class="spm-plain-more" onclick="spm_plain_toggle()"><span id="spm-plain-live-plus-id">+</span>' + spm_lang_object.spm_fromto + '</span></div>';
		var contentindiv = contentindiv + '<div class="spm-plain-live" id="spm-plain-live-more-id" style="display: none;">';
		var contentindiv = contentindiv + '<label>' + spm_lang_object.spm_from_name + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="from_name" autocomplete="nope">';
		var contentindiv = contentindiv + '<label>"' + spm_lang_object.spm_from_mail + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="from_email" autocomplete="nope">';
		var contentindiv = contentindiv + '<label>' + spm_lang_object.spm_to + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="to_email" value="{billing-email}" autocomplete="nope">';
		var contentindiv = contentindiv + '<label>' + spm_lang_object.spm_replyto_name + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="reply_to_name" autocomplete="nope">';
		var contentindiv = contentindiv + '<label>' + spm_lang_object.spm_replyto_mail + '</label><input class="sendprebuiltemails-live-inputs" type="text" name="reply_to_email" autocomplete="nope">';
		var contentindiv = contentindiv + '<label>cc</label><input class="sendprebuiltemails-live-inputs" type="text" name="cc" autocomplete="nope">';
		var contentindiv = contentindiv + '<label>bcc</label><input class="sendprebuiltemails-live-inputs" type="text" name="bcc" autocomplete="nope">';
		var contentindiv = contentindiv + '</div></div></div></div></div>';
		
		var contentindiv = contentindiv + '</div>';
		
		// end form
		
		
		var contentindiv = contentindiv + '</div></div></div></div>';
		var contentindiv = contentindiv + '</div>';
				
		document.getElementById('sendprebuiltemails_bulkrespond_here_id').innerHTML = contentindiv;
		
		$('tbody th.check-column input[type="checkbox"]:checked').each(
			function() {
				$('#sendprebuiltemails_select_id_bulk_prev').append(new Option('#' + $(this).val(), $(this).val()))
			}
		);
		
		
			
				
	} // end if plain
	else {
			
			
						
			var geturl = window.location.href;
			
			if (geturl.indexOf('users.php') > 0) {
			 var type = 'user';	
			}
			
			
			
			var data = {
			'action': 'sendprebuiltemails_secure_sendmail_action',
			'identifier': identifier,
			'order_ids': order_ids,
			'type': type,
			'nonce': spm_ajax_object.spm_ajax_nonce,
            };


		jQuery.ajax({
        type: 'POST',
        url: spm_ajax_object.spm_ajax_url,
        data: data,
        success: function (response) {
			
			if (response.indexOf('_spmexplodespm_') > 0) {
				
				var splitres = response.split('_spmexplodespm_');
				
				if ( type == 'orderbulk' ) {	
					
					document.getElementById('sendprebuiltemails_bulkrespond_here_id').innerHTML = splitres[0];
					var updated_orders = splitres[1].split('spm');
					
					for ( i=0; i<updated_orders.length; i++ ) {
						var rowid = 'post-' + updated_orders[i];
						var row = document.getElementById(rowid);
						row.getElementsByClassName("column-sendprebuiltemails_column_log_id")[0].innerHTML = splitres[2];
					}
				}
				else {
					document.getElementById('sendprebuiltemails_bulkrespond_here_id').innerHTML = splitres[0];
				}
				
				if ( splitres[4].length > 10 ) {
					document.getElementById('sendprebuiltemail_okay_button_id').innerHTML = splitres[4];
					location.reload();
				}
			}
			else {
				document.getElementById('sendprebuiltemails_bulkrespond_here_id').innerHTML = response;
			}
			
			
        },
        error: function (response) {
			
			document.getElementById('sendprebuiltemails_bulkrespond_here_id').innerHTML = '';
			alert('unexpected error, please try again');
			
			
        }
		
		});
		

			

	}	
	
	// This return prevents the submit event to refresh the page.
    return false;
	
		} // END if sendprebuiltemail action
	
	
}
/* END bulk edit */


/* jquery to save advanced admin settings */

$(document).ready(function(){
$('form[name="sendprebuiltemails_admin_adv_settings_form"]').on( 'submit', function($) {
	
	
	//tinyMCE.triggerSave();
    var form_data = jQuery( this ).serializeArray();
	
	var progress = document.getElementById('sendpbm_admin_adv_settings_save_progress');
	progress.innerHTML = '<div class="thinleek-progress"><div class="thinleek-indeterminate"></div></div>';
	
	var submitbtn = document.getElementById('sendpbm_admin_adv_settings_save_btn');
	var submitbanner = document.getElementById('sendpbm_admin_adv_settings_saved_banner');
	
	var placeholderhere = document.getElementsByClassName('spm-placeholder_response_here');
	
	
	submitbtn.disabled = true;
	
	form_data.push( { 'name' : 'security', 'value' : spm_ajax_object.spm_ajax_nonce } );
 
    // Here is the ajax petition.
    jQuery.ajax({
        url : spm_ajax_object.spm_ajax_url,
        type : 'post',
        data : form_data,
        success : function( response ) {
            
			
			
			submitbanner.style.visibility = '';
			submitbanner.classList.add('sendpbm_response_banner');
			submitbtn.disabled = false;
			sendpbm_js_resp_hide_adv();
			progress.innerHTML = '<div style="height:4px;width:100%;"></div>';
			
			for ( i=0; i<placeholderhere.length; i++ ) {
				placeholderhere[i].innerHTML = response;
			}
			

        },
        fail : function( response ) {
			
			
			submitbanner.style.visibility = '';
			submitbanner.classList.add('sendpbm_response_banner');
			submitbtn.disabled = false;
			sendpbm_js_resp_hide_adv();
			progress.innerHTML = '';
			
			for ( i=0; i<placeholderhere.length; i++ ) {
				placeholderhere[i].innerHTML = response;
			}


        }
		
    });
	 
	 
    // This return prevents the submit event to refresh the page.
    return false;
});
});

/* jquery to save advance admin settings END */




/* jquery to save general settings */

$(document).ready(function(){
$('form[name="sendprebuiltemails_admin_general_settings_form"]').on( 'submit', function($) {
	
	
	//tinyMCE.triggerSave();
    var form_data = jQuery( this ).serializeArray();
	
	var progress = document.getElementById('sendpbm_admin_adv_settings_save_progress');
	progress.innerHTML = '<div class="thinleek-progress"><div class="thinleek-indeterminate"></div></div>';
	
	var submitbtn = document.getElementById('sendpbm_admin_adv_settings_save_btn');
	var submitbanner = document.getElementById('sendpbm_admin_adv_settings_saved_banner');
	
	var placeholderhere = document.getElementsByClassName('spm-placeholder_response_here');
	
	
	submitbtn.disabled = true;
	
});
});

/* jquery to save general settings END */





/* jquery to delete Template */
	
$(document).ready(function(){
$('form[name="sendprebuiltemails_template_delete_form"]').on( 'submit', function($) {
	
    var form_data = jQuery( this ).serializeArray();
	
	form_data.push( { 'name' : 'security', 'value' : spm_ajax_object.spm_ajax_nonce } );
	
	var progressdiv = document.getElementById('spm_table_template_overview_progress_id');
	progressdiv.innerHTML = '<div class="thinleek-progress" style="margin-top:-4px;"><div class="thinleek-indeterminate"></div></div>';
 
    // Here is the ajax petition.
    jQuery.ajax({
        url : spm_ajax_object.spm_ajax_url,
        type : 'post',
        data : form_data,
        success : function( response ) {
            // You can craft something here to handle the message return
			location.reload();


        },
        fail : function( err ) {
			location.reload();

        }
    });
	 
	 
    // This return prevents the submit event to refresh the page.
    return false;
});
});

/* jquery to delete Template END */



/* jquery to save admin settings */

$(document).ready(function(){
$('form[name="spm_admin_settings_form"]').on( 'submit', function($) {
	
	
	//tinyMCE.triggerSave();
    var form_data = jQuery( this ).serializeArray();
	
	var progress = document.getElementById('sendpbm_admin_settings_save_progress');
	progress.innerHTML = '<div class="thinleek-progress"><div class="thinleek-indeterminate"></div></div>';
	
	var submitbtn = document.getElementById('sendpbm_admin_settings_save_btn');
	var submitbanner = document.getElementById('sendpbm_admin_settings_saved_banner');
	
	var spreviewbtn = document.getElementById('sendpbm_admin_settings_save_btn');
	
	var trforselect = document.getElementById('spm_selecttemplete_select_id');
	var tableoverview = document.getElementById('spm_overview_table_herein_div');
	var addressprev = document.getElementsByClassName('spm_address_email_header_preview_here_class');
	var adv_bulk = document.getElementById('spm_admin_settings_bulk_here_id');
	
	
	
	submitbtn.disabled = true;
	spreviewbtn.disabled = true;
	
	form_data.push( { 'name' : 'security', 'value' : spm_ajax_object.spm_ajax_nonce } );
 
    // Here is the ajax petition.
    jQuery.ajax({
        url : spm_ajax_object.spm_ajax_url,
        type : 'post',
        data : form_data,
        success : function( response ) {
            // You can craft something here to handle the message return
			submitbanner.style.visibility = '';
			submitbanner.classList.add('sendpbm_response_banner');
			submitbtn.disabled = false;
			spreviewbtn.disabled = false;
			sendpbm_js_resp_hide();
			progress.innerHTML = '<div style="height:4px;width:100%;"></div>';
			
			var splitresponse = response.split('sendprebuiltemails_split_response_njJKdjkNJK');
			
			trforselect.innerHTML = splitresponse[0];
			tableoverview.innerHTML = splitresponse[1];
			adv_bulk.innerHTML = splitresponse[2];
			
			for ( i=3; i<splitresponse.length; i++ ) {
			var iforaddress = i - 3;
			addressprev[iforaddress].innerHTML = splitresponse[i];
			}

        },
        fail : function( err ) {
			submitbanner.style.visibility = '';
			submitbanner.classList.add('sendpbm_response_banner');
			submitbtn.disabled = false;
			spreviewbtn.disabled = false;
			sendpbm_js_resp_hide();
			progress.innerHTML = '';
			var splitresponse = response.split('sendprebuiltemails_split_response_njJKdjkNJK');
			trforselect.innerHTML = splitresponse[0];
			tableoverview.innerHTML = splitresponse[1];
			adv_bulk.innerHTML = splitresponse[2];
			
			for ( i=3; i<splitresponse.length; i++ ) {
			var iforaddress = i - 3;
			addressprev[iforaddress].innerHTML = splitresponse[i];
			}
        }
		
    });
	 
	 
    // This return prevents the submit event to refresh the page.
    return false;
});
});

/* jquery to save admin settings END */


	

})( jQuery );


function sndpbm_disabled_wc_mail(identifier) {
	var progressid = 'sendprebuiltemails_disable_wc_id_' + identifier;
	var progress = document.getElementById(progressid);
	progress.innerHTML = '<div class="thinleek-progress"><div class="thinleek-indeterminate"></div></div>';
	
	var optiondivid = 'sendprebuiltemails_div_wcmail_option_' + identifier;
	var optiondiv = document.getElementById(optiondivid);
	optiondiv.innerHTML = '';
	
	var newstatusid = 'sendprebuiltemails_select_newstatus_id_' + identifier;
	var newstatus = document.getElementById(newstatusid).value;
	
	var trtodisableid = 'sendprebuiltemails_disable_wc_tr_id_' + identifier;
	var trtodisable = document.getElementById(trtodisableid);
	
	var data = {
		'action': 'sendprebuiltemails_disable_wc_mail_option_action',
		'identifier': identifier,
		'new_status': newstatus,
    };
	
	jQuery.ajax({
        type: 'POST',
        url: spm_ajax_object.spm_ajax_url,
        data: data,
        success: function (response) {
			
			var ressplit = response.split('__spm__');
			
			optiondiv.innerHTML = ressplit[0];
			progress.innerHTML = '';
			
			if ( ressplit[1] == 'disabled' ) {
				trtodisable.classList.add('thinleektrdisabled');	
			}
			else {
				trtodisable.classList.remove('thinleektrdisabled');	
			}
				
        },
        error: function (response) {
			
			trtodisable.classList.add('thinleektrdisabled');	
			
		}
	});
			
}

function sendpbm_close_popup_bulk() {
	var bulkhere = document.getElementById('sendprebuiltemails_bulkrespond_here_id');
	bulkhere.innerHTML = '';
	
	var bulkselecttop = document.getElementById('bulk-action-selector-top');
	var bulkselectbottom = document.getElementById('bulk-action-selector-bottom');
	
	var dropdown = document.getElementById('sendprebuiltemails_order_edit_select_id')
	
	if (typeof(bulkselecttop) != 'undefined' && bulkselecttop != null) {
		bulkselecttop.value = '-1';
		bulkselectbottom.value = '-1';
	}
	else if (typeof(dropdown) != 'undefined' && dropdown != null) {
		dropdown.value = 'choose';
		sendprebuiltemails_btn_disabled();
	}
	
}


function sendpbm_close_popup_order() {
	var bulkhere = document.getElementById('sendprebuiltemails_bulkrespond_here_id');
	bulkhere.innerHTML = '';
}


function mlarea(buttonid) {
var button = document.getElementById(buttonid);
var alltabs = document.getElementsByClassName('ml-nav-tabs');
var sections = document.getElementsByClassName('ml-nav-tabs-section');

var sectionid = button.id + '-section';
var activsection = document.getElementById(sectionid);


for (i=0; i<alltabs.length; i++ ) {
alltabs[i].setAttribute('aria-selected','false');
alltabs[i].classList.remove('nav-tab-active');
sections[i].style.display = 'none';
}

button.setAttribute('aria-selected','true');
button.classList.add('nav-tab-active');
button.blur();
activsection.style.display = '';
}


function sendprebuiltemails_templatename_check() {
	
	var select = document.getElementById('sendprebuiltemails-select-id');
	var identifier = select.value;
	
	
	var inputnameid = 'spm_selecttemplete_nameinput_id_' + identifier;
	var inputname = document.getElementById(inputnameid).value;
	var nonamediv = document.getElementById('sendpbm_admin_settings_save_btn_topdiv');
	
	
	if ( inputname.length > 0 ) {
		nonamediv.style.display = 'none';
	}
	else {
		nonamediv.style.display = '';
	}
}

function sendprebuiltemails_whichtemplate_letter(letter) {
	
	var select = document.getElementById('sendprebuiltemails-select-id');
	var identifier = letter;
	var btnsdiv = document.getElementById('spm_save_and_preview_btn');
	var trborder = document.getElementById('spm_tr_choose_template_id');
	
	if ( identifier == 'choose' ) {
		select.value = identifier;
		var alltables = document.getElementsByClassName('spm-template-tables');
		
			for ( i=0; i<alltables.length; i++ ) {
				alltables[i].style.display = 'none';
			}
			
		btnsdiv.style.display = 'none';
		trborder.style.borderBottom = '1px solid #cdcdcd';
	}
	else {
		
		select.value = identifier;
	
		var alltables = document.getElementsByClassName('spm-template-tables');
		var aktivtablename = 'ml_sendpbm_table_' + identifier;
		var aktivtable = document.getElementById(aktivtablename);
	
			for ( i=0; i<alltables.length; i++ ) {
				alltables[i].style.display = 'none';
			}
		
		btnsdiv.style.display = '';
		trborder.style.borderBottom = 'none';
		aktivtable.style.display = '';
		mlarea('edit-btn');
		sendprebuiltemails_templatename_check();
	}
	
}

function sendprebuiltemails_whichtemplate() {
	var select = document.getElementById('sendprebuiltemails-select-id');
	var identifier = select.value;
	var btnsdiv = document.getElementById('spm_save_and_preview_btn');
	var trborder = document.getElementById('spm_tr_choose_template_id');
	
	
	if ( identifier == 'choose' ) {
		var alltables = document.getElementsByClassName('spm-template-tables');
		
			for ( i=0; i<alltables.length; i++ ) {
				alltables[i].style.display = 'none';
			}
			
		btnsdiv.style.display = 'none';
		trborder.style.borderBottom = '1px solid #cdcdcd';
		
	}
	else {
	
		var alltables = document.getElementsByClassName('spm-template-tables');
		var aktivtablename = 'ml_sendpbm_table_' + identifier;
		var aktivtable = document.getElementById(aktivtablename);
	
		for ( i=0; i<alltables.length; i++ ) {
			alltables[i].style.display = 'none';
		}
		
		btnsdiv.style.display = '';
		aktivtable.style.display = '';
		sendprebuiltemails_templatename_check();
		trborder.style.borderBottom = 'none';
	}
		
}

function sendprebuiltemails_tr_klapp(tr,klasse) {
	var klapptr = document.getElementsByClassName(klasse);
	var icon = tr.getElementsByClassName('dashicons')[0];
	var iconclass = icon.className;
	
	if ( iconclass.indexOf('arrow-down') > 0 ) {
		var trstyle = '';
		icon.classList.remove('dashicons-arrow-down');
		icon.classList.add('dashicons-arrow-up');
	}
	else {
		var trstyle = 'none';	
		icon.classList.remove('dashicons-arrow-up');
		icon.classList.add('dashicons-arrow-down');
	}
	
	for ( i=0; i<klapptr.length; i++ ) {
		klapptr[i].style.display = trstyle;
	}
	
}

function sendprebuiltemails_copy(buttonel) {
  var copyText = buttonel;

  copyText.select();

  document.execCommand('copy');
   
  var copiedtxts = document.getElementsByClassName('thinleek-copied-txt');
  
  for ( i=0; i<copiedtxts.length; i++ ) {
		copiedtxts[i].style.visibility = '';
		copiedtxts[i].innerHTML = '<b>' + copyText.value + '</b> kopiert.';
  }
}

function sendpbm_js_resp_hide() {
	var qmsavedbanner = document.getElementById('sendpbm_admin_settings_saved_banner');
	setTimeout(function(){ qmsavedbanner.style.visibility = 'hidden'; }, 3000);
	}
	
function sendpbm_js_resp_hide_adv() {
	var qmsavedbanner = document.getElementById('sendpbm_admin_adv_settings_saved_banner');
	setTimeout(function(){ qmsavedbanner.style.visibility = 'hidden'; }, 3000);
	}
	
	
function ml_sendpbm_confirm(letter) {
	var vorlagename = 'sendpbm_vorschau_name_id_' + letter;
	var vorlage = document.getElementById(vorlagename).innerHTML;
	
	var formname = 'sendprebuiltemails_delete_form_submit' + letter;
	var form = document.getElementById(formname);
	
	var btnname = 'sendpbm_vorlage_' + letter;
	var btn = document.getElementById(btnname);
	
	
	var areysure = spm_lang_object.spm_sure;
	var areysure = areysure.replace('changetemplatename', vorlage);
	var r = confirm(areysure);
	if (r == true) {
		txt = spm_lang_object.spm_deleting;
		btn.innerHTML = txt;
		form.click();
	}
	else {
		txt = spm_lang_object.spm_delete;
	}
  
  
}



function sendpbm_close_popup() {
	var mailsend_res_div = document.getElementById('sendpbm_mailsend_respond_id');	
	mailsend_res_div.innerHTML = '<span style="display:none!important">sendpbm closed</span>';
}


function sendpbm_close_popup_unselect() {
	var mailsend_res_div = document.getElementById('sendpbm_mailsend_respond_id');	
	mailsend_res_div.innerHTML = '<span style="display:none!important">sendpbm closed</span>';
}





