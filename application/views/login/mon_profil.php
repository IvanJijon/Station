<?php $this->load->view('inc/header');?>
    <!--  Jquery UI pour popin draggable -->
    <link href="<?php echo URL_PLUGINS;?>jquery-ui-1.11.4/jquery-ui.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php $this->load->view('inc/nav');?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    	<h3 class="page-header"><i class="fa fa-user fa-fw"></i> <?php echo $this->lang->line('profiluser-profil');?> > <?php echo $this->lang->line('nav-profil');?>
                  			 <div class="pull-right">
                        		<button class="btn btn-success btn-sm mod-edit" data-href="<?php echo base_url();?>main/editer_profil" data-title="<?php echo $this->lang->line('profiluser-edit-title');?>"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('profiluser-edit-title');?></button>
                        	</div>
                       	</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <br />
                
                <div class="row">
	                <div class="col-lg-12">
		                 <?php if($msg=="editok"){?>
                        	 <div class="alert alert-success">
                               	<?php echo $this->lang->line('profiluser-editok');?>
                            </div>
                         <?php }?>
	                    <div class="panel panel-info">
	                        <div class="panel-heading">
	                            <i class="fa fa-users fa-fw"></i> <?php echo $this->lang->line('profiluser-informations');?>              	
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class="panel-body">
	                        	<div class="table-responsive">
                             	 	<table class="table table-hover no-header no-footer">
	                                	<tr class="gradeA odd">
		                                	<td><strong><?php echo $this->lang->line('profiluser-username');?></strong></td>
		                                 	<td><?php echo $_SESSION['session-bihrdy']['infoUser']['USERNAME']; ?></td>
	                                 	</tr> 
                                     	<tr class="gradeA even">
		                                 	<td><strong><?php echo $this->lang->line('profiluser-fullname');?></strong></td>
		                                 	<td><?php echo $_SESSION['session-bihrdy']['infoUser']['FULLNAME']; ?></td>
	                                 	</tr>
	                                  	<tr class="gradeA odd">
		                                 	<td><strong><?php echo $this->lang->line('profiluser-lang');?></strong></td>
		                                	<td><img src="<?php echo URL_IMG?>lang/flag-<?php echo $_SESSION['session-bihrdy']['infoUser']['LANG'];?>.jpg" width="21" height="15"/></td>
	                                 	</tr>
	                                 </table>
	                        	</div>	                        	
	                        </div>
	                        <!-- /.panel-body -->
	                        
	                        <div id="fenetre-edit">
		                                
		                    </div>
	                    </div>
	                    <!-- /.panel -->
	                    
	                    <div class="text-center">
	                    	<button class="btn btn-success btn-sm mod-edit" data-href="<?php echo base_url();?>main/editer_profil" data-title="<?php echo $this->lang->line('profiluser-edit-title');?>"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('profiluser-edit-title');?></button>
	                    </div>
	                </div>
	                <!-- /.col-lg-12 -->
	            </div>
            
            
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	<?php $this->load->view('inc/footer-js');?>

     <!-- Jquery UI -->
    <script src="<?php echo URL_PLUGINS; ?>jquery-ui-1.11.4/jquery-ui.min.js"></script>
	<script>
		$(document).ready(function(){

			var fenetre = $('#fenetre-edit').dialog({
	            autoOpen: false,
	            resizable: true,
	            modal: true,
	            width: 500,
	            draggable:true
	          });

			$(".mod-edit").click(function(){
                var title = $(this).attr('data-title');
    			$.post($(this).attr('data-href'),{},function(retour){
    				$('#fenetre-edit').html(retour);
    				$('#fenetre-edit .fenetre-close').click(function(){
    					fenetre.dialog("close");
    				});
    				fenetre.dialog({title:title});
    				fenetre.dialog("open");
    			})
    			return false;
            });
		});
	</script> 
	

</body>

</html>
