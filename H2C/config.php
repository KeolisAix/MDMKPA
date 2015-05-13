<?php
    ####                                              ####
    ##                                                  ##
    #    FICHIER DE CONFIGURATION DE HASTUS2CHOUETTE     #
    ##                                                  ##
    ####                                              ####

###                  ###
#    Base de Donnée    #
###                  ###

$host = "192.168.207.22";
$port = "5432";
$BDDUser = "postgres";
$BDDPass = "postgres";
$Database = "authentification";


###                  ###
#    Chemins Jobs      #
###                  ###

$JobImportPath = "C:\H2C\Import\Hastus2Chouette_Import\Hastus2Chouette_Import_run.bat";
$JobExportPath = "C:\H2C\Export\Hastus2Chouette_Export\Hastus2Chouette_Export_run.bat";
$JobMEPPath = "C:\H2C\MEP\Hastus2Chouette_MEP\Hastus2Chouette_MEP_run.bat";

###                  ###
#    Chemins Logs      #
###                  ###

$HastusLogsPath = "";
$ChouetteLogsPath = "Logs/ChouetteLog.csv";
$CompteurJob = "Logs/CompteurJob.txt";
?>