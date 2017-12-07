<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	
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
		// On instancie un tableau avec des noms de fonction dont on ne vérifiera pas si l'utilisateur est connecté
		$arrayFunction=array('oublie','changement','change_lang','deconnexion');
		
		//L'utilisateur est connecté ou si la méthode ne requiert pas d'être authentifiée
		if($_SESSION['session-bihrdy']['acces']=="ok" || in_array($method,$arrayFunction))
		{	
			//Alors on appelle la methode appelé
			$this->$method($data);
		}else{			
			//On regarde si l'utilisateur a une session active en cookie
			if($this->main_model->connexionRemember())
			{
				// On reload la page pour que ses informations de sessions soient actives
				redirect(base_url(),'location');
			}else 
			{
				//On vérifie si l'utilisateur ne met pas dans l'adresse un lien dont il n'a pas ou pas encore accès.
				if($method!="index")
				{
					// Redirection page de login
					redirect(base_url(),'location');
				}else 
				{
					// Affichage de la page de login
					$this->login($data);
				}
			}
		}
	}
	
	public function index($data)
	{		
		$this->load->model('dashboard_model');
		$this->lang->load('dashboard',$data['lang']);
		$this->dashboard_model->alterSessionDateFormat();
		
		//Utilisation de la Station
		$data['utilisationStation'] = $this->dashboard_model->utilisationStation();
		//Timeline
		$data['timeLine'] = $this->dashboard_model->timeLine();		
		//Archive
		$data['infoArchive'] = $this->dashboard_model->infoArchive();		
		
		//Éléments Quantitatifs
		$data['elementsQuantitatifs'] = $this->dashboard_model->elementsQuantitafifs();
		
		// Informations regroupement : histogramme + pourcentage
		$data['tabRegroupement'] = $this->dashboard_model->regroupementHistogramme();
		
		// Informations indicateurs de paie
		$data['indicateursPaieDonut'] = $this->dashboard_model->indicateursPaieDonut();
		
		$this->load->view('dashboard',$data);
	}
	
	//Méthode de changement de lang
	
	public function change_lang($data){
		
		// On récupère le tag de langue sur le segment 3 de l'url
		unset($_SESSION['langue']);
		$_SESSION['langue']=$this->uri->segment(3);
		// Ensuite on récupère les segments suivants afin de le rediriger sur l'url où il était précédemment.
		
		$newUrl="";
		if($this->uri->segment(4)!="")
		{
			for($i=4;$i<=count($this->uri->segments);$i++){
				$newUrl .= $this->uri->segment($i)."/";
			}
		}
		
		// On le redirige vers sa page précédente
		redirect(base_url().$newUrl,'location');
	}
	
	function login($data)
	{
		// On check si envoie de donnée en post
		if($_POST){
			// On appelle la fonction de connexion
			$retour=$this->main_model->connexion($_POST);
			if($retour=="true")
			{
				// Si tout s'est bien on reload
				redirect(base_url(),'location');
			}elseif($retour=="aucun")
			{
				// Si identifiants incorrect on affiche un message
				$data['msg']="cx-ko";
			}
		}
		$this->load->view("login/login",$data);
	}
	
	public function profil($data){
		
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		
		$this->load->view("login/mon_profil",$data);
	}
	
	public function editer_profil($data){
		
		if($_POST){
			$this->main_model->editerProfil($_POST);
			redirect(base_url()."main/profil/editok",'location');
		}
		$this->load->view("login/editer_profil",$data);
	}
	
	public function deconnexion($data){
		
		//Supression du cookie
		$this->main_model->deleteConnexionRemember();
		unset($_SESSION['session-bihrdy']);
		redirect(base_url(),'location');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */