<?php
/**
 * Created by PhpStorm.
 * User: toni.schreiber
 * Date: 26.07.2016
 * Time: 16:26
 */

namespace app\components;

use yii\base\Object;


/**
 * Class HocrPaser
 * @package app\components
 */
class HocrParser extends Object{


	/**
	 * @var \DOMDocument
	 */
	private $hocrFile;

	/**
	 * @var array
	 */
	private $documentArray;

    /**
     * @var array temp-Array
     */
    private $currentPage;

    /**
     * @var int
     */
    public $pageCount;


	/**
	 * HocrPaser constructor.
	 * @param string $file Filepath
	 */
	public function __construct($file)
	{
		$this->hocrFile = new \DOMDocument();
		$this->hocrFile->loadXML(file_get_contents($file));
        $this->pageCount = 0;
        $this->documentArray = [];
	}

	/**
	 *
	 */
	public function parse(){
		$this->analyseDomNode($this->hocrFile->getElementsByTagName('body'));
	}

	/**
	 * @param \DOMNodeList $nodeList
	 */
	private function analyseDomNode($nodeList){
		for($n =0 ; $n < $nodeList->length; $n++){
			/** @var \DOMNode $domNode */
			$domNode = $nodeList->item($n);

            if(strcmp($domNode->nodeName, 'body') == 0 ){
                $this->analyseDomNode($domNode->childNodes);
            }else {
                if($domNode->hasAttributes()) {
                    $class = $domNode->attributes->getNamedItem('class')->textContent;
                    switch ($class) {
                        case 'ocrx_word':
                            $title = $domNode->attributes->getNamedItem('title')->textContent;
                            $titleData = explode(' ', $title);
                            array_push($this->currentPage['text'], [
                                'left' => $titleData[1],
                                'top' => $titleData[2],
                                'width' => $titleData[3] - $titleData[1],
                                'height' => $titleData[4] - $titleData[2],
                                'content' => $domNode->textContent
                            ]);
                            break;
                        case 'ocr_page':
                            $this->pageCount++;
                            $title = $domNode->attributes->getNamedItem('title')->textContent;
                            $data = explode(';',$title);
                            $data = explode(' ', trim($data[1]));
                            $this->currentPage = [
                                'page' => $this->pageCount,
                                'width'=> $data[3],
                                'text' => []
                            ];
                            break;
                    }

                    if (in_array($class, ['ocr_page', 'ocr_carea', 'ocr_par', 'ocr_line'])) {
                        $this->analyseDomNode($domNode->childNodes);
                    }

                    if (strcmp($class, 'ocr_page') == 0) {
                        array_push($this->documentArray, $this->currentPage);
                    }
                }
            }
		}
	}

    /**
     * Write a array to a JSON-File
     * @param $file FilePath
     */
    public function save($file){
	    file_put_contents($file,json_encode($this->documentArray));
    }

}