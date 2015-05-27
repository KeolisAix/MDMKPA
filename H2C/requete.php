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
    $testt = 'cmd.exe /c '.$JobImportPath.' --context_param purge='.$Purge.' --context_param datedebut='.$DateSplit[2].$DateSplit[1].$DateSplit[0].' --context_param base='.$base.' --context_param jours='.$dureeSejour.' --context_param mail='.$Mail;    
    echo $testt;
    //exec('cmd.exe /c calc.exe');
    exec('cmd.exe /c '.$JobImportPath.' --context_param purge='.$Purge.' --context_param datedebut='.$DateSplit[2].$DateSplit[1].$DateSplit[0].' --context_param base='.$base.' --context_param jours='.$dureeSejour.' --context_param mail='.$Mail);
}

###                  ###
#      BILLETTIQUE     #
###                  ###
if($Job == "Bill"){
    $DateDebut = $_GET["BillDateDebut"];
    $DateFin = $_GET["BillDateFin"];
    $BillName = $_GET["BillName"];
    $dateFormatDebut = str_replace('/', '-', $DateDebut);
    $dateAnnonceDebut = date('Y-m-d', strtotime($dateFormatDebut));
    $dateFormatFin = str_replace('/', '-', $DateFin);
    $dateAnnonceFin = date('Y-m-d', strtotime($dateFormatFin));
    $dureeSejour = (strtotime($dateAnnonceFin) - strtotime($dateAnnonceDebut)) /86400;
    AddLogs($ChouetteLogsPath, $Job.";;".$DateNow.";".$HeureNow.";".$DateDebut.";".$DateFin.";;".$Demandeur);
    $DateSplit = explode('/', $DateDebut);
    $testt = 'cmd.exe /c '.$JobBillPath.' --context_param datedebut='.$DateSplit[2].$DateSplit[1].$DateSplit[0].' --context_param jours='.$dureeSejour.' --context_param fichier='.$BillName.' --context_param mail='.$Mail;    
    echo $testt;
    //exec('cmd.exe /c calc.exe');
    exec('cmd.exe /c '.$JobBillPath.' --context_param datedebut='.$DateSplit[2].$DateSplit[1].$DateSplit[0].' --context_param jours='.$dureeSejour.'  --context_param fichier='.$BillName.' --context_param mail='.$Mail);
}

###                  ###
#      EXPORTATION     #
###                  ###

if($Job == "Export"){
    $ExportFormat = $_GET["ExportFormat"];
    $ExportName = $_GET["ExportName"];
    $ExportBase = $_GET["ExportBase"];
    $cmd = 'cmd.exe /c '.$JobExportPath.' --context_param format='.$ExportFormat.' --context_param namezip='.$ExportName.' --context_param base='.$ExportBase.' --context_param mail='.$Mail;
    AddLogs($ChouetteLogsPath, $Job.";;".$DateNow.";".$HeureNow.";".$ExportFormat.";".$ExportName.";".$ExportBase.";".$Demandeur);
    $ExportLogs = fopen('./Logs/'.$ExportName.'.zip.txt', 'a+');
    fputs($ExportLogs, "###########################"."\r\n");
    fputs($ExportLogs, "####### EXPORT H2C ########"."\r\n");
    fputs($ExportLogs, "###########################"."\r\n");
    fputs($ExportLogs, ""."\r\n");
    fputs($ExportLogs, "Commande : ".$cmd."\r\n");
    fputs($ExportLogs, "Date : ".$DateNow."\r\n");
    fputs($ExportLogs, "Heure : ".$HeureNow."\r\n");
    fputs($ExportLogs, "Demandeur : ".$Mail."\r\n");
    fclose($ExportLogs);
    //exec("C:\Windows\System32\calc.exe");
    exec($cmd);
}

###                  ###
#     MISE EN PROD     #
###                  ###

if($Job == "MEP"){
    AddLogs($ChouetteLogsPath, $Job.";;".$DateNow.";".$HeureNow.";;;;".$Demandeur);
    $cmd = 'cmd.exe /c '.$JobMEPPath.' --context_param mail='.$Demandeur;
    exec($cmd);
}
###                  ###
#    Definition Logs   #
###                  ###

function AddLogs($Path, $texte){
    $fp=fopen($Path, "a+");
    fwrite($fp, $texte."\r\n"); 
    fclose($fp);
}


?>
