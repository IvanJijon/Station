<?php $this->load->view('inc/header');?>    <!-- DataTables CSS -->    <link href="<?php echo URL_PLUGINS;?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">    <!-- DataTables Responsive CSS -->    <link href="<?php echo URL_PLUGINS;?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">    <!--  Jquery UI pour popin draggable + Selection sortable -->    <link href="<?php echo URL_PLUGINS;?>jquery-ui-1.11.4/jquery-ui.min.css" rel="stylesheet">     <link href="<?php echo URL_ASSETS;?>css/selection.css" rel="stylesheet">    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->    <!--[if lt IE 9]>        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>    <![endif]--></head><body>    <div id="wrapper">        <!-- Navigation -->        <?php $this->load->view('inc/nav');?>        <!-- Page Content -->        <div id="page-wrapper">            <div class="container-fluid">                <div class="row">                    <div class="col-lg-12">                        <h3 class="page-header"><i class="fa fa-database fa-fw"></i> <?php echo $this->lang->line('donnees-title');?> > <a href="<?php echo base_url();?>donnees/liste_fusions"> <i class="fa fa-refresh fa-fw"></i> <?php echo $this->lang->line('fusions-title');?> </a> > <?php echo $this->lang->line('fiche-fusion-title');?> <?php echo $infoFusion->CODE_TALEND;?></h3>                    </div>                    <!-- /.col-lg-12 -->                </div>                <br />                <div class="row">	                <div class="col-lg-12">	                    <div class="panel panel-info">	                        <div class="panel-heading clearfix">	                        	<a data-toggle="collapse" data-parent="#accordion" href="#collapse-info" aria-expanded="false" class=""> <i class="fa fa-refresh fa-fw"></i> <?php echo $this->lang->line('fusions-informations');?> <i class="fa fa-caret-down fa-fw"></i> </a>                  		                        	<div class="pull-right">									<a class="btn btn-warning btn-xs mod-edit" data-href="<?php echo base_url();?>donnees/editer_fusion/<?php echo $infoFusion->CODE_FUSION ; ?>" data-title="<?php echo $this->lang->line('fusion-title-edit')." ".$infoFusion->CODE_TALEND ; ?>"><i class="fa fa-pencil fa-fw"></i></a>									<a data-toggle="modal" data-target="#myModal<?php echo $infoFusion->CODE_FUSION;?>" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-fw"></i></a>									<a class="btn btn-info" href="<?php echo base_url();?>donnees/liste_fusions"><i class="fa fa-list fa-fw"></i> <?php echo $this->lang->line('retour-liste');?></a>									<!-- Modal -->									<div class="modal fade" id="myModal<?php echo $infoFusion->CODE_FUSION;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">									    <div class="modal-dialog">									        <div class="modal-content">									            <div class="modal-header">									                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>									                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('fusion-modal-del-title');?></h4>									            </div>									            <div class="modal-body">									                <?php echo $this->lang->line('fusion-modal-del-txt');?> <strong><?php echo $infoFusion->CODE_TALEND." ".$infoFusion->NAME_FUSION ; ?></strong> !									            </div>									            <div class="modal-footer">									                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>									                <a type="button" class="btn btn-danger" href="<?php echo base_url();?>donnees/liste_fusions/supprimer_fusion/<?php echo $infoFusion->CODE_FUSION ; ?>"><i class="fa fa-trash fa-fw"></i> <?php echo $this->lang->line('liste-del');?></a>									            </div>									        </div>									        <!-- /.modal-content -->									    </div>									    <!-- /.modal-dialog -->									</div>									<!-- /.modal -->								</div>	                        </div>	                        <!-- /.panel-heading -->	                        <div id="collapse-info" class="panel-collapse collapse">		                        <div class="panel-body">		                        	<div class="table-responsive">	                             	 	<table class="table table-hover no-header no-footer">		                                	<tr class="gradeA odd">			                                	<td><strong><?php echo $this->lang->line('fusion-code-talend');?></strong></td>			                                 	<td><?php echo $infoFusion->CODE_TALEND; ?></td>		                                 	</tr> 	                                     	<tr class="gradeA even">			                                 	<td><strong><?php echo $this->lang->line('fusion-nom');?></strong></td>			                                 	<td><?php echo $infoFusion->NAME_FUSION; ?></td>		                                 	</tr>		                                  	<tr class="gradeA odd">			                                 	<td><strong><?php echo $this->lang->line('fusion-desc');?></strong></td>			                                	<td><?php echo $infoFusion->DESC_FUSION; ?></td>		                                 	</tr>		                                 	<tr class="gradeA even">			                                 	<td><strong><?php echo $this->lang->line('fusion-table-cible');?></strong></td>			                                	<td><?php echo $infoFusion->TARGET_TABLE; ?></td>		                                 	</tr>		                                 	<tr class="gradeA odd">			                                 	<td><strong><?php echo $this->lang->line('fusion-fichier');?></strong></td>			                                	<td><?php echo $infoFusion->FILE_NAME; ?></td>		                                 	</tr>		                                 </table>		                        	</div>	                        			                        </div>		                        <!-- /.panel-body -->	                        </div>.	                        <!-- /.collapse -->	                    </div>	                    <!-- /.panel -->	                </div>	                <!-- /.col-lg-12 -->	            </div>           		<!-- /.row -->				<div class="row" id="param">	                <div class="col-lg-12">	                    <div class="panel panel-info">	                        <div class="panel-heading clearfix">	                            <i class="fa fa-sliders"></i> <?php echo $this->lang->line('fusion-parametrage');?> <?php echo $infoFusion->CODE_TALEND;?>								<div class="pull-right">								<button class="btn btn-warning btn-sm mod-edit" data-href="<?php echo base_url();?>donnees/editer_fusion_historique/<?php echo $infoFusion->CODE_FUSION;?>" data-title="<?php echo $this->lang->line('fusion-definir-histo-title')." ".$infoFusion->CODE_TALEND;?>"><i class="fa fa-pencil"></i> &nbsp;<?php echo $this->lang->line('fusion-definir-histo');?></button>								<a class="btn btn-info btn-sm" href="<?php echo base_url()."donnees/export_fusion_historique/".$infoFusion->CODE_FUSION;?>" target="_blank"><i class="fa fa-file-excel-o"></i> &nbsp;<?php echo $this->lang->line('export');?></a>								</div>	                        </div>	                        <!-- /.panel-heading -->	                        <div class="panel-body">	                        	<?php 		                       if(count($infoFusion->listeHistoriques)==0){?>		                        	<p><?php echo $this->lang->line('datatable-empty');?></p>		                       	<?php }else{?>			                        <table class="table table-striped table-bordered table-hover display" id="table-rules">	                                	<thead>	                                    	<tr>	                                    		<th>#</th>		                       					<th><?php echo $this->lang->line('fusion-code-historique');?></th>		                       					<th><?php echo $this->lang->line('fusion-master-historique');?></th>	                                        </tr>	                                    </thead>	                                    <tbody>	                                    	<?php $i=1;	                                    	foreach($infoFusion->listeHistoriques as $histo){?>	                                    	<tr>	                                    		<td><?php echo $i;?></td>	                                        	<td><?php echo $histo->NAME_HIST;?></td>	                                        	<td><input type="checkbox" class="flg_master" id="<?php echo $histo->FUSION_HIST;?>" <?php if($histo->FLG_MASTER_HIST==1){echo 'checked="checked"';}?>/></td>	                                    	 </tr>	                                        <?php $i++;}?>	                                    </tbody>	                            	</table>	                            <?php }?>	                             <div id="fenetre-edit">		                        </div>	                       	</div>	               		</div>	               	</div>	         	</div>            </div>            <!-- /.container-fluid -->        </div>        <!-- /#page-wrapper -->    </div>    <!-- /#wrapper -->	<?php $this->load->view('inc/footer-js');?>	<!-- DataTables JavaScript -->    <script src="<?php echo URL_PLUGINS; ?>datatables/media/js/jquery.dataTables.min.js"></script>    <script src="<?php echo URL_PLUGINS; ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>     <!-- Jquery UI -->    <script src="<?php echo URL_PLUGINS; ?>jquery-ui-1.11.4/jquery-ui.min.js"></script>	<script>		$(document).ready(function(){			table = $('#table-rules').dataTable({		                responsive: true,		                "language": {											"sProcessing":     "<?php echo $this->lang->line('datatable-process');?>",											"sSearch":         "<?php echo $this->lang->line('datatable-search');?>",										    "sLengthMenu":     "<?php echo $this->lang->line('datatable-lengthMenu');?>",											"sInfo":           "<?php echo $this->lang->line('datatable-info');?>",											"sInfoEmpty":      "<?php echo $this->lang->line('datatable-infoEmpty');?>",											"sInfoFiltered":   "<?php echo $this->lang->line('datatable-filtre');?>",											"sInfoPostFix":    "",											"sLoadingRecords": "<?php echo $this->lang->line('datatable-loading');?>",										    "sZeroRecords":    "<?php echo $this->lang->line('datatable-empty');?>",											"sEmptyTable":     "<?php echo $this->lang->line('datatable-emptyTable');?>",											"oPaginate": {												"sFirst":      "<?php echo $this->lang->line('datatable-first');?>",												"sPrevious":   "<?php echo $this->lang->line('datatable-previous');?>",												"sNext":       "<?php echo $this->lang->line('datatable-next');?>",												"sLast":       "<?php echo $this->lang->line('datatable-lfas');?>"											},											"oAria": {												"sSortAscending":  "<?php echo $this->lang->line('datatable-asc');?>",												"sSortDescending": "<?php echo $this->lang->line('datatable-desc');?>"											}										},					"bStateSave": true,		        });			var fenetre = $('#fenetre-edit').dialog({	            autoOpen: false,	            resizable: true,	            modal: true,	            width: 750,	            draggable:true	          });			$(".mod-edit").click(function(){	            var title = $(this).attr('data-title');				$.post($(this).attr('data-href'),{},function(retour){					$('#fenetre-edit').html(retour);					$('#fenetre-edit .fenetre-close').click(function(){						fenetre.dialog("close");					});					$( "#listeHisto, #ListeHistoFusion" ).sortable({						 connectWith: ".connectedSortable"						 }).disableSelection().on('load', function (event) {							 alert('toto');							$('#div-ListeHistoFusion').css('height',$('#div-listeHisto ul').height());						});					fenetre.dialog({title:title});					fenetre.dialog("open");					/*$('#ListeHistoFusion').css('height',$('#div-listeHisto').height());*/				})				return false;	        });	        $('.flg_master').click(function(){				var flg=0;				if($(this).is(':checked')){flg=1;}				$.post('<?php echo base_url();?>donnees/editer_fusion_flg/'+$(this).attr('id'),{flag: flg});	        });		});	</script> </body></html>