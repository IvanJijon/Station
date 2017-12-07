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
                        <h3 class="page-header"><i class="fa fa-cogs fa-fw"></i> <?php echo $this->lang->line('menu-configuration');?> > <i class="fa fa-sitemap fa-fw"></i> <?php echo $this->lang->line('modules-title');?> > <?php echo $this->lang->line('modules-title-liste-modules');?>
                        	<div class="pull-right">
                        		<button class="btn btn-success btn-sm mod-edit text-right" data-href="<?php echo base_url();?>configuration/editer_module" data-title="<?php echo $this->lang->line('modules-title-add');?>"><i class="fa fa-plus-circle"></i> &nbsp;<?php echo $this->lang->line('modules-title-add');?></button>
							</div>
						</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            
           <?php
           foreach($listeModules as $module){
           if(count($module->sous_modules)>=0){?>
            	<div class="row">
               		<div class="col-lg-12">
	                    <div class="panel panel-info">
	                        <div class="panel-heading">
	                            <i class="fa <?php echo $module->ITEM_ICON;?> fa-fw"></i> <?php echo $module->ITEM_NAME;?>
	                            <div class="pull-right">
	                            	<a class="btn btn-warning btn-xs mod-edit" data-href="<?php echo base_url();?>configuration/editer_module/<?php echo $module->ITEM_ID ; ?>" data-title="<?php echo $this->lang->line('modules-title-edit')." ".$module->ITEN_NAME ; ?>"><i class="fa fa-pencil fa-fw"></i></a>
									<a data-toggle="modal" data-target="#myModal<?php echo $module->ITEM_ID ; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-fw"></i></a>
									<!-- Modal -->
									<div class="modal fade" id="myModal<?php echo $module->ITEM_ID ; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									    <div class="modal-dialog">
									        <div class="modal-content">
									            <div class="modal-header">
									                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('modules-modal-del-title');?></h4>
									            </div>
									            <div class="modal-body">
									                <?php echo $this->lang->line('modules-modal-del-txt');?> <strong><?php echo $module->ITEM_NAME ; ?></strong> !
									            </div>
									            <div class="modal-footer">
									                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
									                <a type="button" class="btn btn-danger" href="<?php echo base_url();?>configuration/supprimer_module/<?php echo $module->ITEM_ID ; ?>"><i class="fa fa-trash fa-fw"></i> <?php echo $this->lang->line('liste-del');?></a>
									            </div>
									        </div>
									        <!-- /.modal-content -->
									    </div>
									    <!-- /.modal-dialog -->
									</div>
									<!-- /.modal -->
                            	</div>
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class="panel-body">
	                        	<table class="table table-striped table-bordered table-hover display" id="dataTables-example_<?php echo $module->ITEM_ID?>">
                                    <thead>
                                        <tr>
                                            <th width="18%"><?php echo $this->lang->line('modules-cols0-name');?></th>
                                            <th width="5%"><?php echo $this->lang->line('modules-cols1-name');?></th>
                                            <th width="15%"><?php echo $this->lang->line('modules-cols2-name');?></th>
                                            <th width="15%"><?php echo $this->lang->line('modules-cols3-name');?></th>
                                            <th width="8%"><?php echo $this->lang->line('modules-cols4-name');?></th>
                                            <th width="7%"><?php echo $this->lang->line('modules-cols5-name');?></th>
                                            <th width="7%"><?php echo $this->lang->line('modules-cols6-name');?></th>
                                            <th width="7%"><?php echo $this->lang->line('modules-cols7-name');?></th>
                                            <th width="8%"><?php echo $this->lang->line('modules-cols8-name');?></th>
                                            <th width="10%"><?php echo $this->lang->line('liste-tools');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php foreach($module->sous_modules as $mod){
                                    	//echo "<pre style='position:relative;width:100%;border:1px solid #ff0000;padding:10px;color:#ff0000;font-family:arial;z-index:1000;'>";	var_dump($mod);	echo "</pre>";
                                    	?>
                                    	
	                                		<tr class="odd gradeX">
	                                            <td style="white-space: nowrap"><i class="fa <?php echo $mod->ITEM_ICON ;?> fa-fw"></i> <?php echo $mod->ITEM_NAME ; ?></td>
	                                            <td style="white-space: nowrap" align="center" style="vertical-align:middle"><?php echo $mod->ITEM_ORDER ; ?></td>
	                                            <td style="white-space: nowrap" style="vertical-align:middle"><?php echo $module->ITEM_NAME ; ?></td>
	                                            <td style="white-space: nowrap" style="vertical-align:middle"><?php echo $mod->CONF ; ?></td>
	                                            <td style="white-space: nowrap" align="center" style="vertical-align:middle"><?php echo ($mod->PROFILE01 == 1) ? "<i class=\"fa fa fa-circle fa-fw\"></i>" : "<i class=\"fa fa fa-circle-o fa-fw\"></i>"; ?></td>
	                                            <td style="white-space: nowrap" align="center" style="vertical-align:middle"><?php echo ($mod->PROFILE02 == 1) ? "<i class=\"fa fa fa-circle fa-fw\"></i>" : "<i class=\"fa fa fa-circle-o fa-fw\"></i>"; ?></td>
	                                            <td style="white-space: nowrap" align="center" style="vertical-align:middle"><?php echo ($mod->PROFILE03 == 1) ? "<i class=\"fa fa fa-circle fa-fw\"></i>" : "<i class=\"fa fa fa-circle-o fa-fw\"></i>"; ?></td>
	                                            <td style="white-space: nowrap" align="center" style="vertical-align:middle"><?php echo ($mod->PROFILE04 == 1) ? "<i class=\"fa fa fa-circle fa-fw\"></i>" : "<i class=\"fa fa fa-circle-o fa-fw\"></i>"; ?></td>
	                                            <td style="white-space: nowrap" align="center" style="vertical-align:middle"><?php echo ($mod->PROFILE05 == 1) ? "<i class=\"fa fa fa-circle fa-fw\"></i>" : "<i class=\"fa fa fa-circle-o fa-fw\"></i>"; ?></td>
	                                            <td style="white-space: nowrap" class="center" style="vertical-align:middle">
	                                            	<a class="btn btn-warning btn-xs mod-edit" data-href="<?php echo base_url();?>configuration/editer_module/<?php echo $mod->ITEM_ID ; ?>" data-title="<?php echo $this->lang->line('modules-title-edit')." ".$mod->ITEN_NAME ; ?>"><i class="fa fa-pencil fa-fw"></i></a>
	                                            	<a data-toggle="modal" data-target="#myModal<?php echo $mod->ITEM_ID ; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-fw"></i></a>
	                                            	<!-- Modal -->
						                            <div class="modal fade" id="myModal<?php echo $mod->ITEM_ID ; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						                                <div class="modal-dialog">
						                                    <div class="modal-content">
						                                        <div class="modal-header">
						                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						                                            <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('modules-modal-del-title');?></h4>
						                                        </div>
						                                        <div class="modal-body">
						                                            <?php echo $this->lang->line('modules-modal-del-txt');?> <strong><?php echo $mod->ITEM_NAME ; ?></strong> !
						                                        </div>
						                                        <div class="modal-footer">
						                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
						                                            <a type="button" class="btn btn-danger" href="<?php echo base_url();?>configuration/supprimer_module/<?php echo $mod->ITEM_ID ; ?>"><i class="fa fa-trash fa-fw"></i> <?php echo $this->lang->line('liste-del');?></a>
						                                        </div>
						                                    </div>
						                                    <!-- /.modal-content -->
						                                </div>
						                                <!-- /.modal-dialog -->
						                            </div>
						                            <!-- /.modal -->
	                                            </td>
	                                        </tr>
	                                	<?php
	                                	}
	                                	?>
                                        </tr>
                                    </tbody>
                                </table>
                                
	                        </div>
	                        <!-- /.panel-body -->
	                    </div>
	                    <!-- /.panel -->
	                </div>
	                <!-- /.col-lg-12 -->
	            </div>
            <?php }
           }?>
           <div class="text-center">
           		<button class="btn btn-success btn-sm mod-edit text-right" data-href="<?php echo base_url();?>configuration/editer_module" data-title="<?php echo $this->lang->line('modules-title-add');?>"><i class="fa fa-plus-circle"></i> &nbsp;<?php echo $this->lang->line('modules-title-add');?></button>
           </div>
			<div id="fenetre-edit">
		                                
			</div>
            
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
	 <?php $this->load->view('inc/footer-js');?>
	   
    <!-- DataTables JavaScript -->
    <script src="<?php echo URL_PLUGINS; ?>datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo URL_PLUGINS; ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    
     <!-- Jquery UI -->
    <script src="<?php echo URL_PLUGINS; ?>jquery-ui-1.11.4/jquery-ui.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

    
    $(document).ready(function() {
    	<?php foreach($listeModules as $module){?>
        var table_<?php echo $module->ITEM_ID ; ?> = $('#dataTables-example_<?php echo $module->ITEM_ID;?>').DataTable({
                "responsive": true,
                "scrollX": true,
                "paging":   false,
        		"info":     false ,
        		"bFilter":     false ,
        		"bPaginate":     false ,
                "language": {
									"sProcessing":     "<?php echo $this->lang->line('datatable-process');?>",
									"sSearch":         "<?php echo $this->lang->line('datatable-search');?>",
								    "sLengthMenu":     "<?php echo $this->lang->line('datatable-lengthMenu');?>",
									"sInfo":           "<?php echo $this->lang->line('datatable-info');?>",
									"sInfoEmpty":      "<?php echo $this->lang->line('datatable-infoEmpty');?>",
									"sInfoFiltered":   "<?php echo $this->lang->line('datatable-filtre');?>",
									"sInfoPostFix":    "",
									"sLoadingRecords": "<?php echo $this->lang->line('datatable-loading');?>",
								    "sZeroRecords":    "<?php echo $this->lang->line('datatable-empty');?>",
									"sEmptyTable":     "<?php echo $this->lang->line('datatable-emptyTable');?>",
									"oPaginate": {
										"sFirst":      "<?php echo $this->lang->line('datatable-first');?>",
										"sPrevious":   "<?php echo $this->lang->line('datatable-previous');?>",
										"sNext":       "<?php echo $this->lang->line('datatable-next');?>",
										"sLast":       "<?php echo $this->lang->line('datatable-lfas');?>"
									},
									"oAria": {
										"sSortAscending":  "<?php echo $this->lang->line('datatable-asc');?>",
										"sSortDescending": "<?php echo $this->lang->line('datatable-desc');?>"
									} 
								},
			"bStateSave": true,
			"autoWidth": false
        });
		
		table_<?php echo $module->ITEM_ID ; ?>.columns.adjust().draw( false );
        <?php }?>

        var fenetre = $('#fenetre-edit').dialog({
            autoOpen: false,
            resizable: true,
            modal: true,
            width: 700,
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

        <?php foreach($listeModules as $module){?>
        $('#btn-menu-cols-<?php echo $module->ITEM_ID?>').click(function(){
            if($('#menu-cols-<?php echo $module->ITEM_ID?>').is(':visible')){
            	$('#menu-cols-<?php echo $module->ITEM_ID?>').hide();
            }else{
				$('#menu-cols-<?php echo $module->ITEM_ID?>').show();
            }
        });
		
        $(".check-cols-<?php echo $module->ITEM_ID?>").click(function(){
			if($(this).is(':checked')){
				table_<?php echo $module->ITEM_ID?>.column($(this).val()).visible(true);
			}else{
				table_<?php echo $module->ITEM_ID?>.column($(this).val()).visible(false);
			}
        });
        <?php }?>
    });
    </script>
</body>
</html>