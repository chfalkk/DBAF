$(() => {
    $("#dbaf-fahrplan-form").dxForm({
        formData: {
            abfahrtsbahnhof: "eee",
            abfahrtsdatum: new Date(Date.now()),
        },
        colCount: 1,
        items: [{
            itemType: "group",
            caption: "Fahrplan-Suche",
            colCount: 1,
            items: [{
                dataField: "abfahrtsbahnhof",
                isRequired: "true"
            }, {
                dataField: "abfahrtsdatum",
                isRequired: "true", 
            }]
        }, {
            itemType: "button",
            horizontalAlignment: "left",
            buttonOptions: {
                text: "Verbindungen suchen",
                icon: "fa-solid fa-paper-plane",
                useSubmitBehavior: true
            }
        }]
    });
 
    $("#form-container").on("submit", function(e) {
        setTimeout(function () { 
            alert("Submitted");          
        }, 1000);
 
        e.preventDefault();
    });

});
