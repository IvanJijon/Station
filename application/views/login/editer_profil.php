<form action="<?php echo base_url();?>main/editer_profil" method="post">
    	 <div class="form-group">
        	<label><?php echo $this->lang->line('profiluser-username');?> (*)</label>
        	<input class="form-control" name="USERNAME" value="<?php echo $_SESSION['session-bihrdy']['infoUser']['USERNAME']; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('profiluser-fullname');?></label>
            <input class="form-control" name="FULLNAME" value="<?php echo $_SESSION['session-bihrdy']['infoUser']['FULLNAME']; ?>">
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('profiluser-lang');?></label>
        	<select class="form-control" name="LANG">
        		<option value=""></option>
        		<option value="fr"<?php if($_SESSION['session-bihrdy']['infoUser']['LANG']=="fr"){echo ' selected="selected"';}?>>Français</option>
        		<option value="en"<?php if($_SESSION['session-bihrdy']['infoUser']['LANG']=="en"){echo ' selected="selected"';}?>>English</option>
        	</select>
        </div>
      	 <div class="form-group">
        	<label><?php echo $this->lang->line('profiluser-password');?></label>
            <input class="form-control" name="PASSWORD" value="">
            <p class="help-block"><?php echo $this->lang->line('profiluser-password-no-change');?></p>
        </div>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	