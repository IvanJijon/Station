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
                        <h3 class="page-header"><i class="fa fa-list fa-fw"></i> <?php echo $this->lang->line('referentiels-title');?> > <i class="fa fa-users fa-fw"></i> <?php echo $this->lang->line('regroupements-title');?> > <?php echo $this->lang->line('liste-regroupements-title');?>
                        	<div class="pull-right">
                        		<button class="btn btn-success btn-sm mod-edit" data-href="<?php echo base_url();?>referentiels/editer_regroupement" data-title="<?php echo $this->lang->line('regroupement-title-add');?>"><i class="fa fa-plus-circle"></i> &nbsp;<?php echo $this->lang->line('regroupement-title-add');?></button>
                        	</div>
                        </h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <?php 
                	// On cherche la liste des champs où il y'a toujours des donnees dedans afin d'éviter d'avoir une colonne vide
              	  //$listeChampsActif = getColumnActive($listeRegroupements);
              	  // On liste les champs à supprimer pour les avoir dans l'ordre que l'on veut ou pour simplement ne pas les afficher
              	  //$listeChampsManuel = array('NAME_EXTENSION','DESC_EXTENSION','CODE_DOMAIN');
              	  // On les supprimes des champs actif pour pouvoir les définir en début de tableau
              	 // foreach($listeChampsManuel as $champs){
              	  	 //unset($listeChampsActif[$champs]);
              	  //}
              	  // On liste les champs que l'on veut voir en début de tableau
              	// $listeChampsPrincipaux = array('NAME_EXTENSION','DESC_EXTENSION','NAME_DOMAIN');
              	 // On fusionne les deux tableaux de champs.
              	// $listeChampsAfficheDefault = array_merge($listeChampsPrincipaux,$listeChampsActif);
              	 $listeChampsAfficheDefault = array('NAME_EXTENSION','DESC_EXTENSION','NAME_DOMAIN');
              	 // On liste les champs que l'ont veut afficher sur le tableau (caché ou non)
                	$listeChampsAffiche = array('NAME_EXTENSION','DESC_EXTENSION','NAME_DOMAIN',
                	'CODE_SRC_ATTR_01','CODE_SRC_ATTR_02','CODE_SRC_ATTR_03','CODE_SRC_ATTR_04','CODE_SRC_ATTR_05',
                	'CODE_SRC_ATTR_06','CODE_SRC_ATTR_07','CODE_SRC_ATTR_08','CODE_SRC_ATTR_09','CODE_SRC_ATTR_10',
                	'CODE_SRC_ATTR_11','CODE_SRC_ATTR_12','CODE_SRC_ATTR_13','CODE_SRC_ATTR_14','CODE_SRC_ATTR_15',
                	'CODE_SRC_ATTR_16','CODE_SRC_ATTR_17','CODE_SRC_ATTR_18','CODE_SRC_ATTR_19','CODE_SRC_ATTR_20',
                	'CODE_EXT_ATTR_01','CODE_EXT_ATTR_02','CODE_EXT_ATTR_03','CODE_EXT_ATTR_04','CODE_EXT_ATTR_05',
                	'CODE_EXT_ATTR_06','CODE_EXT_ATTR_07','CODE_EXT_ATTR_08','CODE_EXT_ATTR_09','CODE_EXT_ATTR_10',
                	'CODE_EXT_ATTR_11','CODE_EXT_ATTR_12','CODE_EXT_ATTR_13','CODE_EXT_ATTR_14','CODE_EXT_ATTR_15',
                	'CODE_EXT_ATTR_16','CODE_EXT_ATTR_17','CODE_EXT_ATTR_18','CODE_EXT_ATTR_19','CODE_EXT_ATTR_20');
                	$nbCol = 0;
                ?>
                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users fa-fw"></i> <?php echo $this->lang->line('liste-regroupements-title');?>
                        	<ul class="nav navbar-right">
                        		<li class="dropdown special-dropdown">
				                    <a class="dropdown-toggle" style="margin-right:17px;padding:0;" href="javascript:;" title="<?php echo $this->lang->line('afficher-colonne');?>">
				                        <i class="fa fa-th fa-fw"></i>  <i class="fa fa-caret-down fa-fw"></i>
				                    </a>
				                    <ul class="dropdown-menu" id="liste-champs-dropdown" style="width:600px;max-height:200px;overflow-x:hidden;">
				                    	<?php $i=0;
				                    	foreach($listeChampsAffiche as $champs){											
											?>											
				                    		<li>
		                            			<div class="checkbox" style="padding-left:15px;">
		                            				<label><input class="form-group check-cols" type="checkbox" name="colonnes" <?php if(in_array($champs,$listeChampsAfficheDefault)){?>checked="checked"<?php }?> id="champs-<?php echo $i;?>" value="<?php echo $i;?>"> <?php echo $this->lang->line('regroupement-'.$champs);?></label>
		                            			</div>
		                            		</li>
				                    	<?php 											
										$i++;}?>
				                    </ul>
				                    <!-- /.dropdown-user -->
				                </li>
                        	</ul>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <?php if($msg=="delok"){?>
                        	 <div class="alert alert-success">
                               	<?php echo $this->lang->line('regroupement-msg-delok');?>
                            </div>
                            <?php }?>
                            <div class="dataTable_wrapper" style="padding-top:10px;">
                                <table class="table table-striped table-bordered table-hover display" id="dataTables-regroupements" style="width: 100%;">
                                    <thead>
                                        <tr>
                                        	<?php foreach($listeChampsAffiche as $champs){?>
                                        	<th><?php echo $this->lang->line('regroupement-'.$champs);?></th>
                                        	<?php }?>
                                            <th><?php echo $this->lang->line('liste-tools');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    	foreach ($listeRegroupements as $regroupement) {
	                                	?>
	                                		<tr class="odd gradeX">
	                                			<?php foreach($listeChampsAffiche as $champs){?>
												<td style="white-space: nowrap"><?php 
												// On fait une exception pour les champs de type sources ou cuble afin d'afficher l'attribut qui lui correspond
												if(substr_count($champs,'CODE_SRC_ATTR')==1 || substr_count($champs,'CODE_EXT_ATTR')===1){
													echo $listeAttributes[$regroupement->$champs]->NAME_ATTRIBUTE;
												}else{echo $regroupement->$champs ;}?>
												</td>
	                                			<?php }?>
	                                            <td  style="white-space: nowrap" class="center">
	                                           		<a class="btn btn-info btn-xs" href="<?php echo base_url();?>referentiels/fiche_regroupement/<?php echo $regroupement->CODE_EXTENSION ; ?>" title="<?php echo $this->lang->line('regroupement-title-fiche')." ".$regroupement->NAME_EXTENSION ; ?>"><i class="fa fa-cog fa-fw"></i> </a>
	                                            	<a class="btn btn-warning btn-xs mod-edit" data-href="<?php echo base_url();?>referentiels/editer_regroupement/<?php echo $regroupement->CODE_EXTENSION ; ?>" data-title="<?php echo $this->lang->line('regroupement-title-edit')." ".$regroupement->NAME_EXTENSION ; ?>"><i class="fa fa-pencil fa-fw"></i> </a>
	                                            	<a data-toggle="modal" data-target="#myModal<?php echo $regroupement->CODE_EXTENSION ; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-fw"></i> </a>
	                                            	<!-- Modal -->
						                            <div class="modal fade" id="myModal<?php echo $regroupement->CODE_EXTENSION ; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						                                <div class="modal-dialog">
						                                    <div class="modal-content">
						                                        <div class="modal-header">
						                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						                                            <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('regroupement-modal-del-title');?></h4>
						                                        </div>
						                                        <div class="modal-body">
						                                            <?php echo $this->lang->line('regroupement-modal-del-txt');?> <strong><?php echo $user->NAME_EXTENSION ; ?></strong> !
						                                        </div>
						                                        <div class="modal-footer">
						                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
						                                            <a type="button" class="btn btn-danger" href="<?php echo base_url();?>referentiels/liste_regroupements/supprimer_regroupement/<?php echo $regroupement->CODE_EXTENSION ; ?>"><i class="fa fa-trash fa-fw"></i> <?php echo $this->lang->line('liste-del');?></a>
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
                        		<button class="btn btn-success btn-sm mod-edit" data-href="<?php echo base_url();?>referentiels/editer_regroupement" data-title="<?php echo $this->lang->line('regroupement-title-add');?>"><i class="fa fa-plus-circle"></i> &nbsp;<?php echo $this->lang->line('regroupement-title-add');?></button>
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
    var table ="";
    $(document).ready(function() {
		table = $('#dataTables-regroupements').DataTable({
			"scrollX": false,
			"sScrollX": "100%",
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
			"autoWidth": true
        });		
		<?php 
		//Liste colonnes non affiché
		$colVisibleFalse = "";
		//Liste colonnes affiché
		$colVisibleTrue = "";
		$i=0;
		foreach($listeChampsAffiche as $champs){
			if(!in_array($champs,$listeChampsAfficheDefault)){
				if($colVisibleFalse!=""){$colVisibleFalse.=",";}
				$colVisibleFalse.=$i;
			}else{
				if($colVisibleTrue!=""){$colVisibleTrue.=",";}
				$colVisibleTrue.=$i;
			}
		 $i++;
		}?>
        table.columns([<?php echo $colVisibleFalse;?>]).visible( false, false );
        table.columns([<?php echo $colVisibleTrue?>]).visible( true, true );
		table.columns.adjust().draw( true );
		table.columns.adjust();
		table.draw( true );
        $('#dataTables-regroupements').on('draw.dt', function ( e, settings) {
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
            width: 900,
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
				$('#dataTables-regroupements').DataTable().column($(this).val()).visible(true);
			}else{
				$('#dataTables-regroupements').DataTable().column($(this).val()).visible(false);
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