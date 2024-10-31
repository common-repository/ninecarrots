jQuery(document).ready(function(){
    jQuery("#location_options li").click(function(){
        jQuery("#location_options input[type=radio]").removeAttr("checked");
        jQuery(this).find("input[type=radio]").attr("checked", "1");
    });
    jQuery("#ninecarrots_logo img").mouseover(function(){
        jQuery(this).attr("src", jQuery(this).attr("src").replace(/_grayscale/, ''));
    });
    jQuery("#ninecarrots_logo img").mouseout(function(){
        jQuery(this).attr("src", jQuery(this).attr("src").replace(/ninecarrots\.png/, 'ninecarrots_grayscale.png'));
    });
});