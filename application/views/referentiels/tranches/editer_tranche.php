<form action="<?php echo base_url();?>referentiels/editer_tranche/<?php echo $infoTranche->CODE_SLICE;?>" method="post">		       	
        <div class="form-group">
        	<label><?php echo $this->lang->line('tranche-code');?> (*)</label>
        	<input class="form-control" name="CODE_USER" value="<?php echo $infoTranche->CODE_USER ; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('tranche-name');?>  (*)</label>
        	<input class="form-control" name="NAME_SLICE" value="<?php echo $infoTranche->NAME_SLICE ; ?>" required>
       	</div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('tranche-description');?> (*)</label>
        	<textarea class="form-control" name="DESC_SLICE" required><?php echo $infoTranche->DESC_SLICE ; ?></textarea>
        </div>
		<div class="form-group">
    	<label><?php echo $this->lang->line('tranche-champs-associe');?></label>
	 		<select class="form-control" name="CODE_SLICE_FIELD">
	 			<option value=""></option>
	        	<?php foreach($listeChamps as $champs){?>
	        		<option value="<?php echo $champs->CODE_SLICE_FIELD;?>" <?php if($champs->CODE_SLICE_FIELD==$infoTranche->CODE_SLICE_FIELD){?>selected="selected"<?php }?>><?php echo $champs->NAME_SLICE_FIELD;?></option>
	        	<?php 
	        	}?>
	  		</select>
	 	</div>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	