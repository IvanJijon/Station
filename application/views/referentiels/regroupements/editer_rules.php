<?php $tabChampsRules=array('SRC'=>array(),'EXT'=>array());
for($i=1;$i<=20;$i++){
	$champs="CODE_SRC_ATTR_";if(strlen($i)==1){$nb="0".$i;}else{$nb=$i;}$champs.=$nb;
	if($infoRule->infoRegroupement->$champs!=""){$tabChampsRules['SRC'][count($tabChampsRules['SRC'])]=$nb;}
}
for($i=0;$i<=20;$i++){
	$champs="CODE_EXT_ATTR_";if(strlen($i)==1){$nb="0".$i;}else{$nb=$i;}$champs.=$nb;
    if($infoRule->infoRegroupement->$champs!=""){$tabChampsRules['EXT'][count($tabChampsRules['EXT'])]=$nb;}
}
?>
<form action="<?php echo base_url();?>referentiels/editer_rule/<?php echo $infoRule->CODE_RULE;?>" method="post">
	<input type="hidden" name="CODE_EXTENSION" value="<?php echo $infoRule->CODE_EXTENSION;?>"/>
	<?php foreach($tabChampsRules['SRC'] as $nbRule){
		$champs = "CODE_SRC_ATTR_".$nbRule;
		$champ = "SRC_ATTR_".$nbRule."_VALUE";?>
		<div class="form-group">
        	<label><?php echo $listeAttributesArray[$infoRule->infoRegroupement->$champs]->NAME_ATTRIBUTE;?></label>
        	<input class="form-control" name="<?php echo $champ;?>" value="<?php echo $infoRule->$champ ; ?>" disabled>
        </div>
	<?php }?>
	<?php foreach($tabChampsRules['EXT'] as $nbRule){
		$champs = "CODE_EXT_ATTR_".$nbRule;
		$champ = "EXT_ATTR_".$nbRule."_VALUE";?>
		<div class="form-group">
        	<label><?php echo $listeAttributesArray[$infoRule->infoRegroupement->$champs]->NAME_ATTRIBUTE;?></label>
        	<input class="form-control" name="<?php echo $champ;?>" value="<?php if($infoRule->$champ!="Non défini"){echo $infoRule->$champ ;} ?>" >
        </div>
	<?php }?>
    <div class="modal-footer">
    	<div class="pull-left">(*) <?php echo $this->lang->line('champs-obligatoires');?></div>
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="submit" class="btn btn-success" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>	