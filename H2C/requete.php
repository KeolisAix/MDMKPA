<?php
###                  ###
#    Prérequis         #
###                  ###
include('config.php');
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

###                  ###
#    Definition JOB    #
###                  ###

$Job = $_GET["Job"];
$Demandeur = $_GET["mail"];
$DateNow = date("d/m/Y");
$HeureNow = date("H:i:s");
$Mail = $_GET["mail"];
$base = "test";
###                  ###
#      IMPORTATION     #
###                  ###
exec('cmd.exe /c calc.exe');
if($Job == "Import"){
    $DateDebut = $_GET["ImportDateDebut"];
    $DateFin = $_GET["ImportDateFin"];
    $dateFormatDebut = str_replace('/', '-', $DateDebut);
    $dateAnnonceDebut = date('Y-m-d', strtotime($dateFormatDebut));
    $dateFormatFin = str_replace('/', '-', $DateFin);
    $dateAnnonceFin = date('Y-m-d', strtotime($dateFormatFin));
    $dureeSejour = (strtotime($dateAnnonceFin) - strtotime($dateAnnonceDebut)) /86400;
    if($_GET["PurgeOui"]){ $Purge = "1"; } else { $Purge = "0";}
    AddLogs($ChouetteLogsPath, $Job.";".$base.";".$DateNow.";".$HeureNow.";".$DateDebut.";".$DateFin.";".$Purge.";".$Demandeur);
    $DateSplit = explode('/', $DateDebut);
    //echo $Mail;
    $testt = 'cmd.exe /c "C:\H2C\Import\Hastus2Chouette_Import\Hastus2Chouette_Import_run.bat" --context_param purge='.$Purge.' --context_param datedebut='.$DateSplit[2].$DateSplit[1].$DateSplit[0].' --context_param base='.$base.' --context_param jours='.$dureeSejour.' --context_param mail='.$Mail;    
    echo $testt;
    exec('cmd.exe /c calc.exe');
    //exec('cmd.exe /c "C:\H2C\Import\Hastus2Chouette_Import\Hastus2Chouette_Import_run.bat" --context_param purge='.$Purge.' --context_param datedebut='.$DateSplit[2].$DateSplit[1].$DateSplit[0].' --context_param base='.$base.' --context_param jours='.$dureeSejour.' --context_param mail='.$Mail);
}

###                  ###
#      EXPORTATION     #
###                  ###

if($Job == "Export"){
    $ExportFormat = $_GET["ExportFormat"];
    $ExportName = $_GET["ExportName"];
    $ExportBase = $_GET["ExportBase"];
    AddLogs($ChouetteLogsPath, $Job.";;".$DateNow.";".$HeureNow.";".$ExportFormat.";".$ExportName.";".$ExportBase.";".$Demandeur);
    exec("C:\Windows\System32\calc.exe");
}

###                  ###
#     MISE EN PROD     #
###                  ###

if($Job == "MEP"){
    AddLogs($ChouetteLogsPath, $Job.";;".$DateNow.";".$HeureNow.";;;;".$Demandeur);
    exec("C:\Windows\System32\calc.exe");
}
###                  ###
#    Definition Logs   #
###                  ###

function AddLogs($Path, $texte){
    $fp=fopen($Path, "a+");
    fwrite($fp, $texte."\r\n"); 
}


?>
