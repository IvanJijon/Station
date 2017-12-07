<form action="<?php echo base_url();?>archives/editer_archive/<?php echo $infoArchive->CODE_ARCHIVE;?>" method="post">
	<input type="hidden" name="CODE_ARCHIVE" value="<?php echo $infoArchive->CODE_ARCHIVE ; ?>"/>
	 <div class="form-group">
    	<label><?php echo $this->lang->line('archives-cols0-name');?> (*)</label>
    	<input class="form-control" name="NAME_ARCHIVE" value="<?php echo $infoArchive->NAME_ARCHIVE ; ?>" required>
    </div>
    <div class="form-group">
    	<label><?php echo $this->lang->line('archives-cols1-name');?></label>
        <input class="form-control" name="DESC_ARCHIVE" value="<?php echo $infoArchive->DESC_ARCHIVE ; ?>">
    </div>
    <div class="form-group">
    	<label><?php echo $this->lang->line('archives-cols2-name');?> (*)</label>
    	<select class="form-control" name="CODE_TYPE_ARCHIVE" required>
        <?php foreach ($listeArchivesTypes as $types) {?>
        	<option value="<?php echo $types->CODE_TYPE_ARCHIVE ;?>"<?php if($types->CODE_TYPE_ARCHIVE == $infoArchive->CODE_TYPE_ARCHIVE){echo ' selected="selected"';}?>><?php echo $types->NAME_TYPE_ARCHIVE ;?></option>
        <?php }?>
        </select>
	</div>
	<div class="col-md-12">
		<div class="form-group col-md-6" style="display:inline">
			<label><?php echo $this->lang->line('archives-cols3-name');?> (*)</label>
            <div class="input-append input-group date" id="dt" data-date="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy">
            	<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                <input id="DAT_BEG" class="form-control" name="DAT_BEG" size="10" type="text" value="<?php if ($infoArchive->DAT_BEG !="") echo dateSqlToDate($infoArchive->DAT_BEG) ; ?>" required>
            </div>
		</div>
		<div class="form-group col-md-6" style="display:inline">
			<label><?php echo $this->lang->line('archives-cols4-name');?> (*)</label>
	    	<div class="input-append input-group date" id="dt" data-date="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy">
	        	<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
	            <input id="DAT_END" class="form-control" name="DAT_END" data-date-format="dd/mm/yyyy" size="16" type="text" value="<?php if ($infoArchive->DAT_END !="") echo dateSqlToDate($infoArchive->DAT_END) ; ?>" required>
	        </div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group col-md-6" style="display:inline">
			<label><?php echo $this->lang->line('archives-cols5-name');?></label>
		    <input class="form-control" disabled="" name="DAT_LAST_RUN" value="<?php if ($infoArchive->DAT_LAST_RUN !="") echo dateSqlToDate($infoArchive->DAT_LAST_RUN) ; ?>">
		</div>
		<div class="form-group col-md-6" style="display:inline">
			<label><?php echo $this->lang->line('archives-cols6-name');?></label>
			<div class="input-append input-group date" id="dt" data-date="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy">
            	<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                <input id="DAT_NEXT_RUN" class="form-control" name="DAT_NEXT_RUN" data-date-format="dd/mm/yyyy" size="16" type="text" value="<?php if ($infoArchive->DAT_NEXT_RUN !="") echo dateSqlToDate($infoArchive->DAT_NEXT_RUN) ; ?>">
            </div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group col-md-6" style="display:inline">
			<label><?php echo $this->lang->line('archives-cols7-name');?></label>
		    <input class="form-control" disabled="" name="DAT_LAST_DEL" value="<?php if ($infoArchive->DAT_LAST_DEL !="") echo dateSqlToDate($infoArchive->DAT_LAST_DEL) ; ?>">
		</div>
		<div class="form-group col-md-6" style="display:inline">
			<label><?php echo $this->lang->line('archives-cols8-name');?></label>
        	<div class="input-append input-group date" id="dt" data-date="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy">
            	<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                <input id="DAT_NEXT_DEL" class="form-control" name="DAT_NEXT_DEL" data-date-format="dd/mm/yyyy" size="16" type="text" value="<?php if ($infoArchive->DAT_NEXT_DEL !="") echo dateSqlToDate($infoArchive->DAT_NEXT_DEL) ; ?>">
            </div>
		</div>
	</div>
    <div class="form-group">
    	<label><?php echo $this->lang->line('archives-cols9-name');?></label>
        <input class="form-control" disabled="" name="ARC_FLG_LAST" value="<?php echo $infoArchive->ARC_FLG_LAST ; ?>">
    </div>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>