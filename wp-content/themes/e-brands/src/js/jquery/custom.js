import $ from 'jquery';

function customJquery() {
	// Custom Codes inside
	$('document').ready(function () {
		$('form.product-filter select[name="category"], form.product-filter select[name="brand"]').on('change', function () {
			execute_filter();
		});
		$('form.product-filter').on('submit', function (e) {
			e.preventDefault();
			execute_filter();
		});
		// $('form.product-filter input[name="search_key"]').on('blur', function (e) {
		// 	e.preventDefault();
		// 	execute_filter();
		// 	$('form.product-filter #search-results').hide();
		// });
	});


	$('span.cl-product-filters').on('click', function () {
		$(this).parent().next().val('').trigger('change');
	});
	$('span.cl-product-search-key').on('click', function () {
		$('form.product-filter  #search-results').hide();
		$('div.autocomplete #filter-by-search_key').val('').trigger('change');
		execute_filter();
	});

	$(document).on('click', '.e-brands-pagination a', function (e) {
		e.preventDefault();
		let hrfe_link = $(this).attr('href') == '' ? ebrands_obj.ebrands_shop_url : $(this).prop('href');
		window.history.pushState({}, '', hrfe_link);
		applyAjaxFilter(hrfe_link);
	});


	$('form.product-filter input[name="search_key"]').on("keyup", function () {
		let selected_cat = $('form.product-filter select[name="category"]').val();
		let selected_brand = $('form.product-filter select[name="brand"]').val();
		let search_key = $('form.product-filter input[name="search_key"]').val();
	});

	function execute_filter() {
		let url_params = [];
		let selected_cat = $('form.product-filter select[name="category"]').val();
		let selected_brand = $('form.product-filter select[name="brand"]').val();
		let search_key = $('form.product-filter input[name="search_key"]').val();
		if ('undefined' != typeof (selected_cat) && '' != selected_cat) {
			url_params.push({
				title: 'category',
				att: selected_cat
			});
		}
		if ('undefined' != typeof (selected_brand) && '' != selected_brand) {
			url_params.push({
				title: 'brand',
				att: selected_brand
			});
		}
		if ('undefined' != typeof (search_key) && '' != search_key) {
			url_params.push({
				title: 'search_key',
				att: search_key
			});
		}
		var base_url = ebrands_obj.ebrands_shop_url;
		var updated_url = updateUrlParameter(base_url, url_params);
		applyAjaxFilter(updated_url);
	}

	// Check and add URL Parameters
	function updateUrlParameter(url, params) {
		var urlObject = new URL(url);
		$.each(params, function (index, val) {
			urlObject.searchParams.append(val.title, val.att);
		});
		return urlObject.href;
	}

	function updateTheListingTitle() {
		let title_arr = [];
		let search_keyword = $("form.product-filter input[name='search_key']").val();
		let selected_brand = $("form.product-filter select[name='brand']").find(":selected").val();
		let selected_cat = $("form.product-filter select[name='category']").find(":selected").val();
		if ('undefined' != typeof (search_keyword) && '' != search_keyword) {
			title_arr.push(search_keyword);
		}
		if ('undefined' != typeof (selected_brand) && '' != selected_brand) {
			let selected_brand_label = $("form.product-filter select[name='brand']").find(":selected").text();
			title_arr.push(selected_brand_label);
		}
		if ('undefined' != typeof (selected_cat) && '' != selected_cat) {
			let selected_cat_label = $("form.product-filter select[name='category']").find(":selected").text();
			title_arr.push(selected_cat_label);
		}
		if (title_arr.length !== 0) {
			$("#product-listing-title").html(title_arr.join(' / '));
		} else {
			$("#product-listing-title").html("Highlights");
		}
	}

	function applyAjaxFilter(reqURL, restForm = false) {
		$.ajax({
			url: reqURL,
			type: 'GET',
			beforeSend: function beforeSend() {
				$('section.product-list').addClass('loading');
				$('form.product-filter  #search-results').hide();
			},
			success: function success(response) {
				var listingContent = $(response).find('#ebrands-shop-product-list').html();
				$('#ebrands-shop-product-list').html(listingContent);
				$('section.product-list').removeClass('loading');
				window.history.pushState({}, '', reqURL);
				updateTheListingTitle();
			}
		});
	}

	$(document).ready(function ($) {
		if ('undefined' != typeof (ebrands_obj.selected_event_category) && '' != ebrands_obj.selected_event_category) {
			$('html, body').animate({scrollTop: $('#ebrands-events-listing').offset().top - 320}, 800);
		}

		$('form.product-filter #filter-by-search_key').on('keyup', function (event) {
			if (event.keyCode === 13) {
				return;
			}
			var search_text = $(this).val();
			if ('undefined' != typeof (search_text.length) && search_text.length > 0) {
				$('form.product-filter #search-results').show();
				$.ajax({
					url: ebrands_obj.ajax_url,
					type: 'post',
					beforeSend: function beforeSend() {
						$('form.product-filter #search-results').html('searching...');
						$('form.product-filter #search-results').addClass('search-loading');
					},
					data: {
						action: 'ebrands_product_search_autosuggest',
						search_text: search_text,
						ajax_nonce: ebrands_obj.nonce_ajax // Pass nonce here
					},
					success: function (response) {
						$('form.product-filter #search-results').html(response);
						$('form.product-filter #search-results').removeClass('search-loading');
					}
				});
			} else {
				$('form.product-filter  #search-results').hide();
			}

			//close on click outside
            $(document).on('click', function(event) {
                let targetWrap = $('.autocomplete');
                if (!targetWrap.is(event.target) && targetWrap.has(event.target).length === 0) {
                    $('form.product-filter #search-results').hide();
                }
            });

		});

		$(document).on('click', 'a#load-more-events', function (e) {
			e.preventDefault();
			let searchParams = new URLSearchParams(window.location.search);
			let count = 10;
			if (searchParams.has('count')) {
				count = 5 + parseInt(searchParams.get('count'));
			}
			let url_params = [];
			if (searchParams.has('category')) {
				url_params.push({
					title: 'category',
					att: searchParams.get('category')
				});
			}
			url_params.push({
				title: 'count',
				att: count
			});
			var base_url = ebrands_obj.ebrands_events_listing__url;
			var updated_url = updateUrlParameter(base_url, url_params);
			console.log(ebrands_obj.ebrands_events_listing__url);
			window.history.pushState({}, '', updated_url);
			load_more_events(updated_url);
		});

		function load_more_events(reqURL, restForm = false) {
			$.ajax({
				url: reqURL,
				type: 'GET',
				beforeSend: function beforeSend() {
					$('#load-more-events i').show();
				},
				success: function success(response) {
					var events_list = $(response).find('#ebrands-events-listing').html();
					$('#ebrands-events-listing').html(events_list);
					var load_more_html = $(response).find('#load-more-events-wrapper').html();
					$('#load-more-events-wrapper').html(load_more_html);
					$('#load-more-events i').hide();
					// $('section.product-list').removeClass('loading');
					// window.history.pushState({}, '', reqURL);
					// updateTheListingTitle();
				}
			});
		}
	});

}

export default customJquery;
