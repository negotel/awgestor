(function($) {
    'use strict';
    $(function() {
      Chart.defaults.global.legend.labels.usePointStyle = true;
      
      if ($("#visit-sale-chart").length) {
        Chart.defaults.global.legend.labels.usePointStyle = true;
        var ctx = document.getElementById('visit-sale-chart').getContext("2d");
  
        var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeViolet.addColorStop(0, 'rgba(59, 118, 239)');
        gradientStrokeViolet.addColorStop(1, 'rgba(59, 118, 239)');
        var gradientLegendViolet = 'rgba(59, 118, 239)';
  
  
  
  
    function getSeven(){
        $.post("../control/control.financeiro.php", {dados: "seven_dias"},function(a){
          $("#value_chart_seven").val(a);
        });
        
    }
  
  getSeven();
  
  
   function createConfig_charts2() {
    
      var x = document.getElementById("value_chart_seven").value;
      var z = x.split('|');
      
      var w = z[0];
      var y = z[1];
      
      var valueData  = w.split(',');
      var valueLabel = y.split(',');
    

      return {
          type: 'bar',
          data: {
              labels: valueLabel,
              datasets: [
                {
                  label: "Ganhos",
                  borderColor: gradientStrokeViolet,
                  backgroundColor: gradientStrokeViolet,
                  hoverBackgroundColor: gradientStrokeViolet,
                  legendColor: gradientLegendViolet,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: valueData
                },
                // {
                //   label: "Expanse",
                //   borderColor: gradientStrokeBlue,
                //   backgroundColor: gradientStrokeBlue,
                //   hoverBackgroundColor: gradientStrokeBlue,
                //   legendColor: gradientLegendBlue,
                //   pointRadius: 0,
                //   fill: false,
                //   borderWidth: 2,
                //   fill: 'origin',
                //   data: [21, 45, 65, 75, 35, 56, 77, 44,22,13,43,49]
                // }
            ]
          },
          options: {
            responsive: true,
            legend: false,
            legendCallback: function(chart) {
              var text = []; 
              text.push('<ul>'); 
              for (var i = 0; i < chart.data.datasets.length; i++) { 
                  text.push('<li><span class="legend-dots" style="background:' + 
                             chart.data.datasets[i].legendColor + 
                             '"></span>'); 
                  if (chart.data.datasets[i].label) { 
                      text.push(chart.data.datasets[i].label); 
                  } 
                  text.push('</li>'); 
              } 
              text.push('</ul>'); 
              return text.join('');
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(235,237,242,1)',
                        zeroLineColor: 'rgba(235,237,242,1)'
                      }
                }],
                xAxes: [{
                    // Change here
                    barPercentage: 0.6
                }]
            }
            },
            elements: {
              point: {
                radius: 0
              }
            }
        };
    }
  
  
  
    setTimeout(function(){
         var config = createConfig_charts2();
         var myChart = new Chart(ctx, config)
         $("#visit-sale-chart").html(myChart.generateLegend());
    },2000);
    
    
    
      }
    });
    
  })(jQuery);

  