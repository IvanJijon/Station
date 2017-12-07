<form action="<?php echo base_url();?>securite/editer_profil/<?php echo $infoProfil->CODE_PROFILE;?>" method="post">
	
    	<input type="hidden" name="CODE_PROFILE" value="<?php echo $infoProfil->CODE_PROFILE ; ?>"/>
    	 <div class="form-group">
        	<label><?php echo $this->lang->line('profils-cols0-name');?></label>
        	<input class="form-control" name="NAME_PROFILE" value="<?php echo $infoProfil->NAME_PROFILE ; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('profils-cols1-name');?></label>
            <input class="form-control" name="DESC_PROFILE" value="<?php echo $infoProfil->DESC_PROFILE ; ?>">
        </div>
        
        <div class="form-group">
        	<label><?php echo $this->lang->line('profils-cols2-name');?></label>
        	<select class="form-control" name="COLUMN_PROFILE" required>
            	<option value="PROFILE01" <?php if($infoProfil->COLUMN_PROFILE == "PROFILE01"){echo ' selected="selected"';}?>>PROFILE01</option>
            	<option value="PROFILE02" <?php if($infoProfil->COLUMN_PROFILE == "PROFILE02"){echo ' selected="selected"';}?>>PROFILE02</option>
            	<option value="PROFILE03" <?php if($infoProfil->COLUMN_PROFILE == "PROFILE03"){echo ' selected="selected"';}?>>PROFILE03</option>
            	<option value="PROFILE04" <?php if($infoProfil->COLUMN_PROFILE == "PROFILE04"){echo ' selected="selected"';}?>>PROFILE04</option>
            	<option value="PROFILE05" <?php if($infoProfil->COLUMN_PROFILE == "PROFILE05"){echo ' selected="selected"';}?>>PROFILE05</option>
            </select>
    	</div>
    <div class="modal-footer">
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	