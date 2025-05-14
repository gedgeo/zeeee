function afficherPopulationParRegion2012()
{
    $.getJSON('../Controleurs/controleur.php', 
	{ 'commande': 'getPopRegions2012' 
	})
            .done(function (donnees, stat, xhr) {
               
                const chart = Highcharts.chart('containerReg2012', {
                    chart: {
                        type: 'pie'//'column'  // bar, line, spline
                    },
                    title: {
                        text: 'population par regions 2012 '
                    },                   
                    series: [{
                            data : donnees
                        }]
                });
            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));               
            });
}
$(document).ready(function () {
    $("#popReg2012").click( afficherPopulationParRegion2012);
});