<?php
class Donnees_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**********************************************************
	 *   				FICHIERS SOURCES		           	  *
	 **********************************************************/
	
	function listeFichiersSources(){
		
		$this->db->join('QC1_REP_QDD_DOMAIN','QC1_REP_QDD_DOMAIN.CODE_DOMAIN=QC1_REP_SRC_FILE.CODE_DOMAIN','LEFT');
		$this->db->join('QC1_REP_SRC_CONN','QC1_REP_SRC_CONN.CODE_CONN=QC1_REP_SRC_FILE.CODE_CONN','LEFT');
		$this->db->join('QC1_REP_SRC_ORIGIN','QC1_REP_SRC_ORIGIN.CODE_ORIGIN=QC1_REP_SRC_FILE.CODE_ORIGIN','LEFT');
		$this->db->select('CODE_FILE,QC1_REP_SRC_FILE.CODE_CONN,QC1_REP_SRC_CONN.NAME_CONN,QC1_REP_SRC_FILE.CODE_DOMAIN,QC1_REP_QDD_DOMAIN.NAME_DOMAIN,NAME_FILE,DESC_FILE,FILEPATH,FLG_OPTIONAL,FLG_DUPLICATE,FLG_HIST,FLG_CVT,QC1_REP_SRC_FILE.CODE_ORIGIN,QC1_REP_SRC_ORIGIN.NAME_ORIGIN');
		//On ordonne les enregistrement par le NAME_FILE par ordre croissant
		$this->db->order_by('NAME_FILE', 'ASC');
		// Puis on sort les éléments de la table QC1_REP_SRC_FILE
		$listeFichiersSources = $this->db->get('QC1_REP_SRC_FILE')->result();
		
		return $listeFichiersSources;		
	}	
	
	function editerFichierSource($myArray,$CODE_FILE){
		if($CODE_FILE!=""){
			
			// On initialise les flags à 0
			if ($myArray['FLG_OPTIONAL'] == null)
				$myArray['FLG_OPTIONAL'] = 0;
			if ($myArray['FLG_DUPLICATE'] == null)
				$myArray['FLG_DUPLICATE'] = 0;
			if ($myArray['FLG_HIST'] == null)
				$myArray['FLG_HIST'] = 0;
			if ($myArray['FLG_CVT'] == null)
				$myArray['FLG_CVT'] = 0;			
			
			// Création du logs avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_REP_SRC_FILE','',$CODE_FILE,'CODE_FILE');
			
			// Update de la fusion
			$this->db->where('CODE_FILE',$CODE_FILE);
			$this->db->update('QC1_REP_SRC_FILE',$myArray);
			
		}else{
			// Insertion de la fusion
			$this->main_model->actionLogs('INSERT','QC1_REP_SRC_FILE',$myArray);
			$this->db->insert('QC1_REP_SRC_FILE',$myArray);
		}
	}
	
	function infoFichierSource($CODE_FILE){
		$this->db->join('QC1_REP_QDD_DOMAIN','QC1_REP_QDD_DOMAIN.CODE_DOMAIN=QC1_REP_SRC_FILE.CODE_DOMAIN','LEFT');
		$this->db->join('QC1_REP_SRC_CONN','QC1_REP_SRC_CONN.CODE_CONN=QC1_REP_SRC_FILE.CODE_CONN','LEFT');
		$this->db->join('QC1_REP_SRC_ORIGIN','QC1_REP_SRC_ORIGIN.CODE_ORIGIN=QC1_REP_SRC_FILE.CODE_ORIGIN','LEFT');
		
		
		$this->db->select('CODE_FILE,QC1_REP_SRC_FILE.CODE_CONN,QC1_REP_SRC_CONN.NAME_CONN,QC1_REP_SRC_FILE.CODE_DOMAIN,QC1_REP_QDD_DOMAIN.NAME_DOMAIN,NAME_FILE,DESC_FILE,FILEPATH,FLG_OPTIONAL,FLG_DUPLICATE,FLG_HIST,FLG_CVT,QC1_REP_SRC_FILE.CODE_ORIGIN,QC1_REP_SRC_ORIGIN.NAME_ORIGIN');
		$this->db->order_by('NAME_FILE', 'ASC');
		$infoFichierSource = $this->db->get_where('QC1_REP_SRC_FILE',array('CODE_FILE'=>$CODE_FILE))->result();	
		
		$infoFichierSource[0]->listeFields = $this->listeFieldsFichierSource($CODE_FILE);
		
		return $infoFichierSource[0];
	}
	
	function supprimerFichierSource($CODE_FILE){
		$this->main_model->actionLogs('DELETE','QC1_REP_SRC_FILE','',$CODE_FILE,'CODE_FILE');
		$this->db->delete('QC1_REP_SRC_FILE',array('CODE_FILE'=>$CODE_FILE));
		
		$this->main_model->actionLogs('DELETE','QC1_REP_SRC_FIELD','',$CODE_FILE,'CODE_FILE');
		$this->db->delete('QC1_REP_SRC_FIELD',array('CODE_FIELD'=>$CODE_FIELD));
	}
	
	function listeFieldsFichierSource($CODE_FILE){
		$this->db->order_by('INDEX_FIELD', 'ASC');
		$this->db->join('QC1_REP_TYPE','QC1_REP_TYPE.STRING_TYPE=QC1_REP_SRC_FIELD.TYPE_FIELD');		
		
		return $this->db->get_where('QC1_REP_SRC_FIELD',array('CODE_FILE'=>$CODE_FILE))->result();	
	}
	
	function infoFichierSourceField($CODE_FIELD){
		 $infoFichierSourceField = $this->db->get_where('QC1_REP_SRC_FIELD',array('CODE_FIELD'=>$CODE_FIELD))->result();	
		 return $infoFichierSourceField[0];
	}
	
	function editerFichierSourceField($myArray,$CODE_FILE,$CODE_FIELD){
		$myArray['CODE_FILE']=$CODE_FILE;
		if($myArray['FLG_DAT_BEG_HIST']==null){
			$myArray['FLG_DAT_BEG_HIST'] = 0;
		}
		if($myArray['FLG_DAT_END_HIST']==null){
			$myArray['FLG_DAT_END_HIST'] = 0;
		}
		
		if($CODE_FIELD!=""){			
			// Création du logs avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_REP_SRC_FIELD','',$CODE_FILE,'CODE_FILE');
			
			$this->db->where('CODE_FIELD',$CODE_FIELD);
			$this->db->update('QC1_REP_SRC_FIELD',$myArray);
			
		}else{
			
			$nb = $this->db->get_where('QC1_REP_SRC_FIELD',array('CODE_FILE'=>$CODE_FILE))->num_rows();
			$myArray['INDEX_FIELD'] = $nb+1;
			$this->main_model->actionLogs('INSERT','QC1_REP_SRC_FIELD',$myArray);
			$this->db->insert('QC1_REP_SRC_FIELD',$myArray);
		}
	}
	
	function supprimerFichierSourceField($CODE_FIELD){
		$this->main_model->actionLogs('DELETE','QC1_REP_SRC_FIELD','',$CODE_FIELD,'CODE_FIELD');
		$this->db->delete('QC1_REP_SRC_FIELD',array('CODE_FIELD'=>$CODE_FIELD));
	}
		
	function listeConnexions(){
		$this->db->order_by('NAME_CONN','ASC');
		return $this->db->get('QC1_REP_SRC_CONN')->result();	
	}
	
	function listeTypes(){
		$this->db->order_by('INDEX_TYPE','ASC');
		return $this->db->get('QC1_REP_TYPE')->result();	
	}
	
	function importSRCFiles($data){
		// On elimine les données
		$this->db->truncate('QC1_REP_SRC_FILE');
		$this->db->truncate('QC1_REP_SRC_FIELD');		
		foreach ($data as &$file) {
			// On charge File
			$this->db->insert('QC1_REP_SRC_FILE', $file['File']); 
			// On récupère son CODE_FILE dans la base
			$this->db->where('NAME_FILE', $file['File']['NAME_FILE']);
			$this->db->select('CODE_FILE');
			$this->db->from('QC1_REP_SRC_FILE');
			$CODE_FILE = $this->db->get()->result()[0]->CODE_FILE;
			
			foreach ($file['Fields'] as &$field) {
				// On met à jour le CODE_FILE avec le code stocké en base
				$field['CODE_FILE'] = $CODE_FILE;
				// On charge les Fields
				$this->db->insert('QC1_REP_SRC_FIELD', $field); 
			}
		}
		return "ok";
	}
	
	function listeSimpleFichiersSource(){
		return $this->db->get('QC1_REP_SRC_FILE')->result();
	}
	
	function listeSimpleChampsFichiersSource(){
		return $this->db->get('QC1_REP_SRC_FIELD')->result();
	}
	
	/**********************************************************
	 *   					HISTORIQUES	            		  *
	 **********************************************************/

	function listeHistoriques () {
		//On ordonne les enregistrement par le NAME_HIST par ordre croissant
		$this->db->order_by('NAME_HIST', 'ASC');
		// Puis on sort les éléments de la table QC1_EPE_CFG_HIST
		return  $this->db->get('QC1_EPE_CFG_HIST')->result();	
	}
	
	function infoHistorique($CODE_HIST){
		
		// Récupération des informations de la fusion
		$infoHistorique = $this->db->get_where('QC1_EPE_CFG_HIST',array('CODE_HIST'=>$CODE_HIST))->result();	
		
		// Récupération des historiques field liés
		$infoHistorique[0]->listeHistoriquesField = $this->listeHistoriquesField($CODE_HIST);
				
		return $infoHistorique[0];
	}
	
	function listeHistoriquesField($CODE_HIST){
		//On ordonne les enregistrement par le INDEX_FIELD par ordre croissant
		$this->db->order_by('INDEX_FIELD', 'ASC');
		$this->db->join('QC1_REP_TYPE','QC1_REP_TYPE.STRING_TYPE=QC1_EPE_CFG_HIST_FIELD.TYPE_FIELD');		
		// Puis on sort les éléments de la table QC1_EPE_CFG_HIST_FIELD
		return  $this->db->get_where('QC1_EPE_CFG_HIST_FIELD',array('CODE_HIST'=>$CODE_HIST))->result();	
	}
	
	function editerHistorique($myArray,$CODE_HIST){
		if($CODE_HIST!=""){			
			// Log avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_EPE_CFG_HIST','',$CODE_HIST,'CODE_HIST');
			
			// Update du historique
			$this->db->where('CODE_HIST',$CODE_HIST);
			$this->db->update('QC1_EPE_CFG_HIST',$myArray);
			
		}else{
			// Création du historique
			
			// on récupère la liste des Champs issues du fichier source
			$listeFieldsFichierSource = $this->listeFieldsFichierSource($myArray['CODE_FILE']);
			unset($myArray['CODE_FILE']);
			
			// on crée l'historique mais sans les Champs
			$this->main_model->actionLogs('INSERT','QC1_EPE_CFG_HIST',$myArray);
			$this->db->insert('QC1_EPE_CFG_HIST',$myArray);
				
			// on récupère le code de l'historique que nous venons de créer
			$this->db->select('CODE_HIST');
			$CODE_HIST = $this->db->get_where('QC1_EPE_CFG_HIST', array('NAME_HIST'=>$myArray['NAME_HIST']))->result()[0]->CODE_HIST;
			
			// puis on rajoute les Champs issus du fichier source	
			
			foreach ($listeFieldsFichierSource as $field){				
				$arrayChamps = array(
				"CODE_HIST" => $CODE_HIST,
				"SOURCE_COLUMN" => $field->NAME_FIELD,
				"TARGET_COLUMN" => $field->NAME_FIELD,
				"FLG_MERGE" => 1,
				"FLG_KEY_FIELD" => 0,
				"TYPE_FIELD" => $field->TYPE_FIELD,
				"INDEX_FIELD" => $field->INDEX_FIELD
				);
				//insertion 
				$this->editerHistoriqueChamp($arrayChamps, $CODE_HIST,"");				
			}			
			
		}
	}
	
	function infoHistoriqueChamps($CODE_FIELD){
		$infoHistoriqueChamps = $this->db->get_where('QC1_EPE_CFG_HIST_FIELD',array('CODE_FIELD'=>$CODE_FIELD))->result();
		return $infoHistoriqueChamps[0];
	}
	
	function editerHistoriqueChamp($myArray,$CODE_HIST,$CODE_FIELD){
		$myArray['CODE_HIST']=$CODE_HIST;
		// Rajout des valeurs par défaut à 0 pour les flags FLG_MERGE et FLG_KEY_FIELD
		if ($myArray['FLG_MERGE'] == null){
			$myArray['FLG_MERGE'] = 0;
		}
		if ($myArray['FLG_KEY_FIELD'] == null){
			$myArray['FLG_KEY_FIELD'] = 0;
		}
		if($CODE_FIELD!=""){			
			// Création du logs avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_EPE_CFG_HIST_FIELD','',$CODE_FIELD,'CODE_FIELD');
			
			// Update du champ
			$this->db->where('CODE_FIELD',$CODE_FIELD);
			$this->db->update('QC1_EPE_CFG_HIST_FIELD',$myArray);
			
		}else{
			// Insertion du champ
			$this->main_model->actionLogs('INSERT','QC1_EPE_CFG_HIST_FIELD',$myArray);
			$this->db->insert('QC1_EPE_CFG_HIST_FIELD',$myArray);
		}
	}
	
		
	function supprimerHistorique($CODE_HIST){
		
		//Suppression de l'historique
		$this->main_model->actionLogs('DELETE','QC1_EPE_CFG_HIST','',$CODE_HIST,'CODE_HIST');		
		$this->db->delete('QC1_EPE_CFG_HIST',array('CODE_HIST'=>$CODE_HIST));
	}
	
	function supprimerHistoriqueField($CODE_FIELD){
		
		//Suppression de l'historique
		$this->main_model->actionLogs('DELETE','QC1_EPE_CFG_HIST_FIELD','',$CODE_FIELD,'CODE_HIST');		
		$this->db->delete('QC1_EPE_CFG_HIST_FIELD',array('CODE_FIELD'=>$CODE_FIELD));
	}
	
	/**********************************************************
	 *   					FUSIONS    	            		  *
	 **********************************************************/

	function listeFusions () {
		//On ordonne les enregistrement par le NAME_EXTENSION par ordre croissant
		$this->db->order_by('NAME_FUSION', 'ASC');
		// Puis on sort les éléments de la table QC1_REP_MTA_EXTENSION
		return  $this->db->get('QC1_EPE_CFG_FUSION')->result();	
	}
	
	function infoFusion($CODE_FUSION){
		
		// Récupération des informations de la fusion
		$infoFusion = $this->db->get_where('QC1_EPE_CFG_FUSION',array('CODE_FUSION'=>$CODE_FUSION))->result();	
		
		// Récupération des historiques liés
		$infoFusion[0]->listeHistoriques = $this->listeHistoriquesFusions($CODE_FUSION);
				
		return $infoFusion[0];
	}
	
	function editerFusion($myArray,$CODE_FUSION){
		if($CODE_FUSION!=""){			
			// Création du logs avant update pour avoir les données avant modification
			$this->main_model->actionLogs('UPDATE','QC1_EPE_CFG_FUSION','',$CODE_FUSION,'CODE_FUSION');
			
			// Update de la fusion
			$this->db->where('CODE_FUSION',$CODE_FUSION);
			$this->db->update('QC1_EPE_CFG_FUSION',$myArray);
			
		}else{
			// Insertion de la fusion
			$this->main_model->actionLogs('INSERT','QC1_EPE_CFG_FUSION',$myArray);
			$this->db->insert('QC1_EPE_CFG_FUSION',$myArray);
		}
	}
	
	function editerFusionHistorique($CODE_FUSION,$listeHisto){
		
		// Sépartion des historique au format histo-CODE_HIST;histo-CODE_HIST;histo-CODE_HIST
		$tab = explode(';',$listeHisto);
		// Création d'un tableau récupération la liste des identifiants d'historique
		$tabElem =array();
		foreach($tab as $elem){
			$tabElem[count($tabElem)]=str_replace('histo-','',$elem);
		}
		
		
		// Récupération des Fusions d'historiques 
		$listeHistoriquesFusions = $this->listeHistoriquesFusions($CODE_FUSION);
		$tabHisto=array();
		
		//Suppression des éléments non présent dans la liste
		foreach($listeHistoriquesFusions as $histo){
			if(!in_array($histo->CODE_HIST,$tabElem)){
				$this->db->delete('QC1_EPE_CFG_FUSION_HIST',array('FUSION_HIST'=>$histo->FUSION_HIST));
			}else{
				// Historique déja présent
				$tabHisto[count($tabHisto)]=$histo->CODE_HIST;
			}
		}
		
		//Pour chaque historique récupérer en POST
		foreach($tabElem as $elem){
			
			// SI l'élément n'existe pas dans la table on l'insert
			if(!in_array($elem, $tabHisto)){
				$this->db->insert('QC1_EPE_CFG_FUSION_HIST',array(
					'CODE_FUSION'=>$CODE_FUSION,
					'CODE_HIST'=>$elem,
					'FLG_MASTER_HIST'=>0
				));
			}
			//Sinon on ne fait rien car il existe déja dans la table
		}
	}
	
	function supprimerFusion($CODE_FUSION){
		
		//Suppression de la fusion d'historique
		$this->main_model->actionLogs('DELETE','QC1_EPE_CFG_FUSION','',$CODE_FUSION,'CODE_FUSION');		
		$this->db->delete('QC1_EPE_CFG_FUSION',array('CODE_FUSION'=>$CODE_FUSION));
		
		//Suppression des jointures de fusion d'historique
		$this->main_model->actionLogs('DELETE','QC1_EPE_CFG_FUSION_HIST','',$CODE_FUSION,'CODE_FUSION');
		$this->db->delete('QC1_EPE_CFG_FUSION_HIST',array('CODE_FUSION'=>$CODE_FUSION));
	}
	
	function listeHistoriquesFusions($CODE_FUSION){
		//On fait une jointure pour avoir les historiques lié à la fusion
		$this->db->join('QC1_EPE_CFG_FUSION_HIST','QC1_EPE_CFG_FUSION_HIST.CODE_HIST=QC1_EPE_CFG_HIST.CODE_HIST');
		// On précise les colonnes dont on a besoin
		$this->db->select('QC1_EPE_CFG_HIST.CODE_HIST,QC1_EPE_CFG_HIST.NAME_HIST,QC1_EPE_CFG_FUSION_HIST.FUSION_HIST,QC1_EPE_CFG_FUSION_HIST.FLG_MASTER_HIST');
		// On ordonne par NAME_HIST
		$this->db->order_by('QC1_EPE_CFG_HIST.NAME_HIST', 'ASC');
		return  $this->db->get_where('QC1_EPE_CFG_HIST',array('CODE_FUSION'=>$CODE_FUSION))->result();	
	}
	
	function editerFusionFlg($FUSION_HIST,$flg){
		
		//Insertion de Logs
		$this->main_model->actionLogs('UPDATE','QC1_EPE_CFG_FUSION_HIST','',$FUSION_HIST,'FUSION_HIST');
		
		//Modification du flag
		$this->db->where('FUSION_HIST',$FUSION_HIST);
		$this->db->update('QC1_EPE_CFG_FUSION_HIST',array('FLG_MASTER_HIST'=>$flg));
	}
	
	/**********************************************************
	 *   					     	   			ORIGINES    	            			 				*
	 **********************************************************/
	 
	function listeOrigines () {
		//On ordonne les enregistrement par le NAME_ORIGIN par ordre croissant
		$this->db->order_by('NAME_ORIGIN', 'ASC');
		// Puis on sort les éléments de la table QC1_REP_SRC_ORIGIN
		return  $this->db->get('QC1_REP_SRC_ORIGIN')->result();	
	}
	
	function infoOrigine ($CODE_ORIGIN) {		
		// Puis on sort les éléments de la table QC1_REP_SRC_ORIGIN ayant le CODE_USER mis en param
		$result = $this->db->get_where('QC1_REP_SRC_ORIGIN', array('CODE_ORIGIN' => $CODE_ORIGIN))->result();				
		return $result[0] ;	
	}
	
	function editerOrigine($myArray){
		// On check si on doit update ou insert
		if($myArray['CODE_ORIGIN']!=""){
			$this->db->where('CODE_ORIGIN', $myArray['CODE_ORIGIN']);	
			$this->db->update('QC1_REP_SRC_ORIGIN',array(
				'TYPE_ORIGIN'=>$myArray['TYPE_ORIGIN'],
				'NAME_ORIGIN'=>$myArray['NAME_ORIGIN'],
				'DESC_ORIGIN'=>$myArray['DESC_ORIGIN'],
				'PREFIX_ORIGIN'=>$myArray['PREFIX_ORIGIN']
			));
			return 	$myArray['CODE_ORIGIN'];
		}else{			
			$this->db->insert('QC1_REP_SRC_ORIGIN',array(
				'TYPE_ORIGIN'=>$myArray['TYPE_ORIGIN'],
				'NAME_ORIGIN'=>$myArray['NAME_ORIGIN'],
				'DESC_ORIGIN'=>$myArray['DESC_ORIGIN'],
				'PREFIX_ORIGIN'=>$myArray['PREFIX_ORIGIN']
			));
			//return $this->db->insert_id() ;
		}
	}
	
	function supprimerOrigine ($CODE_ORIGIN) {
		if($this->db->get_where('QC1_REP_SRC_ORIGIN', array('CODE_ORIGIN' => $CODE_ORIGIN))->num_rows()>0){
			// Suppresion de l'archive
			$this->db->where('CODE_ORIGIN', $CODE_ORIGIN);
			$this->db->delete('QC1_REP_SRC_ORIGIN');
		}
		return $CODE_ORIGIN ;	
	}
	
}
?>