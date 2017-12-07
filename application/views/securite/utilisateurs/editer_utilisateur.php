<form action="<?php echo base_url();?>securite/editer_utilisateur/<?php echo $infoUtilisateur->CODE_USER;?>" method="post">
	
    	<input type="hidden" name="CODE_USER" value="<?php echo $infoUtilisateur->CODE_USER ; ?>"/>
    	 <div class="form-group">
        	<label><?php echo $this->lang->line('utilisateur-cols0-name');?> (*)</label>
        	<input class="form-control" name="USERNAME" value="<?php echo $infoUtilisateur->USERNAME ; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('utilisateur-cols1-name');?></label>
            <input class="form-control" name="FULLNAME" value="<?php echo $infoUtilisateur->FULLNAME ; ?>">
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('utilisateur-password');?> (*)</label>
            <input class="form-control" name="PASSWORD" value="" <?php if($infoUtilisateur->CODE_USER==""){?>required<?php }?>>
            <?php if($infoUtilisateur->PASSWORD!=""){?>
            <p class="help-block"><?php echo $this->lang->line('utilisateur-password-edit');?></p>
            <?php }?>
        </div>
      	<div class="form-group">
        	<label><?php echo $this->lang->line('utilisateur-cols2-name');?> (*)</label>
        	<select class="form-control" name="CODE_PROFILE" required>
            <?php foreach ($listeProfils as $profil) {?>
            	<option value="<?php echo $profil->CODE_PROFILE ;?>"<?php if($profil->CODE_PROFILE == $infoUtilisateur->CODE_PROFILE){echo ' selected="selected"';}?>><?php echo $profil->NAME_PROFILE ;?></option>
            <?php }?>
            </select>
    	</div>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	