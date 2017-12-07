<?phpclass Main_model extends CI_Model {	public function __construct()	{		parent::__construct();		$this->optimisation_bdd();	}		private function optimisation_bdd(){				$query = $this->db->query("ALTER SESSION DISABLE PARALLEL QUERY");	}	public function connexion($myArray)	{		//Recherche  de l'utilisateur : true => connexion, aucun => erreur		$this->db->select('CODE_USER');		$infoUser = $this->db->get_where('QC1_REP_SEC_USER',array('USERNAME'=>$myArray['username'],'PASSWORD'=>md5($myArray['password'])))->result();		if(count($infoUser)==0) //aucune ligne remontée		{			return "aucun";		}else 		{			//Mise à jour dernière connexion à faire ici			//Mise en session des informations de l'utilisateur			// Rajouter la Variable CODE_TENANT dans le select			$this->db->select('CODE_USER,USERNAME,FULLNAME,QC1_REP_SEC_USER.CODE_PROFILE,LANG,NAME_PROFILE,DESC_PROFILE,COLUMN_PROFILE,QC1_REP_SEC_USER.CODE_ENV');			$this->db->join('QC1_REP_SEC_PROFILE','QC1_REP_SEC_PROFILE.CODE_PROFILE=QC1_REP_SEC_USER.CODE_PROFILE');			$info = $this->db->get_where('QC1_REP_SEC_USER',array('CODE_USER'=>$infoUser[0]->CODE_USER))->result();			// Si l'utilisateur a coché la checkbox garder la session active on crée un cookie d'une durée d'un mois avec son CODE_USER en variable			if($myArray['remember']=="Oui")			{				setcookie('bihrdy-remember',$infoUser[0]->CODE_USER,time()+calculTime(1,'mois'),'/');			}			// On stock toutes les informations de l'utilsiateur (ligne 24) dans un tableau que l'on met en session			foreach($info[0] as $key=>$value)			{				$_SESSION['session-bihrdy']['infoUser'][$key]=$value;			}			// Cette variable permet de checker simplement l'accès			$_SESSION['session-bihrdy']['acces']="ok";			return "true";		}	}	// Cette fonction gère la 	public function connexionRemember()	{		// On check si le cookie de session active est un numérique (censé être un CODE_USER)		if(is_numeric($_COOKIE['bihrdy-remember']))		{			// On vérifie si ce CODE_USER existe toujours dans la base			$this->db->select('CODE_USER');			$infoUser = $this->db->get_where('QC1_REP_SEC_USER',array('CODE_USER'=>$_COOKIE['bihrdy-remember']))->result();			if(count($infoUser)==0)			{				return false;			}else 			{				//Mise à jour dernière connexion / IP à faire ici				//Mise en session des informations de l'utilisateur				// Rajouter la Variable CODE_TENANT dans le select				$this->db->select('CODE_USER,USERNAME,FULLNAME,QC1_REP_SEC_USER.CODE_PROFILE,LANG,NAME_PROFILE,DESC_PROFILE,COLUMN_PROFILE,QC1_REP_SEC_USER.CODE_ENV');				$this->db->join('QC1_REP_SEC_PROFILE','QC1_REP_SEC_PROFILE.CODE_PROFILE=QC1_REP_SEC_USER.CODE_PROFILE');				$info = $this->db->get_where('QC1_REP_SEC_USER',array('CODE_USER'=>$infoUser[0]->CODE_USER))->result();				// On stock toutes les informations de l'utilsiateur (ligne 24) dans un tableau que l'on met en session				foreach($info[0] as $key=>$value)				{					$_SESSION['session-bihrdy']['infoUser'][$key]=$value;				}				// ON instancie la variable d'accès				$_SESSION['session-bihrdy']['acces']="ok";				return true;			}		}else		{			// Mauvais cookie			return false;		}	}	// Cette fonction permet de supprimer le cookie qui gére la connexion automatique si l'utilisateur à choisit de garder sa session active	public function deleteConnexionRemember()	{		// On check si le cookie de session active est un numérique (censé être un CODE_USER)		if(is_numeric($_COOKIE['bihrdy-remember']))		{			// On remplace le cookie actuelle par un cookie périmé d'une minute			setcookie('bihrdy-remember','',time()-3600,"/",'',1);			//On supprime la variable			unset($_COOKIE['bihrdy-remember']);		}	}	public function get_last_id($nom_table,$nom_colonne) {		$this->db->order_by($nom_colonne, 'DESC');        $query = $this->db->get($nom_table, 1);        return $query->result();    }    public function listeMenus(){    	$this->db->order_by('ITEM_ID','ASC');    	$listeMod = $this->db->get('QC1_REP_SEC_MOD_DEFINITION')->result();    	$listeMenu=array();    	$listeMenuAttente=array();    	foreach($listeMod as $mod){    		if($mod->PARENT_ID==0){    			$listeMenu[$mod->ITEM_ID]=$mod;    			$listeMenu[$mod->ITEM_ID]->sousmenu=array();    		}elseif($mod->PARENT_ID!="0"){    			if(count($listeMenu[$mod->PARENT_ID])>0){    				$listeMenu[$mod->PARENT_ID]->sousmenu[$mod->ITEM_ORDER]=$mod;    			}else{    				$listeMenuAttente[count($listeMenuAttente)]=$mod;    			}    		}    	}    	foreach($listeMenuAttente as $mod){    		$listeMenu[$mod->PARENT_ID]->sousmenu[$mod->ITEM_ORDER]=$mod;    	}    	ksort($listeMenu);    	foreach($listeMenu as $menu){    		ksort($menu->sousmenu);    		foreach($menu->sousmenu as $m){    			$tab=explode('|',$m->CONF);    			$m->config['conf']=$tab[0];    			$m->config['controller']=$tab[1];				//$m->config['controller']=$menu->CONF;    			$m->config['fonction']=$tab[2];    		}    	}    	return $listeMenu;    }    function isAccessModules($module){    	$this->db->like('CONF',$module,'after');    	$mod = $this->db->get('QC1_REP_SEC_MOD_DEFINITION')->result();    	if($mod[0]->$_SESSION['session-bihrdy']['infoUser']['COLUMN_PROFILE']==1){    		return true;    	}else{    		return false;    	}    }    function actionLogs($action,$table,$data="",$id="",$champsId=""){					$dateLog = dateSqlNow();				switch($action){			case "INSERT":    							$this->db->set('CODE_USER',$_SESSION['session-bihrdy']['infoUser']['CODE_USER']);				$this->db->set('ACTION',$action);				$this->db->set('TABLE_IMPACTED',$table);				$this->db->set('ID_IN_TABLE','0');				$this->db->set('FIELD_IN_TABLE','');				$this->db->set('SERIALIZED_ACTION',serialize($data));				$this->db->set('EXECUTION_DATE',"to_date('$dateLog','dd/mm/yyyy')",false);				$this->db->insert('QC1_REP_LOG');    						break;			case "DELETE":    							if($data==""){					$res = $this->db->get_where($table,array($champsId=>$id))->result();					$data = $res[0];				}				$this->db->set('CODE_USER',$_SESSION['session-bihrdy']['infoUser']['CODE_USER']);				$this->db->set('ACTION',$action);				$this->db->set('TABLE_IMPACTED',$table);				$this->db->set('ID_IN_TABLE',$id);				$this->db->set('FIELD_IN_TABLE',$champsId);				$this->db->set('SERIALIZED_ACTION',serialize($data));				$this->db->set('EXECUTION_DATE',"to_date('$dateLog','dd/mm/yyyy')",false);				$this->db->insert('QC1_REP_LOG');    		    						break;			case "UPDATE":    							$res = $this->db->get_where($table,array($champsId=>$id))->result();				$data = $res[0];    							$this->db->set('CODE_USER',$_SESSION['session-bihrdy']['infoUser']['CODE_USER']);				$this->db->set('ACTION',$action);				$this->db->set('TABLE_IMPACTED',$table);				$this->db->set('ID_IN_TABLE',$id);				$this->db->set('FIELD_IN_TABLE',$champsId);				$this->db->set('SERIALIZED_ACTION',serialize($data));				$this->db->set('EXECUTION_DATE',"to_date('$dateLog','dd/mm/yyyy')",false);				$this->db->insert('QC1_REP_LOG');    		    					break;			case "IMPORT":    						$this->db->set('CODE_USER',$_SESSION['session-bihrdy']['infoUser']['CODE_USER']);				$this->db->set('ACTION',$action);				$this->db->set('TABLE_IMPACTED',$table);				$this->db->set('ID_IN_TABLE',$id);				$this->db->set('FIELD_IN_TABLE',$champsId);				$this->db->set('SERIALIZED_ACTION','');				$this->db->set('EXECUTION_DATE',"to_date('$dateLog','dd/mm/yyyy')",false);				$this->db->insert('QC1_REP_LOG');    						break;		}		}    public function editerProfil($myArray){    	$array=array('FULLNAME'=>$myArray['FULLNAME'],'LANG'=>$myArray['LANG'],'USERNAME'=>$myArray['USERNAME']);    	if($myArray['PASSWORD']!=""){    		$array['PASSWORD']=md5($myArray['PASSWORD']);    	}    	$this->main_model->actionLogs('UPDATE','QC1_REP_SEC_USER','',$_SESSION['session-bihrdy']['infoUser']['CODE_USER'],'CODE_USER');    	$this->db->where('CODE_USER',$_SESSION['session-bihrdy']['infoUser']['CODE_USER']);    	$this->db->update('QC1_REP_SEC_USER',$array);    	$this->db->select('CODE_USER,USERNAME,FULLNAME,QC1_REP_SEC_USER.CODE_PROFILE,LANG,NAME_PROFILE,DESC_PROFILE,COLUMN_PROFILE,QC1_REP_SEC_USER.CODE_ENV');		$this->db->join('QC1_REP_SEC_PROFILE','QC1_REP_SEC_PROFILE.CODE_PROFILE=QC1_REP_SEC_USER.CODE_PROFILE');		$info = $this->db->get_where('QC1_REP_SEC_USER',array('CODE_USER'=>$_SESSION['session-bihrdy']['infoUser']['CODE_USER']))->result();		// On stock toutes les informations de l'utilsiateur (ligne 24) dans un tableau que l'on met en session		foreach($info[0] as $key=>$value)		{			$_SESSION['session-bihrdy']['infoUser'][$key]=$value;		}		// ON instancie la variable d'accès		$_SESSION['session-bihrdy']['acces']="ok";    }	/*public function oublieMdp($myArray)	{		$this->db->select('id_utilisateur,prenom_utilisateur,nom_utilisateur,email_utilisateur,statut_utilisateur');		$infoUser = $this->db->get_where('QC1_REP_SEC_USER',array('email_utilisateur'=>$myArray['email']))->result();		if(count($infoUser)>0)+		{			if($infoUser[0]->statut_utilisateur=="Désactivé")			{				return "desactive";			}else			{				$data['sha']= generateCode(30);				$data['infoUser']=$infoUser[0];				$this->db->insert('QC1_REP_SEC_USER_oublie',array('QC1_REP_SEC_USER_id_utilisateur'=>$data['infoUser']->id_utilisateur,'sha_oublie'=>$data['sha'],'date_demande'=>dateSqlNow(),'ip_demande'=>myIP(),'statut_oublie'=>'Non utilisé'));				$this->load->model('phpmailer_model');				$this->phpmailer_model->IsSMTP();				$this->phpmailer_model->SMTPAuth   = true;                  // enable SMTP authentication				$this->phpmailer_model->Host       = "mail.nineteengroupe.fr"; // sets the SMTP server				$this->phpmailer_model->SMTPSecure = "";        // SMTP account password				$this->phpmailer_model->SetFrom("contact@nineteengroupe.fr","Nineteen Groupe");				$this->phpmailer_model->AddAddress($data['infoUser']->email_utilisateur);   // name is optional				$this->phpmailer_model->AddReplyTo("contact@nineteengroupe.fr","Nineteen Groupe");				$this->phpmailer_model->IsHTML(true);    // set email format to HTML				$this->phpmailer_model->Subject="Intranet - Nineteen Groupe : Mot de passe oublié";				$this->phpmailer_model->MsgHTML($this->load->view('mails/mail-oublie',$data,true));				$this->phpmailer_model->Send(); 			}		}else		{			return "0";		}	}	public function verifSha($sha)	{		$this->db->select("QC1_REP_SEC_USER_id_utilisateur,date_demande,sha_oublie,statut_oublie");		$info = $this->db->get_where('QC1_REP_SEC_USER_oublie',array('sha_oublie'=>$sha))->result();		if(count($info)==0)		{			return "sha-ko";		}elseif(count($info)>1)		{			$this->db->select("QC1_REP_SEC_USER_id_utilisateur,date_demande,sha_oublie,statut_oublie");			$this->db->order_by('date_demande','DESC');			$listeSha = $this->db->get_where('QC1_REP_SEC_USER_oublie',array('QC1_REP_SEC_USER_id_utilisateur'=>$info[0]->QC1_REP_SEC_USER_id_utilisateur))->result();			if($sha==$listeSha[0]->sha_oublie && $listeSha[0]->statut_oublie=="Non utilisé")			{				return "sha-ok";			}else			{				return "sha-exist-ko";			}		}else {			if($info[0]->statut_oublie=="Non utilisé")			{				return "sha-ok";			}else			{				return "sha-exist-ko";			}		}	}	public function changeMdp($myArray,$sha)	{		$this->db->select("QC1_REP_SEC_USER_id_utilisateur");		$info = $this->db->get_where('QC1_REP_SEC_USER_oublie',array('sha_oublie'=>$sha))->result();		$this->db->where('id_utilisateur',$info[0]->QC1_REP_SEC_USER_id_utilisateur);		$this->db->update('QC1_REP_SEC_USER',array('mdp_utilisateur'=>md5($myArray['mdp'])));		$this->db->where('sha_oublie',$sha);		$this->db->update('QC1_REP_SEC_USER_oublie',array('statut_oublie'=>'Utilisé'));		return "mdp-ok";	}	*/}?>