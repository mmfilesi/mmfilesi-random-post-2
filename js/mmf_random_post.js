jQuery(document).ready(function($) {
	jQuery (".fila_aleatorios", this).hover(	
			function () {
				var id_a_mostrar = jQuery(this).attr("id");
			if (jQuery("#"+id_a_mostrar+"_op").is(":hidden")) {
				jQuery("#"+id_a_mostrar+"_op").slideDown("slow");
				}
				},
				function () {
				var id_a_mostrar = jQuery(this).attr("id");
				jQuery("#"+id_a_mostrar+"_op").slideUp("slow");
				}
	);
});	