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
                        <h3 class="page-header"><i class="fa fa-lock fa-fw"></i> <?php echo $this->lang->line('securite-title');?> > <i class="fa fa-tags fa-fw"></i> <?php echo $this->lang->line('profils-title');?> > <?php echo $this->lang->line('profils-title-liste');?>
                        <div class="pull-right">
                        		<button class="btn btn-success btn-sm mod-edit" data-href="<?php echo base_url();?>securite/editer_profil" data-title="<?php echo $this->lang->line('profils-title-add');?>"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('profils-title-add');?></button>
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
                            <i class="fa fa-tags fa-fw"></i> <?php echo $this->lang->line('profils-title-liste');?>
                            <ul class="nav navbar-right">
                        		<li class="dropdown special-dropdown">
				                    <a style="margin-right:17px;padding:0;" href="javascript:;" class="dropdown-toggle" title="<?php echo $this->lang->line('afficher-colonne');?>">
				                        <i class="fa fa-th fa-fw"></i>  <i class="fa fa-caret-down fa-fw"></i>
				                    </a>
				                    <ul class="dropdown-menu">
				                       <li>
	                            			<div class="checkbox" style="padding-left:15px;">
	                            				<label><input class="form-group check-cols" type="checkbox" name="colonnes" checked="checked" value="0"> <?php echo $this->lang->line('profils-cols0-name');?></label>
	                            			</div>
	                            		</li>
	                            		<li>
	                            			<div class="checkbox" style="padding-left:15px;">
	                            				<label><input class="form-group check-cols" type="checkbox" name="colonnes" checked="checked" value="1"> <?php echo $this->lang->line('profils-cols1-name');?></label>
	                            			</div>
	                            		</li>
	                            		<li>
	                            			<div class="checkbox" style="padding-left:15px;">
	                            				<label><input class="form-group check-cols" type="checkbox" name="colonnes" checked="checked" value="2"> <?php echo $this->lang->line('profils-cols2-name');?></label>
	                            			</div>
	                            		</li>
				                    </ul>
				                    <!-- /.dropdown-user -->
				                </li>
                        	</ul>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <?php if($msg=="delok"){?>
                        	 <div class="alert alert-success">
                               	<?php echo $this->lang->line('profils-msg-delok');?>
                            </div>
                            <?php }?>
                        
                        	
                            <div class="dataTable_wrapper" style="padding-top:10px;">
                                <table class="table table-striped table-bordered table-hover display" id="dataTables-profils">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('profils-cols0-name');?></th>
                                            <th><?php echo $this->lang->line('profils-cols1-name');?></th>
                                            <th><?php echo $this->lang->line('profils-cols2-name');?></th>
                                            <th><?php echo $this->lang->line('liste-tools');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
										// Pour chaque ligne de la table
                                    	foreach ($listeProfils as $profil) {
	                                	?>
	                                		<tr class="odd gradeX">
	                                            <td style="white-space: nowrap"><?php echo $profil->NAME_PROFILE ; ?></td>
	                                            <td style="white-space: nowrap"><?php echo $profil->DESC_PROFILE ; ?></td>
	                                            <td style="white-space: nowrap"><?php echo $profil->COLUMN_PROFILE ; ?></td>
	                                            <td style="white-space: nowrap" class="center">
	                                            	<a class="btn btn-warning btn-xs mod-edit" data-href="<?php echo base_url();?>securite/editer_profil/<?php echo $profil->CODE_PROFILE ; ?>" data-title="<?php echo $this->lang->line('profils-title-edit')." ".$profil->NAME_PROFILE ; ?>"><i class="fa fa-pencil fa-fw"></i></a>
	                                            	<a data-toggle="modal" data-target="#myModal<?php echo $profil->CODE_PROFILE ; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-fw"></i></a>
	                                            	<!-- Modal -->
						                            <div class="modal fade" id="myModal<?php echo $profil->CODE_PROFILE ; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						                                <div class="modal-dialog">
						                                    <div class="modal-content">
						                                        <div class="modal-header">
						                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						                                            <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('profils-modal-del-title');?></h4>
						                                        </div>
						                                        <div class="modal-body">
						                                            <?php echo $this->lang->line('profils-modal-del-txt');?> <strong><?php echo $profil->NAME_PROFILE ; ?></strong> !
						                                        </div>
						                                        <div class="modal-footer">
						                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
						                                            <a type="button" class="btn btn-danger" href="<?php echo base_url();?>securite/supprimer_profil/<?php echo $profil->CODE_PROFILE ; ?>"><i class="fa fa-trash fa-fw"></i> <?php echo $this->lang->line('liste-del');?></a>
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
                                    </tbody>
                                </table>
                                <div id="fenetre-edit">
		                                
		                        </div>
                            </div>
                            <!-- /.table-responsive -->
                            <div class="text-center">
                        		<button class="btn btn-success btn-sm mod-edit" data-href="<?php echo base_url();?>securite/editer_profil" data-title="<?php echo $this->lang->line('profils-title-add');?>"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('profils-title-add');?></button>
                        	</div>
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
    
     <!-- Jquery UI -->
    <script src="<?php echo URL_PLUGINS; ?>jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        var table = $('#dataTables-profils').DataTable({
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

        table.columns([0,1,2]).visible( true, true );
        table.columns.adjust().draw( false );
			
		$('#dataTables-profils').on('draw.dt', function ( e, settings) {
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
    
      /* Script pour empecher de fermer le dropdown menu apres un choix cliqué (Colonnes). */
    $('li.dropdown.special-dropdown a').on('click', function (event) {
    	$(this).parent().toggleClass("open");
	});
	
	$('body').on('click', function (e) {
    	if (!$('li.dropdown.special-dropdown').is(e.target) && $('li.dropdown.special-dropdown').has(e.target).length === 0 && $('.open').has(e.target).length === 0) {
        	$('li.dropdown.special-dropdown').removeClass('open');
    	}
	});
    </script>
</body>
</html>
