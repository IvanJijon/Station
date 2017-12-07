<form action="<?php echo base_url();?>configuration/editer_module/<?php echo $infoModule->ITEM_ID;?>" method="post">
    	<input type="hidden" name="ITEM_ID" value="<?php echo $infoModule->ITEM_ID ; ?>"/>
		<div class="form-group">
        	<label><?php echo $this->lang->line('modules-cols0-name');?> (*)</label>
        	<input class="form-control" name="ITEM_NAME" value="<?php echo $infoModule->ITEM_NAME ; ?>" required>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('modules-cols1-name');?></label>
            <input class="form-control" name="ITEM_ORDER" value="<?php echo $infoModule->ITEM_ORDER ; ?>">
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('modules-cols2-name');?></label>
            <select class="form-control" name="PARENT_ID" required>
            	<option value="0">Créer un module à la racine (catégorie de modules)</option>
            <?php foreach ($listeModules as $module) {?>
            	<option value="<?php echo $module->ITEM_ID ;?>"<?php if($module->ITEM_ID == $infoModule->PARENT_ID){echo ' selected="selected"';}?>><?php echo $module->ITEM_NAME ;?></option>
            <?php }?>
            </select>
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('modules-cols3-name');?></label>
            <input class="form-control" name="CONF" value="<?php echo $infoModule->CONF ; ?>">
        </div>
        <div class="form-group">
        	<label><?php echo $this->lang->line('modules-cols9-name');?></label>
			<input class="form-control" name="ITEM_ICON" value="<?php echo $infoModule->ITEM_ICON ; ?>">
        </div>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	