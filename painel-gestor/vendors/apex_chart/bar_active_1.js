
function getMeses(){
    $.post("../control/control.financeiro.php", {dados: "mes_a_mes"},function(a){
      $("#data_bar_active").val(a);
    });
    
    $.post("../control/control.financeiro.php", {dados: "mes_a_mes_gastos"},function(a){
      $("#data_bar_active2").val(a);
    });
    
    
}
window.onload = function() {
    getMeses();
}

 function createConfig_charts2() {
    
      var x = document.getElementById("data_bar_active").value;
      var z = x.split(',');
      
      var l = document.getElementById("data_bar_active2").value;
      var w = l.split(',');
    
        return {
                colors : ['#A66DD4', '#3B76EF'],
                series: [{
                name: 'Ganhos',
                type: 'column',
                data: z
              }, {
                name: 'Gastos',
                type: 'line',
                data: w
              }],
                chart: {
                height: 265,
                type: 'line',
                toolbar: {
                    show: false
                  }
              },
            
              stroke: {
                width: [0, 4]
              },
              dataLabels: {
                enabled: false,
                enabledOnSeries: [1]
              },
              legend: {
                show: false
              },
              labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
              xaxis: {
                type: ''
              },
              yaxis: [{
                title: {
                  // text: 'Mês',
                },
              
              }, {
                opposite: true,
                title: {
                 //  text: 'Ano'
                }
              }]
          };
    }
    
  
  setTimeout(function(){
      var config = createConfig_charts2();
      var chart = new ApexCharts(document.querySelector("#bar_active"), config);
      chart.render();
  },2000);