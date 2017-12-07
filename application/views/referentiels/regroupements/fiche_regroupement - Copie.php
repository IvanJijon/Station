<?php $this->load->view('inc/header');?>
    <!-- DataTables CSS -->
    <link href="<?php echo URL_PLUGINS;?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="<?php echo URL_PLUGINS;?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <!-- File upload -->
    <link href="<?php echo URL_PLUGINS;?>bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet">
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
                    	<h3 class="page-header"><i class="fa fa-list fa-fw"></i> <?php echo $this->lang->line('referentiels-title');?> > <i class="fa fa-users fa-fw"></i> <?php echo $this->lang->line('regroupements-title');?> > <?php echo $this->lang->line('fiche-regroupements-title');?> <?php echo $infoRegroupement->NAME_EXTENSION;?></h3>                    	
					</div>
                    <!-- /.col-lg-12 -->
                </div>
                <br />
                <div class="row">
	                <div class="col-lg-12">
		                 <?php if($msg=="importok"){?>
                        	 <div class="alert alert-success">
                               	<?php echo $this->lang->line('regroupement-importok');?>
                            </div>
                         <?php }elseif($msg=="importkoCols"){?>
                        	 <div class="alert alert-danger">
                               	<?php echo $this->lang->line('regroupement-importkoCols');?>
                            </div>
                         <?php }?>
	                    <div class="panel panel-info">
	                        <div class="panel-heading clearfix">
	                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse-info" aria-expanded="false" class=""><i class="fa fa-users fa-fw"></i> <?php echo $this->lang->line('regroupements-informations');?> <i class="fa fa-caret-down fa-fw"></i> </a>                	
								<div class="btn-group pull-right">
									<a class="btn btn-info pull-right" href="<?php echo base_url();?>referentiels/liste_regroupements"><i class="fa fa-list fa-fw"></i> <?php echo $this->lang->line('retour-liste');?></a>
								</div>
							</div>
	                        <!-- /.panel-heading -->
	                        <div id="collapse-info" class="panel-collapse collapse">
		                        <div class="panel-body">
		                        	<div class="table-responsive">
	                             	 	<table class="table table-hover no-header no-footer">
		                                	<tr class="gradeA odd">
			                                	<td><strong><?php echo $this->lang->line('regroupement-NAME_EXTENSION');?></strong></td>
			                                 	<td><?php echo $infoRegroupement->NAME_EXTENSION; ?></td>
		                                 	</tr> 
	                                     	<tr class="gradeA even">
			                                 	<td><strong><?php echo $this->lang->line('regroupement-DESC_EXTENSION');?></strong></td>
			                                 	<td><?php echo $infoRegroupement->DESC_EXTENSION; ?></td>
		                                 	</tr>
		                                  	<tr class="gradeA odd">
			                                 	<td><strong><?php echo $this->lang->line('regroupement-NAME_DOMAIN');?></strong></td>
			                                	<td><?php echo $infoRegroupement->NAME_DOMAIN; ?></td>
		                                 	</tr>
		                                 </table>
		                        	</div>	                        	
		                        </div>
		                        <!-- /.panel-body -->
		                	</div>
		                	<!-- /.collapse -->
	                    </div>
	                    <!-- /.panel -->
	                </div>
	                <!-- /.col-lg-12 -->
	            </div>
            <!-- /.row -->
                <?php $tabChampsRules=array('SRC'=>array(),'EXT'=>array());
                for($i=1;$i<=20;$i++){
                	$champs="CODE_SRC_ATTR_";
                	if(strlen($i)==1){$nb="0".$i;}else{$nb=$i;}
                	$champs.=$nb;
	                if($infoRegroupement->$champs!=""){
	                	$tabChampsRules['SRC'][count($tabChampsRules['SRC'])]=$nb;
	                }
                }
                for($i=0;$i<=20;$i++){
                	$champs="CODE_EXT_ATTR_";
                    if(strlen($i)==1){$nb="0".$i;}else{$nb=$i;}
                    $champs.=$nb;
                    if($infoRegroupement->$champs!=""){
                    	$tabChampsRules['EXT'][count($tabChampsRules['EXT'])]=$nb;
                    }
                }?>
	         	<div class="row" id="param">
	                <div class="col-lg-12">
	                    <div class="panel panel-info">
	                        <div class="panel-heading clearfix">
								<i class="fa fa-sliders"></i> <?php echo $this->lang->line('regroupement-parametrage');?> <?php echo $infoRegroupement->NAME_EXTENSION;?>
								<div class="text-right pull-right">
	                        		<button class="btn btn-success btn-sm mod-edit" data-href="<?php echo base_url();?>referentiels/import_regroupement/<?php echo $infoRegroupement->CODE_EXTENSION;?>" data-title="<?php echo $this->lang->line('regroupement-title-import')." ".$regroupement->NAME_EXTENSION;?>" ><i class="fa fa-file-excel-o"></i> &nbsp;<?php echo $this->lang->line('import');?></button>
	                        		<a class="btn btn-info btn-sm" href="<?php echo base_url();?>referentiels/export_regroupement/<?php echo $infoRegroupement->CODE_EXTENSION;?>" target="_blank"><i class="fa fa-file-excel-o"></i> &nbsp;<?php echo $this->lang->line('export');?></a>
	                        	</div>
							</div>
	                        <!-- /.panel-heading -->
	                        <div class="panel-body">
		                        <br/>
			                        <table class="table table-striped table-bordered table-hover display" id="table-rules">
	                                	<thead>
	                                    	<tr>
	                                    		<th>#</th>
		                       					<?php
	                                    		foreach($tabChampsRules['SRC'] as $nbRule){
	                                    			$champs = "CODE_SRC_ATTR_".$nbRule;?>
	                                    			<th ><?php echo $listeAttributesArray[$infoRegroupement->$champs]->NAME_ATTRIBUTE;?></th>
	                                    		<?php }?>
	                                    		<?php
	                                    		foreach($tabChampsRules['EXT'] as $nbRule){
	                                    			$champs = "CODE_EXT_ATTR_".$nbRule;?>
	                                    			<th><?php echo $listeAttributesArray[$infoRegroupement->$champs]->NAME_ATTRIBUTE;?></th>
	                                    		<?php }?>
	                                    		<th><?php echo $this->lang->line('liste-tools');?></th>
	                                        </tr>
	                                    </thead>
										
										<tfoot>
	                                    	<tr>
	                                    		<th></th>
		                       					<?php
	                                    		foreach($tabChampsRules['SRC'] as $nbRule){?>
	                                    			<th></th>
	                                    		<?php }
	                                    		foreach($tabChampsRules['EXT'] as $nbRule){?>
	                                    			<th></th>
	                                    		<?php }?>
	                                    		
	                                        </tr>
	                                    </tfoot>
										
	                                    <?php if(count($infoRegroupement->listeRules)>0){?>
	                                    <tbody>
	                                    	<?php $i=1;
	                                    	foreach($infoRegroupement->listeRules as $rule){?>
	                                    	<tr>
	                                    		<td><?php echo $i;?></td>
	                                        	<?php 
	                                    		foreach($tabChampsRules['SRC'] as $nbRule){	                                    			
	                                    			$champ = "SRC_ATTR_".$nbRule."_VALUE";?>
	                                    			<td bgcolor="#C9C9C9"><?php echo $rule->$champ;?></td>
	                                    		<?php }?>
	                                    		<?php
	                                    		foreach($tabChampsRules['EXT'] as $nbRule){
	                                    			$champ = "EXT_ATTR_".$nbRule."_VALUE";?>
	                                    			<td><?php echo $rule->$champ;?></td>
	                                    		<?php }?>
	                                    		<td>
													<a class="btn btn-warning btn-xs mod-edit" data-href="<?php echo base_url();?>referentiels/editer_rule/<?php echo $rule->CODE_RULE ; ?>" data-title="<?php echo $this->lang->line('rule-title-edit')." ".$i." ".$regroupement->NAME_EXTENSION ; ?>"><i class="fa fa-pencil fa-fw"></i> </a>
												</td>
		                                    </tr>
	                                        <?php $i++;}?>
	                                    </tbody>
	                                    <?php }?>
	                            	</table>
	                            	<?php if(count($infoRegroupement->listeRules)==0){?>
	                            		<br/>
		                        		<p><?php echo $this->lang->line('regroupement-rules-maj');?></p>
		                       		<?php }?>
	                             <div id="fenetre-edit">
		                        </div>
	                       	</div>
	               		</div>
	               	</div>
	         	</div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
	
	<script src="//code.jquery.com/jquery-1.12.3.js"></script>
	<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	
	<?php $this->load->view('inc/footer-js');?>
	<!-- DataTables JavaScript -->
	
    <script src="<?php echo URL_PLUGINS; ?>datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo URL_PLUGINS; ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <!-- File Upload -->
    <script src="<?php echo URL_PLUGINS; ?>bootstrap-fileupload/bootstrap-fileupload.js"></script>
     <!-- Jquery UI -->
    <script src="<?php echo URL_PLUGINS; ?>jquery-ui-1.11.4/jquery-ui.min.js"></script>
	
	
	
	<script>
		$(document).ready(function(){
			
			// Setup - add a text input to each footer cell
			$('#table-rules tfoot th').each( function () {
				var title = $(this).text();
				$(this).html( '<input type="text" placeholder="Filtre" />' );
			} );
			
			table = $('#table-rules').DataTable({
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
				"bStateSave": true
			});
		 
			// Apply the search
			table.columns().every( function () {
				var that = this;
		 
				$( 'input', this.footer() ).on( 'keyup change', function () {
					if ( that.search() !== this.value ) {
						that
							.search( this.value )
							.draw();
					}
				} );
			} );
			 $('#table-rules').on('draw.dt', function ( e, settings) {
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
			$('button.edit-attr').click(function(){
				var elem = $(this);
				$.post('<?php echo base_url();?>referentiels/ajax_regroupement/',{domain:'<?php echo $infoRegroupement->CODE_DOMAIN;?>',action:'edit',type:$(this).attr('data-type'),attr:$(this).attr('data-attr'),value:$(this).attr('data-value'),CODE_EXTENSION:'<?php echo $infoRegroupement->CODE_EXTENSION?>'},function(data){
					elem.parent().html(data);
				})
			})
			
			
		});
	</script> 
</body>
</html>