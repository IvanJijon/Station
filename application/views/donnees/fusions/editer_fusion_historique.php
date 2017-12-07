<form action="<?php echo base_url();?>donnees/editer_fusion_historique/<?php echo $CODE_FUSION;?>" id="form-fusion" method="post">
	<input type="hidden" id="input-listeHisto" name="listeHisto" value=""/>
	<div class="form-group">
		<div class="connectedSortable" id="div-listeHisto">
			<h4><strong><?php echo $this->lang->line('fusion-liste-historique');?></strong></h4>
			<ul id="listeHisto" class="connectedSortable">
				<?php foreach($listeHistoriques as $histo){
					if(!in_array($histo->CODE_HIST,$listeHistoriquesFusionArray)){?>
					<li id="histo-<?php echo $histo->CODE_HIST;?>"><?php echo $histo->NAME_HIST;?></li>
				<?php }}?>
			</ul>
		</div>
		<div class="sortable-selector">
			<button class="btn btn-success go-to-right" title="<?php echo $this->lang->line('fusion-btn-select-toright');?>"><i class="fa fa-chevron-circle-right"></i></button>
			<br/>
			<button class="btn btn-success go-to-left" title="<?php echo $this->lang->line('fusion-btn-select-toleft');?>"><i class="fa fa-chevron-circle-left"></i></button>
		</div>
		<div class="connectedSortable" id="div-ListeHistoFusion">
			<h4><strong><?php echo $this->lang->line('fusion-liste-historique-fusion');?></strong></h4>
			<ul id="ListeHistoFusion" class="connectedSortable">
				<?php foreach($listeHistoriquesFusion as $histo){?>
					<li id="histo-<?php echo $histo->CODE_HIST;?>"><?php echo $histo->NAME_HIST;?></li>
				<?php }?>
			</ul>
		</div>
	</div>
	<div style="clear:both;"></div>
	<br />
	<div class="modal-footer">
    	<button type="button" class="btn btn-default fenetre-close" data-dismiss="modal"><?php echo $this->lang->line('liste-close');?></button>
        <button type="button" class="btn btn-success submit-form" > <?php echo $this->lang->line('liste-valide');?></button>
    </div>
</form>
<script>
	$(document).ready(function(){
		$('.connectedSortable ul li').click(function(){
			if($(this).hasClass('selected')){
				$(this).removeClass('selected');
			}else{
				$(this).addClass('selected');
			}
		});

		$('.go-to-right').click(function(){
			$('#listeHisto li.selected').each(function(){
				$(this).removeClass('selected');
				$(this).clone().appendTo('#ListeHistoFusion');
				$(this).remove();
				refreshElemListe();
			});
			return false;
		});

		$('.go-to-left').click(function(){
			$('#ListeHistoFusion li.selected').each(function(){
				$(this).removeClass('selected');
				$(this).clone().appendTo('#listeHisto');
				$(this).remove();
				refreshElemListe();
			});
			return false;
		});

		$('.submit-form').click(function(){
			var histo = "";
			$('#ListeHistoFusion li').each(function(){
				if(histo!=""){
					histo+=";";
				}
				histo+=$(this).attr('id');
			});
			$('#input-listeHisto').val(histo);
			$('#form-fusion').submit();
		});
	});

	function refreshElemListe(){
		$('.connectedSortable ul li').unbind('click');
		$('.connectedSortable ul li').click(function(){
			if($(this).hasClass('selected')){
				$(this).removeClass('selected');
			}else{
				$(this).addClass('selected');
			}
		});
	}
</script>