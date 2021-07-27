<?php

namespace App\Service;


class ImageUploaderHelper
{

    private $root;
    
    // $root wired in services.yaml

    public function __construct(string $root)
    {
        $this->root = $root;
    }

    public function getPublicPath(string $path): string
    {
        return $this->root.$path;
    }
    
    /**
     * Get the value of root
     */ 
    public function getRoot()
    {
        return $this->root;
    }
}