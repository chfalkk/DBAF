<?php
    require '../handler/db_apiquery.php';
    require '../ressources/IconRessources.php';


    class HeaderExtensions{

        /**
         * 
         */
        public static function DisplayAPIStatus(){
            $StaDaStatus = DBAPI_StaDa::StaDaIsAvailable();
            $FahrplanAPIStatus = DBAPI_Fahrplan::FahrplanIsAvailable();


            $StaDaIcon = ($StaDaStatus) ? IconRessources::$APIAvailable : IconRessources::$APINotAvailable;
            $FahrplanStatusIcon = ($FahrplanAPIStatus) ? IconRessources::$APIAvailable : IconRessources::$APINotAvailable;
        }

    }
