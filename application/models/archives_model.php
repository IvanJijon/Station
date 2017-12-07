<?php
class Archives_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	//Archives / Gestion des Archives
	function listeArchives () {
		$this->db->join('QC1_REP_ARC_TYPE', 'QC1_REP_ARC_TYPE.CODE_TYPE_ARCHIVE = QC1_REP_ARC_DEFINITION.CODE_TYPE_ARCHIVE');
		//On ordonne les enregistrement par le USERNAME par ordre croissant
		$this->db->order_by('NAME_ARCHIVE', 'ASC');
		// Puis on sort les éléments de la table QC1_REP_ARC_DEFINITION
		return  $this->db->get('QC1_REP_ARC_DEFINITION')->result();	
	}
	
	function infoArchive ($CODE_ARCHIVE) {		
		// Puis on sort les éléments de la table QC1_REP_ARC_DEFINITION ayant le CODE_USER mis en param
		$result = $this->db->get_where('QC1_REP_ARC_DEFINITION', array('CODE_ARCHIVE' => $CODE_ARCHIVE))->result();				
		return $result[0] ;	
	}
	
	function editerArchive($myArray){

		// On check si on doit update ou insert
		if($myArray['CODE_ARCHIVE']!=""){
			$this->db->where('CODE_ARCHIVE', $myArray['CODE_ARCHIVE']);	
			$this->db->update('QC1_REP_ARC_DEFINITION',array(
				'NAME_ARCHIVE'=>$myArray['NAME_ARCHIVE'],
				'DESC_ARCHIVE'=>$myArray['DESC_ARCHIVE'],
				'CODE_TYPE_ARCHIVE'=>$myArray['CODE_TYPE_ARCHIVE'],
				'DAT_BEG'=>dateToDateSql($myArray['DAT_BEG']),
				'DAT_END'=>dateToDateSql($myArray['DAT_END']),
				'DAT_NEXT_RUN'=>dateToDateSql($myArray['DAT_NEXT_RUN']),
				'DAT_NEXT_DEL'=>dateToDateSql($myArray['DAT_NEXT_DEL'])
			));
			return 	$myArray['CODE_ARCHIVE'];
		}else{			
			$this->db->insert('QC1_REP_ARC_DEFINITION',array(
				'NAME_ARCHIVE'=>$myArray['NAME_ARCHIVE'],
				'DESC_ARCHIVE'=>$myArray['DESC_ARCHIVE'],
				'CODE_TYPE_ARCHIVE'=>$myArray['CODE_TYPE_ARCHIVE'],
				'DAT_BEG'=>dateToDateSql($myArray['DAT_BEG']),
				'DAT_END'=>dateToDateSql($myArray['DAT_END']),
				'DAT_NEXT_RUN'=>dateToDateSql($myArray['DAT_NEXT_RUN']),
				'DAT_NEXT_DEL'=>dateToDateSql($myArray['DAT_NEXT_DEL'])
			));
			//return $this->db->insert_id() ;
		}
	}
	
	function supprimerArchive ($CODE_ARCHIVE) {
		if($this->db->get_where('QC1_REP_ARC_DEFINITION', array('CODE_ARCHIVE' => $CODE_ARCHIVE))->num_rows()>0){
			// Suppresion de l'archive
			$this->db->where('CODE_ARCHIVE', $CODE_ARCHIVE);
			$this->db->delete('QC1_REP_ARC_DEFINITION');
		}
		return $CODE_ARCHIVE ;	
	}
	
	//Archives / Types d'Archive
	function listeArchivesTypes () {
		//On ordonne les enregistrement par le USERNAME par ordre croissant
		$this->db->order_by('NAME_TYPE_ARCHIVE', 'ASC');
		// Puis on sort les éléments de la table QC1_REP_ARC_DEFINITION
		return  $this->db->get('QC1_REP_ARC_TYPE')->result();
	}
	
	function infoArchiveType ($CODE_TYPE_ARCHIVE) {
		// Puis on sort les éléments de la table QC1_REP_ARC_DEFINITION ayant le CODE_USER mis en param
		$result = $this->db->get_where('QC1_REP_ARC_TYPE', array('CODE_TYPE_ARCHIVE' => $CODE_TYPE_ARCHIVE))->result();
		return $result[0] ;
	}
	
	function editerArchiveType($myArray){
		// On check si on doit update ou insert
		if($myArray['CODE_TYPE_ARCHIVE']!=""){
			$this->db->where('CODE_TYPE_ARCHIVE', $myArray['CODE_TYPE_ARCHIVE']);
			$this->db->update('QC1_REP_ARC_TYPE',array(
					'NAME_TYPE_ARCHIVE'=>$myArray['NAME_TYPE_ARCHIVE'],
					'DESC_TYPE_ARCHIVE'=>$myArray['DESC_TYPE_ARCHIVE']
			));
			return 	$myArray['CODE_TYPE_ARCHIVE'];
		}else{
			$this->db->insert('QC1_REP_ARC_TYPE',array(
					'NAME_TYPE_ARCHIVE'=>$myArray['NAME_TYPE_ARCHIVE'],
					'DESC_TYPE_ARCHIVE'=>$myArray['DESC_TYPE_ARCHIVE']
			));
			//return $this->db->insert_id() ;
		}
	}
	
	function supprimerArchiveType ($CODE_TYPE_ARCHIVE) {
		if($this->db->get_where('QC1_REP_ARC_TYPE', array('CODE_TYPE_ARCHIVE' => $CODE_TYPE_ARCHIVE))->num_rows()>0){
			// Suppresion de l'archive
			$this->db->where('CODE_TYPE_ARCHIVE', $CODE_TYPE_ARCHIVE);
			$this->db->delete('QC1_REP_ARC_TYPE');
		}
		return $CODE_TYPE_ARCHIVE ;
	}
}
?>