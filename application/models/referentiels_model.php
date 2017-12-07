<?php
class Referentiels_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/***********************************************************
	 *   						Regroupements  			       *
	 ***********************************************************/

	function listeRegroupements () {
		
		$this->db->join('QC1_REP_QDD_DOMAIN','QC1_REP_QDD_DOMAIN.CODE_DOMAIN=QC1_REP_MTA_EXTENSION.CODE_DOMAIN');
		
		//On ordonne les enregistrement par le NAME_EXTENSION par ordre croissant
		$this->db->order_by('NAME_EXTENSION', 'ASC');
		// Puis on sort les éléments de la table QC1_REP_MTA_EXTENSION
		return  $this->db->get('QC1_REP_MTA_EXTENSION')->result();	
	}
	
	function infoRegroupement($CODE_EXTENSION){
		$this->db->join('QC1_REP_QDD_DOMAIN','QC1_REP_QDD_DOMAIN.CODE_DOMAIN=QC1_REP_MTA_EXTENSION.CODE_DOMAIN');
		$infoRegroupement = $this->db->get_where('QC1_REP_MTA_EXTENSION',array('CODE_EXTENSION'=>$CODE_EXTENSION))->result();	
		
		//
		$infoRegroupement[0]->listeRules = $this->db->get_where('QC1_REP_MTA_RULE',array('CODE_EXTENSION'=>$CODE_EXTENSION))->result();
		
		return $infoRegroupement[0];
	}
	
	function infoRules($CODE_RULE){
		$infoRules = $this->db->get_where('QC1_REP_MTA_RULE',array('CODE_RULE'=>$CODE_RULE))->result();
		$infoRegroupement = $this->db->get_where('QC1_REP_MTA_EXTENSION',array('CODE_EXTENSION'=>$infoRules[0]->CODE_EXTENSION))->result();
		$infoRules[0]->infoRegroupement = $infoRegroupement[0];
		
		return $infoRules[0];
	}
	
	function editeRegroupement($myArray,$CODE_EXTENSION=""){
		
		if($CODE_EXTENSION!=""){
			// Création du logs avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_REP_MTA_EXTENSION','',$CODE_EXTENSION,'CODE_EXTENSION');
			
			$this->db->where('CODE_EXTENSION',$CODE_EXTENSION);
			$this->db->update('QC1_REP_MTA_EXTENSION',$myArray);
		}else{
			// Insertion de la fusion
			$this->main_model->actionLogs('INSERT','QC1_REP_MTA_EXTENSION',$myArray,$CODE_EXTENSION);
			
			$nb = $this->db->get('QC1_REP_MTA_EXTENSION')->num_rows();
			$myArray['INDEX_EXTENSION']=$nb+1;
			$this->db->insert('QC1_REP_MTA_EXTENSION',$myArray);
		}
	}
	
	function updateRules($CODE_RULE,$myArray){		
		$this->main_model->actionLogs('UPDATE','QC1_REP_MTA_RULE','',$CODE_RULE,'CODE_RULE');
		$this->db->where('CODE_RULE',$CODE_RULE);
		$this->db->update('QC1_REP_MTA_RULE',$myArray);
	}
	
	function updateRegroupement($CODE_EXTENSION,$myArray){
		$this->main_model->actionLogs('UPDATE','QC1_REP_MTA_EXTENSION','',$CODE_EXTENSION,'CODE_EXTENSION');
		$this->db->where('CODE_EXTENSION',$CODE_EXTENSION);
		$this->db->update('QC1_REP_MTA_EXTENSION',array($myArray['attr']=>$myArray['value']));
	}
	
	function supprimerRegroupement($CODE_EXTENSION){
		$this->main_model->actionLogs('DELETE','QC1_REP_MTA_EXTENSION','',$CODE_EXTENSION,'CODE_EXTENSION');
		$this->db->delete('QC1_REP_MTA_EXTENSION',array('CODE_EXTENSION'=>$CODE_EXTENSION));
		$this->main_model->actionLogs('DELETE','QC1_REP_MTA_RULE','',$CODE_EXTENSION,'CODE_EXTENSION');
		$this->db->delete('QC1_REP_MTA_RULE',array('CODE_EXTENSION'=>$CODE_EXTENSION));
	}
	
	function listeDomains(){
		$this->db->order_by('NAME_DOMAIN', 'ASC');
		return  $this->db->get('QC1_REP_QDD_DOMAIN')->result();	
	}
	function listeDomainsArray () {
		$listeDomains = $this->listeDomains();
		$listeDomainsNew = array();
		foreach($listeDomains as $domain){
			$listeDomainsNew[$domain->CODE_DOMAIN]=$domain;
		}
		return $listeDomainsNew;
	}
	function importRules($CODE_EXTENSION,$data){
		
		// On remonte l'info du regroupement
		$infoRegroupement=$this->db->get_where('QC1_REP_MTA_EXTENSION',array('CODE_EXTENSION'=>$CODE_EXTENSION))->result();
		// $tab contient les noms des CHAMPS ou sont stockes les attributs utilises par le regroupement (SRC ou EXT)
		$tab['attr'] = array();
		
		// Lecture de l'entete pour recuperer les attributs SRC et EXT utilises par le regroupement
		foreach($data['data'][1] as $entete){
			
			// SELECT * FROM QC1_REP_QDD_ATTRIBUTE
			// WHERE NAME_ATTRIBUTE LIKE 'entete_de_la_colonne'
			$this->db->like('NAME_ATTRIBUTE',$entete,'none');
			$res = $this->db->get('QC1_REP_QDD_ATTRIBUTE')->result();
			
			// On balaye les attributs utilises par le regroupement
			// /!\ On ne balaye que les champs SRC et EXT pour eviter la colision des CODES ATTR avec le CODE_EXTENSION
			$champs_exclus = array ('CODE_EXTENSION', 'CODE_DOMAIN', 'NAME_EXTENSION', 'DESC_EXTENSION', 'INDEX_EXTENSION');
			foreach($infoRegroupement[0] as $champ=>$value){
				if (!in_array($champ,$champs_exclus)){					
					// Si le code de l'attribut traite est utilise par le regroupement ...
					if($res[0]->CODE_ATTRIBUTE==$value){
						// alors, on sauvegarde le nom du champ 'CODE_SRC_ATTR_XX' sous la forme 'SRC_ATTR_XX_VALUE' et 'CODE_EXT_ATTR_XX' sous la forme 'EXT_ATTR_XX_VALUE'
						// pour les adapter aux noms des champs de la table QC1_REP_MTA_RULE
						$tab['attr'][count($tab['attr'])]=str_replace('CODE_','',$champ)."_VALUE";
					}
				}
			}
		}
		// $tab['attr'] contient maintenant ['SRC_ATTR_XX_VALUE',(...), 'SRC_ATTR_YY_VALUE', 'EXT_ATTR_WW_VALUE',(...),'EXT_ATTR_ZZ_VALUE']
		// donc, tous les champs source et cibles, renomes.
		
		// On verifie que le nombre d'attributs ainsi recuperes soit egal au nombre de colonnes du fichier (SRC+EXT)
		if(count($tab['attr'])!=$data['numCols']){
			return "koCols";
		}
		
		// On elimine les RULES appartenant au regroupement de la table QC1_REP_MTA_RULE 
		// Il ne faut pas le faire. On va procéder en UPDATE et pas en Anule et remplace
		//$this->db->delete('QC1_REP_MTA_RULE',array('CODE_EXTENSION'=>$CODE_EXTENSION));
		
		// En sautant l'entete, on balaye ligne par ligne le fichier excel pour lire les donnes
		// puis on insere ligne par ligne les donnees dans QC1_REP_MTA_RULE
		for ($i = 2; $i <= $data['numRows']; $i++) {
			
			// On distingue les SRC des EXT			
			$src = array();
			$ext = array();
			foreach($tab['attr'] as $attr){
				if (strpos($attr, 'SRC') !== false) {
					$src[count($src)] = $attr;
				}
				elseif (strpos($attr, 'EXT') !== false) {					
					$ext[count($ext)] = $attr;
				}
			}
			if(count($src) + count($ext) != $data['numCols']){
				return "ko distinction SRC et EXT";
			}
			
			// Les SRC sont dans la condition du UPDATE
			$where = array();
			$it=0;
			foreach ($src as $champ_source) {
				$where[$champ_source]=''.$data['data'][$i][$it];
				$it++;
			}
			$where['CODE_EXTENSION']=$CODE_EXTENSION;
			$this->db->where($where);
			
			// Les EXT sont les champs à mettre à jour
			$update = array();
			$it=count($src); // on reprend $data a partir de la colonne des Champs SRC
			foreach ($ext as $champ_cible) {
				$update[$champ_cible]=$data['data'][$i][$it];
				$it++;
			}
			$this->db->update('QC1_REP_MTA_RULE', $update); 
		}
		$this->main_model->actionLogs('IMPORT','QC1_REP_MTA_RULE','',$CODE_EXTENSION,'CODE_EXTENSION');
		return "ok";
	}
	/***********************************************************
	 *   						Tranches	   			       *
	 ***********************************************************/
	
	function listeTranches(){
		$this->db->join('QC1_REP_SLC_FIELD','QC1_REP_SLC_FIELD.CODE_SLICE_FIELD=QC1_REP_SLC_DEFINITION.CODE_SLICE_FIELD');
		$this->db->order_by('NAME_SLICE','ASC');
		return $this->db->get('QC1_REP_SLC_DEFINITION')->result();
	}
	
	function editerTranche($myArray,$CODE_SLICE){
		if($CODE_SLICE!=""){			
			// Création du logs avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_REP_SLC_DEFINITION','',$CODE_SLICE,'CODE_SLICE');
			
			// Update de la séquence
			$this->db->where('CODE_SLICE',$CODE_SLICE);
			$this->db->update('QC1_REP_SLC_DEFINITION',$myArray);
			
		}else{
			// Insertion de la séquence
			$this->main_model->actionLogs('INSERT','QC1_REP_SLC_DEFINITION',$myArray);
			$this->db->insert('QC1_REP_SLC_DEFINITION',$myArray);
		}
	}
	
	function supprimerTranche($CODE_SLICE){
		$this->main_model->actionLogs('DELETE','QC1_REP_SLC_DEFINITION','',$CODE_SLICE,'CODE_SLICE');
		$this->db->delete('QC1_REP_SLC_DEFINITION',array('CODE_SLICE'=>$CODE_SLICE));
		
		$this->main_model->actionLogs('DELETE','QC1_REP_SLC_RULE','',$CODE_SLICE,'CODE_SLICE');
		$this->db->delete('QC1_REP_SLC_RULE',array('CODE_SLICE'=>$CODE_SLICE));
	}
	
	function infoTranche($CODE_SLICE){
		$this->db->join('QC1_REP_SLC_FIELD','QC1_REP_SLC_FIELD.CODE_SLICE_FIELD=QC1_REP_SLC_DEFINITION.CODE_SLICE_FIELD');		
		$infoTranche = $this->db->get_where('QC1_REP_SLC_DEFINITION',array('CODE_SLICE'=>$CODE_SLICE))->result();
		
		$infoTranche[0]->listeRules = $this->listeRulesTranche($CODE_SLICE);
		
		return $infoTranche[0];
	}
	
	function listeRulesTranche($CODE_SLICE){
		$this->db->order_by('NAME_RULE','ASC');
		return $this->db->get_where('QC1_REP_SLC_RULE',array('CODE_SLICE'=>$CODE_SLICE))->result();
	}
	
	function infoRuleTranche($CODE_RULE){
		$infoStepTranche = $this->db->get_where('QC1_REP_SLC_RULE',array('CODE_RULE'=>$CODE_RULE))->result();
		return $infoStepTranche[0];
	}
	
	function editerTrancheRule($myArray,$CODE_SLICE,$CODE_RULE){
		$myArray['CODE_SLICE']=$CODE_SLICE;
		if($CODE_RULE!=""){			
			// Création du logs avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_REP_SLC_RULE','',$CODE_RULE,'CODE_RULE');
			
			// Update de la rule
			$this->db->where('CODE_RULE',$CODE_RULE);
			$this->db->update('QC1_REP_SLC_RULE',$myArray);
			
		}else{
			// Insertion de la rule
			$this->main_model->actionLogs('INSERT','QC1_REP_SLC_RULE',$myArray);
			$this->db->insert('QC1_REP_SLC_RULE',$myArray);
		}
	}
	
	function supprimerTrancheRule($CODE_RULE){
		$this->main_model->actionLogs('DELETE','QC1_REP_SLC_RULE','',$CODE_RULE,'CODE_RULE');
		$this->db->delete('QC1_REP_SLC_RULE',array('CODE_RULE'=>$CODE_RULE));
	}
	
	function importTranchesRules($CODE_SLICE,$data){
		
		if($data['numCols']!=5){
			return "koCols";
		}
		
		$this->db->delete('QC1_REP_SLC_RULE',array('CODE_SLICE'=>$CODE_SLICE));
		
		for($i=2;$i<=$data['numRows'];$i++){
			$this->db->insert('QC1_REP_SLC_RULE',array(
				'CODE_SLICE'=>$CODE_SLICE,
				'NAME_RULE'=>$data['data'][$i][0],
				'LEFT_OPERATOR'=>$data['data'][$i][1],
				'LEFT_VALUE'=>$data['data'][$i][2],
				'RIGHT_OPERATOR'=>$data['data'][$i][3],
				'RIGHT_VALUE'=>$data['data'][$i][4]
			));
		}
		$this->main_model->actionLogs('IMPORT','QC1_REP_SLC_RULE','',$CODE_SLICE,'CODE_SLICE');	
		return "ok";
	}
		
	/**********************************************************
	 *   				CHAMPS DE TRANCHE    	              *
	 **********************************************************/
	 
	function listeChamps () {
		//On ordonne les enregistrement par le NAME_SLICE_FIELD par ordre croissant
		$this->db->order_by('NAME_SLICE_FIELD', 'ASC');
		// Puis on récupère les éléments de la table QC1_REP_SLC_FIELD
		return  $this->db->get('QC1_REP_SLC_FIELD')->result();
	}
	
	function infoChamp ($CODE_SLICE_FIELD) {
		// On régupère les éléments de la table QC1_REP_SLC_FIELD ayant le CODE_SLICE_FIELD mis en param
		$result = $this->db->get_where('QC1_REP_SLC_FIELD', array('CODE_SLICE_FIELD' => $CODE_SLICE_FIELD))->result();
		return $result[0] ;
	}
	
	function editerChamp($myArray){
		// On check si on doit update ou insert
		if($myArray['CODE_SLICE_FIELD']!=""){
		
			// Création du log avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_REP_SLC_FIELD','',$myArray['CODE_SLICE_FIELD'],'CODE_SLICE_FIELD');
			
			$this->db->where('CODE_SLICE_FIELD', $myArray['CODE_SLICE_FIELD']);
			$this->db->update('QC1_REP_SLC_FIELD',array(
					'NAME_SLICE_FIELD'=>$myArray['NAME_SLICE_FIELD'],
					'NAME_FIELD_SOURCE'=>$myArray['NAME_FIELD_SOURCE'],
					'NAME_FIELD_TARGET'=>$myArray['NAME_FIELD_TARGET'],
					'NAME_TABLE'=>$myArray['NAME_TABLE']
			));
			return 	$myArray['CODE_SLICE_FIELD'];
		}else{
		
			// Insertion du champ
			$this->main_model->actionLogs('INSERT','QC1_REP_SLC_FIELD',$myArray);
			
			$this->db->insert('QC1_REP_SLC_FIELD',array(
					'NAME_SLICE_FIELD'=>$myArray['NAME_SLICE_FIELD'],
					'NAME_FIELD_SOURCE'=>$myArray['NAME_FIELD_SOURCE'],
					'NAME_FIELD_TARGET'=>$myArray['NAME_FIELD_TARGET'],
					'NAME_TABLE'=>$myArray['NAME_TABLE']
			));
			//return $this->db->insert_id() ;
		}
	}
	
	function supprimerChamp ($CODE_SLICE_FIELD) {
	
		//Suppression du champ
		$this->main_model->actionLogs('DELETE','QC1_REP_SLC_FIELD','',$CODE_SLICE_FIELD,'CODE_SLICE_FIELD');
		
		if($this->db->get_where('QC1_REP_SLC_FIELD', array('CODE_SLICE_FIELD' => $CODE_SLICE_FIELD))->num_rows()>0){
			// Suppresion de l'archive
			$this->db->where('CODE_SLICE_FIELD', $CODE_SLICE_FIELD);
			$this->db->delete('QC1_REP_SLC_FIELD');
		}
		return $CODE_SLICE_FIELD ;
	}
	
	/**********************************************************
	 *   					     	   		  COMMENTIARES									    *
	 **********************************************************/
	
	function listeCommentaires () {
	
		//On ordonne les enregistrement par le CODE_CONTENT par ordre croissant
	
		$this->db->order_by('CODE_CONTENT', 'ASC');
	
		// Puis on récupère les éléments de la table QC1_REP_MSG_CONTENT
	
		return  $this->db->get('QC1_REP_MSG_CONTENT')->result();
	
	}
	
	function infoCommentaire ($CODE_CONTENT) {
	
		// On régupère les éléments de la table QC1_REP_MSG_CONTENT ayant le CODE_CONTENT mis en param
	
		$result = $this->db->get_where('QC1_REP_MSG_CONTENT', array('CODE_CONTENT' => $CODE_CONTENT))->result();
	
		return $result[0] ;
	
	}
	
	function editerCommentaire($myArray){
	
		// On check si on doit update ou insert
	
		if($myArray['CODE_CONTENT']!=""){
	
			// Création du log avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_REP_MSG_CONTENT','',$myArray['CODE_CONTENT'],'CODE_CONTENT');
	
			$this->db->where('CODE_CONTENT', $myArray['CODE_CONTENT']);
	
			$this->db->update('QC1_REP_MSG_CONTENT',array(
	
					'CODE_TYPE'=>$myArray['CODE_TYPE'],
	
					'CODE_LANG'=>$myArray['CODE_LANG'],
	
					'DESC_CONTENT'=>$myArray['DESC_CONTENT']
	
			));
	
			return 	$myArray['CODE_CONTENT'];
	
		}else{
	
			// Insertion du Commentaire
			$this->main_model->actionLogs('INSERT','QC1_REP_MSG_CONTENT',$myArray);
	
			$this->db->insert('QC1_REP_MSG_CONTENT',array(
	
					'CODE_TYPE'=>$myArray['CODE_TYPE'],
	
					'CODE_LANG'=>$myArray['CODE_LANG'],
	
					'DESC_CONTENT'=>$myArray['DESC_CONTENT']
	
			));
	
			//return $this->db->insert_id() ;
	
		}
	
	}
	
	function supprimerCommentaire ($CODE_CONTENT) {
	
		//Suppression du commentaire
		$this->main_model->actionLogs('DELETE','QC1_REP_MSG_CONTENT','',$CODE_CONTENT,'CODE_CONTENT');
	
		if($this->db->get_where('QC1_REP_MSG_CONTENT', array('CODE_CONTENT' => $CODE_CONTENT))->num_rows()>0){
	
			// Suppresion du commentaire
	
			$this->db->where('CODE_CONTENT', $CODE_CONTENT);
	
			$this->db->delete('QC1_REP_MSG_CONTENT');
	
		}
	
		return $CODE_CONTENT ;
	
	}
}
?>