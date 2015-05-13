<?php
    ####                                              ####
    ##                                                  ##
    #    FICHIER DE CONFIGURATION DE HASTUS2CHOUETTE     #
    ##                                                  ##
    ####                                              ####

###                  ###
#    Base de Donnée    #
###                  ###

$host = "";
$port = "";
$BDDUser = "";
$BDDPass = "";
$Database = "";

###                  ###
#    Schema Bases      #
###                  ###

$BDDproduction = "";
$BDDpreprod = "";
$BDDtest = "";

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