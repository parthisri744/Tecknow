<?php
$postdata = file_get_contents("php://input");
////var_dump($postdata);
$request = json_decode($postdata);
$result = __DIR__.isset($request->fileurl) ? trim(htmlspecialchars($request->fileurl)) :"";
if(strlen($result)>2){
    $directory = __DIR__.DIRECTORY_SEPARATOR.$result.DIRECTORY_SEPARATOR;
   
}else{
    $directory = __DIR__;
}
$directory = __DIR__;
// echo "RESULT :".$result;
//$directory = "/opt/lampp/htdocs/File";
$scanned_directory = array_diff(scandir($directory), array('..', '.'));
//var_dump($scanned_directory);
$arr = [];
foreach($scanned_directory as $files){
if(is_dir($files) && file_exists($files)){
    $fileinfo = pathinfo($files);
    $fileobj = new stdClass();
    $fileobj->name = $fileinfo["filename"];
    $fileobj->extension = "Directory";
    $fileobj->path = $files;
    $fileobj->basename = $fileinfo["basename"];
    $fileobj->size = filesize($files);
    $fileobj->type = filetype($files);
    $fileobj->ltime = date("d-m-Y H:i:s.", filemtime($files));
    $fileobj->permission = get_permission($directory.DIRECTORY_SEPARATOR.$files);
    $fileobj->owner = fileowner($files);
    $arr[] = $fileobj;

}elseif(is_file($files) && file_exists($files)){
    $fileinfo = pathinfo($files);
    $fileobj = new stdClass();
    $fileobj->name = $fileinfo["filename"];
    $fileobj->extension = $fileinfo["extension"];
    $fileobj->path = $files;
    $fileobj->basename = $fileinfo["basename"];
    $fileobj->size = filesize($files);
    $fileobj->type = filetype($files);
    $fileobj->ltime = date("d-m-Y H:i:s.", filemtime($files));
    $fileobj->permission = get_permission($directory.DIRECTORY_SEPARATOR.$files);
    $fileobj->owner = fileowner($files);
    $arr[] = $fileobj;
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
//print_r($arr);
//$fileinfo = pathinfo($files);
echo json_encode($arr);
?>