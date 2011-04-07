/**
 * @author Azat Khizhin
 * 
 * Main JS
 */

// onload
$(function() {
	// confirm
	$('.confirmDialog').click(function(e) {
		e.preventDefault(this);

		jConfirm('Are your shure your want to continue?', 'Confirm', function(r) {
			if (r) window.location = e.target.href;
		});
	});
	
	new Paginator().init();
});