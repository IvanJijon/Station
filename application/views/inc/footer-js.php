  	<!-- jQuery -->
    <script src="<?php echo URL_PLUGINS;?>jquery/dist/jquery.min.js"></script>	

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo URL_PLUGINS;?>bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo URL_PLUGINS;?>metisMenu/dist/metisMenu.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo URL_ASSETS;?>js/sb-admin-2.js"></script>
    
    <!-- Custom JavaScript Side bar-->
    <script src="<?php echo URL_ASSETS;?>js/show_hide_menu.js"></script>
    
    <!-- Custom JavaScript for fullscreen-->
    <script src="<?php echo URL_PLUGINS;?>jquery-fullscreen/jquery.fullscreen-min.js"></script>
	
	
    
    <!-- Custom JavaScript for tooltip-->
    <?php 
    if (TOOLTIP == "1") {
    ?>
	    <script>
	    	 $(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			})
	    </script>
    <?php
    }
    ?>
    
   
    