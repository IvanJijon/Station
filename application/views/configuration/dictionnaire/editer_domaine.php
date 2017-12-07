<form action="<?php echo base_url();?>configuration/editer_domaine/<?php echo $infoDomaine->CODE_DOMAIN;?>" method="post">		<div class="form-group">        	<label><?php echo $this->lang->line('dictionnaire-name');?></label>        	<select name="CODE_DICTIONARY" class="form-control" required>        		<?php foreach($dictionnairesExistants as $dictionnaire){?>        			<option value="<?php echo $dictionnaire->CODE_DICTIONARY?>"<?php if($infoDomaine->CODE_DICTIONARY==$dictionnaire->CODE_DICTIONARY){?> selected="selected"<?php }?>><?php echo $dictionnaire->NAME_DICTIONARY;?></option>        		<?php }?>        	</select>        </div>						<div class="form-group">
        	<label><?php echo $this->lang->line('domain-name');?>  (*)</label>
        	<input class="form-control" name="NAME_DOMAIN" value="<?php echo $infoDomaine->NAME_DOMAIN ; ?>" required>
       	</div>
       	<div class="form-group">
        	<label><?php echo $this->lang->line('domain-description');?></label>
        	<textarea class="form-control" name="DESC_DOMAIN"><?php echo $infoDomaine->DESC_DOMAIN ; ?></textarea>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('domain-table');?></label>
        	<input class="form-control" name="TABLE_NAME" value="<?php echo $infoDomaine->TABLE_NAME ; ?>">
        </div>				<div class="form-group">        	<label><?php echo $this->lang->line('domain-struct-orga');?></label>        	<div class="checkbox">        		<label><input type="checkbox" name="FLG_ORG" value="1" <?php if($infoDomaine->FLG_ORG==1){?>checked="checked"<?php }?>></label>        	</div>        </div>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	