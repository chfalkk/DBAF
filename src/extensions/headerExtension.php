<?php
    require_once 'handler/db_fahrplan.php';
    require_once 'handler/db_stada.php';
    require 'ressources/iconRessources.php';

    /**
     * Klasse, um Header-Spezifische Daten anzeigen zu lassen
     */
    class HeaderExtension {
        /**
         * Funktion, um eine Status-Anzeige der API darzustellen
         * @return String HTML-Codierten String
         */
        public static function DisplayAPIStatus(){
            $StaDaStatus = DBAPI_StaDa::StaDaIsAvailable();
            $FahrplanAPIStatus = DBAPI_Fahrplan::FahrplanIsAvailable();

            $StaDaIcon = ($StaDaStatus) 
                ? IconRessources::$APIAvailable 
                : IconRessources::$APINotAvailable;

            $FahrplanStatusIcon = ($FahrplanAPIStatus) 
                ? IconRessources::$APIAvailable 
                : IconRessources::$APINotAvailable;

            $FahrplanAPIErreichbarText = ($FahrplanAPIStatus)
                ? 'Die Fahrplan-API ist erreichbar - alle Funktionalitäten nutzbar'
                : 'Die Fahrplan-API ist nicht erreichbar - keine Funktionalität';
            
            $StaDaErreichbarText = ($StaDaStatus)
                ? 'Die StaDa-API ist erreichbar - alle Funktionalitäten nutzbar'
                : 'Die StaDa-API ist nicht erreichbar - keine Funktionalität';

            $reddot = '<span class=\'badge badge-pill dbaf-err-dot\'>' . IconRessources::$APINotAvailable . '</span>';
            $greendot = '<span class=\'badge badge-pill dbaf-suc-dot\'>' . IconRessources::$APIAvailable . '</span>';

            $FahrplanDot = ($FahrplanAPIStatus)
                ? $greendot
                : $reddot;

            $StaDaDot = ($StaDaStatus)
                ? $greendot
                : $reddot;

            $res = '<div class="dropdown dropleft">
                        <button class="btn btn-dbaf dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            API-Status
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item disabled" href="#" data-toggle="tooltip" data-placement="left">' . $FahrplanDot . ' ' .$FahrplanAPIErreichbarText . '</a>
                        <a class="dropdown-item disabled" href="#" data-toggle="tooltip" data-placement="left">' . $StaDaDot . ' ' . $StaDaErreichbarText . '</a>
                    </div>';

            echo $res;
        }

    }