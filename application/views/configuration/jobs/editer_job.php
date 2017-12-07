<form action="<?php echo base_url();?>configuration/editer_job/<?php echo $infoJob->CODE_JOB;?>" method="post">
		<div class="form-group">
        	<label><?php echo $this->lang->line('job-name');?>  (*)</label>
        	<input class="form-control" name="NAME_JOB" value="<?php echo $infoJob->NAME_JOB ; ?>" required>
       	</div>
       	<div class="form-group">
        	<label><?php echo $this->lang->line('job-description');?></label>
        	<textarea class="form-control" name="DESC_JOB"><?php echo $infoJob->DESC_JOB ; ?></textarea>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('job-version');?></label>
        	<input class="form-control" name="VERSION" value="<?php echo $infoJob->VERSION ; ?>">
        </div>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	