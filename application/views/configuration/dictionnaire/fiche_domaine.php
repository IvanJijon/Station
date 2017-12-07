<?php $this->load->view('inc/header');?>    <!-- DataTables CSS -->    <link href="<?php echo URL_PLUGINS;?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">    <!-- DataTables Responsive CSS -->    <link href="<?php echo URL_PLUGINS;?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">    <!--  Jquery UI pour popin draggable + Selection sortable -->    <link href="<?php echo URL_PLUGINS;?>jquery-ui-1.11.4/jquery-ui.min.css" rel="stylesheet">    <!-- File upload -->    <link href="<?php echo URL_PLUGINS;?>bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet">    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->    <!--[if lt IE 9]>        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>    <![endif]--></head><body>    <div id="wrapper">        <!-- Navigation -->        <?php $this->load->view('inc/nav');?>        <!-- Page Content -->        <div id="page-wrapper">            <div class="container-fluid">                <div class="row">                    <div class="col-lg-12">                        <h3 class="page-header"><i class="fa fa-cogs fa-fw"></i> <?php echo $this->lang->line('configuration-title');?> > <i class="fa fa-book fa-fw"></i> <?php echo $this->lang->line('dictionnaire-title');?> > <?php echo $infoDomaine->NAME_DOMAIN;?></h3>                    	<a class="btn btn-info" href="<?php echo base_url();?>configuration/liste_dictionnaire"><i class="fa fa-list fa-fw"></i> <?php echo $this->lang->line('retour-liste');?></a>					                    </div>                    <!-- /.col-lg-12 -->                </div>                <br />                <div class="row">	                <div class="col-lg-12">	                	<?php if($msg!=""){               				if($msg=="delok"){?>								<div class="alert alert-success">									<?php echo $this->lang->line('alert-attribut-delete');?>								</div>						<?php }elseif($msg=="importok"){?>                        	 <div class="alert alert-success">                               	<?php echo $this->lang->line('domain-importok');?>                            </div>                         <?php }elseif($msg=="importkoCols"){?>                        	 <div class="alert alert-danger">                               	<?php echo $this->lang->line('domain-importkoCols');?>                            </div>                         <?php }	                	}                		?>	                    <div class="panel panel-info">	                        <div class="panel-heading">	                        	<a data-toggle="collapse" data-parent="#accordion" href="#collapse-info" aria-expanded="false" class=""> <i class="fa fa-refresh fa-fw"></i> <?php echo $this->lang->line('domain-informations');?> <i class="fa fa-caret-down fa-fw"></i> </a>                  		                        	<div class="pull-right">									<a class="btn btn-warning btn-xs mod-edit" data-href="<?php echo base_url();?>configuration/editer_domaine/<?php echo $infoDomaine->CODE_DOMAIN ; ?>" data-title="<?php echo $this->lang->line('domain-title-edit')." ".$infoDomaine->NAME_DOMAIN ; ?>"><i class="fa fa-pencil fa-fw"></i></a>									<a data-toggle="modal" data-target="#myModal<?php echo $infoDomaine->CODE_DOMAIN;?>" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-fw"></i></a>									<!-- Modal -->									<div class="modal fade" id="myModal<?php echo $infoDomaine->CODE_DOMAIN;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">									    <div class="modal-dialog">									        <div class="modal-content">									            <div class="modal-header">									                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>									                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('domain-modal-del-title');?></h4>									            </div>									            <div class="modal-body">									                <?php echo $this->lang->line('domain-modal-del-txt');?> <strong><?php echo $infoDomaine->NAME_DOMAIN ; ?></strong> !									            </div>									            <div class="modal-footer">									                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>									                <a type="button" class="btn btn-danger" href="<?php echo base_url();?>configuration/liste_dictionnaire/supprimer_domaine/<?php echo $infoDomaine->CODE_DOMAIN ; ?>"><i class="fa fa-trash fa-fw"></i> <?php echo $this->lang->line('liste-del');?></a>									            </div>									        </div>									        <!-- /.modal-content -->									    </div>									    <!-- /.modal-dialog -->									</div>									<!-- /.modal -->								</div>	                        </div>	                        <!-- /.panel-heading -->	                        <div id="collapse-info" class="panel-collapse collapse">		                        <div class="panel-body">		                        	<div class="table-responsive">	                             	 	<table class="table table-hover no-header no-footer">		                                	<tr class="gradeA odd">			                                	<td><strong><?php echo $this->lang->line('dictionnaire-name');?></strong></td>			                                 	<td><?php echo $infoDomaine->NAME_DICTIONARY; ?></td>		                                 	</tr> 	                                     	<tr class="gradeA even">			                                 	<td><strong><?php echo $this->lang->line('domain-name');?></strong></td>			                                 	<td><?php echo $infoDomaine->NAME_DOMAIN; ?></td>		                                 	</tr>		                                  	<tr class="gradeA odd">			                                 	<td><strong><?php echo $this->lang->line('domain-description');?></strong></td>			                                	<td><?php echo $infoDomaine->DESC_DOMAIN; ?></td>		                                 	</tr>		                                 	<tr class="gradeA even">			                                 	<td><strong><?php echo $this->lang->line('domain-table');?></strong></td>			                                	<td><?php echo $infoDomaine->TABLE_NAME; ?></td>		                                 	</tr>											<tr class="gradeA odd">			                                 	<td><strong><?php echo $this->lang->line('domain-struct-orga');?></strong></td>			                                	<td style="vertical-align:middle"><?php echo ($infoDomaine->FLG_ORG == 1) ? "<i class=\"fa fa fa-circle fa-fw\"></i>" : "<i class=\"fa fa fa-circle-o fa-fw\"></i>"; ?></td>		                                 	</tr>													                                 </table>		                        	</div>	                        			                        </div>		                        <!-- /.panel-body -->	                        </div>.	                        <!-- /.collapse -->	                    </div>	                    <!-- /.panel -->	                </div>	                <!-- /.col-lg-12 -->	            </div>           		<!-- /.row -->	         	<div class="row" id="param">	                <div class="col-lg-12">	                    <div class="panel panel-info">	                        <div class="panel-heading clearfix">	                           <i class="fa fa-sliders"></i> <?php echo $this->lang->line('domain-parametrage');?> <?php echo $infoDomaine->NAME_DOMAIN;?>	    								<div class="text-right pull-right">	                        		<button class="btn btn-success btn-sm mod-edit" data-href="<?php echo base_url();?>configuration/editer_attribut/<?php echo $infoDomaine->CODE_DOMAIN;?>" data-title="<?php echo $this->lang->line('domain-add-attribut-title');?>"><i class="fa fa-plus-circle"></i> &nbsp;<?php echo $this->lang->line('domain-add-attribut-title');?></button>	                        		<button class="btn btn-primary btn-sm mod-edit" data-href="<?php echo base_url();?>configuration/import_attributs/<?php echo$infoDomaine->CODE_DOMAIN;?>" data-title="<?php echo $this->lang->line('domain-attribut-import-title')." ".$infoDomaine->NAME_DOMAIN;?>"><i class="fa fa-file-excel-o"></i> &nbsp;<?php echo $this->lang->line('import');?></button>	                        		<a class="btn btn-info btn-sm" href="<?php echo base_url()."configuration/export_attributs/".$infoDomaine->CODE_DOMAIN;?>" target="_blank"><i class="fa fa-file-excel-o"></i> &nbsp;<?php echo $this->lang->line('export');?></a>	                        	</div>							   	                        </div>	                        <!-- /.panel-heading -->	                        <div class="panel-body">	                        	<?php 		                       if(count($infoDomaine->listeAttributs)==0){?>		                        	<p><?php echo $this->lang->line('datatable-empty');?></p>		                       	<?php }else{?>			                        <table class="table table-striped table-bordered table-hover display" id="table-domaine-attributs">	                                	<thead>	                                    	<tr>	                                    		<th><?php echo $this->lang->line('domain-attribut-name');?></th>		                       					<th><?php echo $this->lang->line('domain-attribut-description');?></th>		                       					<th><?php echo $this->lang->line('domain-attribut-champ-cible');?></th>		                       					<th><?php echo $this->lang->line('domain-attribut-locked');?></th>		                       					<th><?php echo $this->lang->line('domain-attribut-custom');?></th>		                       					<th><?php echo $this->lang->line('domain-attribut-lov');?></th>		                       					<th><?php echo $this->lang->line('domain-attribut-tkh');?></th>												<th><?php echo $this->lang->line('domain-attribut-type');?></th>		                       					<th><?php echo $this->lang->line('domain-attribut-source-regroupement');?></th>		                       					<th><?php echo $this->lang->line('domain-attribut-cible-regroupement');?></th>												<th><?php echo $this->lang->line('domain-attribut-indicateur-mobilite');?></th>														                       					<th width="15%"><?php echo $this->lang->line('liste-tools');?></th>	                                        </tr>	                                    </thead>	                                    <tbody>	                                    	<?php	                                    	foreach($infoDomaine->listeAttributs as $attribut){?>	                                    	<tr>	                                    		<td style="white-space: nowrap"><?php echo $attribut->NAME_ATTRIBUTE;?></td>	                                        	<td style="white-space: nowrap"><?php echo $attribut->DESC_ATTRIBUTE;?></td>	                                        	<td style="white-space: nowrap"><?php echo $attribut->FIELD_NAME;?></td>	                                        	<td style="white-space: nowrap" align="center" style="vertical-align:middle"><?php echo ($attribut->FLG_LOCKED == 1) ? "<i class=\"fa fa fa-circle fa-fw\"></i>" : "<i class=\"fa fa fa-circle-o fa-fw\"></i>"; ?></td>	                                        	<td style="white-space: nowrap" align="center" style="vertical-align:middle"><?php echo ($attribut->FLG_CUSTOM == 1) ? "<i class=\"fa fa fa-circle fa-fw\"></i>" : "<i class=\"fa fa fa-circle-o fa-fw\"></i>"; ?></td>	                                        	<td style="white-space: nowrap" align="center" style="vertical-align:middle"><?php echo ($attribut->FLG_LOV == 1) ? "<i class=\"fa fa fa-circle fa-fw\"></i>" : "<i class=\"fa fa fa-circle-o fa-fw\"></i>"; ?></td>
												<td style="white-space: nowrap" align="center" style="vertical-align:middle"><?php echo ($attribut->FLG_TKH == 1) ? "<i class=\"fa fa fa-circle fa-fw\"></i>" : "<i class=\"fa fa fa-circle-o fa-fw\"></i>"; ?></td>
												<td style="white-space: nowrap"><?php echo $attribut->NAME_TYPE;?></td>												<td style="white-space: nowrap"><?php echo $attribut->SRC;?></td>
												<td style="white-space: nowrap"><?php echo $attribut->EXT;?></td>
												<td style="white-space: nowrap"><?php echo $attribut->MOBIND;?></td>	                                        	<td style="white-space: nowrap" class="center">	                                           		<a class="btn btn-warning btn-xs mod-edit" data-href="<?php echo base_url();?>configuration/editer_attribut/<?php echo $infoDomaine->CODE_DOMAIN ; ?>/<?php echo $attribut->CODE_ATTRIBUTE?>" data-title="<?php echo $this->lang->line('domain-attribut-title-edit')." ".$attribut->NAME_ATTRIBUTE ; ?>"><i class="fa fa-pencil fa-fw"></i> </a>	                                            	<a data-toggle="modal" data-target="#attribut<?php echo $attribut->CODE_ATTRIBUTE ; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-fw"></i> </a>	                                            	<!-- Modal -->						                            <div class="modal fade" id="attribut<?php echo $attribut->CODE_ATTRIBUTE ; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">						                                <div class="modal-dialog">						                                    <div class="modal-content">						                                        <div class="modal-header">						                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>						                                            <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('domain-attribut-modal-del-title');?></h4>						                                        </div>						                                        <div class="modal-body">						                                            <?php echo $this->lang->line('domain-attribut-modal-del-txt');?> <strong><?php echo $attribut->NAME_ATTRIBUTE ; ?></strong> !						                                        </div>						                                        <div class="modal-footer">						                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>						                                            <a type="button" class="btn btn-danger" href="<?php echo base_url();?>configuration/fiche_domaine/<?php echo $infoDomaine->CODE_DOMAIN ; ?>/supprimer_attribut/<?php echo $attribut->CODE_ATTRIBUTE ; ?>"><i class="fa fa-trash fa-fw"></i> <?php echo $this->lang->line('liste-del');?></a>						                                        </div>						                                    </div>						                                    <!-- /.modal-content -->						                                </div>						                                <!-- /.modal-dialog -->						                            </div>						                            <!-- /.modal -->													<a class="btn btn-default btn-xs mod-edit" data-href="<?php echo base_url();?>configuration/editer_attribut/<?php echo $infoDomaine->CODE_DOMAIN ; ?>/copier_attribut/<?php echo $attribut->CODE_ATTRIBUTE?>" data-title="<?php echo $this->lang->line('domain-attribut-title-copy')." ".$attribut->NAME_ATTRIBUTE ; ?>"><i class="fa fa-files-o fa-fw"></i> </a>	                                            </td>	                                        </tr>	                                        <?php }?>	                                    </tbody>	                            	</table>	                            <?php }?>	                             <div id="fenetre-edit">		                        </div>	                       	</div>	               		</div>	               	</div>	         	</div>            </div>            <!-- /.container-fluid -->        </div>        <!-- /#page-wrapper -->    </div>    <!-- /#wrapper -->	<?php $this->load->view('inc/footer-js');?>	<!-- DataTables JavaScript -->    <script src="<?php echo URL_PLUGINS; ?>datatables/media/js/jquery.dataTables.min.js"></script>    <script src="<?php echo URL_PLUGINS; ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>    <!-- File Upload -->    <script src="<?php echo URL_PLUGINS; ?>bootstrap-fileupload/bootstrap-fileupload.js"></script>     <!-- Jquery UI -->    <script src="<?php echo URL_PLUGINS; ?>jquery-ui-1.11.4/jquery-ui.min.js"></script>	<script>		$(document).ready(function(){			table = $('#table-domaine-attributs').DataTable({		                "scrollX": true,						"sScrollX": "100%",						responsive: true,		                "language": {											"sProcessing":     "<?php echo $this->lang->line('datatable-process');?>",											"sSearch":         "<?php echo $this->lang->line('datatable-search');?>",										    "sLengthMenu":     "<?php echo $this->lang->line('datatable-lengthMenu');?>",											"sInfo":           "<?php echo $this->lang->line('datatable-info');?>",											"sInfoEmpty":      "<?php echo $this->lang->line('datatable-infoEmpty');?>",											"sInfoFiltered":   "<?php echo $this->lang->line('datatable-filtre');?>",											"sInfoPostFix":    "",											"sLoadingRecords": "<?php echo $this->lang->line('datatable-loading');?>",										    "sZeroRecords":    "<?php echo $this->lang->line('datatable-empty');?>",											"sEmptyTable":     "<?php echo $this->lang->line('datatable-emptyTable');?>",											"oPaginate": {												"sFirst":      "<?php echo $this->lang->line('datatable-first');?>",												"sPrevious":   "<?php echo $this->lang->line('datatable-previous');?>",												"sNext":       "<?php echo $this->lang->line('datatable-next');?>",												"sLast":       "<?php echo $this->lang->line('datatable-lfas');?>"											},											"oAria": {												"sSortAscending":  "<?php echo $this->lang->line('datatable-asc');?>",												"sSortDescending": "<?php echo $this->lang->line('datatable-desc');?>"											}										},						"bStateSave": true,						"autoWidth": true		        });			table.columns.adjust();			table.draw( true );				 $('#table-domaine-attributs').on('draw.dt', function ( e, settings) {					$(".mod-edit").unbind('click');					$(".mod-edit").click(function(){					var title = $(this).attr('data-title');					$.post($(this).attr('data-href'),{},function(retour){						$('#fenetre-edit').html(retour);						$('#fenetre-edit .fenetre-close').click(function(){							fenetre.dialog("close");						});						fenetre.dialog({title:title});						fenetre.dialog("open");					})					return false;					});				});			var fenetre = $('#fenetre-edit').dialog({	            autoOpen: false,	            resizable: true,	            modal: true,	            width: 750,	            draggable:true	          });			$(".mod-edit").click(function(){	            var title = $(this).attr('data-title');				$.post($(this).attr('data-href'),{},function(retour){					$('#fenetre-edit').html(retour);					$('#fenetre-edit .fenetre-close').click(function(){						fenetre.dialog("close");					});					fenetre.dialog({title:title});					fenetre.dialog("open");				})				return false;	        });		});	</script> </body></html>