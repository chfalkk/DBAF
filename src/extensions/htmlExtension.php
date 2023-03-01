
<?php

class HTMLExtension {

     /**
     * Zeigt den HTML-String für eine Pill-Badge an.
     * @param String $content Der Inhalt der Badge
     * @return Void Zeigt die Badge an.
     */
    public static function BuildDisplayPill(string $content){
        echo "<span class=\"badge badge-secondary dbaf-pill-badge\">$content</span>";;
    }


    /**
     * Gibt den HTML-String für eine Pill-Badge zurück.
     * @param String $content Der Inhalt der Badge.
     * @return HTML Der HTML-String der Badge.
     */
    public static function DisplayPill(string $content){
        return "<span class=\"badge badge-secondary dbaf-pill-badge\">$content</span>";;
    }


    /**
     * Methode um die Breadcrumps relativ zur Startseite zu generieren
     */
    public static function BuildBreadcrumps(){

        $StartseitenURL = "index.php";
        $aktuelleURLArrayParts = explode("/",$_SERVER['SCRIPT_FILENAME']);
        $aktuelleSeite = ucfirst($aktuelleURLArrayParts[count($aktuelleURLArrayParts)-1]);

        $seite = explode(".",$aktuelleSeite)[0];

        $icon = IconRessources::$Home;


        echo "<nav aria-label=\"breadcrumb\">
                    <ol class=\"breadcrumb dbaf-breadcrump\">
                        <li class=\"breadcrumb-item\"><a href=\"$StartseitenURL\">$icon Startseite</a></li>
                        <li class=\"breadcrumb-item active\" aria-current=\"page\">$seite</li>
                    </ol>
                </nav>";
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
     * @return Void Zeigt das Panel an
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
            : " $message";
        
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