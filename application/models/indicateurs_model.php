<?phpclass Indicateurs_model extends CI_Model {	public function __construct()	{		parent::__construct();	}		/**********************************************************	 *   				INDICATEURS PAIE	 				  *	 **********************************************************/	public function listeIndicateursPaie(){		$this->db->select('CODE_INDICATOR,NAME_INDICATOR,DESC_INDICATOR,TARGET_FIELD,CODE_TYPE,DESC_TYPE, UDF_001, UDF_002');		$this->db->order_by('NAME_INDICATOR');		return $this->db->get('QC1_REP_PRI_INDICATOR')->result();	}	public function infoIndicateurPaie($CODE_INDICATOR){		$this->db->select('CODE_INDICATOR,NAME_INDICATOR,DESC_INDICATOR,TARGET_FIELD,CODE_TYPE,DESC_TYPE, UDF_001, UDF_002');		$infoIndicateurPaie = $this->db->get_where('QC1_REP_PRI_INDICATOR',array('CODE_INDICATOR'=>$CODE_INDICATOR))->result();		$infoIndicateurPaie[0]->listeRubriques = $this->listeRubriquesIndicateurPaie($CODE_INDICATOR);		return $infoIndicateurPaie[0];	}	public function listeRubriquesIndicateurPaie($CODE_INDICATOR=""){		/* 		//Code de Maxim		if($CODE_INDICATOR!=""){			return $this->db->get_where('QC1_REP_PRI_DEFINITION',array('CODE_INDICATOR'=>$CODE_INDICATOR))->result();		}else{			$this->db->join('QC1_REP_PRI_PR_RULE','QC1_REP_PRI_PR_RULE.CODE_PR_RULE=QC1_REP_PRI_PR_ITEM.CODE_PR_RULE','LEFT');			$this->db->order_by('NAME_PR_ITEM','ASC');			//$this->db->group_by('QC1_REP_PRI_PR_ITEM.NAME_PR_ITEM');			return $this->db->get('QC1_REP_PRI_PR_ITEM')->result();		} */						if($CODE_INDICATOR!=""){			/*			Requete SQL (exemple) :			select QC1_REP_PRI_PR_ITEM.CODE_PR_RULE, QC1_REP_PRI_PR_RULE.NAME_PR_RULE, QC1_REP_PRI_PR_ITEM.CODE_PR_ITEM, QC1_REP_PRI_PR_ITEM.NAME_PR_ITEM			FROM QC1_REP_PRI_DEFINITION 			join QC1_REP_PRI_PR_RULE on QC1_REP_PRI_DEFINITION.CODE_PR_RULE = QC1_REP_PRI_PR_RULE.CODE_PR_RULE			join QC1_REP_PRI_PR_ITEM on QC1_REP_PRI_DEFINITION.CODE_PR_ITEM = QC1_REP_PRI_PR_ITEM.CODE_PR_ITEM			WHERE QC1_REP_PRI_DEFINITION.CODE_INDICATOR =52641;			*/			// Si on affiche les rubriques d'un indicateur on affiche ses rubriques			$this->db->select('QC1_REP_PRI_PR_RULE.CODE_PR_RULE, QC1_REP_PRI_PR_RULE.NAME_PR_RULE, QC1_REP_PRI_PR_ITEM.CODE_PR_ITEM, QC1_REP_PRI_PR_ITEM.NAME_PR_ITEM');			$this->db->join('QC1_REP_PRI_PR_RULE','QC1_REP_PRI_DEFINITION.CODE_PR_RULE=QC1_REP_PRI_PR_RULE.CODE_PR_RULE');			$this->db->join('QC1_REP_PRI_PR_ITEM','QC1_REP_PRI_DEFINITION.CODE_PR_ITEM=QC1_REP_PRI_PR_ITEM.CODE_PR_ITEM and QC1_REP_PRI_DEFINITION.CODE_PR_RULE = QC1_REP_PRI_PR_ITEM.CODE_PR_RULE');			$this->db->where('CODE_INDICATOR', $CODE_INDICATOR);			return $this->db->get('QC1_REP_PRI_DEFINITION')->result();					}else{			/*			Requete SQL :			SELECT QC1_REP_PRI_PR_ITEM.CODE_PR_RULE, QC1_REP_PRI_PR_RULE.NAME_PR_RULE, QC1_REP_PRI_PR_ITEM.CODE_PR_ITEM, QC1_REP_PRI_PR_ITEM.NAME_PR_ITEM			FROM QC1_REP_PRI_PR_ITEM 			JOIN QC1_REP_PRI_PR_RULE ON QC1_REP_PRI_PR_RULE.CODE_PR_RULE=QC1_REP_PRI_PR_ITEM.CODE_PR_RULE 			ORDER BY NAME_PR_ITEM ASC*/						// Si on edite on affiche toutes les rubriques			$this->db->select('QC1_REP_PRI_PR_RULE.CODE_PR_RULE, QC1_REP_PRI_PR_RULE.NAME_PR_RULE, QC1_REP_PRI_PR_ITEM.CODE_PR_ITEM, QC1_REP_PRI_PR_ITEM.NAME_PR_ITEM');			$this->db->join('QC1_REP_PRI_PR_RULE','QC1_REP_PRI_PR_RULE.CODE_PR_RULE=QC1_REP_PRI_PR_ITEM.CODE_PR_RULE');			$this->db->order_by('NAME_PR_ITEM','ASC');			return $this->db->get('QC1_REP_PRI_PR_ITEM')->result();		}	}	public function listeRubriquesArray(){		$listeRubriques = $this->db->get('QC1_REP_PRI_PR_ITEM')->result();		$listeRubriquesArray = array();		foreach($listeRubriques as $rubrique){			$listeRubriquesArray[$rubrique->CODE_PR_ITEM]=$rubrique;		}		return $listeRubriquesArray;	}	public function listeRulesArray(){		$listeRules = $this->db->get('QC1_REP_PRI_PR_RULE')->result();		$listeRulesArray = array();		foreach($listeRules as $rule){			$listeRulesArray[$rule->CODE_PR_RULE]=$rule;		}		return $listeRulesArray;	}	public function editerIndicateurPaie($myArray,$CODE_INDICATOR=""){		if($CODE_INDICATOR!=""){			$this->main_model->actionLogs('UPDATE','QC1_REP_PRI_INDICATOR','',$CODE_INDICATOR,'CODE_INDICATOR');			$this->db->where('CODE_INDICATOR',$CODE_INDICATOR);			$this->db->update('QC1_REP_PRI_INDICATOR',$myArray);		}else{			$this->main_model->actionLogs('INSERT','QC1_REP_PRI_INDICATOR',$myArray);			$this->db->insert('QC1_REP_PRI_INDICATOR',$myArray);		}	}	public function editerRubriquesIndicateurPaie($CODE_INDICATOR,$liste){		// Separtion des rubriques au format CODE_PR_ITEM-CODE_PR_RULE;CODE_PR_ITEM-CODE_PR_RULE;CODE_PR_ITEM-CODE_PR_RULE		$tab = explode(';',$liste);		// Creation d'un tableau recuperation de la liste des identifiants d'historique		$tabItem =array();		$tabRule =array();		foreach($tab as $elem){			$t = explode('-',$elem);			$tabItem[count($tabItem)]=$t[0];			if(count($t)>0){				$tabRule[count($tabRule)]=$t[1];			}else{				$tabRule[count($tabRule)]=NULL;			}		}		// $tabItem contient toutes les rubriques que l'indicateur doit contenir (colonne de droite)		// $tabRule contient toutes les regles auxquelles appartiennent ces rubriques				// Recuperation des Rubriques de l'indicateur de paie qu'on traite		$listeRubriquesIndicateurPaie = $this->listeRubriquesIndicateurPaie($CODE_INDICATOR);		$tabRub=array();				// Suppression des elements non present dans la liste		foreach($listeRubriquesIndicateurPaie as $rubrique){			if(!in_array($rubrique->CODE_PR_ITEM,$tabItem)){				$this->db->delete('QC1_REP_PRI_DEFINITION',array('CODE_PR_ITEM'=>$rubrique->CODE_PR_ITEM,'CODE_INDICATOR'=>$CODE_INDICATOR));			}else{				// Rubrique deja presente				$tabRub[count($tabRub)]=$rubrique->CODE_PR_ITEM;			}		}		// $tabRub contient toutes les rubriques qui sont déjà présentes pour cet indicateur avant l'insertion des nouvelles				//Pour chaque rubrique recuperee en POST		for($i=0;$i<count($tabItem);$i++){			// SI l'element n'existe pas dans la table on l'insert			if(!in_array($tabItem[$i], $tabRub)){				$this->db->insert('QC1_REP_PRI_DEFINITION',array(					'CODE_INDICATOR'=>$CODE_INDICATOR,					'CODE_PR_RULE'=>$tabRule[$i],					'CODE_PR_ITEM'=>$tabItem[$i]				));			}			//Sinon on ne fait rien car il existe deja dans la table		}		$this->main_model->actionLogs('UPDATE','QC1_REP_PRI_DEFINITION','',$CODE_INDICATOR,'CODE_INDICATOR');	}	function getRuleItem($CODE_PR_ITEM){		$res = $this->db->get_where('QC1_REP_PRI_PR_ITEM',array('CODE_PR_ITEM'=>$CODE_PR_ITEM))->result();		return $res[0]->CODE_PR_RULE;	}	public function supprimerIndicateurPaie($CODE_INDICATOR){		$this->main_model->actionLogs('DELETE','QC1_REP_PRI_INDICATOR','',$CODE_INDICATOR,'CODE_INDICATOR');				$this->db->delete('QC1_REP_PRI_INDICATOR',array('CODE_INDICATOR'=>$CODE_INDICATOR));		$this->main_model->actionLogs('DELETE','QC1_REP_PRI_DEFINITION','',$CODE_INDICATOR,'CODE_INDICATOR');		$this->db->delete('QC1_REP_PRI_DEFINITION',array('CODE_INDICATOR'=>$CODE_INDICATOR));	}		/**********************************************************	 *   				INDICATEURS MOBILITE	 				  *	 **********************************************************/	public function listeIndicateursMobilite(){		$this->db->join('QC1_REP_QDD_DOMAIN','QC1_REP_QDD_DOMAIN.CODE_DOMAIN=QC1_REP_MBI_INDICATOR.CODE_DOMAIN','LEFT');		$this->db->select('CODE_INDICATOR,NAME_INDICATOR,DESC_INDICATOR,TARGET_FIELD,QC1_REP_MBI_INDICATOR.CODE_DOMAIN,QC1_REP_QDD_DOMAIN.NAME_DOMAIN');		$this->db->order_by('NAME_INDICATOR','ASC');		return $this->db->get('QC1_REP_MBI_INDICATOR')->result();	}	public function listeIndicateursMobiliteTargetArray($CODE_INDICATOR=""){		$this->db->select('TARGET_FIELD');		if($CODE_INDICATOR==""){			$liste = $this->db->get('QC1_REP_MBI_INDICATOR')->result();		}else{			$liste = $this->db->get_where('QC1_REP_MBI_INDICATOR',array('CODE_INDICATOR <>'=>$CODE_INDICATOR))->result();		}		$array=array();		if(count($liste)>0){			foreach($liste as $mobil){				$array[count($array)]=$mobil->TARGET_FIELD;			}		}		return $array;	}	public function infoIndicateurMobilite($CODE_INDICATOR){		$this->db->join('QC1_REP_QDD_DOMAIN','QC1_REP_QDD_DOMAIN.CODE_DOMAIN=QC1_REP_MBI_INDICATOR.CODE_DOMAIN','LEFT');		$this->db->select('CODE_INDICATOR,NAME_INDICATOR,DESC_INDICATOR,TARGET_FIELD,QC1_REP_MBI_INDICATOR.CODE_DOMAIN,QC1_REP_QDD_DOMAIN.NAME_DOMAIN');		$infoIndicateurMobilite = $this->db->get_where('QC1_REP_MBI_INDICATOR',array('CODE_INDICATOR'=>$CODE_INDICATOR))->result();		$infoIndicateurMobilite[0]->listeRubriques = $this->listeRubriquesIndicateurMobilite($CODE_INDICATOR);		return $infoIndicateurMobilite[0];	}	public function listeRubriquesIndicateurMobilite($CODE_INDICATOR=""){		return $this->db->get_where('QC1_REP_MBI_DEFINITION',array('CODE_INDICATOR'=>$CODE_INDICATOR))->result();	}		public function infoIndicateurMobiliteRubrique($CODE_INDICATOR,$MOD_FIELD){		$infoIndicateurMobiliteRubrique = $this->db->get_where('QC1_REP_MBI_DEFINITION',array('CODE_INDICATOR'=>$CODE_INDICATOR,'MOD_FIELD'=>$MOD_FIELD))->result();		return $infoIndicateurMobiliteRubrique[0];	}	public function editerIndicateurMobilite($myArray,$CODE_INDICATOR=""){		if($CODE_INDICATOR!=""){			$this->main_model->actionLogs('UPDATE','QC1_REP_MBI_INDICATOR','',$CODE_INDICATOR,'CODE_INDICATOR');			$this->db->where('CODE_INDICATOR',$CODE_INDICATOR);			$this->db->update('QC1_REP_MBI_INDICATOR',$myArray);		}else{			$this->main_model->actionLogs('INSERT','QC1_REP_MBI_INDICATOR',$myArray);			$this->db->insert('QC1_REP_MBI_INDICATOR',$myArray);		}	}	public function editerRubriquesIndicateurMobilite($myArray,$CODE_INDICATOR,$MOD_FIELD=""){		if($MOD_FIELD==""){			$myArray['CODE_INDICATOR']=$CODE_INDICATOR;			$this->main_model->actionLogs('INSERT','QC1_REP_MBI_DEFINITION',$myArray);			$this->db->insert('QC1_REP_MBI_DEFINITION',$myArray);		}else{			$this->main_model->actionLogs('UPDATE','QC1_REP_MBI_DEFINITION','',$CODE_INDICATOR,'CODE_INDICATOR');			$this->db->where('CODE_INDICATOR',$CODE_INDICATOR);			$this->db->where('MOD_FIELD',$MOD_FIELD);			$this->db->update('QC1_REP_MBI_DEFINITION',$myArray);		}			}	public function supprimerIndicateurMobilite($CODE_INDICATOR){		$this->main_model->actionLogs('DELETE','QC1_REP_MBI_INDICATOR','',$CODE_INDICATOR,'CODE_INDICATOR');				$this->db->delete('QC1_REP_MBI_INDICATOR',array('CODE_INDICATOR'=>$CODE_INDICATOR));		$this->main_model->actionLogs('DELETE','QC1_REP_MBI_DEFINITION','',$CODE_INDICATOR,'CODE_INDICATOR');		$this->db->delete('QC1_REP_MBI_DEFINITION',array('CODE_INDICATOR'=>$CODE_INDICATOR));	}	public function supprimerIndicateurMobiliteRubrique($CODE_INDICATOR,$CODE_ATTRIBUTE){		$this->main_model->actionLogs('DELETE','QC1_REP_MBI_DEFINITION','',$CODE_INDICATOR,'CODE_INDICATOR');		$this->db->delete('QC1_REP_MBI_DEFINITION',array('CODE_INDICATOR'=>$CODE_INDICATOR,'CODE_ATTRIBUTE'=>$CODE_ATTRIBUTE));	}		/**********************************************************	 *   					     	   		  ANCIENNETE   	                                 		 *	 **********************************************************/	// Attention, modifications realisees a reproduire en Prod /!\ 	function listeAttributes($CODE_DOMAIN="",$type=""){		$this->db->order_by("CODE_DOMAIN", "ASC");		$this->db->order_by("NAME_ATTRIBUTE", "ASC");		if($CODE_DOMAIN!=""){			$this->db->where('CODE_DOMAIN',$CODE_DOMAIN);		}		if($type=="cibles"){			$this->db->where('FLG_CUSTOM',1);		}elseif($type=="tkh"){			$this->db->where('FLG_TKH',1);		}						return  $this->db->get('QC1_REP_QDD_ATTRIBUTE')->result();	}		function listeAttributesArray($CODE_DOMAIN=""){		if($CODE_DOMAIN!=""){			if(is_array($CODE_DOMAIN)){				$listeAttributes= $CODE_DOMAIN;			}else{				$listeAttributes = $this->listeAttributes($CODE_DOMAIN);			}		}else{			$listeAttributes = $this->listeAttributes();		}		$listeAttributesNew = array();				foreach($listeAttributes as $attr){			$listeAttributesNew[$attr->CODE_ATTRIBUTE]=$attr;		}				return $listeAttributesNew;			}	function listeAnciennetes () {				//On ordonne les enregistrement par le SEN_NAME par ordre croissant		$this->db->order_by('SEN_NAME', 'ASC');		// Puis on recupere les elements de la table QC1_REP_SEN_FIELDS		return  $this->db->get('QC1_REP_SEN_FIELDS')->result();	}	function infoAnciennete ($SEN_CODE) {			// On regupere les elements de la table QC1_REP_SEN_FIELDS ayant le SEN_CODE mis en param		$result = $this->db->get_where('QC1_REP_SEN_FIELDS', array('SEN_CODE' => $SEN_CODE))->result();		return $result[0] ;	}	function editerAnciennete($myArray){		// On check si on doit update ou insert		if($myArray['SEN_CODE']!=""){			// Creation du log avant update pour avoir les donnees avant modification			$this->main_model->actionLogs('UPDATE','QC1_REP_SEN_FIELDS','',$myArray['SEN_CODE'],'SEN_CODE');			$this->db->where('SEN_CODE', $myArray['SEN_CODE']);			$this->db->update('QC1_REP_SEN_FIELDS',array(					'SEN_NAME'=>$myArray['SEN_NAME'],					'SEN_DESC'=>$myArray['SEN_DESC'],					'SEN_CODE_SRC_FIELD'=>$myArray['SEN_CODE_SRC_FIELD'],					'SEN_CODE_TGT_FIELD'=>$myArray['SEN_CODE_TGT_FIELD']			));			return 	$myArray['SEN_CODE'];		}else{			// Insertion d'une Anciennete			$this->main_model->actionLogs('INSERT','QC1_REP_SEN_FIELDS',$myArray);			$this->db->insert('QC1_REP_SEN_FIELDS',array(					'SEN_NAME'=>$myArray['SEN_NAME'],					'SEN_DESC'=>$myArray['SEN_DESC'],					'SEN_CODE_SRC_FIELD'=>$myArray['SEN_CODE_SRC_FIELD'],					'SEN_CODE_TGT_FIELD'=>$myArray['SEN_CODE_TGT_FIELD']			));			//return $this->db->insert_id() ;		}	}	function supprimerAnciennete ($SEN_CODE) {		//Suppression du champ		$this->main_model->actionLogs('DELETE','QC1_REP_SEN_FIELDS','',$SEN_CODE,'SEN_CODE');		if($this->db->get_where('QC1_REP_SEN_FIELDS', array('SEN_CODE' => $SEN_CODE))->num_rows()>0){			// Suppresion de l'archive			$this->db->where('SEN_CODE', $SEN_CODE);			$this->db->delete('QC1_REP_SEN_FIELDS');		}		return $SEN_CODE ;	}	public function checkNameAnciennete($SEN_NAME,$SEN_CODE=""){		$this->db->like('SEN_NAME',trim($SEN_NAME));		if($SEN_CODE==""){			$nb = $this->db->get('QC1_REP_SEN_FIELDS')->num_rows();		}else{			$nb = $this->db->get_where('QC1_REP_SEN_FIELDS',array('SEN_CODE <>'=>$SEN_CODE))->num_rows();		}		if($nb==0){			return "true";		}else{			return "false";		}	}}?>