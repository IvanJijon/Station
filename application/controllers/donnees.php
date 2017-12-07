<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Donnees extends CI_Controller {
	
	function _remap($method)
	{
		$data=array();	
		if(isset($_SESSION['langue'])){ // On check si la langue est en session, ce qui veut dire que l'utilisateur a choisit la langue via les flags
			$data['lang']=$_SESSION['langue'];	
		}elseif($_SESSION['session-bihrdy']['infoUser']['LANG']!=""){ // On check si l'utilisateur à une langue par défaut dans son profil
			$data['lang']=$_SESSION['session-bihrdy']['infoUser']['LANG'];
		}else{ // Sinon on check la langue de son naviateur
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			// On fait une condition pour gérer si la langue du navigateur est dans une autre langue qu'anglais ou francais.
			if($lang!="fr"){
				$data['lang']="en";
			}else{
				$data['lang']=$lang;
			}
		}
		// On load les ressources de langue générales
		$this->lang->load('general',$data['lang']);
		$this->lang->load('donnees',$data['lang']);
		
		// On load les helpers
		$this->load->helper('download');		
		
		//On vérifie si l'utilisateur est connecté
		if($_SESSION['session-bihrdy']['acces']=="ok")
		{	
			//On load le model donnees
			$this->load->model('donnees_model');
			//On load le model excel
			$this->load->model('excel_model');
			
			if($this->main_model->isAccessModules('donnees')){
				//Alors on appelle la methode appelé
				$this->$method($data);			
			}else{
				redirect(base_url(),'location');	
			}
		}else{			
			// Redirection page de login
			redirect(base_url(),'location');				
		}
	}
	
	/**********************************************************
	 *   				FICHIERS SOURCES		           	  *
	 **********************************************************/
	
	function liste_fichiers_sources($data){
		
		//Verification d'accès au module fichiers-sources
		if(!$this->main_model->isAccessModules('fichiers-sources')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(3)=="supprimer_fichier_source" && is_numeric($this->uri->segment(4))){
			$this->donnees_model->supprimerFichierSource($this->uri->segment(4));
			redirect(base_url().'donnees/liste_fichiers_sources/delok','location');
		}
		
		// On appelle la liste des Fichiers Source
		$data['listeFichiersSources'] = $this->donnees_model->listeFichiersSources();
		
		// On check les messages pour les notification : historique bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		$this->load->view('donnees/fichiers-sources/liste_fichiers_sources',$data);
	}
	
	function editer_fichier_source($data){
		//Verification d'accès au module fichiers-sources
		if(!$this->main_model->isAccessModules('fichiers-sources')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){			
			// On appelle la fonction d'edition
			//dump($_POST);
			$this->donnees_model->editerFichierSource($_POST,$this->uri->segment(3));
			redirect(base_url().'donnees/liste_fichiers_sources','location');			
		}
		
		// On check si on est en train de copier un fichier source	
		if($this->uri->segment(3)=="copier_fichier_source" && is_numeric($this->uri->segment(4))){
			// On appelle la fonction qui retourne les informations du historique
			$data['infoFichierSource'] = $this->donnees_model->infoFichierSource($this->uri->segment(4));
			// On enlève le CODE_FILE pour eviter de faire un UPDATE et générer ainsi un INSERT.
			$data['infoFichierSource']->CODE_FILE="";
		}
		
		// On check si on a un identifiant en segment 3		
		if($this->uri->segment(3)!="" && is_numeric($this->uri->segment(3))){
			// On appelle la fonction qui retourne les informations du historique
			$data['infoFichierSource'] = $this->donnees_model->infoFichierSource($this->uri->segment(3));
		}
		
		$this->load->model('referentiels_model');
		$data['listeDomains'] = $this->referentiels_model->listeDomains();
		$data['listeConnexions'] = $this->donnees_model->listeConnexions();
		$data['listeOrigines'] = $this->donnees_model->listeOrigines();
		
		$this->load->view('donnees/fichiers-sources/editer_fichier_source',$data);
	}
	
	function fiche_fichier_source($data){
		//Verification d'accès au module fichiers-sources
		if(!$this->main_model->isAccessModules('fichiers-sources')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(4)=="supprimer_field"){
			$this->donnees_model->supprimerFichierSourceField($this->uri->segment(5));
			redirect(base_url()."donnees/fiche_fichier_source/".$this->uri->segment(3)."/delok",'location');
		}else{
			$data['msg'] = $this->uri->segment(4);
		}
		
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations du historique
			$data['infoFichierSource'] = $this->donnees_model->infoFichierSource($this->uri->segment(3));
		}
		$this->load->view('donnees/fichiers-sources/fiche_fichier_source',$data);
	}
	
	function editer_fichier_source_field($data){
		//Verification d'accès au module fichiers-sources
		if(!$this->main_model->isAccessModules('fichiers-sources')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){
			if(is_numeric($this->uri->segment(4))){
				$CODE_FIELD=$this->uri->segment(4);
			}else{
				$CODE_FIELD="";
			}
			// On appelle la fonction d'edition
			$this->donnees_model->editerFichierSourceField($_POST,$this->uri->segment(3),$CODE_FIELD);
			redirect(base_url().'donnees/fiche_fichier_source/'.$this->uri->segment(3),'location');
		}elseif($_GET['action']=="test"){
			$this->donnees_model->editerFichierSourceField($_POST,$this->uri->segment(3),$CODE_FIELD);			
		}
		
		// On check si on est en train de copier un champ		
		if($this->uri->segment(4)=="copier_field" && is_numeric($this->uri->segment(5))){
			// On appelle la fonction qui retourne les informations du champ
			$data['infoFichierSourceField'] = $this->donnees_model->infoFichierSourceField($this->uri->segment(5));
			$data['infoFichierSourceField']->CODE_FIELD = "";
		}
		
		// On check si on a un identifiant en segment 4		
		if($this->uri->segment(4)!="" && is_numeric($this->uri->segment(4))){
			// On appelle la fonction qui retourne les informations du champ
			$data['infoFichierSourceField'] = $this->donnees_model->infoFichierSourceField($this->uri->segment(4));
		}
		$data['listeTypes'] = $this->donnees_model->listeTypes();
		
		$this->load->view('donnees/fichiers-sources/editer_field_fichier_source',$data);
	}
	
	function export_fichier_source_fields($data){
		//Verification d'accès au module fichiers-sources
		if(!$this->main_model->isAccessModules('fichiers-sources')){
			redirect(base_url(),'location');	
		}		
		// Récupération des informations du fichier
		$infoFichierSource = $this->donnees_model->infoFichierSource($this->uri->segment(3));		
		// Création du nom du fichier
		$file=$infoFichierSource->NAME_FILE.".xls";
		// Création du titre du fichier
		$titre=$infoFichierSource->NAME_FILE;
		// Création du tableau contenant les données
		$data['data']=array();
		// Création de la variable définissant le nombre de ligne en mettant 1 pour l'entête
		$data['numRows']=1;
		//Nombre de colonne
		$data['numCols']=5;
		//Préparation entête
		$data['data'][0]= array(
			$this->lang->line('fichier-source-fields-index'),
			$this->lang->line('fichier-source-fields-name-field'),
			$this->lang->line('fichier-source-fields-type-field'),
			$this->lang->line('fichier-source-fields-beg-hist'),
			$this->lang->line('fichier-source-fields-end-hist')
		);
		
		//Préparation data
		foreach($infoFichierSource->listeFields as $field){
			//Incrémentation du nombre de ligne
			$data['numRows']++;
			// Préparation de l'affichage du flag
			if($field->FLG_DAT_BEG_HIST==1){$flg_beg=$this->lang->line('yes');}else{$flg_beg=$this->lang->line('no');}
			if($field->FLG_DAT_END_HIST==1){$flg_end=$this->lang->line('yes');}else{$flg_end=$this->lang->line('no');}
			$data['data'][count($data['data'])]= array(
				$field->INDEX_FIELD,
				$field->NAME_FIELD,
				$field->TYPE_FIELD,
				$flg_beg,
				$flg_end
			);
		}
		// Appel de la création du fichier excel
		$this->excel_model->writeData($file,$titre,$data);
	}
	
	function import_fichiers_source($data){
		//Verification d'accès au module fichiers-sources
		if(!$this->main_model->isAccessModules('fichiers-sources')){
			redirect(base_url(),'location');	
		}
		if($_FILES){
			$file=$_FILES['file']['tmp_name'];
			$donnees = $this->excel_model->getSRCFiles($file);
			$retour = $this->donnees_model->importSRCFiles($donnees);
			redirect(base_url().'donnees/liste_fichiers_sources/import'.$retour,'location');
		}
		$this->load->view('donnees/fichiers-sources/import_fichier_source',$data);		
	}
	
	function export_exemple_fichiers_source(){				
		//Verification d'accès au module fichiers-sources
		if(!$this->main_model->isAccessModules('fichiers-sources')){
			redirect(base_url(),'location');	
		}		
		$data = file_get_contents(URL_FILES."SRC_FILES.xls"); // Read the file's contents
		$name = 'SRC_FILES.xls';
		force_download($name, $data);
	}
	
	function export_fichiers_source(){			
		//Verification d'accès au module fichiers-sources
		if(!$this->main_model->isAccessModules('fichiers-sources')){
			redirect(base_url(),'location');	
		}		
		
		$data['listeSimpleFichiersSource'] = $this->donnees_model->listeSimpleFichiersSource();		
		$data['listeSimpleChampsFichiersSource'] = $this->donnees_model->listeSimpleChampsFichiersSource();
		
		// Appel de la création du fichier excel
		$this->excel_model->exportSRCFiles($data);
	}
	
	/**********************************************************
	 *   					HISTORIQUES		           		  *
	 **********************************************************/
	
	function liste_historiques($data){
		
		//Verification d'accès au module historiques
		if(!$this->main_model->isAccessModules('historiques')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(3)=="supprimer_historique" && is_numeric($this->uri->segment(4))){
			$this->donnees_model->supprimerHistorique($this->uri->segment(4));
			redirect(base_url().'donnees/liste_historiques/delok','location');
		}
		
		// On appelle la liste des historiques
		$data['listeHistoriques'] = $this->donnees_model->listeHistoriques();
		
		// On check les messages pour les notification : historique bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		$this->load->view('donnees/historiques/liste_historiques',$data);
	}
	
	function editer_historique($data){
		
		//Verification d'accès au module historiques
		if(!$this->main_model->isAccessModules('historiques')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){
					
			// On appelle la fonction d'edition, en cas de création le segment 3 est vide
			$this->donnees_model->editerHistorique($_POST,$this->uri->segment(3));
			redirect(base_url().'donnees/liste_historiques','location');
			
		}
		
		// On check si on a un identifiant en segment 3
		
		if($this->uri->segment(3)!=""){		
			// On appelle la fonction qui retourne les informations du historique
			$data['infoHistorique'] = $this->donnees_model->infoHistorique($this->uri->segment(3));
		}
		
		// On appelle la liste des Fichiers Source
		$data['listeFichiersSources'] = $this->donnees_model->listeFichiersSources();
		
		$this->load->view('donnees/historiques/editer_historique',$data);
	}
	
	function fiche_historique($data){
		//Verification d'accès au module historiques
		if(!$this->main_model->isAccessModules('historiques')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(4)=="supprimer_field"){
			$this->donnees_model->supprimerHistoriqueField($this->uri->segment(5));
			redirect(base_url()."donnees/fiche_historique/".$this->uri->segment(3)."/delok",'location');
		}else{
			$data['msg'] = $this->uri->segment(4);
		}
		
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations du historique
			$data['infoHistorique'] = $this->donnees_model->infoHistorique($this->uri->segment(3));
		}
		$this->load->view('donnees/historiques/fiche_historique',$data);
	}
	
	function editer_champs_historique($data){
		
		//Verification d'accès au module historiques
		if(!$this->main_model->isAccessModules('historique')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){
			if(is_numeric($this->uri->segment(4))){
				$CODE_FIELD=$this->uri->segment(4);
			}else{
				$CODE_FIELD="";
			}
			// On appelle la fonction d'edition
			$this->donnees_model->editerHistoriqueChamp($_POST,$this->uri->segment(3),$CODE_FIELD);
			redirect(base_url().'donnees/fiche_historique/'.$this->uri->segment(3),'location');
		}
		
		// On check si on est en train de copier un Champ d'historique
		if($this->uri->segment(4)=="copier_field" && is_numeric($this->uri->segment(5))){
			// On appelle la fonction qui retourne les informations du champ d'historique
			$data['infoHistoriqueChamps'] = $this->donnees_model->infoHistoriqueChamps($this->uri->segment(5));
			// On enlève le CODE_FIELD pour eviter de faire un UPDATE et générer ainsi un INSERT.
			$data['infoHistoriqueChamps']->CODE_FIELD = "";
		}
		
		// On check si on a un identifiant en segment 4		
		if($this->uri->segment(4) !="" && is_numeric($this->uri->segment(4))){
			// On appelle la fonction qui retourne les informations du historique
			$data['infoHistoriqueChamps'] = $this->donnees_model->infoHistoriqueChamps($this->uri->segment(4));
		}
		
		$data['listeTypes'] = $this->donnees_model->listeTypes();
		
		$this->load->view('donnees/historiques/editer_historique_champs',$data);
	}
	
	function export_champs_historique($data){
		//Verification d'accès au module fusions
		if(!$this->main_model->isAccessModules('historiques')){
			redirect(base_url(),'location');	
		}
		
		// Récupération des informations de la fusion
		$infoHistorique = $this->donnees_model->infoHistorique($this->uri->segment(3));		
		// Création du nom du fichier
		$file=$infoHistorique->NAME_HIST.".xls";
		// Création du titre du fichier
		$titre=$infoHistorique->NAME_HIST;
		// Création du tableau contenant les données
		$data['data']=array();
		//création de la variable définissant le nombre de ligne en mettant 1 pour l'entête
		$data['numRows']=1;
		//Nombre de colonne
		$data['numCols']=6;
		//Préparation entête
		$data['data'][0]= array(
			$this->lang->line('historique-champs-index'),
			$this->lang->line('historique-champs-source'),
			$this->lang->line('historique-champs-destination'),
			$this->lang->line('historique-champs-fusion'),
			$this->lang->line('historique-champs-cle'),
			$this->lang->line('historique-champs-type')
		);
		
		//Préparation data
		foreach($infoHistorique->listeHistoriquesField as $field){
			//Incrémentationd u nombre de ligne
			$data['numRows']++;
			// Préparation de l'affichage du flag
			if($field->FLG_MERGE==1){$flg_merge=$this->lang->line('yes');}else{$flg_merge=$this->lang->line('no');}
			if($field->FLG_KEY_FIELD==1){$flg_key_field=$this->lang->line('yes');}else{$flg_key_field=$this->lang->line('no');}
			$data['data'][count($data['data'])]= array(
				$field->INDEX_FIELD,
				$field->SOURCE_COLUMN,
				$field->TARGET_COLUMN,
				$flg_merge,
				$flg_key_field,
				$field->TYPE_FIELD
			);
		}
		// Appel de la création du fichier excel
		$this->excel_model->writeData($file,$titre,$data);
	}
	
	/**********************************************************
	 *   					FUSIONS    	            		  *
	 **********************************************************/

	function liste_fusions($data){
		
		//Verification d'accès au module fusions
		if(!$this->main_model->isAccessModules('fusions')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(3)=="supprimer_fusion" && is_numeric($this->uri->segment(4))){
			$this->donnees_model->supprimerFusion($this->uri->segment(4));
			redirect(base_url().'donnees/liste_fusions/delok','location');
		}
		
		// On appelle la liste des fusions
		$data['listeFusions'] = $this->donnees_model->listeFusions();
		
		// On check les messages pour les notification : fusion bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		$this->load->view('donnees/fusions/liste_fusions',$data);
	}
	
	function editer_fusion($data){
		
		//Verification d'accès au module fusions
		if(!$this->main_model->isAccessModules('fusions')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){
			
			// On appelle la fonction d'edition
			$this->donnees_model->editerFusion($_POST,$this->uri->segment(3));
			redirect(base_url().'donnees/liste_fusions','location');			
		}
		
		// On check si on a un identifiant en segment 3
		
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations du fusion
			$data['infoFusion'] = $this->donnees_model->infoFusion($this->uri->segment(3));
		}
		$this->load->view('donnees/fusions/editer_fusion',$data);
	}
	
	function fiche_fusion($data){
		//Verification d'accès au module fusions
		if(!$this->main_model->isAccessModules('fusions')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations du fusion
			$data['infoFusion'] = $this->donnees_model->infoFusion($this->uri->segment(3));
		}
		$this->load->view('donnees/fusions/fiche_fusion',$data);
	}
	
	function editer_fusion_historique($data){
		//Verification d'accès au module fusions
		if(!$this->main_model->isAccessModules('fusions')){
			redirect(base_url(),'location');	
		}
		
		//Si données en post on modifie les fusions d'historiques
		if($_POST){
			$this->donnees_model->editerFusionHistorique($this->uri->segment(3),$_POST['listeHisto']);
			redirect(base_url()."donnees/fiche_fusion/".$this->uri->segment(3),'location');
		}
		
		// Liste des fusions historiques 
		$data['listeHistoriquesFusion'] = $this->donnees_model->listeHistoriquesFusions($this->uri->segment(3));
		
		// On crée un tableau d'id de fusion d'historique pour gérer l'affichage des deux liste de sélections
		$data['listeHistoriquesFusionArray']=array();
		foreach($data['listeHistoriquesFusion'] as $histo){
			$data['listeHistoriquesFusionArray'][count($data['listeHistoriquesFusionArray'])]=$histo->CODE_HIST;
		}
		// Liste de tous les historiques
		$data['listeHistoriques'] = $this->donnees_model->listeHistoriques();
		$data['CODE_FUSION'] = $this->uri->segment(3);
		
		$this->load->view('donnees/fusions/editer_fusion_historique',$data);
	}
	
	function editer_fusion_flg($data){
		//appel ajax
		$this->donnees_model->editerFusionFlg($this->uri->segment(3),$_POST['flag']);
	}
	
	function export_fusion_historique($data){
		//Verification d'accès au module fusions
		if(!$this->main_model->isAccessModules('fusions')){
			redirect(base_url(),'location');	
		}
		
		// Récupération des informations de la fusion
		$infoFusion = $this->donnees_model->infoFusion($this->uri->segment(3));
				
		// Création du nom du fichier
		$file=$infoFusion->CODE_TALEND.".xls";
		// Création du titre du fichier
		$titre=$infoFusion->CODE_TALEND;
		// Création du tableau contenant les données
		$data['data']=array();
		//création de la variable définissant le nombre de ligne en mettant 1 pour l'entête
		$data['numRows']=1;
		//Nombre de colonne
		$data['numCols']=2;
		//Préparation entête
		$data['data'][0]= array(
			$this->lang->line('fusion-code-historique'),
			$this->lang->line('fusion-master-historique')
		);
		
		//Préparation data
		foreach($infoFusion->listeHistoriques as $histo){
			//Incrémentationd u nombre de ligne
			$data['numRows']++;
			// Préparation de l'affichage du flag
			if($histo->FLG_MASTER_HIST==1){$flg_master=$this->lang->line('yes');}else{$flg_master=$this->lang->line('no');}
			$data['data'][count($data['data'])]= array(
				$histo->NAME_HIST,
				$flg_master
			);
		}
		// Appel de la création du fichier excel
		$this->excel_model->writeData($file,$titre,$data);		
	}
	
	/**********************************************************
	 *   					     	   			ORIGINES    	            			 				*
	 **********************************************************/
	 
	 function liste_origines($data){
		// Vérification droit user sur le module
		if(!$this->main_model->isAccessModules('origines')){
			//redirect(base_url(),'location');	
		}
		// On appelle la liste des origines
		$data['listeOrigines'] = $this->donnees_model->listeOrigines();
		// On check les messages pour les notification : origine bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		$this->load->view('donnees/origines/liste_origines',$data);
	}
	
	function editer_origine($data){
		if(!$this->main_model->isAccessModules('origines')){
			redirect(base_url(),'location');	
		}
		// On vérifie si un post est envoyé
		if($_POST){
			// On appelle la fonction d'edition
			$this->donnees_model->editerOrigine($_POST);
			redirect(base_url().'donnees/liste_origines','location');
		}
		// On check si on a un identifiant en segment 3
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations de l'origine
			$data['infoOrigine'] = $this->donnees_model->infoOrigine($this->uri->segment(3));
		}
		//On stock dans une variable la liste des origines
		$data['listeOrigines'] = $this->donnees_model->listeOrigines();
		$this->load->view('donnees/origines/editer_origines',$data);
	}
	
	function supprimer_origine($data){
		if(!$this->main_model->isAccessModules('origines')){
			redirect(base_url(),'location');	
		}
		// On supprime l'utilisateur
		$this->donnees_model->supprimerorigine($this->uri->segment(3));
		// On redirige sur la liste avec un segment delok
		redirect(base_url().'donnees/liste_origines/delok','location');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */