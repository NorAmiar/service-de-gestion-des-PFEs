$(document).ready(function(){
    var ctx = $("#myChart");
    var data = {
        labels : ["Proposer des sujets","Non N'ont pas proposer"],
        datasets : [
            {
                
            label : "",
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
        labels : ["Proposer License","Proposer Master"],
        datasets : [
            {
                
            label : "",
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
  

});