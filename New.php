<?php 
$action  = $_GET['actionname'];
if($action=="getfolder"){
    getfolder();
}elseif($action =="createfolder"){
    createfolder();
}elseif($action=="createfile"){
    createfile();
}elseif($action=="deletefiles"){
    deletefiles();
}
function getfolder(){
define("ROOT_DIR",__DIR__);
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
// $result = isset($request->fileurl) ? ROOT_DIR.DIRECTORY_SEPARATOR.trim(htmlspecialchars($request->fileurl)).DIRECTORY_SEPARATOR : ROOT_DIR.DIRECTORY_SEPARATOR;
$result = isset($request->fileurl) ? $request->fileurl : ROOT_DIR.DIRECTORY_SEPARATOR;
$arr=[];
$arrdir = array_diff(scandir($result), array('..', '.'));
foreach($arrdir as $dir){
    $fileinfo = pathinfo($dir);
    $fileobj = new stdClass();
    $fileobj->type = filetype($result.DIRECTORY_SEPARATOR.$dir);
    $fileobj->extension =  is_dir($result.DIRECTORY_SEPARATOR.$dir) ?  "Directory" : $fileinfo['extension'];
    $fileobj->path = strlen(realpath($dir)) > 2 ? realpath($dir)   : $result.DIRECTORY_SEPARATOR.$dir ;
    $fileobj->basename = $fileinfo["basename"];
    $fileobj->name = $fileinfo["filename"];
    $fileobj->size = format_size(filesize($result.DIRECTORY_SEPARATOR.$dir));
    $fileobj->ltime = date("d-m-Y H:i:s.", filemtime($result.DIRECTORY_SEPARATOR.$dir));
    $fileobj->permission = get_permission($result.DIRECTORY_SEPARATOR.$dir);
    $fileobj->owner = fileowner($result.DIRECTORY_SEPARATOR.$dir);
    $arr[] = $fileobj;
}
echo json_encode($arr);
}
function createfolder(){
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $foldername = isset($request->foldername) ? $request->foldername : "";
    $currentdir =isset($request->currentdir) ? $request->currentdir : "";
    $path = $currentdir.DIRECTORY_SEPARATOR.$foldername;
    if(file_exists($path) && strlen($foldername) < 2){
       // echo "Folder is Already Exist";
        echo json_encode(false);
    }else{
        system("chmod a+rwx '".$currentdir."'");
        system("sudo chown -R :riya24  $currentdir");
        system("mkdir '$path'");  
        system("chmod a+rwx '".$path."'");
        system("sudo chown -R :riya24  $path");
        echo json_encode(true);
    }
}
function createfile(){
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $filename = isset($request->filename) ? $request->filename : "";
    $currentdir =isset($request->currentdir) ? $request->currentdir : "";
    $fileinfo =  pathinfo($filename);
    $extension = isset($fileinfo['extension'])  ? $fileinfo['extension'] : "" ;
    if(!isset($extension) || $extension == ''){
       $filename = $filename.".txt";
    }
    $path = $currentdir.DIRECTORY_SEPARATOR.$filename;
    if(file_exists($path) && strlen($filename) < 0){
        echo json_encode(false);
    }else{
        system("chmod a+rwx '".$currentdir."'");
        system("sudo chown -R :riya24  $currentdir");
        system("touch '$path'");  
        system("chmod a+rwx '".$path."'");
        system("sudo chown -R :riya24  $path");
        echo json_encode(true);
    }
}
function deletefiles(){
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $filename = isset($request->deletepath) ? $request->deletepath : "";
    foreach($filename as $file){
        if(file_exists($file)){
            if(is_file($file)){
                system("rm $file");
                echo  json_encode(true);
            }elseif(is_dir($file)){
                system("rm -rf  $file");
                echo  json_encode(true);
            }
        }else{
            echo json_encode(false);
        }
    }

}





















function get_permission($path){
    $perms = fileperms('/etc/passwd');
  
    switch ($perms & 0xF000) {
        case 0xC000: // socket
            $info = 's';
            break;
        case 0xA000: // symbolic link
            $info = 'l';
            break;
        case 0x8000: // regular
            $info = 'r';
            break;
        case 0x6000: // block special
            $info = 'b';
            break;
        case 0x4000: // directory
            $info = 'd';
            break;
        case 0x2000: // character special
            $info = 'c';
            break;
        case 0x1000: // FIFO pipe
            $info = 'p';
            break;
        default: // unknown
            $info = 'u';
    }
    
    // Owner
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
                (($perms & 0x0800) ? 's' : 'x' ) :
                (($perms & 0x0800) ? 'S' : '-'));
    
    // Group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
                (($perms & 0x0400) ? 's' : 'x' ) :
                (($perms & 0x0400) ? 'S' : '-'));
    
    // World
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
                (($perms & 0x0200) ? 't' : 'x' ) :
                (($perms & 0x0200) ? 'T' : '-'));
    
    return $info;
  }
  function format_size($size) {
    $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    if ($size == 0) { return('0 Bytes'); } else {
    return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]); }
  }
?>