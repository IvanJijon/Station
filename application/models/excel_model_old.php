<?php

require_once("excel/reader.php");

class Excel_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	function getData($file){
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('UTF-8');
		$data->read($file);
		$tableau=array();
		$tableau['data']=$data->sheets[0]['cells'];
		$tableau['numRows']=$data->sheets[0]['numRows'];
		$tableau['numCols']=$data->sheets[0]['numCols'];
		return $tableau;
		/*for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
			for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
				$data->sheets[0]['cells'][$i][$j]."\",";
			}
			echo "\n";
		
		}*/
	}
	
	function writeData($file,$titre,$data){
		$workbook = new Spreadsheet_Excel_Writer();
		
		$format_bold =& $workbook->addFormat();
		$format_bold->setBold();
		
		// Nous avons besoin d'une feuille de travail dans laquelle nous allons placer nos données
		$worksheet =& $workbook->addWorksheet();
		// Ceci est notre titre
		$worksheet->write(0, 0, $titre, $format_bold);
		
		for($i=0;$i<$data['numRows'];$i++){
			for($j=0;$j<$data['numCols'];$j++){
				$worksheet->write($i, $j, $data['data'][$i][$j]);
			}
		}

		$workbook->send($file);
		$workbook->close();
	}
}
?>