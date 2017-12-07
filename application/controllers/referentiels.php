<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Referentiels extends CI_Controller {
	
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
		$this->lang->load('referentiels',$data['lang']);
		
		//On vérifie si l'utilisateur est connecté
		if($_SESSION['session-bihrdy']['acces']=="ok")
		{	
			//On load le model referentiels
			$this->load->model('referentiels_model');
			
			if($this->main_model->isAccessModules('referentiels')){
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

	/***********************************************************
	 *   									  Regroupements 	   			    	   			 *
	 ***********************************************************/
	function liste_regroupements($data){
		
		if(!$this->main_model->isAccessModules('regroupements')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(3)=="supprimer_regroupement" && is_numeric($this->uri->segment(4))){
			 $this->referentiels_model->supprimerRegroupement($this->uri->segment(4));
			 redirect(base_url()."referentiels/liste_regroupements/delok",'location');
		}
		
		// On appelle la liste des regroupements
		$data['listeRegroupements'] = $this->referentiels_model->listeRegroupements();
		
		// On check les messages pour les notification : regroupement bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		$this->load->model('indicateurs_model');
		$data['listeAttributes'] = $this->indicateurs_model->listeAttributesArray();
		$this->load->view('referentiels/regroupements/liste_regroupements',$data);
	}
	
	function editer_regroupement($data){
		
		if(!$this->main_model->isAccessModules('regroupements')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){
			
			// On appelle la fonction d'edition
			$this->referentiels_model->editeRegroupement($_POST,$this->uri->segment(3));
			redirect(base_url().'referentiels/liste_regroupements','location');
		}
		
		// On check si on a un identifiant en segment 3
		
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations du regroupement
			$data['infoRegroupement'] = $this->referentiels_model->infoRegroupement($this->uri->segment(3));
			$this->load->model('indicateurs_model');
			$data['listeAttributesSources'] = $this->indicateurs_model->listeAttributes($data['infoRegroupement']->CODE_DOMAIN);
			$data['listeAttributesCibles'] = $this->indicateurs_model->listeAttributes($data['infoRegroupement']->CODE_DOMAIN,"cibles");
		}
		
		//On stock dans une variable la liste des domaines
		$data['listeDomains'] = $this->referentiels_model->listeDomains();
		$this->load->view('referentiels/regroupements/editer_regroupement',$data);
	}
	
	function fiche_regroupement($data){
		if(!$this->main_model->isAccessModules('regroupements')){
			redirect(base_url(),'location');	
		}
		
		if($_POST){
			$this->referentiels_model->updateRegroupement($this->uri->segment(3),$_POST);
		}
		
		if($this->uri->segment(4)=="supprimer_attribut"){
			$this->referentiels_model->updateRegroupement($this->uri->segment(3),array('attr'=>$this->uri->segment(5),'value'=>NULL));
		}
		
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations du regroupement
			$data['infoRegroupement'] = $this->referentiels_model->infoRegroupement($this->uri->segment(3));
		}
		
		if($this->uri->segment(4)!=""){
			$data['msg']=$this->uri->segment(4);
		}
		
		$this->load->model('indicateurs_model');
		$data['listeAttributes'] = $this->indicateurs_model->listeAttributes($data['listeAttributes']);
		$data['listeAttributesArray'] = $this->indicateurs_model->listeAttributesArray();
		$this->load->view('referentiels/regroupements/fiche_regroupement',$data);
	}
	
	function editer_rule($data){
		if(!$this->main_model->isAccessModules('regroupements')){
			redirect(base_url(),'location');	
		}
		
		if($_POST && $this->uri->segment(3)!="" && is_numeric($this->uri->segment(3))){
			$this->referentiels_model->updateRules($this->uri->segment(3),$_POST);
			redirect(base_url().'referentiels/fiche_regroupement/'.$_POST['CODE_EXTENSION'].'#param','location');
		}
		
		if($this->uri->segment(4)=="" && $this->uri->segment(3)!=""){
			$data['infoRule'] = $this->referentiels_model->infoRules($this->uri->segment(3));
		}
		
		$this->load->model('indicateurs_model');
		$data['listeAttributesArray'] = $this->indicateurs_model->listeAttributesArray();
		$this->load->view('referentiels/regroupements/editer_rules',$data);
	}
	
	function ajax_regroupement($data){
		$liste=explode(";",$_POST['listeElem']);
		$type=$_POST['type'];
		$CODE_DOMAIN = $_POST['CODE_DOMAIN'];
		$data['attr']="";
		$this->load->model('indicateurs_model');
		if($type=="sources"){			
			$data['listeAttributes']=$this->indicateurs_model->listeAttributes($CODE_DOMAIN);	
			for($i=1;$i<=20;$i++){
	        	$champs="CODE_SRC_ATTR_";
	            if(strlen($i)==1){$nb="0".$i;}else{$nb=$i;}
	            $champs.=$nb;
	         	if(!in_array($champs,$liste) && $data['attr']==""){
	         		$data['attr']=$champs;
	         	}   
			}
		}else{
			$data['listeAttributes']=$this->indicateurs_model->listeAttributes($CODE_DOMAIN,'cibles');
			for($i=1;$i<=20;$i++){
	        	$champs="CODE_EXT_ATTR_";
	            if(strlen($i)==1){$nb="0".$i;}else{$nb=$i;}
	            $champs.=$nb;
	         	if(!in_array($champs,$liste) && $data['attr']==""){
	         		$data['attr']=$champs;
	         	}   
			}
		}
		//dump($data);
		$this->load->view('referentiels/regroupements/ajax/attributs',$data);
	}
	
	function import_regroupement($data){
		$data['CODE_EXTENSION'] = $this->uri->segment(3);
		if($_FILES){
			$file=$_FILES['file']['tmp_name'];
			$this->load->model('excel_model');
			$donnees = $this->excel_model->getData($file);
			$retour = $this->referentiels_model->importRules($data['CODE_EXTENSION'],$donnees);
			redirect(base_url().'referentiels/fiche_regroupement/'.$data['CODE_EXTENSION']."/import".$retour,'location');
		}
		
		$this->load->view('referentiels/regroupements/import_regroupement',$data);
	}
	
	function export_regroupement($data){
		//Verification d'accès au module regroupements
		if(!$this->main_model->isAccessModules('regroupements')){
			redirect(base_url(),'location');	
		}
		
		// Récupération des informations de lu regroupement
		$infoRegroupement = $this->referentiels_model->infoRegroupement($this->uri->segment(3));
		$this->load->model('indicateurs_model');
		$listeAttributesArray = $this->indicateurs_model->listeAttributesArray();
		// On load le model excel
		$this->load->model('excel_model');
		// Création du nom du fichier
		$file=$infoRegroupement->NAME_EXTENSION.".xls";
		// Création du titre du fichier
		$titre=$infoRegroupement->NAME_EXTENSION;
		// Création du tableau contenant les données
		$data['data']=array();
		
		$tabChampsRules=array('SRC'=>array(),'EXT'=>array());
        for($i=1;$i<=20;$i++){
        	$champs="CODE_SRC_ATTR_";
            if(strlen($i)==1){$nb="0".$i;}else{$nb=$i;}
            $champs.=$nb;
	        if($infoRegroupement->$champs!=""){
	           	$tabChampsRules['SRC'][count($tabChampsRules['SRC'])]=$nb;
	        }
       	}
                
        for($i=0;$i<=20;$i++){
          	$champs="CODE_EXT_ATTR_";
            if(strlen($i)==1){$nb="0".$i;}else{$nb=$i;}
          	$champs.=$nb;
            if($infoRegroupement->$champs!=""){
              	$tabChampsRules['EXT'][count($tabChampsRules['EXT'])]=$nb;
            }
        }
        //Préparation entête
        $data['data'][0]= array();
		
		foreach($tabChampsRules['SRC'] as $nbRule){
		    $champs = "CODE_SRC_ATTR_".$nbRule;
		    $data['data'][0][count($data['data'][0])]=$listeAttributesArray[$infoRegroupement->$champs]->NAME_ATTRIBUTE;
	    }
	    foreach($tabChampsRules['EXT'] as $nbRule){
	    	$champs = "CODE_EXT_ATTR_".$nbRule;
	        $data['data'][0][count($data['data'][0])]=$listeAttributesArray[$infoRegroupement->$champs]->NAME_ATTRIBUTE;
	    }
		
		
		
		//création de la variable définissant le nombre de ligne en mettant 1 pour l'entête
		$data['numRows']=1;
		//Nombre de colonne
		$data['numCols']=count($data['data'][0]);
		
		//Préparation data
		if(count($infoRegroupement->listeRules)>0){
			foreach($infoRegroupement->listeRules as $rule){
				
				$data['numRows']++;
				$nb = count($data['data']);
				$data['data'][$nb]=array();
	        	foreach($tabChampsRules['SRC'] as $nbRule){	                                    			
	            	$champ = "SRC_ATTR_".$nbRule."_VALUE";
	                $data['data'][$nb][count($data['data'][$nb])]=$rule->$champ;
	        	}
	            foreach($tabChampsRules['EXT'] as $nbRule){
					$champ = "EXT_ATTR_".$nbRule."_VALUE";
					 $data['data'][$nb][count($data['data'][$nb])]=$rule->$champ;
	            }
	       	}
		}
		// Appel de la création du fichier excel
		$this->excel_model->writeData($file,$titre,$data);
	}
	
	function ajax_regroupement_old($data){
		$action = $_POST['action'];
		$this->load->model('indicateurs_model');
		if($action=="add"){
			$type = $_POST['type'];
			if($type=="sources"){
				$domain = $_POST['domain'];
				$nbElem = $_POST['nb_elem'];
				$cible = $_POST['cible'];
				$champs="CODE_SRC_ATTR_";
	            if(strlen($nbElem)==1){$champs.="0".$nbElem;}else{$champs.=$nbElem;}
				if($cible=="body"){
					$data['CODE_EXTENSION'] = $_POST['CODE_EXTENSION'];
					$data['attr']=$champs;
					
					$data['listeAttributes'] = $this->indicateurs_model->listeAttributes($domain);
					$this->load->view('referentiels/regroupements/ajax/fichier_source',$data);
				}elseif($cible=="head"){
					echo "<th>".$this->lang->line('regroupement-'.$champs)."</th>";
				}
			}else{
				$domain = $_POST['domain'];
				$nbElem = $_POST['nb_elem'];
				$cible = $_POST['cible'];
				$champs="CODE_EXT_ATTR_";
	            if(strlen($nbElem)==1){$champs.="0".$nbElem;}else{$champs.=$nbElem;}
				if($cible=="body"){
					$data['CODE_EXTENSION'] = $_POST['CODE_EXTENSION'];
					$data['attr']=$champs;
					$data['listeAttributes'] = $this->indicateurs_model->listeAttributes($domain,'cibles');
					$this->load->view('referentiels/regroupements/ajax/fichier_cible',$data);
				}elseif($cible=="head"){
					echo "<th>".$this->lang->line('regroupement-'.$champs)."</th>";
				}
			}		
		}elseif($action=="edit"){
			$domain = $_POST['domain'];
			$data['CODE_EXTENSION'] = $_POST['CODE_EXTENSION'];
			$data['attr'] = $_POST['attr'];
			$data['value'] = $_POST['value'];
			if($type=="sources"){
				$data['listeAttributes'] = $this->indicateurs_model->listeAttributes($domain);
				$this->load->view('referentiels/regroupements/ajax/fichier_source',$data);
			}else{
				$data['listeAttributes'] = $this->indicateurs_model->listeAttributes($domain,'cibles');
				$this->load->view('referentiels/regroupements/ajax/fichier_cible',$data);
			}
		}
	}
	
	
	/***********************************************************
	 *   						Tranches	   			       *
	 ***********************************************************/
	
	function liste_tranches($data){
		
		//Verification d'accès au module indicateurs de paue
		if(!$this->main_model->isAccessModules('tranches')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(3)=="supprimer_tranche" && is_numeric($this->uri->segment(4))){
			$this->referentiels_model->supprimerTranche($this->uri->segment(4));
			redirect(base_url().'referentiels/liste_tranches/delok','location');
		}
		
		// On appelle la liste des tranches
		$data['listeTranches'] = $this->referentiels_model->listeTranches();
		
		
		// On check les messages pour les notification : tranches bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		$this->load->view('referentiels/tranches/liste_tranches',$data);
	}
	
	function editer_tranche($data){
		
		//Verification d'accès au module paie
		if(!$this->main_model->isAccessModules('tranches')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){			
			// On appelle la fonction d'edition
			$this->referentiels_model->editerTranche($_POST,$this->uri->segment(3));
			redirect(base_url().'referentiels/liste_tranches','location');
			
		}
		
		// On check si on a un identifiant en segment 3		
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations de la séquence
			$data['infoTranche'] = $this->referentiels_model->infoTranche($this->uri->segment(3));
		}
		
		$data['listeChamps'] = $this->referentiels_model->listeChamps();
		
		$this->load->view('referentiels/tranches/editer_tranche',$data);
	}
	
	function fiche_tranche($data){
		
	//Verification d'accès au module paie
		if(!$this->main_model->isAccessModules('tranches')){
			redirect(base_url(),'location');	
		}
		
		if($this->uri->segment(4)=="supprimer_rule"){
			$this->referentiels_model->supprimerTrancheRule($this->uri->segment(5));
			redirect(base_url()."referentiels/fiche_tranche/".$this->uri->segment(3)."/delok",'location');
		}else{
			$data['msg']=$this->uri->segment(4);
		}
				
		// On check si on a un identifiant en segment 3
		
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations de la séquence
			$data['infoTranche'] = $this->referentiels_model->infoTranche($this->uri->segment(3));
		}else{
			redirect(base_url().'referentiels/liste_tranches','location');
		}
		
		$this->load->view('referentiels/tranches/fiche_tranche',$data);
	}
	
	function editer_tranche_rule($data){
		//Verification d'accès au module historiques
		if(!$this->main_model->isAccessModules('tranches')){
			redirect(base_url(),'location');	
		}
		
		// On vérifie si un post est envoyé
		if($_POST){
			// On récupère le CODE_RULE via l'URI
			if(is_numeric($this->uri->segment(4))){
				$CODE_RULE=$this->uri->segment(4);
			}else{
				$CODE_RULE="";
			}
			// On appelle la fonction d'edition
			$this->referentiels_model->editerTrancheRule($_POST,$this->uri->segment(3),$CODE_RULE);
			redirect(base_url().'referentiels/fiche_tranche/'.$this->uri->segment(3),'location');
		}
		
		// On check si on a un identifiant en segment 5	: COPIE
		if($this->uri->segment(4)=="copier_rule" && is_numeric($this->uri->segment(5))){
			// On appelle la fonction qui retourne les informations de la règle
			$data['infoRuleTranche'] = $this->referentiels_model->infoRuleTranche($this->uri->segment(5));
			// On enlève le CODE_RULE pour eviter de faire un UPDATE et générer ainsi un INSERT.
			$data['infoRuleTranche']->CODE_RULE="";
		}
		
		// On check si on a un identifiant en segment 4	: EDITION
		if($this->uri->segment(4)!="" && is_numeric($this->uri->segment(4))){
			// On appelle la fonction qui retourne les informations de la règle
			$data['infoRuleTranche'] = $this->referentiels_model->infoRuleTranche($this->uri->segment(4));
		}
		
		$this->load->view('referentiels/tranches/editer_tranche_rule',$data);
	}
	
	function import_tranche_rules($data){
		$data['CODE_SLICE'] = $this->uri->segment(3);
		if($_FILES){
			$file=$_FILES['file']['tmp_name'];
			$this->load->model('excel_model');
			$donnees = $this->excel_model->getData($file);
			$retour = $this->referentiels_model->importTranchesRules($data['CODE_SLICE'],$donnees);
			redirect(base_url().'referentiels/fiche_tranche/'.$data['CODE_SLICE']."/import".$retour,'location');
		}
		
		$this->load->view('referentiels/tranches/import_tranche_rules',$data);
	}
	
	function export_tranche_rules($data){
		//Verification d'accès au module fusions
		if(!$this->main_model->isAccessModules('tranches')){
			redirect(base_url(),'location');	
		}
		
		// Récupération des informations de la fusion
		$infoTranche = $this->referentiels_model->infoTranche($this->uri->segment(3));
		// On load le model excel
		$this->load->model('excel_model');
		// Création du nom du fichier
		$file=$infoTranche->CODE_USER.".xls";
		// Création du titre du fichier
		$titre=$infoTranche->CODE_USER;
		// Création du tableau contenant les données
		$data['data']=array();
		//création de la variable définissant le nombre de ligne en mettant 1 pour l'entête
		$data['numRows']=1;
		//Nombre de colonne
		$data['numCols']=5;
		//Préparation entête
		$data['data'][0]= array(
			$this->lang->line('tranche-rule-name'),
			$this->lang->line('tranche-rule-left-ope'),
			$this->lang->line('tranche-rule-left-value'),
			$this->lang->line('tranche-rule-right-ope'),
			$this->lang->line('tranche-rule-right-value')
		);
		
		//Préparation data
		foreach($infoTranche->listeRules as $rule){
			//Incrémentationd u nombre de ligne
			$data['numRows']++;
			// Préparation de l'affichage du flag
			$data['data'][count($data['data'])]= array(
				$rule->NAME_RULE,
	            $rule->LEFT_OPERATOR,
	            $rule->LEFT_VALUE,
	            $rule->RIGHT_OPERATOR,
	            $rule->RIGHT_VALUE
			);
		}
		// Appel de la création du fichier excel
		$this->excel_model->writeData($file,$titre,$data);
	}
	
	/***********************************************************
	 *   									  Champs de tranche 	   			    	   			 *
	 ***********************************************************/
	
	function liste_champs($data){
		// Vérification droit user sur le module
		if(!$this->main_model->isAccessModules('tranches')){
			redirect(base_url(),'location');
		}
		// On appelle la liste des champs
		$data['listeChamps'] = $this->referentiels_model->listeChamps();
		// On check les messages pour les notification : champ bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
		$this->load->view('referentiels/tranches-champs/liste_champs',$data);
	}
	
	function editer_champ($data){
		if(!$this->main_model->isAccessModules('tranches')){
			redirect(base_url(),'location');
		}
		// On vérifie si un post est envoyé
		if($_POST){
			// On appelle la fonction d'edition
			$this->referentiels_model->editerChamp($_POST);
			redirect(base_url().'referentiels/liste_champs','location');
		}
		// On check si on a un identifiant en segment 3
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations du champ
			$data['infoChamp'] = $this->referentiels_model->infoChamp($this->uri->segment(3));
		}
		//On stock dans une variable la liste des champs de tranches
		$data['listeChamps'] = $this->referentiels_model->listeChamps();
	
		$this->load->view('referentiels/tranches-champs/editer_champ',$data);
	}
	
	function supprimer_champ($data){
		if(!$this->main_model->isAccessModules('tranches')){
			redirect(base_url(),'location');
		}
		// On supprime l'utilisateur
		$this->referentiels_model->supprimerChamp($this->uri->segment(3));
		// On redirige sur la liste avec un segment delok
		redirect(base_url().'referentiels/liste_champs/delok','location');
	}
	
	/**********************************************
	 *   					            Commentaires		 			  	  *
	 **********************************************/
	
	function liste_commentaires($data){
		// Vérification droit user sur le module
		if(!$this->main_model->isAccessModules('commentaires')){
			redirect(base_url(),'location');
		}
	
		// On check les messages pour les notification : champ bien supprimé
		if($this->uri->segment(3)!=""){
			$data['msg']=$this->uri->segment(3);
		}
	
		//On stock dans une variable la liste des Commentaires
		$data['listeCommentaires'] = $this->referentiels_model->listeCommentaires();
	
		$this->load->view('referentiels/commentaires/liste_commentaires',$data);
	}
	
	function editer_commentaire($data){
		if(!$this->main_model->isAccessModules('commentaires')){
			redirect(base_url(),'location');
		}
		// On vérifie si un post est envoyé
		if($_POST){
			// On appelle la fonction d'edition
			$this->referentiels_model->editerCommentaire($_POST);
			redirect(base_url().'referentiels/liste_commentaires','location');
		}
		// On check si on a un identifiant en segment 3
		if($this->uri->segment(3)!=""){
			// On appelle la fonction qui retourne les informations du champ
			$data['infoCommentaire'] = $this->referentiels_model->infoCommentaire($this->uri->segment(3));
		}
	
		//On stock dans une variable la liste des Anciennetés
		$data['listeCommentaires'] = $this->referentiels_model->listeCommentaires();
	
		$this->load->view('referentiels/commentaires/editer_commentaire',$data);
	}
	
	function supprimer_commentaire($data){
		if(!$this->main_model->isAccessModules('commentaires')){
			redirect(base_url(),'location');
		}
		// On supprime l'utilisateur
		$this->referentiels_model->supprimerCommentaire($this->uri->segment(3));
		// On redirige sur la liste avec un segment delok
		redirect(base_url().'referentiels/liste_commentaires/delok','location');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */