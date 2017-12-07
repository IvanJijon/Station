<form action="<?php echo base_url();?>referentiels/editer_regroupement/<?php echo $infoRegroupement->CODE_EXTENSION;?>" method="post">
    	 <div class="form-group">
        	<label><?php echo $this->lang->line('regroupement-cols-name');?> (*)</label>
        	<input class="form-control" name="NAME_EXTENSION" value="<?php echo $infoRegroupement->NAME_EXTENSION ; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('regroupement-cols-desc');?></label>
            <textarea class="form-control" row="3" name="DESC_EXTENSION"><?php echo $infoRegroupement->DESC_EXTENSION ; ?></textarea>
        </div>
      	<div class="form-group">
        	<label><?php echo $this->lang->line('regroupement-cols-domain');?> (*)</label>
        	<select class="form-control" name="CODE_DOMAIN" id="CODE_DOMAIN" required>
        		<option value=""></option>
            <?php foreach ($listeDomains as $domaine) {?>
            	<option value="<?php echo $domaine->CODE_DOMAIN ;?>"<?php if($domaine->CODE_DOMAIN == $infoRegroupement->CODE_DOMAIN){echo ' selected="selected"';}?>><?php echo $domaine->NAME_DOMAIN ;?></option>
            <?php }?>
            </select>
    	</div>
    	
    	<div class="row" id="attributs">
                <div class="col-lg-12">
                	<div class="alert alert-danger" style="display:none;">
                		<?php echo $this->lang->line('alert-domain');?>
                	</div>
                    <div class="panel panel-info" id="panel-sources">
                        <div class="panel-heading">
                           	<i class="fa fa-hand-o-left"></i> <?php echo $this->lang->line('regroupement-liste-attributs-sources');?>
                           	<div class="pull-right">
                           		<button class="btn btn-success btn-xs add-source"><i class="fa fa-plus-circle"></i></button>
							</div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	<?php for($i=1;$i<=20;$i++){
                                   $champs="CODE_SRC_ATTR_";
                                   if(strlen($i)==1){$nb="0".$i;}else{$nb=$i;}
                                   $champs.=$nb;
                                   if($infoRegroupement->$champs!="" && $infoRegroupement->$champs!=0){?>
			                       	<div class="form-group col-xs-4" id="<?php echo $champs;?>">
							        	<label><?php echo $this->lang->line('regroupement-'.$champs);?></label>
							        	<select class="form-control" name="<?php echo $champs;?>">
							        		<option value=""></option>
							            <?php foreach ($listeAttributesSources as $attribute) {?>
							            	<option value="<?php echo $attribute->CODE_ATTRIBUTE ;?>" <?php if($attribute->CODE_ATTRIBUTE==$infoRegroupement->$champs){?>selected="selected"<?php }?>><?php echo $attribute->NAME_ATTRIBUTE ;?></option>
							            <?php }?>
							            </select>
							    	</div>
							   <?php }
                              }?>
	               		</div>
	               	</div>
	               	
	               	<div class="panel panel-info" id="panel-cibles">
                        <div class="panel-heading">
                           	<i class="fa fa-hand-o-right"></i> <?php echo $this->lang->line('regroupement-liste-attributs-cibles');?>
                           	<div class="pull-right">
                           		<button class="btn btn-success btn-xs add-cible"><i class="fa fa-plus-circle"></i></button>
							</div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	<?php for($i=1;$i<=20;$i++){
                                   $champs="CODE_EXT_ATTR_";
                                   if(strlen($i)==1){$nb="0".$i;}else{$nb=$i;}
                                   $champs.=$nb;
                                   if($infoRegroupement->$champs!="" && $infoRegroupement->$champs!=0){?>
			                       	<div class="form-group col-xs-4" id="<?php echo $champs;?>">
							        	<label><?php echo $this->lang->line('regroupement-'.$champs);?></label>
							        	<select class="form-control" name="<?php echo $champs;?>">
							        		<option value=""></option>
							            <?php foreach ($listeAttributesCibles as $attribute) {?>
							            	<option value="<?php echo $attribute->CODE_ATTRIBUTE ;?>" <?php if($attribute->CODE_ATTRIBUTE==$infoRegroupement->$champs){?>selected="selected"<?php }?>><?php echo $attribute->NAME_ATTRIBUTE ;?></option>
							            <?php }?>
							            </select>
							    	</div>
							   <?php }
                              }?>
	               		</div>
	               	</div>
	         	</div>
	         	
            </div>	    	
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	
<script>
	$(document).ready(function(){
		$('.add-source').click(function(){
			if(!verifDomain()){
				return false;
			}
			var listeAttrSource = "";
			var nbSource = 0;
			$('#panel-sources .panel-body .form-group').each(function(){
				if(listeAttrSource!=""){listeAttrSource+=";";}
				listeAttrSource+=$(this).attr('id');
				nbSource++;
			});
			if(nbSource<20){
				$.post('<?php echo base_url();?>referentiels/ajax_regroupement',{listeElem:listeAttrSource,type:"sources",CODE_DOMAIN:$("#CODE_DOMAIN").val()},function(data){
					$('#panel-sources .panel-body').append(data);
				});
			}
			return false;
		});

		$('.add-cible').click(function(){
			var listeAttrCible = "";
			var nbCible = 0;
			$('#panel-cibles .panel-body .form-group').each(function(){
				if(listeAttrCible!=""){listeAttrCible+=";";}
				listeAttrCible+=$(this).attr('id');
				nbCible++;
			});
			if(nbCible<20){
				$.post('<?php echo base_url();?>referentiels/ajax_regroupement',{listeElem:listeAttrCible,type:"cibles",CODE_DOMAIN:$("#CODE_DOMAIN").val()},function(data){
					$('#panel-cibles .panel-body').append(data);
				});
			}
			return false;
		});

		$('#CODE_DOMAIN').change(function(){
			$('#panel-sources .panel-body').html('');
			$('#panel-cibles .panel-body').html('');
			$(".alert-danger").fadeOut('slow');
		})
	});

	function verifDomain(){
		if($("#CODE_DOMAIN").val()==""){
			$(".alert-danger").fadeIn('slow');
			return false;
		}else{
			$(".alert-danger").fadeOut('slow');
			return true;
		}
		
	}
</script>