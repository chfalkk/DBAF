<?php
    require_once './handler/db_fahrplan.php';
    require_once './handler/db_stada.php';
    require './ressources/iconRessources.php';

    class HeaderExtensions {
        /**
         * @return String Einen HTML-Codierten String um den API-Status darzustellen
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

            $FahrplanAPIErreichbarText = ($FahrplanAPIStatus) ? "Die Fahrplan-API ist erreichbar" : "Die Fahrplan-API ist nicht erreichbar";
            $StaDaErreichbarText = ($StaDaStatus) ? "Die StaDa-API ist erreichbar" : "Die StaDa-API ist nicht erreichbar";


            $reddot = "<span class=\"badge badge-pill dbaf-err-dot\">".IconRessources::$APINotAvailable."</span>";
            $greendot = "<span class=\"badge badge-pill dbaf-suc-dot\">".IconRessources::$APIAvailable."</span>";

            $FahrplanDot = ($FahrplanAPIStatus) ? $greendot : $reddot;
            $StaDaDot = ($StaDaStatus) ? $greendot : $reddot;

            $res = '<div class="dropdown dropleft">
                        <button class="btn btn-dbaf dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            API-Stati
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item disabled" href="#" data-toggle="tooltip" data-placement="left">'.$FahrplanDot." ".$FahrplanAPIErreichbarText.'</a>
                        <a class="dropdown-item disabled" href="#" data-toggle="tooltip" data-placement="left">'.$StaDaDot." ".$StaDaErreichbarText.'</a>
                        <div class="dropdown-divider"></div>
                            <a class="dropdown-item dbaf-hover-display">'.IconRessources::$Information.' Informationen zum API-Status</a>
                            <a class="dbaf-hide">
                            <p>In diesem Element sehen Sie den Status der Bahn-API.</p> 
                            <p>ROT bedeutet, dass die API nicht erreichbar ist. Dementsprechend können einige Kernfunktionalitäten der Anwendung nicht benutzt werden!</p>
                            <p>GRÜN bedeutet, dass die API erreichbar ist. Alle Funktionalitäten können wie erwartet benutzt werden.</p>
                            </a>
                        </div>
                    </div>';


            echo $res;
        }

    }
