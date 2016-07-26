<?php
/**
 * Created by PhpStorm.
 * User: toni.schreiber
 * Date: 26.07.2016
 * Time: 16:26
 */

namespace app\components;

use Yii;
use yii\base\Object;


/**
 * Class HocrPaser
 * @package app\components
 */
class HocrPaser extends Object{


	/**
	 * @var \DOMDocument
	 */
	private $hocrFile;

	/**
	 * @var array
	 */
	private $textArray;

	private $currentPage;


	/**
	 * HocrPaser constructor.
	 * @param string $file Filepath
	 */
	public function __construct($file)
	{
		$this->hocrFile = new \DOMDocument();
		$this->hocrFile->loadXML(file_get_contents($file));
	}

	/**
	 *
	 */
	public function parse(){
		$this->hocrFile->getElementsByTagName('body');
	}

	/**
	 * @param \DOMNodeList $nodeList
	 */
	private function analyseDomNode($nodeList){
		for($n =0 ; $n < $nodeList->length(); $n++){

			/** @var \DOMNode $domNode */
			$domNode = $nodeList->item($n);

			$class = $domNode->attributes->getNamedItem('class')->textContent;

			switch ($class){
				case 'ocrx_word':
					//Wort zum Array hinzufügen
					break;
				case 'ocr_page':
					//
					break;
			}


			if(in_array($class, ['ocr_page','ocr_carea','ocr_par','ocr_line'])){
				$this->analyseDomNode($domNode->childNodes);
			}


		}
	}

}