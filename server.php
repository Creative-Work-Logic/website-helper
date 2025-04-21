<?php
/*
require_once('vendor/autoload.php');

use SshWrapper\SshCore;
use ServerInfo\ServerCore;
//ssh i5ubuntu

$ssh = new SshCore('192.168.1.1');
$ssh->authUser = 'root';
$ssh->port = 22;
$ssh->connect();
/*
$server = new ServerCore($ssh);

$hostname = $server->getHostname();

$php      = $server->getPHPServiceName();

$data     = $server->getVhosts();     
*/
require_once('vendor/autoload.php');
use danielme85\Server\Info;

$info = new Info();

$cpuinfo = Info::get()->cpuInfo();
$filteredCpuInfo = Info::get()->cpuInfo($core = null, ['processor', 'model_name', 'cpu_mhz', 'cache_size']);
$cpuLoad = Info::get()->cpuLoad($sampleSec = 1, $rounding = 2);
$memoryUsage = Info::get()->memoryUsage();
$memoryLoad = Info::get()->memoryLoad();
$volumes = Info::get()->volumesInfo();
$allprocs = Info::get()->processes();
$filteredprocs = Info::get()->processes(['name', 'state', 'pid', 'ppid', 'vmpeak', 'vmsize', 'threads'], 'status', true);
//$spesifficproc = Info::get()->process($pid);
$output=array($cpuinfo,$filteredCpuInfo,$cpuLoad,$memoryUsage,$memoryLoad,$volumes,$allprocs,$filteredprocs);
print_r($output);
/*
$filteredCpuInfo = Info::get()->cpuInfo($core = null, ['processor', 'model_name', 'cpu_mhz', 'cache_size']);
$cpuLoad = Info::get()->cpuLoad($sampleSec = 1, $rounding = 2);

$memoryUsage = Info::get()->memoryUsage();
$memoryLoad = Info::get()->memoryLoad();
$volumes = Info::get()->volumesInfo();
$allprocs = Info::get()->processes();
$filteredprocs = Info::get()->processes(['name', 'state', 'pid', 'ppid', 'vmpeak', 'vmsize', 'threads'], 'status', true);
$spesifficproc = Info::get()->process($pid);
//$uptime => Info::get()->uptime();

$output=array($cpuinfo,$filteredCpuInfo,$cpuLoad,$memoryUsage,$memoryLoad,$volumes,$allprocs,$filteredprocs,$spesifficproc);
print_r($output);
*/

/*
$cpuInfo = $info->cpuInfo();
$cpuUsage = $info->cpuLoad($sampleSec = 1, $rounding = 2);

print_r($cpuInfo);
print_r($cpuUsage);
*/
//phpinfo();