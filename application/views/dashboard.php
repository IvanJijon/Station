<?php $this->load->view('inc/header');?>
 <!-- Morris Charts CSS -->
    <link href="<?php echo URL_PLUGINS;?>morrisjs/morris.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php $this->load->view('inc/nav');?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $this->lang->line('dashboard-title');?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $this->lang->line('station-use-title');?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="utilisationStation"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $this->lang->line('quality-data-histo-title');?>
                        </div>
                        <div class="panel-body">
                            <div id="regroupement-histo"></div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $this->lang->line('quality-data-taux-title');?>
                        </div>
                        <div class="panel-body">
                          	<div class="row">
                          		<div class="col-lg-6">
                          			<?php for($i=0;$i<ceil(count($tabRegroupement)/2);$i++){
                          				if($tabRegroupement[$i]['nbRules']==0){
                          					$taux=0;
                          				}else{
                          					$taux=round((($tabRegroupement[$i]['nbRules']-$tabRegroupement[$i]['nbLignes'])/$tabRegroupement[$i]['nbRules'])*100);
                          				}
                          				if($taux>=80){$color="green";}elseif($taux<80 && $taux>=40){$color="yellow";}elseif($taux<40 && $taux>=20){$color="orange";}else{$color="red";}
                          				?>
                          			<div>
	                                    <p>
	                                        <strong><?php echo $tabRegroupement[$i]['name'];?></strong>
	                                        <span class="pull-right text-muted"><?php echo $taux;?>% <?php echo $this->lang->line('data-complete');?></span>
	                                    </p>
	                                    <div class="progress progress-striped active">
	                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $taux;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $taux;?>%;background-color:<?php echo $color;?>">
	                                            <span class="sr-only"><?php echo $taux;?>% <?php echo $this->lang->line('data-complete');?></span>
	                                        </div>
	                                    </div>
	                                </div>
	                                <?php }?>
                          		</div>
                          		<div class="col-lg-6">
                          			<?php for($i=ceil(count($tabRegroupement)/2);$i<count($tabRegroupement);$i++){
                          				if($tabRegroupement[$i]['nbRules']==0){
                          					$taux=0;
                          				}else{
                          					$taux=round((($tabRegroupement[$i]['nbRules']-$tabRegroupement[$i]['nbLignes'])/$tabRegroupement[$i]['nbRules'])*100);
                          				}
                          				if($taux>=80){$color="green";}elseif($taux<80 && $taux>=40){$color="yellow";}elseif($taux<40 && $taux>=20){$color="orange";}else{$color="red";}
                          				?>
                          			<div>
	                                    <p>
	                                        <strong><?php echo $tabRegroupement[$i]['name'];?></strong>
	                                        <span class="pull-right text-muted"><?php echo $taux;?>% <?php echo $this->lang->line('data-complete');?></span>
	                                    </p>
	                                    <div class="progress progress-striped active">
	                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $taux;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $taux;?>%;background-color:<?php echo $color;?>">
	                                            <span class="sr-only"><?php echo $taux;?>% <?php echo $this->lang->line('data-complete');?></span>
	                                        </div>
	                                    </div>
	                                </div>
	                                <?php }?>
                          		</div>
                          	</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> <?php echo $this->lang->line('timeline-title');?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="timeline">
                            	<?php $i=0;foreach($timeLine as $elem){?>
                                <li<?php if($i%2==1){?> class="timeline-inverted"<?php }?>>
                                    <div class="timeline-badge <?php if($elem->ACTION=="INSERT"){echo "success";}else{echo "warning";}?>"><i class="fa fa-<?php if($elem->ACTION=="INSERT"){echo "plus-circle";}else{echo "pencil";}?>"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><?php echo $elem->TABLE_IMPACTED;?></h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo $this->lang->line('le')." ".dateSqlToDate($elem->EXECUTION_DATE)." ".$this->lang->line('par')." ".$elem->FULLNAME?></small>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <?php $i++; }?>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                	<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-archive fa-fw"></i> <?php echo $this->lang->line('archives-title');?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	<div class="panel panel-green">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-truck fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><?php echo dateSqlToDate($infoArchive['nextChargement']);?></div>
		                                    <div><?php echo $this->lang->line('next-chargement');?></div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
                           <div class="panel panel-yellow">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-truck fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><?php echo dateSqlToDate($infoArchive['lastChargement']);?></div>
		                                    <div><?php echo $this->lang->line('last-chargement');?></div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>		                    
		                    <div class="panel panel-green">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-trash fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><?php echo dateSqlToDate($infoArchive['nextPurge']);?></div>
		                                    <div><?php echo $this->lang->line('next-purge');?></div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="panel panel-primary">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-archive fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><?php echo $infoArchive['nbTotal'];?></div>
		                                    <div><?php echo $this->lang->line('nb-total-archives');?></div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>     
                	<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-keyboard-o fa-fw"></i> <?php echo $this->lang->line('elem-quantitatif-title');?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body"> 
                        	<div class="panel panel-info">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-users fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><?php echo $elementsQuantitatifs['nbRegroupements'];?></div>
		                                    <div><?php echo $this->lang->line('nb-regroupements');?></div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="panel panel-green">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-university fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><?php echo $elementsQuantitatifs['nbAnciennetes'];?></div>
		                                    <div><?php echo $this->lang->line('nb-anciennetes');?></div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="panel panel-primary">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-bar-chart fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><?php echo $elementsQuantitatifs['nbTranches'];?></div>
		                                    <div><?php echo $this->lang->line('nb-tranches')?></div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="panel panel-yellow">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-car fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><?php echo $elementsQuantitatifs['nbMobilites'];?></div>
		                                    <div><?php echo $this->lang->line('nb-mobilites')?></div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="panel panel-red">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-archive fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><?php echo $elementsQuantitatifs['nbArchives'];?></div>
		                                    <div><?php echo $this->lang->line('nb-archives')?></div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
                        </div>
                	</div> 
                	<!-- /.panel -->  
                	<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $this->lang->line('nb-indicateurs-type');?>
                        </div>
                        <div class="panel-body">
                            <div id="indicateur-paie-donut"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->         	
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
     <?php $this->load->view('inc/footer-js');?>
      <!-- Morris Charts JavaScript -->
    <script src="<?php echo URL_PLUGINS;?>raphael/raphael-min.js"></script>
    <script src="<?php echo URL_PLUGINS;?>morrisjs/morris.min.js"></script>
    <script>
    	$(document).ready(function(){
		    Morris.Area({
		        element: 'utilisationStation',
		        data: [<?php foreach($utilisationStation as $date=>$uS){
		        		echo "{date:'".$date."',INSERT:".$uS['INSERT'].",UPDATE:".$uS['UPDATE'].",DELETE:".$uS['DELETE']."},";
		        	}?>],
		        xkey: 'date',
		        ykeys: ['INSERT', 'UPDATE', 'DELETE'],
		        labels: ['<?php echo $this->lang->line('ajout');?>', '<?php echo $this->lang->line('modification');?>', '<?php echo $this->lang->line('suppression');?>'],
		        pointSize: 2,
		        hideHover: 'auto',
		        resize: true,
		        parseTime: false
		    });
		    Morris.Bar({
		        element: 'regroupement-histo',
		        data: [<?php foreach($tabRegroupement as $regroupement){
		        	echo "{y:'".$regroupement['name']."',a:'".$regroupement['nbLignes']."'},";
		        }?>],
		        xkey: 'y',
		        ykeys: ['a'],
		        labels: ['<?php echo $this->lang->line('label-histo');?>'],
		        hideHover: 'auto',
		        resize: true
		    });
		    Morris.Donut({
		        element: 'indicateur-paie-donut',
		        data: [<?php foreach($indicateursPaieDonut as $indic){
		        	echo "{ label: \"".$indic->DESC_TYPE."\",value: ".$indic->NB."},";
		        }?>],
		        resize: true
		    });
    	});
    </script>
</body>
</html>