<?php $this->load->view('inc/header');?>
    <!-- DataTables CSS -->
    <link href="<?php echo URL_PLUGINS;?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo URL_PLUGINS;?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    
    <!--  Jquery UI pour popin draggable -->
    <link href="<?php echo URL_PLUGINS;?>jquery-ui-1.11.4/jquery-ui.min.css" rel="stylesheet">
    
    <!--  Datepicker -->
    <link href="<?php echo URL_PLUGINS;?>bootstrap-datepicker-1.4.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

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
                        <h3 class="page-header"><i class="fa fa-archive fa-fw"></i> <?php echo $this->lang->line('archives-title');?> > <i class="fa fa-list-alt fa-fw"></i> <?php echo $this->lang->line('archives-type-title-liste');?> > <?php echo $this->lang->line('archives-type-title-liste');?>
                        	<div class="pull-right">
                        		<button class="btn btn-success btn-sm mod-edit" data-href="<?php echo base_url();?>archives/editer_type" data-title="<?php echo $this->lang->line('archive-type-title-add');?>"><i class="fa fa-plus-circle"></i> &nbsp;<?php echo $this->lang->line('archive-type-title-add');?></button>
                        	</div>
                        </h3>
                    </div>
                    <!-- /.col-lg-12 -->
                    
                </div>
                <!-- /.row -->
                
                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-list-alt fa-fw"></i> <?php echo $this->lang->line('archives-type-title-liste');?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <?php if($msg=="delok"){?>
                        	 <div class="alert alert-success">
                               	<?php echo $this->lang->line('archive-type-msg-delok');?>
                            </div>
                            <?php }?>
                        
                        	
                            <div class="dataTable_wrapper" style="padding-top:10px;">
                                <table class="table table-striped table-bordered table-hover display" id="dataTables-types">
                                    <thead>
                                        <tr>
                                            <th width="35%"><?php echo $this->lang->line('archives-type-cols0-name');?></th>
                                            <th width="55%"><?php echo $this->lang->line('archives-type-cols1-name');?></th>
                                            <th width="10%"><?php echo $this->lang->line('liste-tools');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    	foreach ($listeArchivesTypes as $archiveType) {
	                                	?>
	                                		<tr class="odd gradeX">
	                                            <td style="white-space: nowrap"><?php echo $archiveType->NAME_TYPE_ARCHIVE ; ?></td>
	                                            <td style="white-space: nowrap"><?php echo $archiveType->DESC_TYPE_ARCHIVE ; ?></td>
	                                            <td style="white-space: nowrap" class="center">
	                                            	<a class="btn btn-warning btn-xs mod-edit" data-href="<?php echo base_url();?>archives/editer_type/<?php echo $archiveType->CODE_TYPE_ARCHIVE ; ?>" data-title="<?php echo $this->lang->line('archive-type-title-edit')." ".$archiveType->NAME_TYPE_ARCHIVE ; ?>"><i class="fa fa-pencil fa-fw"></i></a>
	                                            	<a data-toggle="modal" data-target="#myModal<?php echo $archiveType->CODE_TYPE_ARCHIVE ; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-fw"></i></a>
	                                            	<!-- Modal -->
						                            <div class="modal fade" id="myModal<?php echo $archiveType->CODE_TYPE_ARCHIVE ; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						                                <div class="modal-dialog">
						                                    <div class="modal-content">
						                                        <div class="modal-header">
						                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						                                            <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('archive-type-modal-del-title');?></h4>
						                                        </div>
						                                        <div class="modal-body">
						                                            <?php echo $this->lang->line('archive-type-modal-del-txt');?> <strong><?php echo $archiveType->NAME_TYPE_ARCHIVE ; ?></strong> !
						                                        </div>
						                                        <div class="modal-footer">
						                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
						                                            <a type="button" class="btn btn-danger" href="<?php echo base_url();?>archives/supprimer_type/<?php echo $archiveType->CODE_TYPE_ARCHIVE ; ?>"><i class="fa fa-trash fa-fw"></i> <?php echo $this->lang->line('liste-del');?></a>
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
                                <div class="text-center">
	                        		<button class="btn btn-success btn-sm mod-edit" data-href="<?php echo base_url();?>archives/editer_type" data-title="<?php echo $this->lang->line('archive-type-title-add');?>"><i class="fa fa-plus-circle"></i> &nbsp;<?php echo $this->lang->line('archive-type-title-add');?></button>
	                        	</div>
                                <div id="fenetre-edit">
		                                
		                        </div>
                            </div>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            
            
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
    
     <!-- Datepicker JavaScript -->
    <script src="<?php echo URL_PLUGINS; ?>bootstrap-datepicker-1.4.0/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo URL_PLUGINS; ?>bootstrap-datepicker-1.4.0/locales/bootstrap-datepicker.<?php if($lang=="en"){echo "en-GB";}else{echo $lang;}?>.min.js"></script>
    
     <!-- Jquery UI -->
    <script src="<?php echo URL_PLUGINS; ?>jquery-ui-1.11.4/jquery-ui.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        var table = $('#dataTables-types').DataTable({
                
				responsive: true,
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

        $('dataTables-types').on('draw.dt', function ( e, settings) {
			$(".mod-edit").unbind('click');
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

        $('#btn-menu-cols').click(function(){
            if($('#menu-cols').is(':visible')){
            	$('#menu-cols').hide();
            }else{
				$('#menu-cols').show();
            }
        });

        $(".check-cols").click(function(){
			if($(this).is(':checked')){
				table.column($(this).val()).visible(true);
			}else{
				table.column($(this).val()).visible(false);
			}
        });
    });
    </script>

</body>

</html>
