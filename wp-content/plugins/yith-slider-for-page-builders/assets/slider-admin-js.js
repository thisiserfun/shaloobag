(function ($) {

	// Add Color Picker to all inputs that have 'color-field' class.
	$(function () {
		$('#single_slide_background_color').wpColorPicker();


	});
	var slider = $('#yith_slider_control_autoplay_timing');
	var slider2 = $('#yith_slider_control_container_max_width');
	var slider3 = $('#yith_slider_control_min_heigth');

	function update_slide_value() {
		var timing_value = $('#timing_value'),
			max_content_width = $('#container_max_width'),
			min_content_height = $('#container_min_height');
		timing_value.html(slider.val() / 1000 + ' s');
		max_content_width.html(slider2.val() + ' px');
		min_content_height.html(slider3.val() + ' px');
	}

	slider.on('mousemove', update_slide_value).change();
	slider2.on('mousemove', update_slide_value).change();
	slider3.on('mousemove', update_slide_value).change();

	var slides_list = $(".yith-slider-slides-list");
	slides_list.sortable({
		update: update_list_elements_index
	});
	slides_list.disableSelection();

	function update_list_elements_index() {
		slides_list.find('li').each(function () {
			var t = $(this);
			t.attr("data-order", t.index());
		});
	}

	update_list_elements_index();

})(jQuery);