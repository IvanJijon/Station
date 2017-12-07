<?php $this->load->view('inc/header');?>
    <!-- DataTables CSS -->
    <link href="<?php echo URL_PLUGINS;?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo URL_PLUGINS;?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    
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
                        <h3 class="page-header"><i class="fa fa-lock fa-fw"></i> <?php echo $this->lang->line('securite-title');?> > <i class="fa fa-unlock fa-fw"></i> <?php echo $this->lang->line('securite-title-permissions');?></h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            <?php
           foreach($listeModules as $module){
           if(count($module->sous_modules)>0){?>
            	<div class="row">
               		<div class="col-lg-12">
	                    <div class="panel panel-info">
	                        <div class="panel-heading">
	                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $module->ITEM_ID;?>" aria-expanded="false" class=""><i class="fa fa-<?php echo $this->lang->line('fa-permissions-module-'.$module->CONF);?> fa-fw"></i> <?php echo $module->ITEM_NAME;?> <i class="fa fa-caret-down fa-fw"></i> </a>
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div id="collapse<?php echo $module->ITEM_ID;?>" class="panel-collapse collapse<?php if($module->ITEM_ID==$ITEM_ID){echo " in";}?>">
		                        <div class="panel-body">
		                        	<?php foreach($module->sous_modules as $mod){?>
		                        	<div class="col-lg-4">
					                    <div class="panel panel-default">
					                        <div class="panel-heading">
					                            <i class="fa fa-<?php echo $this->lang->line('fa-permissions-module-'.$mod->CONF);?> fa-fw"></i> <?php echo $this->lang->line('securite-permissions-module');?> : <?php echo $mod->ITEM_NAME;?> 
					                        </div>
					                        <div class="panel-body">
					                        	<div class="table-responsive">
					                                <table class="table table-striped table-bordered table-hover dataTable">
					                                    <thead>
					                                        <tr>
					                                        	<th width="90%"><?php echo $this->lang->line('menu-securite-profils');?></th>
					                                        	<th width="10%"><?php echo $this->lang->line('liste-tools');?></th>
					                                        </tr>
					                                    </thead>
					                                    <tbody>
					                                    	<?php foreach($listeProfilsColumn as $col=>$profil){
					                                    	if($mod->$col==1){?>
					                                        <tr>
					                                            <td><?php echo $profil->NAME_PROFILE;?></td>
					                                            <td>
					                                            	<a data-toggle="modal" data-target="#myModal-supprimer-<?php echo $mod->ITEM_ID; ?>-<?php echo $profil->CODE_PROFILE;?>" style="margin-left: 3px;"><i class="btn btn-danger btn-sm fa fa-trash-o"></i></a>
															
					                                            	<div class="modal fade" id="myModal-supprimer-<?php echo $mod->ITEM_ID; ?>-<?php echo $profil->CODE_PROFILE;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							                                            <div class="modal-dialog" style="text-align: left;">
							                                                <div class="modal-content">
							                                                    <div class="modal-header">
							                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							                                                        <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('modal-confirmer-suppression');?></h4>
							                                                    </div>
							                                                    <div class="modal-body">
							                                                        <?php echo $this->lang->line('securite-permission-delete-txt1');?><br/> <strong><?php echo $profil->NAME_PROFILE;?></strong> <?php echo $this->lang->line('securite-permission-delete-txt2');?> : <strong><?php echo $mod->ITEM_NAME; ?></strong> ?
							                                                    </div>
							                                                    <div class="modal-footer"> 
							                                                        <a class="btn btn-primary" href="<?php echo base_url();?>securite/gestion_permissions/supprimer_permission/<?php echo $mod->ITEM_ID;?>/<?php echo $profil->CODE_PROFILE;?>"><?php echo $this->lang->line('liste-valide');?></a>
							                                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('modal-annuler');?></button>
							                                                    </div>
							                                                </div>
							                                            </div>
							                                        </div>	
					                                            </td>
					                                        </tr>
					                                        <?php }
					                                    	}?>
					                                    </tbody>
					                                </table>
					                                <form action="<?php echo base_url();?>securite/gestion_permissions" method="post" class="form-inline">
					                                	<input type="hidden" name="ITEM_ID" value="<?php echo $mod->ITEM_ID;?>"/>
					                                	<select name="CODE_PROFILE" class="form-control">
					                                		<?php foreach($listeProfilsColumn as $col=>$profil){
					                                			if($mod->$col==0){?>
					                                			<option value="<?php echo $profil->CODE_PROFILE;?>"><?php echo $profil->NAME_PROFILE;?></option>
					                                		<?php }
					                                		}?>
					                                	</select>
					                                	 <button type="submit" class="btn btn-success"> <i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('liste-add');?></button>
					                                </form>
					                            </div>
					                        </div>
					                        <!-- /.panel-body -->
					                    </div>
					                    <!-- /.panel -->
					                </div>
		                        <?php }?>
		                        </div>
	                        </div>
	                    </div>
	                    <!-- /.panel -->
	                </div>
	                <!-- /.col-lg-12 -->
	            </div>
            <?php }
           }?>
            
            
            
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	 <?php $this->load->view('inc/footer-js');?>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
   

</body>

</html>
