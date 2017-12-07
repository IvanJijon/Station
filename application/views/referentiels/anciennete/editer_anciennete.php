<form action="<?php echo base_url();?>referentiels/editer_anciennete/<?php echo $infoAnciennete->SEN_CODE;?>" id="formAnciennete" method="post">
	<div class="alert alert-danger" id="msg-anciennete" style="display:none">
		Attention une ancienneté porte déjà ce nom
	</div>
	<input type="hidden" name="SEN_CODE" value="<?php echo $infoAnciennete->SEN_CODE ; ?>"/>
	 <div class="form-group">
    	<label><?php echo $this->lang->line('anciennete-cols0-name');?></label>
    	<input class="form-control" name="SEN_NAME" id="SEN_NAME" value="<?php echo $infoAnciennete->SEN_NAME ; ?>" required>
    </div>
    <div class="form-group">
    	<label><?php echo $this->lang->line('anciennete-cols1-name');?></label>
        <input class="form-control" name="SEN_DESC" value="<?php echo $infoAnciennete->SEN_DESC ; ?>">
    </div>    
    <div class="form-group">
    	<label><?php echo $this->lang->line('anciennete-cols2-name');?></label>
    	<select class="form-control" name="SEN_CODE_SRC_FIELD" required>
        <?php foreach ($listeAttributes as $attribute) {?>
        	<option value="<?php echo $attribute->CODE_ATTRIBUTE;?>"<?php if($attribute->CODE_ATTRIBUTE == $infoAnciennete->SEN_CODE_SRC_FIELD){echo ' selected="selected"';}?>><?php echo $listeDomainsArray[$attribute->CODE_DOMAIN]->NAME_DOMAIN ." / ". $attribute->NAME_ATTRIBUTE ;?></option>
        <?php }?>
        </select>
	</div>
    <div class="form-group">
    	<label><?php echo $this->lang->line('anciennete-cols3-name');?></label>
    	<select class="form-control" name="SEN_CODE_TGT_FIELD" required>
        <?php foreach ($listeAttributes as $attribute) {
	        if($attribute->CODE_DOMAIN == 21 && $attribute->FLG_CUSTOM == 1){?>
	        	<option value="<?php echo $attribute->CODE_ATTRIBUTE;?>"<?php if($attribute->CODE_ATTRIBUTE == $infoAnciennete->SEN_CODE_TGT_FIELD){echo ' selected="selected"';}?>><?php echo $attribute->NAME_ATTRIBUTE;?></option>
	        <?php } 
        }?>
        </select>
	</div>
    <div class="modal-footer">
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="button" class="btn btn-success" id="submit-anciennete" onclick="return verifName();"> <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>
<script>
	function verifName(){
		if($('#SEN_NAME').val()!=""){				
			$.post('<?php echo base_url()?>referentiels/check_name_anciennete/<?php echo $infoAnciennete->SEN_CODE;?>',{SEN_NAME:$('#SEN_NAME').val()},function(data){
				if(data=="true"){					
					$('#formAnciennete').submit();
				}else{
					$('#msg-anciennete').fadeIn("slow");
				}
				return false;
			});
			return false;
		}
		$array
	}
</script>