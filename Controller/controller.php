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
                $path_serv.= DIRECTORY_SEPARATOR.$value;
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
                        $this->setCurrent($path_serv);
                    }
                }
                else {
                    $errorpop = true;
                    $pop .= '/'.$value;               
                 }
            }
        } 
        if ($errorpop == true)  
            echo "<p> Impossible pour la recherche ".$pop.".</p>";
            $this->scan_dir();
        }
    
public function scan_dir(){
    $path_serv = str_replace($_SERVER['DOCUMENT_ROOT'],'',$this->path);
    $stop= explode ('/', $path_serv);
    array_pop($stop);
    $stop = BASE_URI.implode(DIRECTORY_SEPARATOR, $stop);
  
    if($this->path_org == 'folder'){
        $scan = scandir($this->path);
        $stock_path = [];
  
        foreach($scan as $content){
          if($this->path == $_SERVER['DOCUMENT_ROOT']){
            if($content != '.' && $content != '..'){
              $path = $path_serv.DIRECTORY_SEPARATOR.$content;
              $stock_path[$path] = $content;
            }
          }
          else {
            if($content != '.' ){
              $path = $path_serv.DIRECTORY_SEPARATOR.$content;
              $stock_path[$path] = $content;
            }
          }
        }
        $this->supply($stock_path);
      }
    
    else if($this->path_org == 'file'){
    echo '<a href="'.$stock_path.'"><div class="links"><p>Retour</p></div></a>';
    $date = file_get_contents($this->path);
    $file = $_SERVER['DOCUMENT_ROOT'].BASE_URI.'/file.txt';
    $lock_file = fopen($file, "w");
    fclose($lock_file);
    $read_file= fopen($file, 'r+');
    fwrite($read_file, $date);
    echo '<div id ="file">'.file_get_contents($file).'</div>';
    fclose($read_file);
    }
  elseif($this->path_org == 'image'){
    echo '<a href="'.$stop.'"><div class="links"><p>Retour</p></div></a>';
    $src = str_replace($_SERVER['DOCUMENT_ROOT'],'',$this->path);
    echo '<img src="' . $src . '">';
  }
}
public function supply (){
  $path_serv = str_replace($_SERVER['DOCUMENT_ROOT'],'',$this->path);
    $links = explode('/', $path_serv);
    $path = '';

    for($i=0; $i<count($links); $i++){
      $folder = $links[$i];
      if($i == 0) $folder = 'Index';

      $path .= $links[$i].DIRECTORY_SEPARATOR;
      $links[$i] = '<a href="'.BASE_URI.$path.'">'.$folder.'</a>';
    }
    $pwd_path = '<p class="pwd">'.implode(DIRECTORY_SEPARATOR, $links).'</p>';
    echo $pwd_path;
    $files = [];

    foreach($stock_path as $path => $data){
      $path_serv = $_SERVER['DOCUMENT_ROOT'].$path;

      if(is_file($path_serv)){
        $file_size = filesize($path_serv);
        $last_mod = filemtime($path_serv);
       
        $params = ['name' => $data, 'path' => BASE_URI.$path, 'size' => $file_size, 'last-mod' => $last_mod];
        array_push($files, $params);
      }

      else{
        echo '<a href="'.BASE_URI.$path.'"><div class="links">
        <img class="folder-img" src="'.BASE_URI.'/public/folder.png" width="30" height="30"/><p>'.$data.'</p>
        </div></a>';
      }
    }
    $files_array = array_filter($files);

   
    if (!empty($files_array)) {
      $this->list($files);
    }
  
}
public function list($files){
  if(isset($_POST['order'])){
    usort($files, function($a, $b) {
      return $a[$_POST['order']] - $b[$_POST['order']];
    });
  }

  foreach($files as $data){
    $file_size = ($data['size']);
    $last_mod = date("m.d.Y, H:m a", $data['last-mod']);
    echo '<a href="'.$data['path'].'"><div class="links">
    <div class="left-link"><p>'.$data['name'].'</p></div>
    <div class="right-link"><p>'.$file_size.' - last mod: '.$last_mod.'</p></div>
    </div></a>';
  }
}
    }
  