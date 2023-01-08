(function($) {
    'use strict';
    $(function() {
        
      chart1();
      chart2();
      chart3();
      chart4();
      
      // Chart 1
      
      function chart1() {
        Chart.defaults.global.legend.labels.usePointStyle = true;
        var ctx = document.getElementById('link1-sale-chart').getContext("2d");
  
        var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeViolet.addColorStop(0, '#7922ff');
        gradientStrokeViolet.addColorStop(1, '#7922ff');
        var gradientLegendViolet = '#7922ff';
  
  
           function createConfig_charts1_zap() {
            
              var x = document.getElementById("value_chart_link").value;
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
                          label: "Clicks",
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
                 var config = createConfig_charts1_zap();
                 var myChart = new Chart(ctx, config)
                 $("#link1-sale-chart").html(myChart.generateLegend());
            },1000);
            
    
    
      }
      
      
           
     function chart2(){
     
      Chart.defaults.global.legend.labels.usePointStyle = true;
      
      // chart 2
      
        var ctx = document.getElementById('link2-sale-chart').getContext("2d");
        var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeViolet.addColorStop(0, '#7922ff');
        gradientStrokeViolet.addColorStop(1, '#7922ff');
        var gradientLegendViolet = '#7922ff';
  

           function createConfig_charts2_zap() {
            
              var x = document.getElementById("value_chart_link2").value;
              var z = x.split('|');
              
              var w = z[0];
              var y = z[1];
              
              var valueData  = w.split(',');
              var valueLabel = y.split(',');
              
              console.log(valueData);
            
        
              return {
                  type: 'bar',
                  data: {
                      labels: valueLabel,
                      datasets: [
                        {
                          label: "Clicks",
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
                 var config2 = createConfig_charts2_zap();
                 var myChart2 = new Chart(ctx, config2)
                 $("#link2-sale-chart").html(myChart2.generateLegend());
            },1000);
            
    
    }
   
      
   function chart3(){
     
      Chart.defaults.global.legend.labels.usePointStyle = true;
      
      // chart 2
      
        var ctx = document.getElementById('link3-sale-chart').getContext("2d");
        var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeViolet.addColorStop(0, '#7922ff');
        gradientStrokeViolet.addColorStop(1, '#7922ff');
        var gradientLegendViolet = '#7922ff';
  

           function createConfig_charts3_zap() {
            
              var x = document.getElementById("value_chart_link3").value;
              var z = x.split('|');
              
              var w = z[0];
              var y = z[1];
              
              var valueData  = w.split(',');
              var valueLabel = y.split(',');
              
              console.log(valueData);
            
        
              return {
                  type: 'bar',
                  data: {
                      labels: valueLabel,
                      datasets: [
                        {
                          label: "Clicks",
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
                 var config3 = createConfig_charts3_zap();
                 var myChart3 = new Chart(ctx, config3)
                 $("#link3-sale-chart").html(myChart3.generateLegend());
            },1000);
            
    
    }
    
    
    
     function chart4(){
     
      Chart.defaults.global.legend.labels.usePointStyle = true;
      
      // chart 2
      
        var ctx = document.getElementById('link4-sale-chart').getContext("2d");
        var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeViolet.addColorStop(0, '#7922ff');
        gradientStrokeViolet.addColorStop(1, '#7922ff');
        var gradientLegendViolet = '#7922ff';
  

           function createConfig_charts4_zap() {
            
              var x = document.getElementById("value_chart_link4").value;
              var z = x.split('|');
              
              var w = z[0];
              var y = z[1];
              
              var valueData  = w.split(',');
              var valueLabel = y.split(',');
              
              console.log(valueData);
            
        
              return {
                  type: 'bar',
                  data: {
                      labels: valueLabel,
                      datasets: [
                        {
                          label: "Clicks",
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
                 var config4 = createConfig_charts4_zap();
                 var myChart4 = new Chart(ctx, config4)
                 $("#link4-sale-chart").html(myChart4.generateLegend());
            },1000);
            
    
    }
    
    
    });
    
  })(jQuery);

  