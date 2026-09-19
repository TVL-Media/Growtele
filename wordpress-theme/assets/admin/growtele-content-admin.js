(function ($) {
	'use strict';

	function openMediaFrame($field) {
		var frame = wp.media({
			title: 'Select media',
			button: { text: 'Use this file' },
			multiple: false,
		});

		frame.on('select', function () {
			var attachment = frame.state().get('selection').first().toJSON();
			$field.find('[data-attachment-id]').val(attachment.id);
			var url = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
			$field.find('.growtele-media-field__preview').html(
				'<img src="' + url + '" alt="" style="max-width:120px;height:auto;" />'
			);
		});

		frame.open();
	}

	$(document).on('click', '[data-growtele-media-select]', function (e) {
		e.preventDefault();
		openMediaFrame($(this).closest('[data-growtele-media]'));
	});

	$(document).on('click', '[data-growtele-media-clear]', function (e) {
		e.preventDefault();
		var $field = $(this).closest('[data-growtele-media]');
		$field.find('[data-attachment-id]').val('0');
		$field.find('.growtele-media-field__preview').empty();
	});
})(jQuery);
