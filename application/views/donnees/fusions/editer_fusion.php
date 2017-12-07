<form action="<?php echo base_url();?>donnees/editer_fusion/<?php echo $infoFusion->CODE_FUSION;?>" method="post">
		<div class="form-group">
        	<label><span class="color-label"><?php echo $this->lang->line('fusion-title-talend');?></span> - <?php echo $this->lang->line('fusion-code-talend');?>  (*)</label>
        	<input class="form-control" name="CODE_TALEND" value="<?php echo $infoFusion->CODE_TALEND ; ?>" required>
       	</div>
       	<div class="form-group">
        	<label><span class="color-label"><?php echo $this->lang->line('fusion-title-fusion');?></span> - <?php echo $this->lang->line('fusion-nom');?></label>
        	<input class="form-control" name="NAME_FUSION" value="<?php echo $infoFusion->NAME_FUSION ; ?>">
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('fusion-desc');?></label>
        	<textarea class="form-control" row="3" name="DESC_FUSION"><?php echo $infoFusion->DESC_FUSION ; ?></textarea>
        </div>
        <div class="form-group">
        	<label><span class="color-label"><?php echo $this->lang->line('fusion-title-cible');?></span> - <?php echo $this->lang->line('fusion-table-cible');?></label>
        	<input class="form-control" name="TARGET_TABLE" value="<?php echo $infoFusion->TARGET_TABLE ; ?>">
        </div>
        <div class="form-group">
        	<label><span class="color-label"><?php echo $this->lang->line('fusion-title-fichier');?></span> - <?php echo $this->lang->line('fusion-fichier');?></label>
        	<input class="form-control" name="FILE_NAME" value="<?php echo $infoFusion->FILE_NAME ; ?>">
        </div>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	