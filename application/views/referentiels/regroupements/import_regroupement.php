<div class="text-center">
	<form action="<?php echo base_url();?>referentiels/import_regroupement/<?php echo $CODE_EXTENSION;?>" method="post" enctype="multipart/form-data">
		<div class="fileupload fileupload-new" data-provides="fileupload">
	        <span class="btn btn-warning btn-file">
	        <span class="fileupload-new"><i class="fa fa-paperclip"> </i> Choisir le <?php echo $this->lang->line('fichier-excel');?> </span>
	        <span class="fileupload-exists"><i class="fa fa-undo"></i> Modifier le <?php echo $this->lang->line('fichier-excel');?></span>
	        <input type="file" class="default" name="file" accept="application/xls" required/>
	        </span>
	          <span class="fileupload-preview" style="margin-left:5px;"></span>
	          <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
	    </div>
		<div class="modal-footer">
	    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
	        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
	    </div>
	</form>
</div>