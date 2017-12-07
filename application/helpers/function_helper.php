<?php 
function dump($array)
{
	echo "<pre style='margin-top:100px;position:relative;width:100%;border:1px solid #ff0000;padding:10px;color:#ff0000;font-family:arial;font-size:11px'>"; var_dump($array); echo "</pre>";
}
function dateSqlNow()
{
	if(defined('DATE_MASK')){
		$tabMask = explode (' ',DATE_MASK);	
		//return date(str_replace('dd','d',str_replace('mm','m',str_replace('yyyy','Y',$tabMask[0])))." ".str_replace('hh','H',str_replace('mm','i',str_replace('ss','s',$tabMask[1]))));
		return date(str_replace('dd','d',str_replace('mm','m',str_replace('yyyy','Y',$tabMask[0]))));
	}else{
		return date('Y-m-d H:i:s');
	}
}
function myIP()
{
	return $_SERVER['REMOTE_ADDR'];
}
// Type : dd , mm , yyyy
function findDateMask($type,$tabMask,$tabDate){
	for($i=0;$i<count($tabMask);$i++){
		if($tabMask[$i]==$type){
			return $tabDate[$i];
		}
	}
}
function dateSqlToDate($datesql)
{
	if(defined('DATE_MASK')){
		$tabMask = explode (' ',DATE_MASK);
		$tabDate = explode(' ',$datesql);
		if(substr_count($tabMask[0], '/')>0){
			$tabDateMask = explode('/',$tabMask[0]);
			$tab = explode('/',$tabDate[0]);			
			$newDate = "";
			for($i=0;$i<count($tabDateMask);$i++){
				if($newDate==""){
					$newDate=findDateMask('dd',$tabDateMask,$tab);
				}else{
					if(substr_count($newDate,'/')==0){
						$newDate .= "/".findDateMask('mm',$tabDateMask,$tab);
					}else{
						$newDate .= "/".findDateMask('yyyy',$tabDateMask,$tab);
					}
				}
			}
			if(count($tabDate)>1){
				if($tabDate[1]!="00:00:00"){
					$newDate .= " ".$tabDate[1];
				}
			}			
			return $newDate;
		}elseif(substr_count($tabMask[0],'-')>0){
			$tabDateMask = explode('-',$tabMask[0]);
			$tab = explode('-',$tabDate[0]);
			$newDate = "";
			for($i=0;$i<count($tabDateMask);$i++){
				if($newDate==""){
					$newDate=findDateMask('dd',$tabDateMask,$tab);
				}else{
					if(substr_count($newDate,'/')==0){
						$newDate .= "/".findDateMask('mm',$tabDateMask,$tab);
					}else{
						$newDate .= "/".findDateMask('yyyy',$tabDateMask,$tab);
					}
				}
			}
			// Affichage des heures
			if(count($tabDate)>1){
				if($tabDate[1]!="00:00:00"){
					$newDate .= " ".$tabDate[1];
				}
			}
			return $newDate;
		}		
	}else{	
		$tabDate = explode(' ',$datesql);
		$date = explode('-',$tabDate[0]);
		if($tabDate[0]=="0000-00-00")
		{
			return "";
		}else {
			if(count($tabDate)>1)
			{
				return $date[2]."/".$date[1]."/".$date[0]." ".$tabDate[1];
			}else{
				return $date[2]."/".$date[1]."/".$date[0];
			}
		}
	}
}
function dateToDateSql($date,$time="")
{
	if ($date == ''){
		return '';
	}
	if(defined('DATE_MASK')){
		$tabMask = explode (' ',DATE_MASK);
		$tabDate = explode(' ',$date);
		$tab = explode('/',$tabDate[0]);
		if(count($tabDate)==1){			
			return str_replace('dd',$tab[0],str_replace('mm',$tab[1],str_replace('yyyy',$tab[2],$tabMask[0])));
		}else{
			$tabTime = explode(':',$tabDate[1]);
			return str_replace('dd',$tab[0],str_replace('mm',$tab[1],str_replace('yyyy',$tab[2],$tabMask[0])))." ".str_replace('hh',$tabTime[0],str_replace('mm',$tabTime[1],str_replace('ss',$tabTime[2],$tabMask[0])));
		}
	}else{
		$tabDate = explode('/',$date);	
		if($time=="")
		{
			return $tabDate[2]."-".$tabDate[1]."-".$tabDate[0];
		}else{
			return $tabDate[2]."-".$tabDate[1]."-".$tabDate[0]." ".$time;
		}
	}
}
function dateToDateChar($date,$tabMois){
	$tab = explode(' ',$date);
	$tabDate = explode('/',$tab[0]);
	$tabM = explode('|',$tabMois);
	if(substr($tabDate[1],0,1)=="0"){$m=substr($tabDate[1],1,1);}else{$m=$tabDate[1];}
	if(count($tab)==1){
		return $tabDate[0]." ".$tabM[$m]." ".$tabDate[2];
	}else{
		return $tabDate[0]." ".$tabM[$m]." ".$tabDate[2]." ".$tab[1];
	}
}
function compareDate($date1,$date2="")
{
	if($date2!=""){$date2=date('d/m/Y');}
	$tabDate1 = explode('/',$date1);
	$tabDate2 = explode('/',$date2);
	$mktime1 = mktime(0,0,0,$tabDate1[1],$tabDate1[0],$tabDate1[2]);
	$mktime2 = mktime(0,0,0,$tabDate2[1],$tabDate2[0],$tabDate2[2]);
	if($mktime1>$mktime2){
		return ">";
	}elseif($mktime1<$mktime2){
		return "<";
	}else{
		return "=";
	}
}
function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
        $time1 = $ttime;
        $diffs[$interval]++;
        // Create new temp time from time1 and interval
        $ttime = strtotime("+1 " . $interval, $time1);
      }
    }
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
        break;
      }
      // Add value and interval
      // if value is bigger than 0
      if ($value > 0) {
        // Add s if value is not 1
        if ($value != 1) {
          $interval .= "s";
        }
        // Add value and interval to times array
         $intervals_no['second'] = 'seconde';
     $intervals_no['seconds'] = 'secondes';
         $intervals_no['minute'] = 'minute';
     $intervals_no['minutes'] = 'minutes';
         $intervals_no['hour'] = 'heure';
     $intervals_no['hours'] = 'heures';
         $intervals_no['day'] = 'jour';
     $intervals_no['days'] = 'jours';
         $intervals_no['month'] = 'mois';
     $intervals_no['months'] = 'mois';
         $intervals_no['year'] = 'an';
     $intervals_no['years'] = 'ans';
        $times[] = $value . " " . $intervals_no[$interval];
        $count++;
      }
    }
    $times['string'] = implode(", ", $times) ;
    $times['tableau'] = $diffs ;
    return $times;
  }
function calculTime($nb,$type)
{
	switch($type){
		case "secondes":
			return $nb;
		break;
		case "minutes":
			return $nb*60;
		break;
		case "heures":
			return $nb*60*60;
		break;
		case "jours":
			return $nb*60*60*24;
		break;
		case "mois":
			return $nb*60*60*24*30;
		break;
		case "annees":
			return $nb*60*60*24*30*12;
		break;
	}
}
function dateSqlVide()
{
	return "0000-00-00 00:00:00";
}
function generateCode($nb)
{
	$characts    = 'abcdefghijklmnopqrstuvwxyz';
    $characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';	
	$characts   .= '1234567890'; 
	$code_aleatoire      = ''; 
	for($i=0;$i < $nb;$i++)
	{ 
        $code_aleatoire .= substr($characts,rand()%(strlen($characts)),1); 
	}
	return $code_aleatoire;
}
function getDureeMin($min)
{
	$h=floor($min/60);
	$minute=$min-$h*60;
	if(strlen($minute)==1)
	{
		$minute="0".$minute;
	}
	return $h.'h'.$minute;
}
function affichagePrix($prix){
	$tab = explode('.',$prix);
	$nb=strlen($tab[0]);
	$retour="";
	for($i=0;$i<$nb;$i++){
		if(($nb-$i-3)%3=="0" && $i>0){$return .=" ";}
		$return .= substr($tab[0],$i,1);
	}
	if(count($tab)>1){
		return $return.".".$tab[1];
	}else{
		return $return;
	}	
}
function getColumnActive($obj){	
	$listeChamps = array();
	foreach($obj as $tab){
		foreach($tab as $key=>$val){
			if($val!=NULL && $val!="" && $val!="Non défini"){
				if(!in_array($key,$listeChamps)){
					array_push($listeChamps,$key);
				}
			}
		}	
	}
	return $listeChamps;
}
function listeChamps($tab){
	$listeChamps = array();
	foreach($tab as $key=>$value){
		array_push($listeChamps,$key);
	}
	return $listeChamps;
}
?>