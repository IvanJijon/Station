<form action="<?php echo base_url();?>donnees/editer_origine/<?php echo $infoOrigine->CODE_ORIGIN;?>" method="post">
    	<input type="hidden" name="CODE_ORIGIN" value="<?php echo $infoOrigine->CODE_ORIGIN ; ?>"/>
    	 <div class="form-group">
        	<label><?php echo $this->lang->line('origines-cols1-name');?></label>
            <input class="form-control" name="TYPE_ORIGIN" value="<?php echo $infoOrigine->TYPE_ORIGIN ; ?>">
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('origines-cols2-name');?> (*)</label>
        	<input class="form-control" name="NAME_ORIGIN" value="<?php echo $infoOrigine->NAME_ORIGIN ; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('origines-cols3-name');?></label>
            <input class="form-control" name="DESC_ORIGIN" value="<?php echo $infoOrigine->DESC_ORIGIN ; ?>">
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('origines-cols4-name');?></label>
            <input class="form-control" name="PREFIX_ORIGIN" value="<?php echo $infoOrigine->PREFIX_ORIGIN ; ?>">
        </div>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>