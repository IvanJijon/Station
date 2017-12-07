 							<div class="form-group col-xs-3">
					        	<label><?php echo $this->lang->line('regroupement-'.$attr);?></label>
					        	<select class="form-control" name="<?php echo $attr;?>">
					        		<option value=""></option>
					            <?php foreach ($listeAttributes as $attribute) {?>
					            	<option value="<?php echo $attribute->CODE_ATTRIBUTE ;?>"><?php echo $attribute->NAME_ATTRIBUTE ;?></option>
					            <?php }?>
					            </select>
					    	</div>