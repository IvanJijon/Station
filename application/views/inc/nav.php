		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div style="position:relative;top:8px; left:45px;" id="logo-birdy">
                	<a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo URL_IMG?>logo-bihrdy.png" width="102" height="45"/></a>
                </div>
            </div>
            <!-- /.navbar-header -->

            <?php $this->load->view('inc/nav-header');?>
            <!-- /.navbar-top-links -->

            <?php $this->load->view('inc/nav-menu');?>
            <!-- /.navbar-static-side -->
        </nav>