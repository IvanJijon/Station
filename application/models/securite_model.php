<?php
class Securite_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**********************************************************
	 *   					     		SECURITE	UTILISATEURS 		 			    	    *
	 **********************************************************/

	function listeUtilisateurs () {
		
		//Jointures sur la table profil
		$this->db->join('QC1_REP_SEC_PROFILE', 'QC1_REP_SEC_PROFILE.CODE_PROFILE = QC1_REP_SEC_USER.CODE_PROFILE');
		//On ordonne les enregistrement par le USERNAME par ordre croissant
		$this->db->order_by('USERNAME', 'ASC');
		// Puis on sort les éléments de la table QC1_REP_SEC_USER
		return  $this->db->get('QC1_REP_SEC_USER')->result();	
	}
	
	function infoUtilisateur ($CODE_USER) {		

		//Jointures sur la table profil
		$this->db->join('QC1_REP_SEC_PROFILE', 'QC1_REP_SEC_PROFILE.CODE_PROFILE = QC1_REP_SEC_USER.CODE_PROFILE');
		// Puis on sort les éléments de la table QC1_REP_SEC_USER ayant le CODE_USER mis en param
		$result = $this->db->get_where('QC1_REP_SEC_USER', array('CODE_USER' => $CODE_USER))->result();				
		return $result[0] ;	
	}
	
	function editerUtilisateur($myArray){
		// On check si on doit update ou insert
		if($myArray['CODE_USER']!=""){
			
			// On vérifie si on doit modifier le mot de passe
			if($myArray['PASSWORD']==""){
				
				//Pas de modification de password
				$this->db->where('CODE_USER', $myArray['CODE_USER']);	
				$this->db->update('QC1_REP_SEC_USER',array(
					'CODE_ENV'=>'1',
					'USERNAME'=>$myArray['USERNAME'],
					'FULLNAME'=>$myArray['FULLNAME'],
					'CODE_PROFILE'=>$myArray['CODE_PROFILE']
				));
			}else{
				//Update avec encryptage du mot de passe en md5
				$this->db->where('CODE_USER', $myArray['CODE_USER']);	
				$this->db->update('QC1_REP_SEC_USER',array(
					'CODE_ENV'=>'1',
					'USERNAME'=>$myArray['USERNAME'],
					'FULLNAME'=>$myArray['FULLNAME'],
					'PASSWORD'=>md5($myArray['PASSWORD']),
					'CODE_PROFILE'=>$myArray['CODE_PROFILE']
				));
			}
		}else{
			// Appel de la fonction qui retourne le dernier id de la table
			//$last = $this->main_model->get_last_id('QC1_REP_SEC_USER','CODE_USER');
			// On incrémente l'id
			//$last_id = $last[0]->CODE_USER + 1 ;
			
			// Insertion avec encryptage du mot de passe en md5
			$this->db->insert('QC1_REP_SEC_USER',array(
				//'CODE_USER'=>$last_id,
				'CODE_ENV'=>'1',
				'USERNAME'=>$myArray['USERNAME'],
				'FULLNAME'=>$myArray['FULLNAME'],
				'PASSWORD'=>md5($myArray['PASSWORD']),
				'CODE_PROFILE'=>$myArray['CODE_PROFILE']
			));
					
		}
	}
	
	function supprimerUtilisateur ($CODE_USER) {
				
		if($this->db->get_where('QC1_REP_SEC_USER', array('CODE_USER' => $CODE_USER))->num_rows()>0){
			// Suppresion de l'utilisateur
			$this->db->where('CODE_USER', $CODE_USER);
			$this->db->delete('QC1_REP_SEC_USER');
		}
		
		return $CODE_USER ;	
	}
	
	
	/**********************************************************
	 *   					     		   SECURITE	PROFILS 		    			    	    *
	 **********************************************************/
	
	function listeProfils() {
		$this->db->order_by ( 'NAME_PROFILE', 'ASC' );
		
		return $this->db->get ( 'QC1_REP_SEC_PROFILE' )->result ();
	}
	
	function infoProfil($CODE_PROFILE) {
		
		// Puis on sort les éléments de la table QC1_REP_SEC_USER ayant le CODE_USER mis en param
		$result = $this->db->get_where ( 'QC1_REP_SEC_PROFILE', array (
				'CODE_PROFILE' => $CODE_PROFILE 
		) )->result ();
		
		return $result [0];
	}
	
	function editerProfil($myArray) {
		
		// On check si on doit update ou insert
		if ($myArray ['CODE_PROFILE'] != "") {			
			$this->db->where ( 'CODE_PROFILE', $myArray ['CODE_PROFILE'] );
			$this->db->update('QC1_REP_SEC_PROFILE',array(
					'NAME_PROFILE'=>$myArray['NAME_PROFILE'],
					'DESC_PROFILE'=>$myArray['DESC_PROFILE'],
					'COLUMN_PROFILE'=>$myArray['COLUMN_PROFILE']					
			));
		} else {
			
			// Appel de la fonction qui retourne le dernier id de la table
			//$last = $this->main_model->get_last_id ( 'QC1_REP_SEC_PROFILE', 'CODE_PROFILE' );
			// On incrémente l'id
			//$last_id = $last [0]->CODE_USER + 1;			
			// Insertion avec encryptage du mot de passe en md5			
			$this->db->insert ( 'QC1_REP_SEC_PROFILE', array (					
					'NAME_PROFILE' => $myArray ['NAME_PROFILE'],					
					'DESC_PROFILE' => $myArray ['DESC_PROFILE'],					
					'COLUMN_PROFILE' => $myArray ['COLUMN_PROFILE'] 
			));
			
		}
	}
	
	function supprimerProfil($CODE_PROFILE) {
		if ($this->db->get_where ( 'QC1_REP_SEC_PROFILE', array (
				'CODE_PROFILE' => $CODE_PROFILE
		) )->num_rows () > 0) {				
			// Suppresion de l'utilisateur
			$this->db->where ( 'CODE_PROFILE', $CODE_PROFILE );
			$this->db->delete ( 'QC1_REP_SEC_PROFILE' );
		}
	
		return $CODE_USER;
	}
	
	function listeProfilsColumn(){
		$listeProfils = $this->listeProfils();
		$listeProfilsColumn=array();
		foreach($listeProfils as $profil){
			$listeProfilsColumn[$profil->COLUMN_PROFILE] = $profil;
		}
		return $listeProfilsColumn;
	}
	
	
	/**********************************************************
	 *   					     		SECURITE	PERMISSIONS 		 			    	    *
	 **********************************************************/
	
	function listeModules($PARENT_ID){
		$this->db->order_by('ITEM_ORDER','ASC');
		return $this->db->get_where('QC1_REP_SEC_MOD_DEFINITION',array('PARENT_ID'=>$PARENT_ID))->result();
	}
	
	function updatePermissionModule($ITEM_ID,$CODE_PROFILE,$perm){
		$infoProfil = $this->infoProfil($CODE_PROFILE);
		
		$this->db->where('ITEM_ID',$ITEM_ID);
		$this->db->update('QC1_REP_SEC_MOD_DEFINITION',array($infoProfil->COLUMN_PROFILE=>$perm));
		
		//Verification de permission du module parent
		
		$infoModule = $this->db->get_where('QC1_REP_SEC_MOD_DEFINITION',array('ITEM_ID'=>$ITEM_ID))->result();
		
		$listeModules = $this->listeModules($infoModule[0]->PARENT_ID);
		$permParent=0;
		
		$profil = $infoProfil->COLUMN_PROFILE;
		
		foreach($listeModules as $mod){
			if($permParent==0){
				if($mod->$profil==1){
					$permParent=1;
				}
			}
		}
		
		$this->db->where('ITEM_ID',$infoModule[0]->PARENT_ID);
		$this->db->update('QC1_REP_SEC_MOD_DEFINITION',array($infoProfil->COLUMN_PROFILE=>$permParent));
		
		return $infoModule[0]->PARENT_ID;
	}
}
?>