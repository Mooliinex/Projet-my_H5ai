<?php

class Controller {
    public $path; 
    public $path_org;


    public function start($url){
        $this->urlCheck($url);
    }

    public function setPath($path){
        $this->path = $path;
    }

    public function  urlCheck($url){
        $check= explode('/', $url);
        $path_serv = $_SERVER['DOCUMENT_ROOT'];
        $pop = ''; 
        $errorpop= false; 

        foreach ($check as $value){
            if ($value !=''){
                $path_serv.= DIRECTORY_SEPARATOR.$value;
            }
        }
    }




}
