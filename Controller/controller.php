<?php

class Controller {
    public $path; 
    public $path_org;

    
    public function start($url){
        $this->urlCheck($url);
    }

    public function setCurrent($path){
        $this->path = $path;
    }

    public function  urlCheck($url){
        $check= explode('/', $url);
        $path_serv = $_SERVER['DOCUMENT_ROOT'];
        $pop = ''; 
        $errorpop= false; 

        foreach ($check as $value){
            if ($value !=''){
                $path_serv.= $value;
            }
            if (is_dir($path_serv)){
                $this->path_org = 'folder';
                $this->setCurrent($path_serv);
            } else { 
                if (is_file($path_serv)){
                    if(preg_match('/([\w\-])+(.png|.pnj|.jpg|.jpeg|.svg|.gif|.ico)$/', $value)){
                        $this->path_org = 'image';
                        $this->setCurrent($path_serv);
                    } else {
                        $this->path_org = 'file';
                        $this->setCurrentPath($path_serv);
                    }
                }
                else {
                    $errorpop = true;
                    $pop .= '/'.$value;               
                 }
            }
        } 
        if ($errorpop == true)  {
            echo "<p> Impossible pour la recherche ".$message.".</p>";
            $this->scan_dir();
        }
    
} 
public function scandir(){
    $path_serv = str_replace($_SERVER['DOCUMENT_ROOT'],'',$this->path);
    $stop= explode ('/', $path_serv);
    array_pop($stop);
    
  
    if($this->path_org == 'folder'){
        $scan = scandir($this->path);
        $stock_path = [];
  
        foreach($scan as $content){
          if($this->path == $_SERVER['DOCUMENT_ROOT']){
            if($content != '.' && $content != '..'){
              $path = $path_serv.$content;
              $stock_path[$path] = $content;
            }
          }
          else {
            if($content != '.' ){
              $path = $path_serv.$content;
              $stock_path[$path] = $content;
            }
          }
        }
        $this->render($stock_path);
      }
}
    elseif($this->path_org == 'file'){
    echo '<a href="'.$stock_path.'"><div class="links"><p>Retour</p></div></a>';
    $date = file_get_contents($this->path);

    $file = $_SERVER['DOCUMENT_ROOT'].'/file.txt';
    $lock_file- fopen($file, "w");
    fclose($lock_file);
    $read_file= fopen($file, 'r+');
    fwrite($read_file, $date);
    echo '<div id ="file">'.file_get_contents($file).'</div>';
    fclose($read_file);
    }
  
}