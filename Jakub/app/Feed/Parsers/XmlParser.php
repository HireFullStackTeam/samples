<?php

namespace App\Feed\Parsers;

use DOMDocument;
use Illuminate\Filesystem\Filesystem;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as SabreXmlService;



abstract class XmlParser extends AbstractParser
{

	/**
	 * @var SabreXmlService
	 */
	protected $sabreXmlService;

	/**
	 * @var Reader
	 */
	protected $reader;

	/**
	 * @var Filesystem
	 */
	protected $files;



	/**
	 * @param SabreXmlService $service
	 * @param Reader          $reader
	 * @param Filesystem      $files
	 */
	public function __construct(SabreXmlService $service, Reader $reader, Filesystem $files)
	{
		$this->sabreXmlService = $service;
		$this->reader = $reader;
		$this->files = $files;
	}



	/**
	 * @param string $path
	 * @return bool
	 */
	public function match($path)
	{
		$doc = new DOMDocument();
		$doc->load($path);

		return $doc->firstChild->nodeName !== $this->rootNodeName();
	}



	/**
	 * @return string
	 */
	public function rootNodeName()
	{
		return $this->rootNodeName;
	}
}