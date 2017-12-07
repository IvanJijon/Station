<form action="<?php echo base_url();?>donnees/editer_fichier_source/<?php echo $infoFichierSource->CODE_FILE?>" method="post">	<div class="form-group">    	<label><?php echo $this->lang->line('fichier-source-nom-file');?> (*)</label>        <input class="form-control" name="NAME_FILE" value="<?php echo $infoFichierSource->NAME_FILE ; ?>" required>	</div>    <div class="form-group">    	<label><?php echo $this->lang->line('fichier-source-desc');?></label>        <textarea class="form-control" row="3" name="DESC_FILE"><?php echo $infoFichierSource->DESC_FILE ; ?></textarea> 	</div> 	<div class="form-group">    	<label><?php echo $this->lang->line('fichier-source-domain');?> (*)</label> 		<select class="form-control" name="CODE_DOMAIN" required> 			<option value=""></option>        	<?php foreach($listeDomains as $domain){?>        		<option value="<?php echo $domain->CODE_DOMAIN;?>" <?php if($domain->CODE_DOMAIN==$infoFichierSource->CODE_DOMAIN){?>selected="selected"<?php }?>><?php echo $domain->NAME_DOMAIN;?></option>        	<?php }?>  		</select> 	</div> 	<div class="form-group">    	<label><?php echo $this->lang->line('fichier-source-connexion');?></label> 		<select class="form-control" name="CODE_CONN"> 			<option value=""></option>        	<?php foreach($listeConnexions as $conn){?>        		<option value="<?php echo $conn->CODE_CONN;?>" <?php if($conn->CODE_CONN==$infoFichierSource->CODE_CONN){?>selected="selected"<?php }?>><?php echo $conn->NAME_CONN;?></option>        	<?php }?>  		</select> 	</div>  	<div class="form-group"> 		<label><?php echo $this->lang->line('fichier-source-chemin');?></label>    	<input class="form-control" name="FILEPATH" value="<?php echo $infoFichierSource->FILEPATH ; ?>"> 	</div> 	<div class="form-group">    	<label><?php echo $this->lang->line('fichier-source-origine');?></label> 		<select class="form-control" name="CODE_ORIGIN"> 			<option value=""></option>        	<?php foreach($listeOrigines as $origine){?>        		<option value="<?php echo $origine->CODE_ORIGIN;?>" <?php if($origine->CODE_ORIGIN==$infoFichierSource->CODE_ORIGIN){?>selected="selected"<?php }?>><?php echo $origine->NAME_ORIGIN;?></option>        	<?php }?>  		</select> 	</div>	<label><?php echo $this->lang->line('fichier-source-options');?></label>	<div class="row">		<div class="col-md-6">			<div class="checkbox">				<label>					<input type="checkbox" name="FLG_OPTIONAL" value="1"<?php if($infoFichierSource->FLG_OPTIONAL==1){?> checked="checked"<?php }?>/> 					<?php echo $this->lang->line('fichier-source-option');?>				</label>			</div>			<div class="checkbox">				<label>					<input type="checkbox" name="FLG_DUPLICATE" value="1"<?php if($infoFichierSource->FLG_DUPLICATE==1){?> checked="checked"<?php }?>/> 					<?php echo $this->lang->line('fichier-source-del-doublon');?>				</label>			</div>		</div>		<div class="col-md-6">			<div class="checkbox">				<label>					<input type="checkbox" name="FLG_HIST" value="1"<?php if($infoFichierSource->FLG_HIST==1){?> checked="checked"<?php }?>/> 					<?php echo $this->lang->line('fichier-source-gestion-historique');?>				</label>			</div>			<div class="checkbox">				<label>					<input type="checkbox" name="FLG_CVT" value="1"<?php if($infoFichierSource->FLG_CVT==1){?> checked="checked"<?php }?>/> 					<?php echo $this->lang->line('fichier-source-conversion');?>				</label>			</div>		</div>	</div>	<div class="modal-footer">    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>    </div></form>