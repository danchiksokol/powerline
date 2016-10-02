var $j = jQuery.noConflict();

$j(function () {
	$j('#woocommerce-checkall').click(function () {
		$j('#empty-woocommerce-tables').find(':checkbox').attr('checked', true);
	});
	$j('#woocommerce-uncheckall').click(function () {
		$j('#empty-woocommerce-tables').find(':checkbox').attr('checked', false);
	});

	$j('#wordpress-checkall').click(function () {
		$j('#empty-wordpress-tables').find(':checkbox').attr('checked', true);
	});
	$j('#wordpress-uncheckall').click(function () {
		$j('#empty-wordpress-tables').find(':checkbox').attr('checked', false);
	});
});