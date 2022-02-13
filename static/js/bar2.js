$(document).ready(function(){

    var ctx = $("#myChart4");
    var data = {
        labels : ["Sans Compte","Avec Compte"],
        datasets : [
            {
                
            label : "",
            data : i,
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
                text: 'Etats des etudiants'
            },
            
        }
    });
    var ctx = $("#myChart5");
    var data = {
        labels : ["Sans Sujet","Avec Sujet"],
        datasets : [
            {
                
            label : "",
            data : f,
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
                text: "Etat d'affectation des étudiants"
            },
            
        }
    });
});