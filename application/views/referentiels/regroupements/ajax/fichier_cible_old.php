			<?php if($value==""){?><td><?php }?>
				<form action="<?php echo base_url();?>referentiels/fiche_regroupement/<?php echo $CODE_EXTENSION;?>" method="post">
					<input type="hidden" name="attr" value="<?php echo $attr;?>"/>
					<div class="col-xs-3">
						<select class="form-control" name="value" required>
			        		<option value=""></option>
			            <?php foreach ($listeAttributes as $attribute) {?>
			            	<option value="<?php echo $attribute->CODE_ATTRIBUTE ;?>" <?php if($attribute->CODE_ATTRIBUTE==$value){?>selected="selected"<?php }?>><?php echo $attribute->NAME_ATTRIBUTE ;?></option>
			            <?php }?>
			            </select>
		            </div>
		            <button class="btn btn-success" type="submit"><i class="fa fa-check"></i></button>
	            </form>
            <?php if($value==""){?></td><?php }?>