<?php

class BehalfZF2api {
	/**
	 * @var Traversable
	 */
	private $clientConfig;
	
	/**
	 * @var \ZRayExtension
	 */
	private $zray;
	
	/**
	 * @var Zend\Http\Client
	 */
	private $client;
	
	public function __construct($zray) {
		$this->zray = $zray;
	}
	
	
	public function collect($context, &$storage){
		$result = $context['returnValue']; /* @var $result \Zend\Http\Response */
        $body = '';
        $statusCode = '';
		if ($result instanceof \Zend\Http\Response) {
			$body = $result->getBody();
            $statusCode = $result->getStatusCode();
		}
		
        $client = $context['this']; /* @var $client \Zend\Http\Client */
        
		$params = array();
		if (in_array($client->getRequest()->getMethod(), array(Zend\Http\Request::METHOD_POST, Zend\Http\Request::METHOD_PUT, Zend\Http\Request::METHOD_PATCH))) {
			$params = $client->getRequest()->getContent();
		} else {
			$params = json_encode($client->getRequest()->getQuery()->toArray());
		}


		$storage['RequestsZf2'][] = array(
			'method' => $client->getRequest()->getMethod(),
			'url' => $client->getRequest()->getUri()->toString(),
			'headers' => json_encode($client->getRequest()->getHeaders()->toArray()),
			'params' => ($params),
			'responseRawBody' => $body,
            'responseCode' => $statusCode,
            'duration' => $context['durationInclusive']
        );
	}
}


$zre = new ZRayExtension('zf2http');

$zre->setEnabled();

$behalfZf2Api = new BehalfZF2api($zre);

$zre->traceFunction('Zend\Http\Client::send', function($context, &$storage){}, array($behalfZf2Api, 'collect'));
