<?php

namespace ZRay\ZendHttp;

class Module extends \ZRay\ZRayModule {

	public function config() {
        return array(
            // The name defined in ZRayExtension
            'extension' => array(
                'name' => 'zf2http',
            ),
            // Prevent those default panels from being displayed
            'defaultPanels' => array(
                'RequestsZf2' => false,
            ),
            // configure all custom panels
            'panels' => array(
                'zf2httpTable' => array(
                    'display'           => true,
                    'menuTitle'         => 'ZF2 Requests',
                    'panelTitle'        => 'ZF2 Requests',
                    'searchId'          => 'zf2http-table-search',
                    'pagerId'           => 'zf2http-table-pager',
                )
            )
        );
    }
	
	
	
}
