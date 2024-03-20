(function ($) {
	$('body').addClass('wizard__drawer--open');
	$('#demo-content-list li:first-child').addClass('selected');
	$('#demo-content-list li').on('click', function () {
		var t = $(this),
			chosen_demo = t.attr('data-demo'),
			selected_demo = $('.js-wizard-demo-import-select');
		t.addClass('selected').siblings().removeClass('selected');
		selected_demo.val(chosen_demo);
	});
	$('.yith-proteo-toolkit-wizard-nav ul li.active').prevAll('li').addClass('step-done');
})(jQuery);