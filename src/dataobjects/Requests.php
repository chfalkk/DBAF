<?php

/**
 * Request-Objekt um Parameter zu bündeln und Arbeit mit Requests zu vereinfachen
 */
abstract class RequestBase{
    protected string $Method;
}

/**
 * Request-Objekt um Parameter zu bündeln und Arbeit mit Requests zu vereinfachen
 */
class FahrplanRequest extends RequestBase{
    
    public string $abfahrtsbahnhof;
    public ?string $ankunftsbahnhof;
    public string $abfahrtsdatum;
    public ?string $ankunftsdatum;
    public bool $isOnlyAbfahrt;

    function __construct(string $method,
        string $abBahnhof, 
        ?string $anBahnhof = null, 
        string $abDatum, 
        ?string $anDatum = null, 
        bool $onlyAb)
    {
        $this->Method = $method;
        $this->abfahrtsbahnhof = $abBahnhof;
        $this->ankunftsbahnhof = $anBahnhof;
        $this->abfahrtsdatum = $abDatum;
        $this->ankunftsdatum = $anDatum;
        $this->isOnlyAbfahrt = $onlyAb;
    }

    /**
    * @param FahrplanRequest $request Die Post-Parameter
    */
    public function HandleRequest(){
            
        // Display ERROR-BOX wenn API nicht erreichbar
        if(!DBAPI_Fahrplan::FahrplanIsAvailable()){
            return HTMLExtension::BuildPanel(PanelType::Error, "Die Fahrplan-API ist zur Zeit nicht erreichbar");
        }

        //TODO: Handling wenn API online

    }

}