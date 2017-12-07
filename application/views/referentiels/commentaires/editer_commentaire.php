<form action="<?php echo base_url();?>referentiels/editer_commentaire/<?php echo $infoCommentaire->CODE_CONTENT;?>" method="post">
	<input type="hidden" name="CODE_CONTENT" value="<?php echo $infoCommentaire->CODE_CONTENT ; ?>"/>
	 <div class="form-group">
    	<label><?php echo $this->lang->line('commentaires-cols0-name');?></label>
    	<input class="form-control" disabled="" name="CODE_CONTENT" value="<?php echo $infoCommentaire->CODE_CONTENT;?>" required>
    </div>
    <div class="form-group">
    	<label><?php echo $this->lang->line('anciennete-cols1-name');?></label>
    	<select class="form-control" name="CODE_TYPE" required>
	        	<option value="1"<?php if($infoCommentaire->CODE_TYPE == "Standard"){echo ' selected="selected"';}?>>Standard</option>
        </select>
	</div>
	<div class="form-group">
    	<label><?php echo $this->lang->line('anciennete-cols2-name');?></label>
    	<select class="form-control" name="CODE_LANG" required>
	        	<option value="FR"<?php if($infoCommentaire->CODE_LANG == "FR"){echo ' selected="selected"';}?>>Français</option>
	        	<option value="EN"<?php if($infoCommentaire->CODE_LANG == "EN"){echo ' selected="selected"';}?>>English</option>
        </select>
	</div>
    <div class="form-group">
    	<label><?php echo $this->lang->line('commentaires-cols3-name');?></label>
        <input class="form-control" name="DESC_CONTENT" value="<?php echo $infoCommentaire->DESC_CONTENT ; ?>" required>
    </div>
    <div class="modal-footer">
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>