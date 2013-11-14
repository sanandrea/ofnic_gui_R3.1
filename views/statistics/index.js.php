<script src="webroot/assets/js/jquery.js"></script>
<script src="webroot/assets/js/bootstrap.js"></script>


<script src="webroot/assets/js/arbor.js"></script>
<script src="webroot/assets/js/arbor-tween.js"></script>
<script src="webroot/assets/js/graphics.js"></script>
<script src="webroot/assets/js/jquery.flot.js"></script>
<script src="webroot/assets/js/jstorage.js"></script>
<script src="webroot/assets/js/bootstrap.js"></script>
<script src="webroot/assets/js/bootstrap.min.js"></script>

<script type="text/javascript"  language="javascript">
	$(document).ready(function() {
	setContent(1);
	generateGraph();
	setupNewTaskCollapse();
	});
	function alertMessage(mess,success){
		$('#messageBox').html(mess);
		if (success){
			$('#messageBox').attr('style',"background-color:#5cb85c;font-size: medium;")
		}else{
			$('#messageBox').attr('style',"background-color:#ed9c28;font-size: medium;")
		}	
		$('#messageBox').fadeIn();
		setTimeout(function () { $("#messageBox").fadeOut(); }, 3000);
	}
</script>


<script src="webroot/js/template.js"></script>
<script src="webroot/js/grafo.js"></script>    
<script src="webroot/js/renderer.js"></script>
<script src="webroot/js/routing.js"></script>
<script src="webroot/js/statistics.js"></script>
<script src="webroot/js/grafoStatistics.js"></script>
<script src="webroot/js/panel.js"></script>
<!--
<script src="webroot/assets/js/google-code-prettify/prettify.js"></script>
<script src="webroot/assets/js/bootstrap-transition.js"></script>
<script src="webroot/assets/js/bootstrap-alert.js"></script>
<script src="webroot/assets/js/bootstrap-modal.js"></script>
<script src="webroot/assets/js/bootstrap-dropdown.js"></script>
<script src="webroot/assets/js/bootstrap-scrollspy.js"></script>
<script src="webroot/assets/js/bootstrap-tab.js"></script>
<script src="webroot/assets/js/bootstrap-tooltip.js"></script>
<script src="webroot/assets/js/bootstrap-popover.js"></script>
<script src="webroot/assets/js/bootstrap-button.js"></script>
<script src="webroot/assets/js/bootstrap-collapse.js"></script>
<script src="webroot/assets/js/bootstrap-carousel.js"></script>
<script src="webroot/assets/js/bootstrap-typeahead.js"></script>
<script src="webroot/assets/js/application.js"></script>
-->