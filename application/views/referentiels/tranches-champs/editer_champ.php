<form action="<?php echo base_url();?>referentiels/editer_champ/<?php echo $infoChamp->CODE_SLICE_FIELD;?>" method="post">
	<input type="hidden" name="CODE_SLICE_FIELD" value="<?php echo $infoChamp->CODE_SLICE_FIELD ; ?>"/>
	 <div class="form-group">
    	<label><?php echo $this->lang->line('champs-cols0-name');?></label>
    	<input class="form-control" name="NAME_SLICE_FIELD" value="<?php echo $infoChamp->NAME_SLICE_FIELD ; ?>" required>
    </div>
    <div class="form-group">
    	<label><?php echo $this->lang->line('champs-cols1-name');?></label>
        <input class="form-control" name="NAME_TABLE" value="<?php echo $infoChamp->NAME_TABLE ; ?>">
    </div>
    <div class="form-group">
    	<label><?php echo $this->lang->line('champs-cols2-name');?></label>
        <input class="form-control" name="NAME_FIELD_SOURCE" value="<?php echo $infoChamp->NAME_FIELD_SOURCE ; ?>">
    </div>
    <div class="form-group">
    	<label><?php echo $this->lang->line('champs-cols3-name');?></label>
        <input class="form-control" name="NAME_FIELD_TARGET" value="<?php echo $infoChamp->NAME_FIELD_TARGET ; ?>">
    </div>
    <div class="modal-footer">
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>