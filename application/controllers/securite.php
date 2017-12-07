<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Securite extends CI_Controller {
	
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
		$this->lang->load('securite',$data['lang']);
		
		//On vérifie si l'utilisateur est connecté
		if($_SESSION['session-bihrdy']['acces']=="ok")
		{	
			//On load le model utilisateurs
			$this->load->model('securite_model');
			
			if($this->main_model->isAccessModules('securite')){
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

	function liste_utilisateurs($data){
		
		if(!$this->main_model->isAccessModules('securite')){
			redirect(base_url(),'location');	
		}
		
		// On appelle la liste des utilisateurs
		$data['listeUtilisateurs'] = $this->securite_model->listeUtilisateurs();
		
		// On check les messages pour les notification : utilisateur bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		
		$this->load->view('securite/utilisateurs/liste_utilisateurs',$data);
	}
	
	function editer_utilisateur($data){
		
		if(!$this->main_model->isAccessModules('securite')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){
			
			// On appelle la fonction d'edition
			$this->securite_model->editerUtilisateur($_POST);
			redirect(base_url().'securite/liste_utilisateurs','location');
		}
		
		// On check si on a un identifiant en segment 3
		
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations de l'utilisateurs
			$data['infoUtilisateur'] = $this->securite_model->infoUtilisateur($this->uri->segment(3));
		}
		
		//On stock dans une variable la liste des profils
		$data['listeProfils'] = $this->securite_model->listeProfils();
		$this->load->view('securite/utilisateurs/editer_utilisateur',$data);
	}
	
	function supprimer_utilisateur($data){		
		if(!$this->main_model->isAccessModules('securite')){
			redirect(base_url(),'location');	
		}
		
		// On supprime l'utilisateur
		$this->securite_model->supprimerUtilisateur($this->uri->segment(3));
		// On redirige sur la liste avec un segment delok
		redirect(base_url().'securite/liste_utilisateurs/delok','location');
	}
	
	
	function gestion_permissions($data){
		if(!$this->main_model->isAccessModules('securite')){
			redirect(base_url(),'location');	
		}
		
		if($_POST){
			$data['ITEM_ID'] = $this->securite_model->updatePermissionModule($_POST['ITEM_ID'],$_POST['CODE_PROFILE'],1);
		}
		
		if($this->uri->segment(3)=="supprimer_permission" && is_numeric($this->uri->segment(4)) && is_numeric($this->uri->segment(5))){
			$data['ITEM_ID'] = $this->securite_model->updatePermissionModule($this->uri->segment(4),$this->uri->segment(5),0);
		}
		
		
		
		$data['listeModules'] = $this->securite_model->listeModules(0);
		foreach($data['listeModules'] as $mod){
			$mod->sous_modules = $this->securite_model->listeModules($mod->ITEM_ID);
		}
		$data['listeProfilsColumn'] = $this->securite_model->listeProfilsColumn();
		$this->load->view('securite/permissions/gestion-permissions',$data);
	}
	
	function liste_profils($data){
		
		if(!$this->main_model->isAccessModules('securite')){
			redirect(base_url(),'location');
		}
		
		$data['listeProfils'] = $this->securite_model->listeProfils();
		
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		
		$this->load->view('securite/profils/liste_profils',$data);
	}
	
	function editer_profil($data){
		
		if(!$this->main_model->isAccessModules('securite')){
			redirect(base_url(),'location');
		}
		
		if($_POST){
			// On appelle la fonction d'edition
			$this->securite_model->editerProfil($_POST);
			redirect(base_url().'securite/liste_profils','location');
		}
		
		if($this->uri->segment(3)!=""){
			$data['infoProfil'] = $this->securite_model->infoProfil($this->uri->segment(3));
		}
		$this->load->view('securite/profils/editer_profil',$data);
	}
	
	function supprimer_profil($data){
		if(!$this->main_model->isAccessModules('securite')){
			redirect(base_url(),'location');
		}
		
		$this->securite_model->supprimerProfil($this->uri->segment(3));
		redirect(base_url().'securite/liste_profils/delok','location');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */