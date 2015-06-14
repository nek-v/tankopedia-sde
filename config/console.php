<?php

return CMap::mergeArray(
        CMap::mergeArray(array(
            'basePath'  => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
            'runtimePath'   => dirname(__FILE__).DIRECTORY_SEPARATOR.'../runtime',
            'preload'   => ['log'],
            'aliases' => [
                'vendor'    => realpath(__DIR__ . '/../vendor')
            ]
        ),
            require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'components.php')
        ),
        CMap::mergeArray(
            require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'params.php'),
            []
        )
);

