function getPorcentagem(){
    $.post("../control/control.dados_num_clientes.php",function(a){
      $("#data_chart_porcentagem").val(a);
    });
}

  getPorcentagem();



 function options_p_1(){
     
     var x = document.getElementById("data_chart_porcentagem").value;
     var z = x.split('|');
     
    return {
          chart: {
            height: 200,
            type: "radialBar",
          },
        
          series: [z[0]],
          colors: ["#6DD4B1"],
          plotOptions: {
            radialBar: {
              hollow: {
                margin: 0,
                size: "55%",
              },
              track: {
                dropShadow: {
                  enabled: false,
                  top: 0,
                  left: 0,
                  opacity: 0.15
                }
              },
              style: {
                fontSize: '14px',
                fontFamily: "'Muli', sans-serif",
                fontWeight: '700',
                colors: '#000'
            },
              dataLabels: {
                name: {
                  offsetY: 18,
                  color: "#A3A5AD",
                  fontSize: "13px",
                  fontWeight: 700,
                  fontFamily: "'Muli', sans-serif",
                },
                value: {
                  offsetY: -18,
                  color: "#4D4F5C",
                  fontSize: "21px",
                  fontWeight: 900,
                  show: true,
                  fontFamily: "'Muli', sans-serif",
                }
              }
            }
          },
          fill: {
            type: "gradient",
            gradient: {
              shade: "dark",
              type: "vertical",
              gradientToColors: ["#4D71EC"],
              stops: [0, 100]
            }
          },
          stroke: {
            lineCap: "round"
          },
          labels: ["Inadimplentes"]
        }; 
 }


 function options_p_2(){
     
     var x = document.getElementById("data_chart_porcentagem").value;
     var z = x.split('|');
     
    return {
        chart: {
          height: 200,
          type: "radialBar",
        },
      
        series: [z[1]],
        colors: ["#6DD4B1"],
        plotOptions: {
          radialBar: {
            hollow: {
              margin: 0,
              size: "55%",
            },
            track: {
              dropShadow: {
                enabled: false,
                top: 0,
                left: 0,
                opacity: 0.15
              }
            },
            style: {
              fontSize: '14px',
              fontFamily: "'Muli', sans-serif",
              fontWeight: '700',
              colors: '#000'
          },
          dataLabels: {
            name: {
              offsetY: 18,
              color: "#A3A5AD",
              fontSize: "13px",
              fontWeight: 700,
              fontFamily: "'Muli', sans-serif",
            },
            value: {
              offsetY: -18,
              color: "#4D4F5C",
              fontSize: "21px",
              fontWeight: 900,
              show: true,
              fontFamily: "'Muli', sans-serif",
            }
          }
          }
        },
        fill: {
          type: "gradient",
          gradient: {
            shade: "dark",
            type: "vertical",
            gradientToColors: ["#4D71EC"],
            stops: [0, 100]
          }
        },
        stroke: {
          lineCap: "round"
        },
        labels: ["Ativos"]
      };
  
 }



  setTimeout(function(){
      
      var config = options_p_1();
      var chart = new ApexCharts(document.querySelector("#radial_1"), config);
      chart.render();
      
      var config2 = options_p_2();
      var chart = new ApexCharts(document.querySelector("#radial_2"), config2);
        chart.render();
      
  },2000);



