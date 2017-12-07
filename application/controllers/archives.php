<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Archives extends CI_Controller {
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
		$this->lang->load('archives',$data['lang']);
		// On load le helper 
		$this->load->helper('function');
		//On vérifie si l'utilisateur est connecté
		if($_SESSION['session-bihrdy']['acces']=="ok")
		{	
			//On load le model archives
			$this->load->model('archives_model');
			if($this->main_model->isAccessModules('archives')){
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
	 *   					     	   			ARCHIVES    	            			 				*
	 **********************************************************/
	 
	function liste_archives($data){
		// Vérification droit user sur le module
		if(!$this->main_model->isAccessModules('archives')){
			redirect(base_url(),'location');	
		}
		// On appelle la liste des archives
		$data['listeArchives'] = $this->archives_model->listeArchives();
		// On check les messages pour les notification : archive bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		$this->load->view('archives/gestion/liste_archives',$data);
	}
	
	function editer_archive($data){
		if(!$this->main_model->isAccessModules('archives')){
			redirect(base_url(),'location');	
		}
		// On vérifie si un post est envoyé
		if($_POST){
			// On appelle la fonction d'edition
			$this->archives_model->editerArchive($_POST);
			redirect(base_url().'archives/liste_archives','location');
		}
		// On check si on a un identifiant en segment 3
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations de l'archive
			$data['infoArchive'] = $this->archives_model->infoArchive($this->uri->segment(3));
		}
		//On stock dans une variable la liste des archives
		$data['listeArchives'] = $this->archives_model->listeArchives();
		//On stock dans une variable la liste des types d'archive
		$data['listeArchivesTypes'] = $this->archives_model->listeArchivesTypes();
		$this->load->view('archives/gestion/editer_archive',$data);
	}
	
	function supprimer_archive($data){
		if(!$this->main_model->isAccessModules('archives')){
			redirect(base_url(),'location');	
		}
		// On supprime l'utilisateur
		$this->archives_model->supprimerArchive($this->uri->segment(3));
		// On redirige sur la liste avec un segment delok
		redirect(base_url().'archives/liste_archives/delok','location');
	}
	
	/**********************************************************
	 *   					        	           	TYPES   	            			    			*
	 **********************************************************/
	 
	function liste_types($data){
		// Vérification droit user sur le module
		if(!$this->main_model->isAccessModules('archives')){
			redirect(base_url(),'location');
		}
		// On appelle la liste des types d'archive
		$data['listeArchivesTypes'] = $this->archives_model->listeArchivesTypes();
		// On check les messages pour les notification : type d'archive bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		$this->load->view('archives/gestion/liste_types',$data);
	}
	
	function editer_type($data){
		if(!$this->main_model->isAccessModules('archives')){
			redirect(base_url(),'location');
		}
		// On vérifie si un post est envoyé
		if($_POST){
			// On appelle la fonction d'edition
			$this->archives_model->editerArchiveType($_POST);
			redirect(base_url().'archives/liste_types','location');
		}
		// On check si on a un identifiant en segment 3
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations de l'archive
			$data['infoArchiveType'] = $this->archives_model->infoArchiveType($this->uri->segment(3));
		}
		//On stock dans une variable la liste des archives
		$data['listeArchives'] = $this->archives_model->listeArchives();
		//On stock dans une variable la liste des types d'archive
		$data['listeArchivesTypes'] = $this->archives_model->listeArchivesTypes();
		$this->load->view('archives/gestion/editer_type',$data);
	}
	
	function supprimer_type($data){
		if(!$this->main_model->isAccessModules('archives')){
			redirect(base_url(),'location');
		}
		// On supprime l'utilisateur
		$this->archives_model->supprimerArchiveType($this->uri->segment(3));
		// On redirige sur la liste avec un segment delok
		redirect(base_url().'archives/liste_types/delok','location');
	}
}
/* End of file archives.php */
/* Location: ./application/controllers/welcome.php */