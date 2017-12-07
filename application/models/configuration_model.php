<?php
class Configuration_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
		
	/**********************************************************
	 *   					     			    	MODULES    				 			    	    *
	 **********************************************************/
	
	function listeModules($PARENT_ID){
		$this->db->order_by('ITEM_ORDER','ASC');
		return $this->db->get_where('QC1_REP_SEC_MOD_DEFINITION',array('PARENT_ID'=>$PARENT_ID))->result();
	}
	
	function updatePermissionModule($ITEM_ID,$CODE_PROFILE,$perm){
		$this->main_model->actionLogs('UPDATE','QC1_REP_SEC_MOD_DEFINITION','',$ITEM_ID,'ITEM_ID');
		$infoProfil = $this->infoProfil($CODE_PROFILE);
		$this->db->where('ITEM_ID',$ITEM_ID);
		$this->db->update('QC1_REP_SEC_MOD_DEFINITION',array($infoProfil->COLUMN_PROFILE=>$perm));
	}
	
	function infoModule($ITEM_ID) {
		// Puis on sort les éléments de la table QC1_REP_SEC_USER ayant le CODE_USER mis en param
		$result = $this->db->get_where ( 'QC1_REP_SEC_MOD_DEFINITION', array (
				'ITEM_ID' => $ITEM_ID
		) )->result ();
		return $result [0];
	}
	
	function editerModule($myArray) {
		// On check si on doit update ou insert
		if ($myArray ['ITEM_ID'] != "") {
			$this->main_model->actionLogs('UPDATE','QC1_REP_SEC_MOD_DEFINITION','',$myArray ['ITEM_ID'],'ITEM_ID');
			$this->db->where ( 'ITEM_ID', $myArray ['ITEM_ID'] );
			$this->db->update('QC1_REP_SEC_MOD_DEFINITION',array(
					'ITEM_NAME'=>$myArray['ITEM_NAME'],
					'ITEM_ORDER'=>$myArray['ITEM_ORDER'],
					'PARENT_ID'=>$myArray['PARENT_ID'],
					'CONF'=>$myArray['CONF'],
					'ITEM_ICON'=>$myArray['ITEM_ICON']
			));
			return $myArray ['CODE_PROFILE'];
		} else {
			$this->main_model->actionLogs('INSERT','QC1_REP_SEC_MOD_DEFINITION',$myArray);
			$this->db->insert ( 'QC1_REP_SEC_MOD_DEFINITION', array (
					'ITEM_NAME'=>$myArray['ITEM_NAME'],
					'ITEM_ORDER'=>$myArray['ITEM_ORDER'],
					'PARENT_ID'=>$myArray['PARENT_ID'],
					'CONF'=>$myArray['CONF'],
					'ITEM_ICON'=>$myArray['ITEM_ICON'],
					'PROFILE01'=>1,
					'PROFILE03'=>1,
			));
			//return $this->db->insert_id();
		}
	}
	
	function supprimerModule($ITEM_ID) {
		if ($this->db->get_where ( 'QC1_REP_SEC_MOD_DEFINITION', array (
				'ITEM_ID' => $ITEM_ID
		) )->num_rows () > 0) {
			// Suppresion de l'utilisateur
			$this->db->where ( 'ITEM_ID', $ITEM_ID );
			$this->db->delete ( 'QC1_REP_SEC_MOD_DEFINITION' );
		}
		return $CODE_PROFILE;
	}

	/**********************************************************
	 *   					SEQUENCES	          			  *
	 **********************************************************/
	
	function listeSequences(){
		$this->db->order_by('SEQ_ORDER','ASC');
		return $this->db->get('QC1_REP_RUN_SEQ')->result();
	}
	
	function editerSequence($myArray,$CODE_SEQ){
		if($CODE_SEQ!=""){			
			// Création du logs avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_REP_RUN_SEQ','',$CODE_SEQ,'CODE_SEQ');
			
			// Update de la séquence
			$this->db->where('CODE_SEQ',$CODE_SEQ);
			$this->db->update('QC1_REP_RUN_SEQ',$myArray);
			
		}else{
			// Insertion de la séquence
			$this->main_model->actionLogs('INSERT','QC1_REP_RUN_SEQ',$myArray);
			$this->db->insert('QC1_REP_RUN_SEQ',$myArray);
		}
	}
	
	function supprimerSequence($CODE_SEQ){
		$this->main_model->actionLogs('DELETE','QC1_REP_RUN_SEQ','',$CODE_SEQ,'CODE_SEQ');
		$this->db->delete('QC1_REP_RUN_SEQ',array('CODE_SEQ'=>$CODE_SEQ));
		
		$this->main_model->actionLogs('DELETE','QC1_REP_RUN_STEP','',$CODE_SEQ,'CODE_SEQ');
		$this->db->delete('QC1_REP_RUN_STEP',array('CODE_STEP'=>$CODE_SEQ));
	}
	
	function infoSequence($CODE_SEQ){
		$infoSequence = $this->db->get_where('QC1_REP_RUN_SEQ',array('CODE_SEQ'=>$CODE_SEQ))->result();
		
		if($infoSequence[0]->ERR_GOTO!=NULL){
			$err = $this->db->get_where('QC1_REP_RUN_SEQ',array('CODE_SEQ'=>$infoSequence[0]->ERR_GOTO))->result();
			$infoSequence[0]->sequenceGoto = $err[0];
		}
		
		$infoSequence[0]->listeSteps = $this->listeStepSequence($CODE_SEQ);
		
		return $infoSequence[0];
	}
	
	function listeStepSequence($CODE_SEQ){
		$this->db->join('QC1_REP_RUN_JOB','QC1_REP_RUN_JOB.CODE_JOB=QC1_REP_RUN_STEP.CODE_JOB');
		$this->db->order_by('STEP_ORDER','ASC');
		return $this->db->get_where('QC1_REP_RUN_STEP',array('CODE_SEQ'=>$CODE_SEQ))->result();
	}
	
	function infoStepSequence($CODE_STEP){
		$this->db->join('QC1_REP_RUN_JOB','QC1_REP_RUN_JOB.CODE_JOB=QC1_REP_RUN_STEP.CODE_JOB');
		$infoStepSequence = $this->db->get_where('QC1_REP_RUN_STEP',array('CODE_STEP'=>$CODE_STEP))->result();
		return $infoStepSequence[0];
	}
	
	function editerSequenceStep($myArray,$CODE_SEQ,$CODE_STEP){
		$myArray['CODE_SEQ']=$CODE_SEQ;
		if($CODE_STEP!=""){			
			// Création du logs avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_REP_RUN_STEP','',$CODE_STEP,'CODE_STEP');
			
			// Update de la séquence
			$this->db->where('CODE_STEP',$CODE_STEP);
			$this->db->update('QC1_REP_RUN_STEP',$myArray);
			
		}else{
			// Insertion de la séquence
			$this->main_model->actionLogs('INSERT','QC1_REP_RUN_STEP',$myArray);
			$this->db->insert('QC1_REP_RUN_STEP',$myArray);
		}
	}
	
	function supprimerSequenceStep($CODE_STEP){
		$this->main_model->actionLogs('DELETE','QC1_REP_RUN_STEP','',$CODE_STEP,'CODE_STEP');
		$this->db->delete('QC1_REP_RUN_STEP',array('CODE_STEP'=>$CODE_STEP));
	}
	
	/**********************************************************
	 *   						JOBS	          			  *
	 **********************************************************/
	
	function listeJobs(){
		$this->db->order_by('NAME_JOB','ASC');
		return $this->db->get('QC1_REP_RUN_JOB')->result();
	}
	
	function infoJob($CODE_JOB){		
		$infoJob = $this->db->get_where('QC1_REP_RUN_JOB',array('CODE_JOB'=>$CODE_JOB))->result();
		return $infoJob[0];
	}
	
	function editerJob($myArray,$CODE_JOB){	
		if($CODE_JOB!=""){			
			// Création du logs avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_REP_RUN_JOB','',$CODE_JOB,'CODE_JOB');
			
			// Update de la séquence
			$this->db->where('CODE_JOB',$CODE_JOB);
			$this->db->update('QC1_REP_RUN_JOB',$myArray);
			
		}else{
			// Insertion de la séquence
			$this->main_model->actionLogs('INSERT','QC1_REP_RUN_JOB',$myArray);
			$this->db->insert('QC1_REP_RUN_JOB',$myArray);
		}
	}
	
	function supprimerJob($CODE_JOB){
		$this->main_model->actionLogs('DELETE','QC1_REP_RUN_JOB','',$CODE_JOB,'CODE_JOB');
		$this->db->delete('QC1_REP_RUN_JOB',array('CODE_JOB'=>$CODE_JOB));
	}
	
	/**********************************************************
	 *   						Dictionnaire      			  *
	 **********************************************************/
	
	function listeDictionnaire(){
		
		$this->db->join ('QC1_REP_QDD_DICTIONARY', 'QC1_REP_QDD_DICTIONARY.CODE_DICTIONARY = QC1_REP_QDD_DOMAIN.CODE_DICTIONARY');
		$this->db->order_by('NAME_DOMAIN','ASC');
		
		return $this->db->get('QC1_REP_QDD_DOMAIN')->result();	
	}
	
	function infoDomaine($CODE_DOMAIN){	
		$this->db->join ('QC1_REP_QDD_DICTIONARY', 'QC1_REP_QDD_DICTIONARY.CODE_DICTIONARY = QC1_REP_QDD_DOMAIN.CODE_DICTIONARY');
		$infoDomaine = $this->db->get_where('QC1_REP_QDD_DOMAIN',array('CODE_DOMAIN'=>$CODE_DOMAIN))->result();
		
		$this->db->order_by('NAME_ATTRIBUTE','ASC');
		$infoDomaine[0]->listeAttributs = $this->listeAttributs($CODE_DOMAIN);
		
		return $infoDomaine[0];
	}
	
	function dictionnairesExistants(){
		$this->db->order_by('CODE_DICTIONARY','ASC');
		return $this->db->get('QC1_REP_QDD_DICTIONARY')->result();
	}
	
	function editerDomaine($myArray,$CODE_DOMAIN){
		
		// Valeur de FLG_ORG par défaut = 0
		if($myArray['FLG_ORG']!="1") {
			$myArray['FLG_ORG']="0";
		}		
		
		if($CODE_DOMAIN!=""){			
			// Création du logs avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_REP_QDD_DOMAIN','',$CODE_DOMAIN,'CODE_DOMAIN');
			
			// Update de la séquence
			$this->db->where('CODE_DOMAIN',$CODE_DOMAIN);
			$this->db->update('QC1_REP_QDD_DOMAIN',$myArray);
			
		}else{
			// Insertion de la séquence
			$this->main_model->actionLogs('INSERT','QC1_REP_QDD_DOMAIN',$myArray);
			$this->db->insert('QC1_REP_QDD_DOMAIN',$myArray);
		}
	}
	
	function supprimerDomaine($CODE_DOMAIN){
		$this->main_model->actionLogs('DELETE','QC1_REP_QDD_DOMAIN','',$CODE_DOMAIN,'CODE_DOMAIN');
		$this->db->delete('QC1_REP_QDD_DOMAIN',array('CODE_DOMAIN'=>$CODE_DOMAIN));
		
		$this->main_model->actionLogs('DELETE','QC1_REP_QDD_ATTRIBUTE','',$CODE_DOMAIN,'CODE_DOMAIN');
		$this->db->delete('QC1_REP_QDD_ATTRIBUTE',array('CODE_DOMAIN'=>$CODE_DOMAIN));
	}
		
	function listeAttributs($CODE_DOMAIN){
		$this->db->order_by('NAME_ATTRIBUTE','ASC');
		$this->db->join ('QC1_REP_TYPE', 'QC1_REP_TYPE.STRING_TYPE = QC1_REP_QDD_ATTRIBUTE.TYPE_ATTRIBUTE');
		$listeAttributs = $this->db->get_where('QC1_REP_QDD_ATTRIBUTE',array('CODE_DOMAIN'=>$CODE_DOMAIN))->result();
		
		
		// on recupere les champs presents dans autres tables
		foreach($listeAttributs as $attribut){
			$CODE_ATTRIBUTE = $attribut->CODE_ATTRIBUTE;
			$TYPE_ATTRIBUTE = $attribut->TYPE_ATTRIBUTE;
			
			// Pour le champ SRC
			$this->db->select('NAME_EXTENSION');
			$this->db->where("( CODE_SRC_ATTR_01 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_02 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_03 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_04 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_05 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_06 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_07 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_08 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_09 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_10 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_11 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_12 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_13 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_14 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_15 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_16 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_17 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_18 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_19 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_20 = $CODE_ATTRIBUTE )");
			$attribut->SRC = $this->db->get('QC1_REP_MTA_EXTENSION')->result()[0]->NAME_EXTENSION;
			
			// Ce code fonctionne aussi :
			// $this->db->select('NAME_EXTENSION');
			// $this->db->where("( CODE_SRC_ATTR_01 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_02 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_03 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_04 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_05 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_06 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_07 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_08 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_09 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_10 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_11 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_12 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_13 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_14 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_15 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_16 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_17 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_18 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_19 = $CODE_ATTRIBUTE OR CODE_SRC_ATTR_20 = $CODE_ATTRIBUTE )");			
			// $requete = $this->db->get('QC1_REP_MTA_EXTENSION');
			// foreach($requete->result() as $row){
				// $attribut->SRC = $row->NAME_EXTENSION;
			// }
			
			// Pour le champ EXT = 
			$this->db->select('NAME_EXTENSION');
			$this->db->where("( CODE_EXT_ATTR_01 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_02 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_03 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_04 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_05 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_06 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_07 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_08 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_09 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_10 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_11 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_12 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_13 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_14 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_15 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_16 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_17 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_18 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_19 = $CODE_ATTRIBUTE OR CODE_EXT_ATTR_20 = $CODE_ATTRIBUTE )");
			$attribut->EXT = $this->db->get('QC1_REP_MTA_EXTENSION')->result()[0]->NAME_EXTENSION;
			
			// Pour le champ MOBIND 
			//On traite d'abord la sous requete pour recuperer le CODE_INDICATOR
			$this->db->select('CODE_INDICATOR');
			$CODE_INDICATOR = $this->db->get_where('QC1_REP_MBI_DEFINITION',array('CODE_ATTRIBUTE'=>$CODE_ATTRIBUTE))->result()[0]->CODE_INDICATOR;
			
			//Avec le CODE_INDICATOR on recupere le NAME_INDICATOR
			$this->db->select('NAME_INDICATOR');
			$this->db->where('CODE_INDICATOR',$CODE_INDICATOR);
			$attribut->MOBIND = $this->db->get('QC1_REP_MBI_INDICATOR')->result()[0]->NAME_INDICATOR;
		}
		
		return $listeAttributs;
	}
	
	function infoAttribut($CODE_ATTRIBUTE){	
		$infoAttribut = $this->db->get_where('QC1_REP_QDD_ATTRIBUTE',array('CODE_ATTRIBUTE'=>$CODE_ATTRIBUTE))->result();
		return $infoAttribut[0];
	}
	
	function editerAttribut($myArray,$CODE_DOMAIN,$CODE_ATTRIBUTE){
		$myArray['CODE_DOMAIN']=$CODE_DOMAIN;
		
		// Valeur des flags par défaut = 0
		if($myArray['FLG_LOCKED']!="1") {
			$myArray['FLG_LOCKED']="0";
		}
		if($myArray['FLG_CUSTOM']!="1") {
			$myArray['FLG_CUSTOM']="0";
		}
		if($myArray['FLG_LOV']!="1") {
			$myArray['FLG_LOV']="0";
		}
		if($myArray['FLG_TKH']!="1") {
			$myArray['FLG_TKH']="0";
		}
		
		if($CODE_ATTRIBUTE!=""){			
			// Création du logs avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_REP_QDD_ATTRIBUTE','',$CODE_ATTRIBUTE,'CODE_ATTRIBUTE');
			
			// Update de l'attribut
			$this->db->where('CODE_ATTRIBUTE',$CODE_ATTRIBUTE);
			$this->db->update('QC1_REP_QDD_ATTRIBUTE',$myArray);
			
		}else{
			// Insertion de la rule
			$this->main_model->actionLogs('INSERT','QC1_REP_QDD_ATTRIBUTE',$myArray);
			$this->db->insert('QC1_REP_QDD_ATTRIBUTE',$myArray);
		}
	}
	
	function supprimerAttribut($CODE_ATTRIBUTE){
		$this->main_model->actionLogs('DELETE','QC1_REP_QDD_ATTRIBUTE','',$CODE_ATTRIBUTE,'CODE_ATTRIBUTE');
		$this->db->delete('QC1_REP_QDD_ATTRIBUTE',array('CODE_ATTRIBUTE'=>$CODE_ATTRIBUTE));
	}
	
	
}
?>