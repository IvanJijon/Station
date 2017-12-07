<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuration extends CI_Controller {
	
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
		$this->lang->load('configuration',$data['lang']);
		
		//On vérifie si l'utilisateur est connecté
		if($_SESSION['session-bihrdy']['acces']=="ok")
		{	
			//On load le model configuration et données
			$this->load->model('configuration_model');
			$this->load->model('donnees_model');
			
			if($this->main_model->isAccessModules('configuration')){
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
	 *   					     	   			MODULES    	   *
	 **********************************************************/
	
	// Configuration / Modules
	function liste_modules($data){
	
		if(!$this->main_model->isAccessModules('configuration')){
			redirect(base_url(),'location');
		}
		
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		
		$data['listeModules'] = $this->configuration_model->listeModules(0);
		
		foreach($data['listeModules'] as $mod){
			$mod->sous_modules = $this->configuration_model->listeModules($mod->ITEM_ID);
		}		
		
		$this->load->model('securite_model');
		$data['listeProfilsColumn'] = $this->securite_model->listeProfilsColumn();
		
		$this->load->view('configuration/modules/liste_modules',$data);
	}
	
	function editer_module($data){
		if(!$this->main_model->isAccessModules('configuration')){
			redirect(base_url(),'location');
		}
		
		if($_POST){
			// On appelle la fonction d'edition
			$this->configuration_model->editerModule($_POST);
			redirect(base_url().'configuration/liste_modules','location');
		}
		
		if($this->uri->segment(3)!=""){
			$data['infoModule'] = $this->configuration_model->infoModule($this->uri->segment(3));
		}
		
		$data['listeModules'] = $this->configuration_model->listeModules(0);
		
		$this->load->view('configuration/modules/editer_module',$data);
	}
	
	function supprimer_module($data){
	
		if(!$this->main_model->isAccessModules('configuration')){
			redirect(base_url(),'location');
		}
		
		$this->configuration_model->supprimerModule($this->uri->segment(3));
		
		redirect(base_url().'configuration/liste_modules/delok','location');
	}
	
	/**********************************************************
	 *   					SEQUENCES	          			  *
	 **********************************************************/
	
	function liste_sequences($data){
		
		//Verification d'accès au module indicateurs de paue
		if(!$this->main_model->isAccessModules('sequences')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(3)=="supprimer_sequence" && is_numeric($this->uri->segment(4))){
			$this->configuration_model->supprimerSequence($this->uri->segment(4));
			redirect(base_url().'configuration/liste_sequences/delok','location');
		}
		
		// On appelle la liste des séquences
		$data['listeSequences'] = $this->configuration_model->listeSequences();
		
		//Création des tableau de séquences pour ERR_GOTO
		$data['listeSequencesArray'] = array();
		foreach($data['listeSequences'] as $sequence){
			$data['listeSequencesArray'][$sequence->CODE_SEQ]=$sequence;
		}
		
		// On check les messages pour les notification : indicateur bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		$this->load->view('configuration/sequences/liste_sequences',$data);
	}
	
	function editer_sequence($data){
		
		//Verification d'accès au module paie
		if(!$this->main_model->isAccessModules('sequences')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){
			
			// On appelle la fonction d'edition
			$this->configuration_model->editerSequence($_POST,$this->uri->segment(3));
			redirect(base_url().'configuration/liste_sequences','location');
			
		}
		
		// On check si on est en train de copier une SEQUENCE
		if($this->uri->segment(3)=="copier_sequence" && is_numeric($this->uri->segment(4))){
			// On appelle la fonction qui retourne les informations de la séquence
			$data['infoSequence'] = $this->configuration_model->infoSequence($this->uri->segment(4));
			// On enlève le CODE_SEQ pour eviter de faire un UPDATE et générer ainsi un INSERT
			$data['infoSequence']->CODE_SEQ = "";
		}
		
		// On check si on a un identifiant en segment 3		
		if($this->uri->segment(3)!="" && is_numeric($this->uri->segment(3))){
			// On appelle la fonction qui retourne les informations de la séquence
			$data['infoSequence'] = $this->configuration_model->infoSequence($this->uri->segment(3));
		}
		
		$data['listeSequences'] = $this->configuration_model->listeSequences();
		
		//Création des tableau de séquences pour ERR_GOTO
		$data['listeSequencesArray'] = array();
		foreach($data['listeSequences'] as $sequence){
			$data['listeSequencesArray'][$sequence->CODE_SEQ]=$sequence;
		}
		
		$this->load->view('configuration/sequences/editer_sequence',$data);
	}
	
	function fiche_sequence($data){
		
	//Verification d'accès au module paie
		if(!$this->main_model->isAccessModules('sequences')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(4)=="supprimer_step"){
			$this->configuration_model->supprimerSequenceStep($this->uri->segment(5));
			redirect(base_url()."configuration/fiche_sequence/".$this->uri->segment(3)."/delok",'location');
		}else{
			$data['msg']=$this->uri->segment(4);
		}
				
		// On check si on a un identifiant en segment 3
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations de la séquence
			$data['infoSequence'] = $this->configuration_model->infoSequence($this->uri->segment(3));
		}else{
			redirect(base_url().'configuration/liste_sequences','location');
		}
		
		$this->load->view('configuration/sequences/fiche_sequence',$data);
	}
	
	function editer_sequence_step($data){
		//Verification d'accès au module historiques
		if(!$this->main_model->isAccessModules('sequences')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){
			if(is_numeric($this->uri->segment(4))){
				$CODE_STEP=$this->uri->segment(4);
			}else{
				$CODE_STEP="";
			}
			// On appelle la fonction d'edition
			$this->configuration_model->editerSequenceStep($_POST,$this->uri->segment(3),$CODE_STEP);
			redirect(base_url().'configuration/fiche_sequence/'.$this->uri->segment(3),'location');
		}
		
		// On check si on est en train de copier un STEP
		if($this->uri->segment(4)=="copier_step" && is_numeric($this->uri->segment(5))){
			// On appelle la fonction qui retourne les informations du historique
			$data['infoStepSequence'] = $this->configuration_model->infoStepSequence($this->uri->segment(5));
			// On enlève le CODE_STEP pour eviter de faire un UPDATE et générer ainsi un INSERT.
			$data['infoStepSequence']->CODE_STEP = "";
		}
		
		// On check si on a un identifiant en segment 4
		if($this->uri->segment(4) !="" && is_numeric($this->uri->segment(4))){
			// On appelle la fonction qui retourne les informations du historique
			$data['infoStepSequence'] = $this->configuration_model->infoStepSequence($this->uri->segment(4));
		}
		$data['listeJobs'] = $this->configuration_model->listeJobs();
		
		$this->load->view('configuration/sequences/editer_sequence_step',$data);
	}
	
	function export_sequence_step($data){
		//Verification d'accès au module fusions
		if(!$this->main_model->isAccessModules('sequencess')){
			redirect(base_url(),'location');	
		}
		
		// Récupération des informations de la fusion
		$infoSequence = $this->configuration_model->infoSequence($this->uri->segment(3));
		// On load le model excel
		$this->load->model('excel_model');
		// Création du nom du fichier
		$file=$infoSequence->NAME_SEQ.".xls";
		// Création du titre du fichier
		$titre=$infoSequence->NAME_SEQ;
		// Création du tableau contenant les données
		$data['data']=array();
		//création de la variable définissant le nombre de ligne en mettant 1 pour l'entête
		$data['numRows']=1;
		//Nombre de colonne
		$data['numCols']=13;
		//Préparation entête
		$data['data'][0]= array(
			$this->lang->line('sequence-step-name-job'),
			$this->lang->line('sequence-step-name'),
			$this->lang->line('sequence-step-description'),
			$this->lang->line('sequence-step-projet'),
			$this->lang->line('sequence-step-chemin-files'),
			$this->lang->line('sequence-step-chemin-job'),
			$this->lang->line('sequence-step-chemin-librairy'),
			$this->lang->line('sequence-step-param-java-xms'),
			$this->lang->line('sequence-step-param-java-xmx'),
			$this->lang->line('sequence-step-index'),
			$this->lang->line('sequence-step-flg-exec'),
			$this->lang->line('sequence-step-flg-stop'),
			$this->lang->line('sequence-step-contexte')
		);
		
		//Préparation data
		foreach($infoSequence->listeSteps as $step){
			//Incrémentationd du nombre de ligne
			$data['numRows']++;
			// Préparation de l'affichage du flag
			if($step->FLG_EXEC==1){$flg_exec=$this->lang->line('yes');}else{$flg_exec=$this->lang->line('no');}
			if($step->FLG_STOP==1){$flg_stop=$this->lang->line('yes');}else{$flg_stop=$this->lang->line('no');}
			$data['data'][count($data['data'])]= array(
				$step->NAME_JOB,
	            $step->NAME_STEP,
	            $step->DESC_STEP,
	            $step->PROJECT,
	            $step->CLASSPATH,
	            $step->JOB_FOLDER,
	            $step->LIB_FOLDER,
	            $step->JAVA_XMS,
	            $step->JAVA_XMX,
	            $step->STEP_ORDER,
				$flg_beg,
				$flg_stop,
				$step->STEP_CONTEXT
			);
		}
		// Appel de la création du fichier excel
		$this->excel_model->writeData($file,$titre,$data);
	}
	
	/**********************************************************
	 *   					Jobs		          			  *
	 **********************************************************/
	
	function liste_jobs($data){
		//Verification d'accès au module indicateurs de paue
		if(!$this->main_model->isAccessModules('jobs')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(3)=="supprimer_job" && is_numeric($this->uri->segment(4))){
			$this->configuration_model->supprimerJob($this->uri->segment(4));
			redirect(base_url().'configuration/liste_jobs/delok','location');
		}
		
		// On appelle la liste des séquences
		$data['listeJobs'] = $this->configuration_model->listeJobs();
		
		// On check les messages pour les notification : indicateur bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		$this->load->view('configuration/jobs/liste_jobs',$data);
	}
	
	function editer_job($data){
		//Verification d'accès au module paie
		if(!$this->main_model->isAccessModules('jobs')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){
			
			// On appelle la fonction d'edition
			$this->configuration_model->editerJob($_POST,$this->uri->segment(3));
			redirect(base_url().'configuration/liste_jobs','location');
			
		}
		
		// On check si on a un identifiant en segment 3		
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations de la séquence
			$data['infoJob'] = $this->configuration_model->infoJob($this->uri->segment(3));
		}
		
		$this->load->view('configuration/jobs/editer_job',$data);
	}
	
	
	/***********************************************************
	 *   						Dictionnaire	   			   *
	 ***********************************************************/
	
	function liste_dictionnaire($data){
		
		//Verification d'accès au module dictionnaire
		if(!$this->main_model->isAccessModules('dictionnaire')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(3)=="supprimer_domaine" && is_numeric($this->uri->segment(4))){
			$this->configuration_model->supprimerDomaine($this->uri->segment(4));
			redirect(base_url().'configuration/liste_dictionnaire/delok','location');
		}
		
		// On appelle la liste des dictionnaires
		$data['listeDictionnaire'] = $this->configuration_model->listeDictionnaire();
		
		
		// On check les messages pour les notification : dictionnaire bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		$this->load->view('configuration/dictionnaire/liste_dictionnaire',$data);
	}
	
	function editer_domaine($data){
		
		//Verification d'accès au module paie
		if(!$this->main_model->isAccessModules('dictionnaire')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){			
			// On appelle la fonction d'edition
			$this->configuration_model->editerDomaine($_POST,$this->uri->segment(3));
			redirect(base_url().'configuration/liste_dictionnaire','location');			
		}
		
		// On check si on est en train de copier un domaine
		if($this->uri->segment(3)=="copier_domaine" && is_numeric($this->uri->segment(4))){
			// On appelle la fonction qui retourne les informations du domaine
			$data['infoDomaine'] = $this->configuration_model->infoDomaine($this->uri->segment(4));
			// On enlève le CODE_DOMAIN pour eviter de faire un UPDATE du domaine que l'on copie et générer ainsi un INSERT.
			$data['infoDomaine']->CODE_DOMAIN = "";
		}
		
		// On check si on a un identifiant en segment 3	
		if($this->uri->segment(3)!="" && is_numeric($this->uri->segment(3))){
			// On appelle la fonction qui retourne les informations du domaine
			$data['infoDomaine'] = $this->configuration_model->infoDomaine($this->uri->segment(3));
		}
		
		// On recupere la liste des dictionnaires
		$data['dictionnairesExistants'] = $this->configuration_model->dictionnairesExistants();
		
		$this->load->view('configuration/dictionnaire/editer_domaine',$data);
	}
	
	function fiche_domaine($data){
		//Verification d'accès au module paie
		if(!$this->main_model->isAccessModules('dictionnaire')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(4)=="supprimer_attribut"){
			$this->configuration_model->supprimerAttribut($this->uri->segment(5));
			redirect(base_url()."configuration/fiche_domaine/".$this->uri->segment(3)."/delok",'location');
		}else{
			$data['msg']=$this->uri->segment(4);
		}
				
		// On check si on a un identifiant en segment 3
		
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations du domaine
			$data['infoDomaine'] = $this->configuration_model->infoDomaine($this->uri->segment(3));	
			$data['listeTypes'] = $this->donnees_model->listeTypes();
		}else{
			redirect(base_url().'configuration/liste_dictionnaire','location');
		}
		
		$this->load->view('configuration/dictionnaire/fiche_domaine',$data);
	}
	
	function editer_attribut($data){
		//Verification d'accès au module historiques
		if(!$this->main_model->isAccessModules('dictionnaire')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){
			if(is_numeric($this->uri->segment(4))){
				$CODE_ATTRIBUTE=$this->uri->segment(4);
			}else{
				$CODE_ATTRIBUTE="";
			}
			// On appelle la fonction d'edition
			$this->configuration_model->editerAttribut($_POST,$this->uri->segment(3),$CODE_ATTRIBUTE);
			redirect(base_url().'configuration/fiche_domaine/'.$this->uri->segment(3),'location');
		}
		
		// On check si on est en train de copier un attribut
		if($this->uri->segment(4)=="copier_attribut" && is_numeric($this->uri->segment(5))){
			// On appelle la fonction qui retourne les informations du domaine
			$data['infoAttribut'] = $this->configuration_model->infoAttribut($this->uri->segment(5));
			// On enlève le CODE_DOMAIN pour eviter de faire un UPDATE du domaine que l'on copie et générer ainsi un INSERT.
			$data['infoAttribut']->CODE_ATTRIBUTE = "";
			$data['listeTypes'] = $this->donnees_model->listeTypes();
		}
		
		// On check si on a un identifiant en segment 3 (CODE_DOMAIN) et en segment 4 (CODE_ATTRIBUTE) : EDITION
		if(is_numeric($this->uri->segment(4))){
			// On appelle la fonction qui retourne les informations de l'attribut
			$data['infoAttribut'] = $this->configuration_model->infoAttribut($this->uri->segment(4));
			$data['listeTypes'] = $this->donnees_model->listeTypes();
		}
		
		// On check si on a un identifiant en segment 3 (CODE_DOMAIN) seulement : CREATION
		if(is_numeric($this->uri->segment(3)) && $this->uri->segment(4)==null){
			$data['listeTypes'] = $this->donnees_model->listeTypes();
		}
		
		$this->load->view('configuration/dictionnaire/editer_attribut',$data);
	}
}

/* End of file configuration.php */
/* Location: ./application/controllers/configuration.php */