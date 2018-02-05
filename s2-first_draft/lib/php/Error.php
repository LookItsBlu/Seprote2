<?php
function errorMes($errorText="une erreur est survenue !"){
	echo (
		"<div class='ui-widget'>\n".
			"<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>\n".
				"<p>\n".
					"<span class='ui-icon ui-icon-alert' style='margin-right: .3em;'></span>\n".
					"<strong>ERREUR: </strong> ".$errorText."\n".
				"</p>\n".
			"</div>\n".
		"</div>\n"
	);
}
?>
