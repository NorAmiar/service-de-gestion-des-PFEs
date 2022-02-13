$(document).ready(function(){
    var ctx = $("#myChart");
    var data = {
        labels : ["Validé","Non validé"],
        datasets : [
            {
                
            label : "%",
            data : x,
            backgroundColor : [
                "#1E3D59 ",
                "#DC2166"
            ],
            borderColor : [
                "rgba(150,20,30,1)",
                "rgba(150,20,30,1)"
            ],
            borderWidth: 1
        }
    ]
    };
    var chart  = new Chart(ctx,{
        type: "doughnut",
        data : data,
        options : {
            title: {
                display: true,
                text: 'Etat de validation de sujets'
            }
        }
    });
    var ctx = $("#myChart2");
    var data = {
        labels : ["Affecté","Non Affecté"],
        datasets : [
            {
                
            label : "%",
            data : y,
            backgroundColor : [
                "#1E3D59 ",
                "#DC2166"
            ],
            borderColor : [
                "rgba(150,20,30,1)",
                "rgba(150,20,30,1)"
            ],
            borderWidth: 1
        }
    ]
    };
    var chart  = new Chart(ctx,{
        type: "doughnut",
        data : data,
        options : {
            title: {
                display: true,
                text: 'Etat de choix de sujets'
            },
            
        }
    });
    var ctx = $("#myChart3");
    var data = {
        labels : ["License","Master"],
        datasets : [
            {
                
            label : "",
            data : z,
            backgroundColor : [
                "#1E3D59 ",
                "#DC2166"
            ],
            borderColor : [
                "rgba(150,20,30,1)",
                "rgba(150,20,30,1)"
            ],
            borderWidth: 1
        }
    ]
    };
    var chart  = new Chart(ctx,{
        type: "doughnut",
        data : data,
        options : {
            title: {
                display: true,
                text: 'Niveau de sujets'
            },
            
        }
    });
});