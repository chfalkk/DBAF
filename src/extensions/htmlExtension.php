
<?php

class HTMLExtension {

   /**
     * @return HTML HTML-String welcher eine Fehlerbox mit gegebenen Inhalten darstellt
     * @param String $fehlerart (Standartwert="Datenbankfehler:") Gibt an, welche Markung die Fehlerbox haben soll
     * @param String $msg Gibt die Fehlernachricht an
     */
    public static function BuildErrorPanel($fehlerart, $msg) {
        echo '<div class="dbaf-panel dbaf-panel-err" id="dbaf-panel-err">
            <button class="close dbaf-panel-closer" data-toggle="collapse" data-target="#dbaf-panel-err" aria-expanded="false" aria-controls="collapseExample" aria-label="Panel schließen">
                <i class="fa-solid fa-xmark"></i>
            </button>
    
            <i class="fa-solid fa-skull"></i>
            <span><b>' . $fehlerart . ': </b>' . $msg. '</span>
        </div>';
    }

    /**
     * @return HTML HTML-String welcher eine Warnbox mit gegebenen Inhalten darstellt
     * @param String $inhalt Gibt die darzustellende Überschrift an
     */
    public static function BuildWarnPanel($inhalt) {
        echo '<div class="dbaf-panel dbaf-panel-wrn position-relative" id="dbaf-panel-wrn">

                <button class="close dbaf-panel-closer" data-toggle="collapse" data-target="#dbaf-panel-wrn" aria-expanded="false" aria-controls="collapseExample" aria-label="Panel schließen">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div>
                    <i class="fa-solid fa-circle-exclamation"></i>
                        '.$inhalt.'
                </div>
                </div>';
    }

    /**
     * @return HTML HTML-String welcher eine Successbox mit gegebenen Inhalten darstellt
     * @param String $inhalt Gibt die darzustellende Überschrift an
     */
    public static function BuildSuccessPanel($inhalt) {
        echo '<div class="dbaf-panel dbaf-panel-success" id="dbaf-panel-success">
                <button class="close dbaf-panel-closer" data-toggle="collapse" data-target="#dbaf-panel-success" aria-expanded="false" aria-controls="collapseExample" aria-label="Panel schließen">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <i class="fa-solid fa-square-check"></i>
                    '.$inhalt.'
                </div>';
    }

    /**
     * @return HTML HTML-String welcher eine Infobox mit gegebenen Inhalten darstellt
     * @param String $inhalt Gibt die darzustellende Überschrift an
     */
    public static function BuildInfoPanel($inhalt) {
        echo '<div class="dbaf-panel dbaf-panel-info" id="dbaf-panel-info">
                <button class="close dbaf-panel-closer" data-toggle="collapse" data-target="#dbaf-panel-wrn" aria-expanded="false" aria-controls="collapseExample" aria-label="Panel schließen">
                    <i class="fa-solid fa-xmark"></i>
                </button>
    
                <i class="fa-solid fa-circle-info"></i>
                    '.$inhalt.'
                </div>';
    }

    /**
     * @return HTML HTML-String welcher eine Headline mit gegebenen Inhalten darstellt
     * @param String $heading Gibt die darzustellende Überschrift an
     */
    public static function BuildSectionHeading($heading) {
        echo '<div class="h2 dbaf-heading">
                    '.$heading.'
                    <hr/>
                </div>';
    }


    /**
     * @return HTML HTML-String welcher eine Sub-Headline mit gegebenen Inhalten darstellt
     * @param String $heading Gibt die darzustellende Überschrift an
     */
    public static function BuildSubSectionHeading($heading) {
        echo '<div class="h5 dbaf-heading">
                    '.$heading.'
                    <hr/>
                </div>';
    }

    /**
     * Generelle Builder-Methode um die Panel-Builder zusammenzufassen
     * @param PanelType $panel Der Typ des Panels
     * @param String $message Die anzuzeigende Nachricht
     * @param ?String $fehlermessage Die Fehlernachricht die angezeigt werden soll
     */
    public static function BuildPanel(int|PanelType $panel, string $message, ?string $fehlermessage = null){

        $classString = "";
        $idString = "";
        $icon = "";
        $schliessenIcon = IconRessources::$Schliessen;
        $fehlernachricht = $fehlermessage ?? "Invalid Magic";

        switch ($panel) {
            case PanelType::Info:
                $classString = "dbaf-panel dbaf-panel-info";
                $idString = "dbaf-panel-info";
                $icon = IconRessources::$Information;
                break;
            case PanelType::Success:
                $classString = "dbaf-panel dbaf-panel-success";
                $idString = "dbaf-panel-success";
                $icon = IconRessources::$SuccessIcon;
                break;
            case PanelType::Warn:
                $classString = "dbaf-panel dbaf-panel-wrn";
                $idString = "dbaf-panel-wrn";
                $icon = IconRessources::$WarningIcon;
                break;
            case PanelType::Error:
                $classString = "dbaf-panel dbaf-panel-err";
                $idString = "dbaf-panel-err";
                $icon = IconRessources::$ErrorIcon;
                break;
            default:
                throw new Exception("Falscher Parameter für den Paneltype");
        }

        $res = "<div class=\"$classString\" id=\"$idString\">
                    <button class=\"close dbaf-panel-closer\" data-toggle=\"collapse\" data-target=\"#$idString\" aria-expanded=\"false\" aria-controls=\"collapseExample\" aria-label=\"Panel schließen\">
                        $schliessenIcon
                    </button>
                <div>";

        $res .= $icon;

        $msg = ($panel == (int) PanelType::Error) 
            ? "<span><b> $fehlernachricht: </b> $message </span>"
            : $message;
        
        $res .= $msg;
        $res .= "</div>";
        $res .= "</div>";

        echo $res;

    }
}


/**
 * Abstrakte Klasse für die Panel-Typen, da diese PHP-Version keine ENUMS unterstützt
 */
abstract class PanelType{
    const Info = 0;
    const Success = 1;
    const Warn = 2;
    const Error = 3;
} 
?>