jQuery(document).ready(function(){
    jQuery('[name="post_title"]').on('blur', function(){
        var lastName = jQuery('[name="post_title"]').val().split(' ').pop();
        jQuery('#acf-field-last_name').val(lastName);
    });
});
