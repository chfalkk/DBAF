<?php
    require_once '../handler/db_fahrplan.php';
    require_once '../handler/db_stada.php';
    require '../ressources/iconRessources.php';

    class HeaderExtensions {
        /**
         * @return String Einen HTML-Codierten String um den API-Status darzustellen
         */
        public static function DisplayAPIStatus(){
            $StaDaStatus = DBAPI_StaDa::StaDaIsAvailable();
            $FahrplanAPIStatus = DBAPI_Fahrplan::FahrplanIsAvailable();


            $StaDaIcon = ($StaDaStatus) ? IconRessources::$APIAvailable : IconRessources::$APINotAvailable;
            $FahrplanStatusIcon = ($FahrplanAPIStatus) ? IconRessources::$APIAvailable : IconRessources::$APINotAvailable;

            $StaDaPillClass = ($StaDaStatus) ? "success" : "warning";
            $FahrplanPillClass = ($StaDaStatus) ? "success" : "warning";

            $PillDescription = " In diesem Element sehen Sie den Status der Bahn-API. \n
            ROT bedeutet, dass die API nicht erreichbar ist. Dementsprechend können einige Kernfunktionalitäten der Anwendung nicht benutzt werden!\n
            GRÜN bedeutet, dass die API erreichbar ist. Alle Funktionalitäten können wie erwartet benutzt werden.";


            
        $res = "<span class=\"d-inline-block\" tabindex=\"0\" data-toggle=\"tooltip\" title=\"Disabled tooltip\">
                        <button class=\"badge badge-pill badge-".$StaDaPillClass."\" style=\"pointer-events: none;\" type=\"button\" disabled>".$StaDaIcon . $PillDescription."</button>
                    </span>";
        $res .= "<span class=\"d-inline-block\" tabindex=\"0\" data-toggle=\"tooltip\" title=\"Disabled tooltip\">
                        <button class=\"badge badge-pill badge-".$FahrplanPillClass."\" style=\"pointer-events: none;\" type=\"button\" disabled>".$FahrplanStatusIcon . $PillDescription."</button>
                    </span>";

            
        }

    }
