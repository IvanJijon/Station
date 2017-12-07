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
                        <h1 class="page-header"><i class="fa fa-list fa-fw"></i> <?php echo $this->lang->line('referentiels-title');?></h1>
                        <h3><i class="fa fa-users fa-fw"></i> <?php echo $this->lang->line('regroupements-title');?> : <?php echo $this->lang->line('fiche-regroupements-title');?> <?php echo $infoRegroupement->NAME_EXTENSION;?></h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <br />
                
                <div class="row">
	                <div class="col-lg-12">
	                    <div class="panel panel-info">
	                        <div class="panel-heading">
	                            <i class="fa fa-users fa-fw"></i> <?php echo $this->lang->line('regroupements-informations');?>                     	
	                        </div>
	                        <!-- /.panel-heading -->
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
	                    <!-- /.panel -->
	                </div>
	                <!-- /.col-lg-12 -->
	            </div>
            <!-- /.row -->
            <?php $tabChampsRules=array('SRC'=>array(),'EXT'=>array());?>
            	<div class="row">
	                <div class="col-lg-12">
	                    <div class="panel panel-info">
	                        <div class="panel-heading">
	                           <i class="fa fa-hand-o-left"></i> <?php echo $this->lang->line('regroupement-liste-attributs-sources');?>
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class="panel-body">
	                        	<div class="text-right">
	                        		<button class="btn btn-success btn-sm add-source"><i class="fa fa-plus-circle"></i> &nbsp;<?php echo $this->lang->line('regroupement-add-source');?></button>
	                        	</div>
	                        	<br/>
	                       	 	<table class="table table-striped table-bordered display" id="table-source">
                                	<thead>
                                    	<tr>
                                        	<?php for($i=1;$i<=20;$i++){
                                        		 $champs="CODE_SRC_ATTR_";
                                        		if(strlen($i)==1){$nb="0".$i;}else{$nb=$i;}
                                        		$champs.=$nb;
                                        		if($infoRegroupement->$champs!=""){
                                        			$tabChampsRules['SRC'][count($tabChampsRules['SRC'])]=$nb;?>
                                        		 <th><?php echo $this->lang->line('regroupement-'.$champs);?></th>
                                        		 <?php }
                                        		}?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                        	<?php
                                        	for($i=1;$i<=20;$i++){
                                        		 $champs="CODE_SRC_ATTR_";
                                        		if(strlen($i)==1){$champs.="0".$i;}else{$champs.=$i;}
                                        		if($infoRegroupement->$champs!=""){?>
                                        		 <td>
                                        		 	<?php echo $listeAttributesArray[$infoRegroupement->$champs]->NAME_ATTRIBUTE;?>
                                        		 	<button class="btn btn-warning btn-xs edit-attr" data-type="sources" data-attr="<?php echo $champs;?>" data-value="<?php echo $infoRegroupement->$champs;?>"><i class="fa fa-pencil fa-fw"></i> </button>
                                        		 	<a class="btn btn-danger btn-xs" href="<?php echo base_url()."referentiels/fiche_regroupement/".$infoRegroupement->CODE_EXTENSION."/supprimer_attribut/".$champs;?>"><i class="fa fa-trash fa-fw"></i> </a>
                                        		 </td>
                                        	<?php }
                                        	}?>
                                        </tr>
                                    </tbody>
                            	</table>
	                        </div>
	               		</div>
	               	</div>
	         	</div>
	         	
	         	<div class="row">
	                <div class="col-lg-12">
	                    <div class="panel panel-info">
	                        <div class="panel-heading">
	                           <i class="fa fa-hand-o-right"></i> <?php echo $this->lang->line('regroupement-liste-attributs-cibles');?>                     	
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class="panel-body">
	                        	<div class="text-right">
	                        		<button class="btn btn-success btn-sm add-cible"><i class="fa fa-plus-circle"></i> &nbsp;<?php echo $this->lang->line('regroupement-add-cible');?></button>
	                        	</div>
	                        	<br/>
	                        	<table class="table table-striped table-bordered table-hover display" id="table-cible">
                                	<thead>
                                    	<tr><?php
                                        	for($i=0;$i<=20;$i++){
                                        		 $champs="CODE_EXT_ATTR_";
                                        		if(strlen($i)==1){$nb="0".$i;}else{$nb=$i;}
                                        		$champs.=$nb;
                                        		if($infoRegroupement->$champs!=""){
                                        		$tabChampsRules['EXT'][count($tabChampsRules['EXT'])]=$nb;
                                        			?>
                                        		 <th><?php echo $this->lang->line('regroupement-'.$champs);?></th>
                                        		 <?php }
                                        	}?> </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                        	<?php
                                        	for($i=0;$i<=20;$i++){
                                        		 $champs="CODE_EXT_ATTR_";
                                        		if(strlen($i)==1){$champs.="0".$i;}else{$champs.=$i;}
                                        		if($infoRegroupement->$champs!=""){?>
                                        		<td>
                                        		 	<?php echo $listeAttributesArray[$infoRegroupement->$champs]->NAME_ATTRIBUTE;?>
                                        		 	<button class="btn btn-warning btn-xs edit-attr" data-type="cibles" data-attr="<?php echo $champs;?>" value="<?php echo $infoRegroupement->$champs;?>"><i class="fa fa-pencil fa-fw"></i> </button>
                                        		 	<a class="btn btn-danger btn-xs" href="<?php echo base_url()."referentiels/fiche_regroupement/".$infoRegroupement->CODE_EXTENSION."/supprimer_attribut/".$champs;?>"><i class="fa fa-trash fa-fw"></i> </a>
	                                            </td>
                                        	<?php }
                                        	}?>
                                        </tr>
                                    </tbody>
                            	</table>
	                        </div>
	               		</div>
	               	</div>
	         	</div>
	         	
	         	<div class="row" id="param">
	                <div class="col-lg-12">
	                    <div class="panel panel-info">
	                        <div class="panel-heading">
	                           <i class="fa fa-sliders"></i> <?php echo $this->lang->line('regroupement-parametrage');?> <?php echo $infoRegroupement->NAME_EXTENSION;?>
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class="panel-body">
		                        <?php 
		                        if(count($infoRegroupement->listeRules)==0){?>
		                        	<p><?php echo $this->lang->line('regroupement-rules-maj');?></p>
		                       	<?php }else{?>
			                        <table class="table table-striped table-bordered table-hover display" id="table-rules">
	                                	<thead>
	                                    	<tr>
	                                    		<th>#</th>
		                       					<?php
	                                    		foreach($tabChampsRules['SRC'] as $nbRule){
	                                    			$champs = "CODE_SRC_ATTR_".$nbRule;?>
	                                    			<th><?php echo $listeAttributesArray[$infoRegroupement->$champs]->NAME_ATTRIBUTE;?></th>
	                                    		<?php }?>
	                                    		<?php
	                                    		foreach($tabChampsRules['EXT'] as $nbRule){
	                                    			$champs = "CODE_EXT_ATTR_".$nbRule;?>
	                                    			<th><?php echo $listeAttributesArray[$infoRegroupement->$champs]->NAME_ATTRIBUTE;?></th>
	                                    		<?php }?>
	                                    		<th><?php echo $this->lang->line('liste-tools');?></th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                    	<?php $i=1;
	                                    	foreach($infoRegroupement->listeRules as $rule){?>
	                                    	<tr>
	                                    		<td><?php echo $i;?></td>
	                                        	<?php 
	                                    		foreach($tabChampsRules['SRC'] as $nbRule){	                                    			
	                                    			$champ = "SRC_ATTR_".$nbRule."_VALUE";?>
	                                    			<td><?php echo $rule->$champ;?></td>
	                                    		<?php }?>
	                                    		<?php
	                                    		foreach($tabChampsRules['EXT'] as $nbRule){
	                                    			$champ = "EXT_ATTR_".$nbRule."_VALUE";?>
	                                    			<td><?php echo $rule->$champ;?></td>
	                                    		<?php }?>
	                                    		<td><a class="btn btn-warning btn-xs mod-edit" data-href="<?php echo base_url();?>referentiels/editer_rule/<?php echo $rule->CODE_RULE ; ?>" data-title="<?php echo $this->lang->line('rule-title-edit')." ".$i." ".$regroupement->NAME_EXTENSION ; ?>"><i class="fa fa-pencil fa-fw"></i> </a></td>
		                                    </tr>
	                                        <?php $i++;}?>
	                                    </tbody>
	                            	</table>
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
	<?php $this->load->view('inc/footer-js');?>
	
	<!-- DataTables JavaScript -->
    <script src="<?php echo URL_PLUGINS; ?>datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo URL_PLUGINS; ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    
    
     <!-- Jquery UI -->
    <script src="<?php echo URL_PLUGINS; ?>jquery-ui-1.11.4/jquery-ui.min.js"></script>
	<script>
		$(document).ready(function(){
			$('button.add-source').click(function(){
				var nbElem = $('#table-source thead tr > *').length;
				if(nbElem<20){
					$.post('<?php echo base_url();?>referentiels/ajax_regroupement/',{domain:'<?php echo $infoRegroupement->CODE_DOMAIN;?>',action:'add',cible:'head',type:'sources',nb_elem:nbElem+1},function(data){
						$('#table-source thead tr').append(data);
					});
					$.post('<?php echo base_url();?>referentiels/ajax_regroupement/',{domain:'<?php echo $infoRegroupement->CODE_DOMAIN;?>',action:'add',cible:'body',type:'sources',nb_elem:nbElem+1,CODE_EXTENSION:'<?php echo $infoRegroupement->CODE_EXTENSION?>'},function(data){
						$('#table-source tbody tr').append(data);
					});
					
				}else{
					//Afficher message erreur
				}
			});

			 table = $('#table-rules').dataTable({
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

			$('button.add-cible').click(function(){
				var nbElem = $('#table-cible thead tr > *').length;
				if(nbElem<20){
					$.post('<?php echo base_url();?>referentiels/ajax_regroupement/',{domain:'<?php echo $infoRegroupement->CODE_DOMAIN;?>',action:'add',cible:'head',type:'cibles',nb_elem:nbElem+1},function(data){
						$('#table-cible thead tr').append(data);
					});
					$.post('<?php echo base_url();?>referentiels/ajax_regroupement/',{domain:'<?php echo $infoRegroupement->CODE_DOMAIN;?>',action:'add',cible:'body',type:'cibles',nb_elem:nbElem+1,CODE_EXTENSION:'<?php echo $infoRegroupement->CODE_EXTENSION?>'},function(data){
						$('#table-cible tbody tr').append(data);
					});
					
				}else{
					//Afficher message erreur
				}
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
