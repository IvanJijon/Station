<form action="<?php echo base_url();?>configuration/editer_sequence_step/<?php echo $this->uri->segment(3);if($infoStepSequence->CODE_STEP!=""){?>/<?php echo $infoStepSequence->CODE_STEP;}?>" method="post">
		<div class="form-group">
    		<label><?php echo $this->lang->line('sequence-step-name-job');?>  (*)</label>
	 		<select class="form-control" name="CODE_JOB" required>
	 			<option value=""></option>
	        	<?php foreach($listeJobs as $job){?>
	        		<option value="<?php echo $job->CODE_JOB;?>" <?php if($job->CODE_JOB==$infoStepSequence->CODE_JOB){?>selected="selected"<?php }?>><?php echo $job->NAME_JOB;?></option>
	        	<?php 
	        	}?>
	  		</select>
	 	</div>
		<div class="form-group">
        	<label><?php echo $this->lang->line('sequence-step-name');?>  (*)</label>
        	<input class="form-control" name="NAME_STEP" value="<?php echo $infoStepSequence->NAME_STEP ; ?>" required>
       	</div>
       	<div class="form-group">
        	<label><?php echo $this->lang->line('sequence-step-description');?></label>
        		<textarea class="form-control" name="DESC_STEP"><?php echo $infoStepSequence->DESC_STEP ; ?></textarea>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('sequence-step-projet');?> (*)</label>
        	<input class="form-control" name="PROJECT" value="<?php echo $infoStepSequence->PROJECT ; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('sequence-step-chemin-files');?></label>
        	<input class="form-control" name="CLASSPATH" value="<?php echo $infoStepSequence->CLASSPATH ; ?>" >
        </div>
       	<div class="form-group">
        	<label><?php echo $this->lang->line('sequence-step-chemin-job');?> (*)</label>
        	<input class="form-control" name="JOB_FOLDER" value="<?php echo $infoStepSequence->JOB_FOLDER ; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('sequence-step-chemin-librairy');?> (*)</label>
        	<input class="form-control" name="LIB_FOLDER" value="<?php echo $infoStepSequence->LIB_FOLDER ; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('sequence-step-param-java-xms');?> (*)</label>
        	<input class="form-control" name="JAVA_XMS" value="<?php echo $infoStepSequence->JAVA_XMS ; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('sequence-step-param-java-xmx');?> (*)</label>
        	<input class="form-control" name="JAVA_XMX" value="<?php echo $infoStepSequence->JAVA_XMX ; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('sequence-step-index');?> (*)</label>
        	<input class="form-control" name="STEP_ORDER" value="<?php echo $infoStepSequence->STEP_ORDER ; ?>" required>
        </div>
        <div class="form-group">
			<label><?php echo $this->lang->line('sequence-step-flg-exec');?></label>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="FLG_EXEC" value="1"<?php if($infoStepSequence->FLG_EXEC==1){?> checked="checked"<?php }?>/>
				</label>
			</div>
		</div>
		<div class="form-group">
			<label><?php echo $this->lang->line('sequence-step-flg-stop');?></label>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="FLG_STOP" value="1"<?php if($infoStepSequence->FLG_STOP==1){?> checked="checked"<?php }?>/>
				</label>
			</div>
		</div>
		<div class="form-group">
    	<label><?php echo $this->lang->line('sequence-step-contexte');?></label>
	 		<input class="form-control" name="STEP_CONTEXT" value="<?php echo $infoStepSequence->STEP_CONTEXT ; ?>" >
	 	</div>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	