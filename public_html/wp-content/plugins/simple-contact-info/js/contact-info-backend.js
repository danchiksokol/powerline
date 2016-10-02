jQuery(document).ready(function($) {
	$('#contactSocialForm').submit(function() {
		var count = $(this).find('input[type=radio]:checked').length;
		if (count < 5) {
			$("#dialog-message").dialog({
				modal: true,
				buttons: {
					Ok: function() {
						$("#dialog-message").dialog( "close" );
					}
				}
			});
			return false;
		} else {
			$(this).submit();
		}
	});

	$('.sci-delete').live('click', function(){
		var _this = $(this);
		$("#dialog-confirm").dialog({
			resizable: false,
			height:190,
			modal: true,
			buttons: {
				"Delete icon": function() {
					var data = {
						action: 'sci_ajax_delete_icon',
						icon: _this.parent("li").find('.sci-radio').val()
					};

					$.post(ajaxurl, data, function(response) {
						if (response) {
							_this.parent("li").fadeOut("slow", function(){
								var count = _this.parents('tr').find('li').length;
								if (count == 1) {
									_this.parents('tr').remove();
								} else {
									_this.parent('li').remove();
								}
							});
						}
						$('#dialog-confirm').dialog("close");
					});
				},
				Cancel: function() {
					$(this).dialog("close");
				}
			}
		});
	});

	$('.sci-delete-option').live('click', function(){
		var _this = $(this);
		$("#dialog-confirm").dialog({
			resizable: false,
			height:190,
			modal: true,
			buttons: {
				Delete: function() {
					var data = {
						action: 'sci_ajax_delete_option',
						option: _this.parent("td").find('.sci-option').val()
					};
					$.post(ajaxurl, data, function(response) {
						_this.parent("td").parent("tr").fadeOut("slow");
						$('#dialog-confirm').dialog("close");
					});
				},
				Cancel: function() {
					$(this).dialog("close");
				}
			}
		});
	});
});