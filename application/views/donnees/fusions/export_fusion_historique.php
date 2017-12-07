<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<table>
	<thead>
		<tr>
	    	<th width="200"><?php echo $this->lang->line('fusion-code-historique');?></th>
            <th width="200"><?php echo $this->lang->line('fusion-master-historique');?></th>
        </tr>
	</thead>
	<tbody>
    <?php foreach($infoFusion->listeHistoriques as $histo){?>
		<tr>
			<td bg-color="#000;"><?php echo $histo->NAME_HIST;?></td>
            <td width="200"><?php if($histo->FLG_MASTER_HIST==1){echo $this->lang->line('yes');}else{echo $this->lang->line('no');}?></td>
		</tr>
	<?php }?>
	</tbody>
</table>