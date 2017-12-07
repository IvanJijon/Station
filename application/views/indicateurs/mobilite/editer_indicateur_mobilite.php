<form action="<?php echo base_url();?>indicateurs/editer_indicateur_mobilite/<?php echo $infoIndicateurMobilite->CODE_INDICATOR;?>" method="post">
		<div class="form-group">
        	<label><?php echo $this->lang->line('mobilite-name');?>  (*)</label>
        	<input class="form-control" name="NAME_INDICATOR" value="<?php echo $infoIndicateurMobilite->NAME_INDICATOR ; ?>" required>
       	</div>
       	<div class="form-group">
        	<label><?php echo $this->lang->line('mobilite-description');?></label>
        		<input class="form-control" name="DESC_INDICATOR" value="<?php echo $infoIndicateurMobilite->DESC_INDICATOR ; ?>">
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('mobilite-domain');?> (*)</label>
        	<select class="form-control" name="CODE_DOMAIN" required>
        		<option value=""></option>
	            <?php foreach ($listeDomains as $domaine) {?>
	            	<option value="<?php echo $domaine->CODE_DOMAIN ;?>"<?php if($domaine->CODE_DOMAIN == $infoIndicateurMobilite->CODE_DOMAIN){echo ' selected="selected"';}?>><?php echo $domaine->NAME_DOMAIN ;?></option>
	            <?php }?>
            </select>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('mobilite-target');?></label>
        	<select class="form-control" name="TARGET_FIELD" required>
        		<option value=""></option>
        		<?php $targetBase="QC1_MOB_UDF_0";        		
        		for($i=1;$i<=50;$i++){
        			if($i<10){$nb="0".$i;}else{$nb=$i;}
        			if(!in_array($targetBase.$nb,$targetArray)){?>
        				<option value="<?php echo $targetBase.$nb?>"<?php if($infoIndicateurMobilite->TARGET_FIELD==$targetBase.$nb){ echo ' selected="selected"'; }?>><?php echo $targetBase.$nb?></option>
        		<?php }
        		}?>
        	</select>
        </div>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	