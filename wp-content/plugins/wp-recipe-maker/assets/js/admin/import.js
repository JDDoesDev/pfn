var wprm_admin = wprm_admin || {};

wprm_admin.import_last_checked = false;

jQuery(document).ready(function($) {
	// Quick select functionality.
	jQuery('.wprm-import-recipes-select-all').on('click', function(e) {
		e.preventDefault();
		jQuery('.wprm-import-recipes').find(':checkbox').each(function() {
			jQuery(this).prop('checked', true);
		});
	});
	jQuery('.wprm-import-recipes-select-none').on('click', function(e) {
		e.preventDefault();
		jQuery('.wprm-import-recipes').find(':checkbox').each(function() {
			jQuery(this).prop('checked', false);
		});
	});

	// Select multiple using SHIFT
	jQuery('.wprm-import-recipes').on('click', ':checkbox', function(e) {
		if(wprm_admin.import_last_checked && e.shiftKey) {
			var checkboxes = jQuery('.wprm-import-recipes').find(':checkbox'),
				start = checkboxes.index(this),  
				end = checkboxes.index(wprm_admin.import_last_checked);

			checkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', wprm_admin.import_last_checked.checked);
		}

		wprm_admin.import_last_checked = this;
	});
});
