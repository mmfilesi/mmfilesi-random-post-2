jQuery(document).ready(function($) {
	jQuery (".post_aleatorios_sumario").css("display", "none");
	
	jQuery ("#post_aleatorios_contenedor").hover(
	
		function () {
		if ($(".post_aleatorios_sumario:first").is(":hidden")) {
		jQuery(".post_aleatorios_sumario").slideDown("slow");
		}
		},
		function () {
		jQuery(".post_aleatorios_sumario").slideUp("slow");
		}
	);	
});	

/* <script>$("body").click(function(event) {
  $("#log").html("clicked: " + event.target.nodeName);
});  </script> */