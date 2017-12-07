<form action="<?php echo base_url();?>indicateurs/editer_mobilite_rubrique/<?php echo $infoIndicateurMobilite->CODE_INDICATOR;if($this->uri->segment(4)){echo "/".$this->uri->segment(4);}?>" method="post">
		<div class="form-group">
        	<label><?php echo $this->lang->line('mobilite-rubrique-attribut');?></label>
        	<select class="form-control" name="CODE_ATTRIBUTE" required>
        		<option value=""></option>
        		<?php 
        			foreach($listeAttributes as $attr){?>
        				<option value="<?php echo $attr->CODE_ATTRIBUTE?>"<?php if($infoIndicateurMobiliteRubrique->CODE_ATTRIBUTE==$attr->CODE_ATTRIBUTE){ echo ' selected="selected"'; }?>><?php echo $attr->NAME_ATTRIBUTE;?></option>
        		<?php }?>
        	</select>
       	</div>
       	<div class="form-group">
        	<label><?php echo $this->lang->line('mobilite-rubrique-dico');?></label>
        	<select class="form-control" name="MOD_FIELD" required>
        		<option value=""></option>
        		<?php 
        			foreach($listeAttributesField as $attr){
        				if(!in_array($attr->FIELD_NAME,$listeModField) || $infoIndicateurMobiliteRubrique->MOD_FIELD==$attr->FIELD_NAME){?>
        				<option value="<?php echo $attr->FIELD_NAME?>"<?php if($infoIndicateurMobiliteRubrique->MOD_FIELD==$attr->FIELD_NAME){ echo ' selected="selected"'; }?>><?php if($infoIndicateurMobiliteRubrique->MOD_FIELD==$attr->FIELD_NAME){ echo $attr->FIELD_NAME;}else{echo $attr->NAME_ATTRIBUTE;}?></option>
        			<?php }
        			}?>
        	</select>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('mobilite-rubrique-ope');?> (*)</label>
        	<select class="form-control" name="OPERATOR" required>
        		<option value=""></option>
	           	<option value="Et"<?php if($infoIndicateurMobiliteRubrique->OPERATOR=="Et"){echo ' selected="selected"';}?>><?php echo $this->lang->line('operateur-et');?></option>
	           	<option value="Ou"<?php if($infoIndicateurMobiliteRubrique->OPERATOR=="Ou"){echo ' selected="selected"';}?>><?php echo $this->lang->line('operateur-ou');?></option>
	       	</select>
        </div>
        
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	