<?php
// FileMK Ver.beta Copyright (c) 2018 MediaKobo Co., Ltd.
//
// FileMK : File ManagerK on browser.
//          needs PHP and http server.
//          does not support the Windows server.
//
// License : GNU General Public License
//
//
//  List of users. Plain 'user/password' or md5(user/password)
//
  $Users = [				// List of user
	'admin/admin'
  ];
//
//  Set document the root directory from the file system root.
//  If not set, the directory put FileMX.php is the document root directory.
//
  $RootDir = '';			// Document root directory
//
//  setlocale(LC_ALL, 'ja_JP.UTF-8');	// Set locale
//
// ************************************************************************
//
function fmksetcolor() {	// Set File ManagerK color and background color
?>
<style type="text/css">
<!--
body {color:gold; background:black;}
form input {color:gold; background:black; border:1px darkgray solid;}
#fmk-nav {background:darkslategray;}
.fmk-nav-kuz a {color:gold;}
.fmk-nav-kuz a:hover {color:yellow;}
.fmk-nav-btn {background:black;}
.fmk-nav-btn a {color:gold;}
.fmk-nav-btn a:hover {color:yellow;}
.fmk-detail-btn {background:black; border:1px yellow solid;}
.fmk-detail-btn a {color:gold;}
.fmk-detail-btn a:hover {color:yellow;}
#fmk-message {background:black;}
#fmk-detail-table {border:1px orange solid;}
#fmk-ls-table th {border:1px orange solid;}
#fmk-ls-table td {border:1px orange solid;}
#fmk-ls-table a {color:gold;}
#fmk-ls-table a:hover {color:yellow;}
#fmk-editform input {color:gold; background:black;}
#fmk-edittext {color:gold; background:black; border:1px solid dimgray;}
.CodeMirror {border:1px solid dimgray;}
.CodeMirror-scroll {background:black;}
-->
</style>
<?php
}
//
// ************************************************************************
//
  $File = '';		// File or directory name, RootDir/File => workfile
  $Command = '';	// Command
  $Parameter = '';	// Parameter of command
  $Message = '';	// Output Message
  $WorkDir = '';	// Work directory, WorkDir/WorkFile => workfile
  $WorkFile = '';	// Work file name
  $RenewInterval   = 60;	// Interval time[sec] of renew session
  $TimeoutInterval = $RenewInterval * 60;	// Session timeout[sec]
  fmkcheck();		// Pre check
  fmkexec();		// Execute command
//
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>FileMK</title>

<style type="text/css">
<!--
* {margin:0; padding:0}
p {margin:10px;}
html {height:100%; margin:0}
body {color:black; background:aliceblue; height:100%; margin:0; -webkit-text-size-adjust:100%;}
form input {padding:2px; border:1px showwhite solid;}
#fmk-nav {position:fixed; top:0; left:0; padding:5px; width:100%; z-index:100; background:azure; box-shadow:0 4px 5px rgba(0,0,0,0.2);}
#fmk-nav-left {float:left; padding-left:20px;}
#fmk-nav-right {float:right; padding-right:20px;}
#fmk-nav-gap {clear:both; position:relative; margin-top:5px;}
.fmk-nav-kuz {margin:2px; padding:2px; display:inline;}
.fmk-nav-kuz a {text-decoration:none; color:black;}
.fmk-nav-kuz a:hover {text-decoration:none; color:red;}
.fmk-nav-btn {margin:2px; padding:2px; display:inline; border:1px solid lightgreen; background:whitesmoke;}
.fmk-nav-btn a {text-decoration:none; color:black;}
.fmk-nav-btn a:hover {text-decoration:none; color:red;}
#fmk-message {border:1px solid palegreen; background:lightcyan; margin:10px; padding:5px;}
#fmk-main {height:87%; margin:10px; padding:5px;}
#fmk-detail-table {border:1px lightgray solid; margin:auto; border-collapse:collapse;}
#fmk-detail-table th {padding:1px 10px;}
#fmk-detail-table td {padding:1px 10px;}
#fmk-detail-table td.fmk-textright {}
#fmk-detail-table td.fmk-monospace {font-family:"Consolas","Courier New",monospace;}
#fmk-detail-table a {text-decoration:none; color:black;}
#fmk-detail-table a:hover {text-decoration:none; color:red;}
.fmk-detail-btns {margin:5px auto; text-align:center;}
.fmk-detail-btn {margin:2px; padding:4px; display:inline; border:1px solid lightgreen; background:whitesmoke;}
.fmk-detail-btn a {text-decoration:none; color:black;}
.fmk-detail-btn a:hover {text-decoration:none; color:red;}
#fmk-showtext {margin:10px auto; padding:0px;}
#fmk-showimg {text-align:center; margin:10px auto;}
#fmk-ls-table {border:1px lightgray solid; margin:auto; border-collapse:collapse;}
#fmk-ls-table th {border:1px lightgray solid; padding:10px;}
#fmk-ls-table td {border:1px lightgray solid; padding:10px;}
#fmk-ls-table td.fmk-textright {text-align:right;}
#fmk-ls-table td.fmk-monospace {font-family:"Consolas","Courier New",monospace;}
#fmk-ls-table a {text-decoration:none; color:black;}
#fmk-ls-table a:hover {text-decoration:none; color:red;}
.fmk-scroll{overflow:auto; white-space:nowrap;}
.fmk-scroll::-webkit-scrollbar{height:5px;}
.fmk-scroll::-webkit-scrollbar-track{background:lightgray;}
.fmk-scroll::-webkit-scrollbar-thumb {background:silver;}
#fmk-editform {width:100%; height:100%; box-sizing:border-box;}
#fmk-edittext {width:100%; height:100%; box-sizing:border-box; background:honeydew; border:1px solid gainsboro; margin:10px auto; padding:0px; font-family:"Consolas","Courier New",monospace;}
.CodeMirror {border: 1px solid gainsboro;}
.CodeMirror-scroll {overflow-y:hidden; overflow-x:auto; width:100%; background:honeydew;}
-->
</style>

<?php
fmksetcolor();			// Set color and background color
?>

<script>
function fmkconfirm(mes, f, c, p) {
  var par = '';
  var ret;

  if(f !== undefined && f != '') par = 'f=' + f;
  if(c !== undefined && c != '') {
    if(par != '') par = par + '&c=' + c;
    else par = 'c=' + c;
  }
  if(p !== undefined && p != '') {
    if(par != '') par = par + '&p=' + p;
    else par = 'p=' + p;
  }
  ret = window.confirm(mes);
  if(ret) window.location.href = "?" + par;
}

function fmkprompt(mes, f, c, p) {
  var par = '';
  var val = '';
  var ret;

  if(f !== undefined && f != '') par = 'f=' + f;
  if(c !== undefined && c != '') {
    if(par != '') par = par + '&c=' + c;
    else par = 'c=' + c;
  }
  if(p !== undefined && p != '') val = p;
  ret = window.prompt(mes, val);
  if(ret !== null) {
    if(ret != '') {
      if(par != '') par = par + '&p=' + ret;
      else par = 'p=' + ret;
    }
    window.location.href = "?" + par;
  }
}
</script>
</head>

<body>
<div id="fmk-nav">
  <div id="fmk-nav-left"><?php fmkkuzu(); ?></div>
  <div id="fmk-nav-right">
<?php
  if($WorkDir != '') echo '<div class="fmk-nav-btn"><a href="?c=logout">&#x1F4E4; Logout</a></div>';
?>
  </div>
</div>
<div id="fmk-nav-gap"> &nbsp; </div>
<?php
  if($Message != '') echo "<div id=\"fmk-message\">$Message</div>\n";
?>
<div id="fmk-main">
<?php fmkshow(); ?>
</div>
</body>
</html>

<?php
exit;

function fmkcheck() {
  global $File;		// File or directory name
  global $Command;	// Command
  global $Parameter;	// Parameter of command
  global $Message;	// Output Message
  global $Users;	// User id/pw
  global $TimeoutInterval;	// Session timeout
  global $RenewInterval;	// Renew session key interval
  global $RootDir;	// Document root directory
  global $WorkDir;	// Working directory
  global $WorkFile;	// Working filename

  session_start();		// Start session

  if(isset($_REQUEST['f'])) $File = $_REQUEST['f'];
  if(isset($_REQUEST['c'])) $Command = $_REQUEST['c'];
  if(isset($_REQUEST['p'])) $Parameter = $_REQUEST['p'];

  if($RootDir == '') {			// Default root directory
    $rpath = realpath(__FILE__);
    $RootDir = dirname($rpath);		// Set document root directory
  } else {
    $RootDir = realpath($RootDir);	// Set document root directory
  }
  $workfile = realpath($RootDir . '/' . $File);	// Work file
  if(strpos($workfile, $RootDir) !== 0) {	// Work file under root?
    $Message .= ' Directory is out of range.';
    $WorkDir = '';
    $WorkFile = '';
    $Command = 'logout';
    return;
  }
  if(is_dir($workfile)) {		// Get file information
    $WorkDir = $workfile;
    $WorkFile = '';
  } else if(is_file($workfile) || is_link($workfile)) {
    $workparts = pathinfo($workfile);
    $WorkDir = $workparts['dirname'];
    $WorkFile = $workparts['basename'];
  } else {
    $Message .= ' Not directory, not file, not link.';
    $WorkDir = '';
    $WorkFile = '';
    $Command = 'logout';
    return;
  }

  if(isset($_SESSION['FILEMX'])) {
    $skey = $_SESSION['FILEMX'];
    list($fmktm, $fmkhash) = preg_split('/:/', $skey, 2);
    $logonf = false;
    foreach($Users as $user) {
      $hash = md5($fmktm . ':' . $user);
      if($fmkhash === $hash) {
        $logonf = true;
	break;
      }
    }
    if(! $logonf) {
      $Command = 'logout';
      return;
    }
    $tm = time();
    $dtm = $tm - $fmktm;
    if($dtm > $TimeoutInterval) {	// Auto logout interval
      $Command = 'logout';
      return;
    }
    if($dtm > $RenewInterval) {		// Renew key interval
      $hash = md5($tm . ':' . $user);
      $_SESSION['FILEMX'] = $tm . ':' . $hash;
    }
  } else {
    if($Command != 'login') {
      $Command = 'logout';
    }
  }
}

function fmkexec() {
  global $File;		// File or directory name
  global $Command;	// Command
  global $Parameter;	// Parameter of command
  global $Message;	// Output Message
  global $RootDir;	// Document root directory
  global $WorkDir;	// Working directory
  global $WorkFile;	// Working filename
  global $Users;	// User id/pw

  if($Command == 'login') {				// Login
    $fmkid = '';
    $fmkpw = '';
    if(isset($_POST['fmkid'])) {
      $fmkid = $_POST['fmkid'];
    }
    if(isset($_POST['fmkpw'])) {
      $fmkpw = $_POST['fmkpw'];
    }
    $fmkuser = $fmkid . '/' . $fmkpw;
    if($fmkuser != '/') {
      $logonf = false;
      foreach($Users as $user) {
        if($fmkuser === $user || md5($fmkuser) === $user) {
          $logonf = true;
          break;
        }
      }
      if($logonf) {
        $tm = time();
        $hash = md5($tm . ':' . $user);
        $_SESSION['FILEMX'] = $tm . ':' . $hash;
        $Command = '';
      } else {
        $Message .= ' Login failure';
        sleep(5);
        $Command = 'logout';
      }
    } else {
      $Command = 'logout';
    }
  }
  if($Command == 'logout') {				// Logout
    session_unset();
    session_destroy();
    $WorkDir = '';
  }
  if($Command == 'edit' || $Command == 'ckeditor' || $Command == 'tinymce' || $Command == 'codemirror') {
    $filefl = $WorkDir . '/' . $WorkFile;		// File full path
    $fi = fmkfileinfo($filefl);				// Get file information
    if($fi == false) return;				// Invalide file
    $filesz = $fi['size'];				// File size
    $filemi = $fi['mime'];				// File MIME

    if(strpos($filemi, 'text/') === 0 || $filesz == 0) {	// Save text
      if(isset($_POST['fmk-editarea'])) {
        $cont = $_POST['fmk-editarea'];
        $fp = fopen($filefl, 'w');
        if($fp) {
          fwrite($fp, $cont);
          fclose($fp);
//          $Message .= ' Saved. ' . date('G:i:s');
        } else {
          $Message .= ' Fail to save.';
        }
      }
    }
  }
  if($Command == 'delete') {				// Delete
    $Command = '';
    $filefl = $WorkDir . '/' . $WorkFile;		// File full path
    if(is_dir($filefl)) {				// Directory ?
      if($RootDir == $WorkDir) {
        $Message .= " Can not delete the document root directory";
      } else {
        $prnt = dirname($filefl);			// Parent directory
        $chld = substr($filefl, strlen($prnt));		// Child directory
        if(rmdir($filefl)) {				// Delete directory
          $Message .= " Delete $chld";
          $File = substr($prnt, strlen($RootDir));	// From document root
          $WorkDir = $prnt;
          $WorkFile = '';
        } else {
          $Message .= " Fail to delete $chld";
        }
      }
    } else {
      if(unlink($filefl)) {				// Delete file
        //$File = substr($File, 0, strlen($File) - strlen($WorkFile));
        $File = dirname($File);
        $Message .= " Delete $WorkFile";
        $WorkFile = '';
      } else {
        $Message .= " Fail to delete $WorkFile";
      }
    }
  }
  if($Command == 'newfile') {				// New file
    $Command = '';
    if($WorkFile != '' || $Parameter == '') {
      $Message .= " Fail to make a new file";
    } else {
      $filefl = $WorkDir . '/' . $Parameter;		// File full path
      if(strpos($filefl, $RootDir) !== 0) 	{	// Work file under root?
        $Message .= " File is not under the root document.";
      } else {
        if(touch($filefl)) {				// Touch new file
          $Message .= " Make a new file : $Parameter";
        } else {
          $Message .= " Fail to make a new file : $Parameter";
        }
      }
    }
  }
  if($Command == 'newdirectory') {			// New directory
    $Command = '';
    if($WorkFile != '' || $Parameter == '') {
      $Message .= " Fail to make a new directory";
    } else {
      $filefl = $WorkDir . '/' . $Parameter;		// File full path
      if(strpos($filefl, $RootDir) !== 0) {		// Work file under root?
        $Message .= " Directory is not under the root document.";
      } else {
        if(mkdir($filefl)) {				// Make new directory
          $Message .= " Make a new directory : $Parameter";
        } else {
          $Message .= " Fail to make a new directory : $Parameter";
        }
      }
    }
  }
  if($Command == 'dirop') {				// Directory operation
    if(isset($_POST['upload'])) {
      $filename = "";
      if(isset($_FILES['upfile'])) {
        $filename = $_FILES['upfile']['name'];
        $filesize = $_FILES['upfile']['size'];
        $filetype = $_FILES['upfile']['type'];
        $filetemp = $_FILES['upfile']['tmp_name'];
      }
      if($filename != "" && $filesize != 0) {
        $file = $WorkDir . '/' . $filename;
        if(move_uploaded_file($filetemp, $file)) {
          $Message .= " Upload file : $filename";
        } else {
          $Message .= "Fail to upload : $filename";
        }
      } else {
        $Message .= "Fail to upload";
      }
    }
  }
  if($Command == 'copy') {				// Copy
    $Command = '';
    if($WorkFile == '' || $Parameter == '') {
      $Message .= " Fail to copy a file";
    } else {
      $org = $WorkDir . '/' . $WorkFile;		// Original file
      $des = $WorkDir . '/' . $Parameter;		// Destination file
      if(copy($org, $des)) {
        $Message .= " Copy $WorkFile to $Parameter";
      } else {
        $Message .= " Fail to copy $WorkFile to $Parameter";
      }
    }
  }
  if($Command == 'move') {				// Move
    $Command = '';
    if($Parameter == '') {
      $Message .= " Fail to move a file";
    } else {
      $filefl = $WorkDir . '/' . $WorkFile;		// File full path
      if(is_dir($filefl)) {				// Directory ?
        if($RootDir == $WorkDir) {
          $Message .= " Can not delete the document root directory";
        } else {
          $prnt = dirname($filefl);			// Parent directory
          $org = $WorkDir . '/' . $WorkFile;		// Original file
          $des = $prnt . '/' . $Parameter;		// Destination file
          if(rename($org, $des)) {
            $Message .= " Move $File to $Parameter";
            $File = substr($des, strlen($RootDir));
            $WorkDir = $des;
            $WorkFile = '';
          } else {
            $Message .= " Fail to move $File to $Parameter";
          }
        }

      } else {
        $org = $WorkDir . '/' . $WorkFile;		// Original file
        $des = $WorkDir . '/' . $Parameter;		// Destination file
        if(rename($org, $des)) {
          $File = dirname($File);
          $Message .= " Move $WorkFile to $Parameter";
          $WorkFile = '';
        } else {
          $Message .= " Fail to move $WorkFile to $Parameter";
        }
      }
    }
  }
  if($Command == 'unzip') {				// Unzip
    $Command = '';
    $filefl = $WorkDir . '/' . $WorkFile;		// File full path
    $zip = new ZipArchive();				// Zip archive
    if($zip->open($filefl)) {
      $zip->extractTo($WorkDir);			// Extract zip file
      $zip->close();
      $Message .= " Unzip $WorkFile";
    } else {
      $Message .= " Fail to unzip $WorkFile";
    }
  }
  if($Command == 'mkzip') {				// Make zip archive
    $Command = '';
    if($RootDir == $WorkDir || $WorkFile != '') {	// Root or not direcotry
      $Message .= " Can not make a zip archive";
    } else {
      $ziproot = dirname($WorkDir);			// Parent directory
      $zipdir  = basename($WorkDir);			// Archive directory
      $zipfile = $ziproot . '/' . $zipdir . '.zip';	// Zip file name
      if(is_dir($ziproot . '/' . $zipdir)) {
        $zip = new ZipArchive();			// Zip archive object
        if($zip->open($zipfile, ZipArchive::CREATE) === true) {
          if(fmkmakezip($zip, $ziproot, $zipdir)) {	// Archive all files
            if($zip->close()) {				// Close zip archive
              $Message .= " Make zip file : $zipdir.zip";
            } else {
              $Message .= " Fail to make zip file";
            }
          } else {
            $zip->close();
            $Message .= " Fail to make zip file";
          }
        } else {
          $Message .= " Can not open zip file";
        }
      } else {
        $Message .= " Not a directory";
      }
    }
  }
  if($Command == 'fromurl') {				// Download from URL
    $Command = '';
    $filefl = $WorkDir . '/' . $WorkFile;		// File full path
    $filename = basename($Parameter);			// Download file name
    if($filename == '') $filename = 'downloadfile.fmk';
    $cont = file_get_contents($Parameter);
    if($cont !== false) {
      $filefl = $WorkDir . '/' . $filename;
      if(file_put_contents($filefl, $cont)) {
        $Message .= " Get from $Parameter and save $filename";
      } else {
        $Message .= " Fail to save data : $filename";
      }
    } else {
      $Message .= " Fail to get contents from $Parameter";
    }
  }
  if($Command == 'download') {				// Download file
    $Command = '';
    $filefl = $WorkDir . '/' . $WorkFile;		// File full path
    if(is_file($filefl)) {
      $cont = file_get_contents($filefl);
      if($cont !== false) {				// Output file
        echo $cont;
      } else {
        echo "failed to open stream";
      }
      exit;						// Exit for send file
    } else {
      $Message .= "Not a file";
    }
  }
  if($Command == 'tolf') {				// Replace CR/LF -> LF
    $Command = '';
    $filefl = $WorkDir . '/' . $WorkFile;		// File full path
    if(is_file($filefl)) {
      $cont = file_get_contents($filefl);
      if($cont !== false) {
        $colf = str_replace(array("\r\n", "\r", "\n\r"), "\n", $cont);
        if(file_put_contents($filefl, $colf)) {
          $Message .= " Replace CR/LF -> LF";
        } else {
          $Message .= " Can not replace code";
        }
      } else {
        $Message .= " Can not read a file";
      }
    } else {
      $Message .= " Not a file";
    }
  }
}

function fmkkuzu() {
  global $Message;	// Output Message
  global $RootDir;	// Document root directory
  global $WorkDir;	// Working directory

  if($WorkDir == '') return;
  if(strpos($WorkDir, $RootDir) !== 0) return;
  $subdir = substr($WorkDir, strlen($RootDir));
  $subdirs = preg_split('/\//', $subdir);

  $upath = '';
  echo '<div class="fmk-nav-kuz">';
  foreach($subdirs as $subd) {
    if($upath == '') {
      echo ' <a href="?f="> &nbsp; / &nbsp; </a> &nbsp; ';
      $upath .= '/';
      continue;
    }
    $upath .= $subd . '/';
    echo " <a href=\"?f=$upath\"> $subd </a> / ";
  }
  echo "</div>\n";
}

function fmkmakezip($zip, $ziproot, $zipdir) {
  global $Message;

  $wdir = $ziproot . '/' . $zipdir;			// Zip work directory
  if(is_dir($wdir)) {
    if($dh = opendir($wdir)) {				// Open directory
      while(($file = readdir($dh)) !== false){		// For all files
        if($file == '.') continue;			// Current directory
        if($file == '..') continue;			// Parent directory
        $fl = $wdir . '/' . $file;			// Full path file
        $zl = $zipdir . '/' . $file;			// Zip path file
        if(is_file($fl)) {				// Is file?
          if(! $zip->addFile($fl, $zl)) {	// Add file to zip archive
            return false;
          }
        }
        if(is_dir($fl)) {				// Is directory?
          if(! fmkmakezip($zip, $ziproot, $zl)) {	// Recursive directory
            return false;
          }
        }
      }
      closedir($dh);
    }
  }
  return true;
}

function fmkpermission($file) {
  $perms = fileperms($file);		// Get permission

  switch ($perms & 0xF000) {
    case 0xC000: // Socket
        $info = 's';
        break;
    case 0xA000: // Symblic link
        $info = 'l';
        break;
    case 0x8000: // Ordinary file
        $info = '-';	// 'r';
        break;
    case 0x6000: // Block special file
        $info = 'b';
        break;
    case 0x4000: // Directory
        $info = 'd';
        break;
    case 0x2000: // Character special file
        $info = 'c';
        break;
    case 0x1000: // FIFO pipe
        $info = 'p';
        break;
    default: // Unknown
        $info = 'u';
  }

  $info .= (($perms & 0x0100) ? 'r' : '-');	// Owner
  $info .= (($perms & 0x0080) ? 'w' : '-');
  $info .= (($perms & 0x0040) ?
           (($perms & 0x0800) ? 's' : 'x' ) :
           (($perms & 0x0800) ? 'S' : '-'));

  $info .= (($perms & 0x0020) ? 'r' : '-');	// Group
  $info .= (($perms & 0x0010) ? 'w' : '-');
  $info .= (($perms & 0x0008) ?
           (($perms & 0x0400) ? 's' : 'x' ) :
           (($perms & 0x0400) ? 'S' : '-'));

  $info .= (($perms & 0x0004) ? 'r' : '-');	// Other
  $info .= (($perms & 0x0002) ? 'w' : '-');
  $info .= (($perms & 0x0001) ?
           (($perms & 0x0200) ? 't' : 'x' ) :
           (($perms & 0x0200) ? 'T' : '-'));

  return $info;
}

function fmkfileinfo($file) {
  global $RootDir;	// Document root directory

  $fi['fullpath']   = $file;				// File full path
  $fi['fromroot']   = substr($file, strlen($RootDir));	// From document root
  $fi['type']       = filetype($file);			// File type
  $fi['size']       = filesize($file);			// File size
  $fi['permission'] = fmkpermission($file);		// File permission
  $fi['owner']      = posix_getpwuid(fileowner($file))['name'];	// Owner
  $fi['group']      = posix_getgrgid(filegroup($file))['name'];	// Group
  $fi['accesstime'] = date("F d Y H:i:s", fileatime($file));	// Access time
  $fi['changetime'] = date("F d Y H:i:s", filectime($file));	// Change time
  $fi['modifytime'] = date("F d Y H:i:s", filemtime($file));	// Modified time
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $fi['mime']       = finfo_file($finfo, $file);	// File MIME
  if($fi['mime'] === false) $fi['mime'] = 'failed to open';
  finfo_close($finfo);
  $finfo = finfo_open();
  $fi['info']       = finfo_file($finfo, $file);	// File info
  if($fi['info'] === false) $fi['info'] = 'failed to open';
  finfo_close($finfo);

  return $fi;
}

function fmkshow() {
  global $Command;	// Command
  global $WorkDir;	// Working directory
  global $WorkFile;	// Working filename

  if($Command == 'login') {		// login command
    fmklogin();
  } else if($Command == 'logout') {	// logout command
    fmklogin();
  } else if($Command == 'dirop') {	// dirop command
    fmkdirop();
  } else if($Command == 'edit') {	// edit command
    fmkedit();
  } else if($Command == 'ckeditor') {	// ckeditor command
    fmkedit();
  } else if($Command == 'tinymce') {	// tinymce command
    fmkedit();
  } else if($Command == 'codemirror') {	// codemirror command
    fmkedit();
  } else {				// show command
    if($WorkFile == '') {		// Directory?
      fmklist();			// Show file table
    } else {
      fmkdetail();			// Show file detail
    }
  }
}

function fmklogin() {
?>
<form action="?c=login" method="post" style="width:300px; margin:auto;">
<h3> FileMK </h3>
<p> I D &nbsp;: <input type="text" name="fmkid" autofocus="autofocus" /> </p>
<p> PW : <input type="password" name="fmkpw" /> </p>
<p> <input type="submit" value="Login" /> </p>
</form>
<?php
}

function fmkdirop() {
  global $WorkDir;	// Working directory
  global $WorkFile;	// Working filename
  global $File;		// File or directory name

  $mmove = "Rename $File ?";			// Move dialog message
  $mdelete = "Delete $File ?";			// Delete dialog message
  $fzip = $WorkDir . '.zip';			// Zip file
  if(file_exists($fzip)) {
    $mmkzip = "Overwrite $File.zip?";
  } else {
    $mmkzip = "Make a new $File.zip?";
  }
?>
<div class="fmk-scroll">
<table id="fmk-ls-table">

<tr>
<th> <h3>Directory operation</h3> </th>
<td> <?php echo $File; ?> </td>
</tr>

<tr>
<th> Rename directory </th>
<td>
<div class="fmk-detail-btn">
<a href="javascript:void(0)" onclick="fmkprompt('<?php echo $mmove; ?>', '<?php echo $File; ?>', 'move')">&#x27A1; Move</a>
</div>
</td>
</tr>

<tr>
<th> Delete directory </th>
<td>
<div class="fmk-detail-btn">
<a href="javascript:void(0)" onclick="fmkconfirm('<?php echo $mdelete; ?>', '<?php echo $File; ?>', 'delete')">&#x1F6AE; Delete</a>
</div>
</td>
</tr>

<tr>
<th> Make a new file </th>
<td>
<div class="fmk-detail-btn">
<a href="javascript:void(0)" onclick="fmkprompt('Input new file name', '<?php echo $File; ?>', 'newfile')">&#x1F4DD; Make New File</a>
</div>
</td>
</tr>

<tr>
<th> Make a new directory </th>
<td>
<div class="fmk-detail-btn">
<a href="javascript:void(0)" onclick="fmkprompt('Input new directory name', '<?php echo $File; ?>', 'newdirectory')">&#x1F4C1; Make New directory</a>
</div>
</td>
</tr>

<tr>
<th> Upload a new file </th>
<td>
<form method="post" enctype="multipart/form-data">
<input type="file" name="upfile">
<input type="submit" name="upload" value="UPLOAD">
</form>
</td>
</tr>

<tr>
<th> Download from specified URL </th>
<td>
<div class="fmk-detail-btn">
<a href="javascript:void(0)" onclick="fmkprompt('Download from URL', '<?php echo $File; ?>', 'fromurl')">&#x1F4E5; Download from URL</a>
</div>
</td>
</tr>

<tr>
<th> Make a zip archive of this directory </th>
<td>
<div class="fmk-detail-btn">
<a href="javascript:void(0)" onclick="fmkconfirm('<?php echo $mmkzip; ?>', '<?php echo $File; ?>', 'mkzip')">&#x1F4C2; Make zip archive</a>
</div>
</td>
</tr>

</table>
</div>
<p>
<?php
  fmklist();
}

function fmklist() {
  global $RootDir;	// Document root directory
  global $WorkDir;	// Working directory
  global $Message;	// Output Message

  $files = array();			// Get filename under workdir
  if(is_dir($WorkDir)) {
    if($dh = opendir($WorkDir)) {
      while(($file = readdir($dh)) !== false){
        $files[] = $file;
      }
      closedir($dh);
    }
    sort($files);
  } else {
    $Message .= ' Not directory.';
    return;
  }
?>
<div class="fmk-scroll">
<table id="fmk-ls-table">
<tr>
<th> Name </th>
<th> Type </th>
<th> Size </th>
<th> Permission </th>
<th> Owner </th>
<th> Group </th>
<th> Date </th>
<th> MIME </th>
</tr>
<?php
  foreach($files as $file) {
    if($file == '..' && $WorkDir == $RootDir) continue;
    if($file == '.') {
      $filefl = $WorkDir;				// Current directory
    } else {
      $filefl = $WorkDir . '/' . $file;			// File full path
    }
    $fi = fmkfileinfo($filefl);				// Get file information
    if($fi == false) continue;				// Invalid file
    $fileau = $fi['fromroot'];			// File from document root
    $filety = $fi['type'];				// File type
    $filesz = $fi['size'];				// File size
    $filepm = $fi['permission'];			// File permission
    $fileow = $fi['owner'];				// File owner
    $filegp = $fi['group'];				// File group
    $filemt = $fi['modifytime'];			// File modified time
    $filemi = $fi['mime'];				// File MIME

    echo "<tr>";
    echo "<td>";
    if($file == '.') {
      echo "<a href=\"?f=$fileau&amp;c=dirop\">";
    } else {
      echo "<a href=\"?f=$fileau\">";
    }
    if(is_dir($filefl)) {
      echo " &nbsp; &#x1F4C1; &nbsp; $file &nbsp; ";
    } else {
      echo " &nbsp; $file &nbsp; ";
    }
    echo "</a>";
    echo "</td>";
    echo "<td> $filety </td>";
    echo "<td class=\"fmk-textright\"> $filesz </td>";
    echo "<td class=\"fmk-monospace\"> $filepm </td>";
    echo "<td> $fileow </td>";
    echo "<td> $filegp </td>";
    echo "<td> $filemt </td>";
    echo "<td> $filemi </td>";
    echo "</tr>\n";
  }

  echo "</table>\n";
  echo "</div>\n";
  echo "<p>\n";
}

function fmkdetail() {
  global $File;		// File or directory name
  global $RootDir;	// Document root directory
  global $WorkDir;	// Working directory
  global $WorkFile;	// Working filename

  $filefl = $WorkDir . '/' . $WorkFile;			// File full path
  $fi = fmkfileinfo($filefl);				// Get file information
  if($fi == false) {					// Invalid file
    echo " Can not get a file information : $WorkFile";
    return;
  }

  $fileau = $fi['fromroot'];			// File from document root
  $filety = $fi['type'];				// File type
  $filesz = $fi['size'];				// File size
  $filepm = $fi['permission'];				// File permission
  $fileow = $fi['owner'];				// File owner
  $filegp = $fi['group'];				// File group
  $fileat = $fi['accesstime'];				// File access date
  $filect = $fi['changetime'];				// File change date
  $filemt = $fi['modifytime'];				// File modified date
  $filemi = $fi['mime'];				// File MIME
  $fileif = $fi['info'];				// File info

  $fileup = dirname($fileau);				// Directory name
  $mcopy = "Copy $WorkFile ?";				// Copy dialog message
  $mmove = "Rename $WorkFile ?";			// Move dialog message
  $mdelete = "Delete $WorkFile ?";			// Delete dialog message
  $mtolf = "Replace all CR/LF, CR code to LF?" 		// To LF dialog message
?>
<div class="fmk-scroll">
<table id="fmk-detail-table">
<tr><th> Name </th>   <td> <?php echo $WorkFile; ?> </td></tr>
<tr><th> Type </th>   <td> <?php echo $filety; ?> </td></tr>
<tr><th> Size </th>   <td class="fmk-textright"> <?php echo $filesz; ?> </td></tr>
<tr><th> Permission </th> <td class="fmk-monospace"> <?php echo $filepm; ?> </td></tr>
<tr><th> Owner </th>         <td> <?php echo $fileow; ?> </td></tr>
<tr><th> Group </th>         <td> <?php echo $filegp; ?> </td></tr>
<tr><th> Access Time </th>   <td> <?php echo $fileat; ?> </td></tr>
<tr><th> Change Time </th>   <td> <?php echo $filect; ?> </td></tr>
<tr><th> Modified Time </th> <td> <?php echo $filemt; ?> </td></tr>
<tr><th> MIME </th>          <td> <?php echo $filemi; ?> </td></tr>
<tr><th> Information </th>   <td> <?php echo $fileif; ?> </td></tr>
</table>
</div>
<p>
<div class="fmk-detail-btns">
<div class="fmk-detail-btn">
<a href="?f=<?php echo $fileup; ?>">&#x1F4C1; Dir</a>
</div>
<div class="fmk-detail-btn">
<a href="?c=download&amp;f=<?php echo $File; ?>" download="<?php echo $WorkFile; ?>">&#x1F4E5; DL</a>
</div>
<div class="fmk-detail-btn">
<a href="javascript:void(0)" onclick="fmkprompt('<?php echo $mcopy; ?>', '<?php echo $File; ?>', 'copy')">&#x1F46C; CP</a>
</div>
<div class="fmk-detail-btn">
<a href="javascript:void(0)" onclick="fmkprompt('<?php echo $mmove; ?>', '<?php echo $File; ?>', 'move')">&#x27A1; MV</a>
</div>
<div class="fmk-detail-btn">
<a href="javascript:void(0)" onclick="fmkconfirm('<?php echo $mdelete; ?>', '<?php echo $File; ?>', 'delete')">&#x1F6AE; RM</a>
</div>
</div>
<p>
<?php
  if(strpos($filemi, 'text/') === 0 || $filesz == 0) {	// Show text data
    echo "<div class=\"fmk-detail-btns\">";
    echo "<div class=\"fmk-detail-btn\">";		// Edit button
    echo "<a href=\"?c=edit&amp;f=$File\">&#x1F4D6; Edit</a>";
    echo "</div>\n";
//    echo "<div class=\"fmk-detail-btn\">";		// TinyMCE button
//    echo "<a href=\"?c=tinymce&amp;f=$File\">&#x1F4D6; TinyMCE</a>";
//    echo "</div>\n";
//    echo "<div class=\"fmk-detail-btn\">";		// CKEdit button
//    echo "<a href=\"?c=ckeditor&amp;f=$File\">&#x1F4D6; CKEditor</a>";
//    echo "</div>\n";
    echo "<div class=\"fmk-detail-btn\">";		// CodeMirror button
    echo "<a href=\"?c=codemirror&amp;f=$File\">&#x1F4D6; CodeMirror</a>";
    echo "</div>\n";
    echo "<div class=\"fmk-detail-btn\">";		// LF button
    echo "<a href=\"javascript:void(0)\" onclick=\"fmkconfirm('$mtolf', '$File', 'tolf')\">&#x21A9; To LF</a>";
    echo "</div>\n";
    echo "</div>\n";					// fmk-detail-btns
    echo "<p>\n";
    echo "<pre id=\"fmk-showtext\">\n";
    $cont = file_get_contents($filefl);
    if($cont !== false) {
      echo htmlspecialchars($cont);
    } else {
      echo "failed to open stream";
    }
    echo "\n</pre>\n";
  }
  if(strpos($filemi, 'application/zip') === 0) {	// Show zip data
    echo "<div class=\"fmk-detail-btns\">";
    echo "<div class=\"fmk-detail-btn\">";		// Unzip button
    $mes = "Unzip $WorkFile ?";
    echo "<a href=\"javascript:void(0)\" onclick=\"fmkconfirm('$mes', '$File', 'unzip')\">&#x1F4C2; Unzip</a>";
    echo "</div>";
    echo "</div>\n";					// fmk-detail-btns
  }
  if(strpos($filemi, 'image/') === 0) {			// Show image data
    echo '<div id="fmk-showimg">';
    echo "<img width=\"100%\" height=\"100%\" src=\"data:$filemi;base64,";
    $cont = file_get_contents($filefl);
    if($cont !== false) {
      echo base64_encode($cont);
    } else {
      echo "failed to open stream";
    }
    echo "\"></div>\n";
  }
  echo "<p>\n";
}

function fmkedit() {
  global $File;		// File or directory name
  global $Command;	// Command
  global $RootDir;	// Document root directory
  global $WorkDir;	// Working directory
  global $WorkFile;	// Working filename

  $filefl = $WorkDir . '/' . $WorkFile;			// File full path
  $fi = fmkfileinfo($filefl);				// Get file information
  if($fi == false) return;				// Invalide file
  $filesz = $fi['size'];				// File size
  $filemi = $fi['mime'];				// File MIME

  if(strpos($filemi, 'text/') === 0 || $filesz == 0) {	// Show text data
    $cont = file_get_contents($filefl);
    if($cont !== false) {
      $cont = htmlspecialchars($cont);
    } else {
      $cont = 'failed to open stream';
    }
?>
    <form method="post" id="fmk-editform">
    <div class="fmk-detail-btns">
    Edit : <?php echo $WorkFile; ?> &nbsp; 
    <input type="button" value="&#x25FC; Cancel" onClick="location.href='?c=cancel&amp;f=<?php echo $File ?>'" />
    <input type="submit" value="&#x1F4BE; Save" />
    </div>
    <textarea id="fmk-edittext" name="fmk-editarea"><?php echo $cont; ?></textarea>
    </form>
<?php
    if($Command == 'tinymce') {				// For TinyMCE
?>
      <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
      <script>tinymce.init({ selector:'textarea' });</script>
<?php
    }
    if($Command == 'ckeditor') {			// For CKEditor
?>
      <script src="https://cdn.ckeditor.com/ckeditor5/10.1.0/classic/ckeditor.js"></script>
      <script>
        ClassicEditor
          .create( document.querySelector( '#fmk-edittext' ) )
          .catch( error => {
            console.error( error );
          } );
      </script>
<?php
    }
    if($Command == 'codemirror') {			// For CodeMirror
?>
      <link rel="stylesheet" href="codemirror/lib/codemirror.css">
      <link rel="stylesheet" href="codemirror/theme/blackboard.css">
      <script src="codemirror/lib/codemirror.js"></script>
      <script src="codemirror/mode/css/css.js"></script>
      <script src="codemirror/mode/xml/xml.js"></script>
      <script src="codemirror/mode/javascript/javascript.js"></script>
      <script src="codemirror/mode/htmlmixed/htmlmixed.js"></script>
      <script src="codemirror/mode/clike/clike.js"></script>
      <script src="codemirror/mode/php/php.js"></script>
      <script>
        var editor = CodeMirror.fromTextArea(document.getElementById("fmk-edittext"), {
//          mode: "htmlmixed",
          mode: "application/x-httpd-php",
          theme: "blackboard",
          tabSize: 4,
          lineNumbers: true
        });
        editor.setSize("100%", "100%");
      </script>
<?php
    }
  }
}
?>
