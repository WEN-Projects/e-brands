jQuery(document).ready(function ($) {
	$('#approve-customer-confirm-btn').on('click', function () {
		let customer_id = $(this).attr('customer-id');
		if (typeof (customer_id) == 'undefined' || customer_id == '') {
			return;
		}
		$.ajax({
			url: ebrands_obj.ajax_url,
			type: 'post',
			beforeSend: function beforeSend() {
				$("#approve-customer-confirm-btn i").show();
			},
			data: {
				action: 'ebrands_admin_approve_customer',
				customer_id: customer_id,
				ajax_nonce: ebrands_obj.nonce_ajax // Pass nonce here
			},
			success: function success(response) {
				$("#approve-customer-confirm-btn i").hide();
				if ('undefined' != typeof (response.status) && 1 == response.status) {
					$("#approval-response-message").html("<i class=\"fa fa-check-circle\"></i> " + response.message);
					setTimeout(function () {
						location.reload();
					}, 400);
				} else {
					$("#approval-response-message").html("fail to approve the user");
				}
			}
		});
	});
})
