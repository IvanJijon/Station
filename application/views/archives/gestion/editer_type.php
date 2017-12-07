<form action="<?php echo base_url();?>archives/editer_type/<?php echo $infoArchiveType->CODE_TYPE_ARCHIVE;?>" method="post">
    	<input type="hidden" name="CODE_TYPE_ARCHIVE" value="<?php echo $infoArchiveType->CODE_TYPE_ARCHIVE ; ?>"/>
    	 <div class="form-group">
        	<label><?php echo $this->lang->line('archives-type-cols0-name');?> (*)</label>
        	<input class="form-control" name="NAME_TYPE_ARCHIVE" value="<?php echo $infoArchiveType->NAME_TYPE_ARCHIVE ; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('archives-type-cols1-name');?></label>
            <input class="form-control" name="DESC_TYPE_ARCHIVE" value="<?php echo $infoArchiveType->DESC_TYPE_ARCHIVE ; ?>">
        </div>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>