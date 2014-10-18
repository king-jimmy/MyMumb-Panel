// Main javascript
	
$(function()
{
	$(".ui-dialog-titlebar").hide();
});


function newDialog(name, width, height)
{
	$("#" + name).dialog(
	{
		width: width,
		height: height,
		autoOpen: false,
		modal: true,
		show: {
			effect: "fade",
			duration: 200
		},
		hide: {
			effect: "fade",
			duration: 200
		},
		open: function()
		{
			jQuery('.ui-widget-overlay').bind('click',function() {
				jQuery("#" + name).dialog('close');
			})
		}
	});
}

function newFlexibleDialog(name, width)
{
	$("#" + name).dialog(
	{
		width: width,
		autoOpen: false,
		modal: true,
		show: {
			effect: "fade",
			duration: 200
		},
		hide: {
			effect: "fade",
			duration: 200
		},
		open: function()
		{
			jQuery('.ui-widget-overlay').bind('click',function() {
				jQuery("#" + name).dialog('close');
			})
		}
	});
}