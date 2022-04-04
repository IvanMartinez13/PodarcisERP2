import axios from "axios";
import React from "react";


class StrategyEvolution extends React.Component{

    constructor(props){
        super(props);

        this.strategy = this.props.strategy;

        this.state = {loading: true};

        this.dataSets = [];
        this.years = [];

        this.targetValue='';
    }

    render(){
        if (this.state.loading) {
            return(
                <div>
                    <div className="spiner-example">
                        <div className="sk-spinner sk-spinner-double-bounce">
                            <div className="sk-double-bounce1"></div>
                            <div className="sk-double-bounce2"></div>
                        </div>
                    </div>
                    <p className="mt-3 text-center"> Cargando... </p>       
                </div>
            )
        }
        return(
            <canvas id={"strategy_evolution"+this.strategy.token} className="animated fadeIn" height={200}></canvas>
        )
    }

    componentDidMount()
    {
        axios.post('/ods/strategy/evolution_chart', {token: this.strategy.token}).then( (response) => {

            let evaluations = response.data.evaluations;
            let years = response.data.years;

            let targetValue = response.data.targetValue ;
            var data = [];
    
            years.map( (year) => {

                let suma = 0;
                evaluations[year].map( (evaluation) => {
                    suma += Number(evaluation.value);
                    
                } )
                
                data.push(suma);

            } )
    
            this.dataSets = data;
            this.years = years;
            this.targetValue = targetValue ;

            $("#strategy_target_value"+this.strategy.token).text(this.formatValue(targetValue.toFixed(3))+' '+this.strategy.indicator)

            this.setState({loading: false})

        } ).then( () => {

            if ( typeof this.targetValue == 'number') {

                let ctx = document.getElementById('strategy_evolution'+this.strategy.token).getContext('2d');

                const config = {
                    type: 'line',
                    
                    data:{
                        labels: this.years,
                        
                        datasets: [{
                            label: this.strategy.indicator,
                            data: this.dataSets,
                            fill: false,
                            borderColor: '#1AB394',
                            backgroundColor: '#1AB394',
                            tension: 0.2,
                            
                        }],
                    },
    
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        },

                        "horizontalLine": [{
                            y: this.targetValue,
                            style: "#ed5565",
                            text: 'Valor objetivo ' + this.formatValue(this.targetValue.toFixed(3)),
                            
                        }],
                
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
    
                        scales: {
                            yAxes:[{
    
    
                                ticks: {
                                    beginAtZero: true
                                },
                               
                            }]
                        }
    
                    }
                }

                this.chart = new Chart(ctx, config);

                var horizonalLinePlugin = {
                    afterDraw: function(chartInstance) {
                      var yScale = chartInstance.scales["y-axis-0"];
                      var xAxis = chartInstance.scales["x-axis-0"];
                      var canvas = chartInstance.chart;
                      var ctx = canvas.ctx;
                      var index;
                      var line;
                      var style;
                      if (chartInstance.options.horizontalLine) {
                        for (index = 0; index < chartInstance.options.horizontalLine.length; index++) {
                          line = chartInstance.options.horizontalLine[index];
                          if (!line.style) {
                            style = "#ed5565";
                          } else {
                            style = line.style;
                          }
                          if (line.y) {
                            var yValue = yScale.getPixelForValue(line.y);
                          } else {
                            var yValue = 0;
                          }
                          ctx.lineWidth = 3;
                          if (yValue) {
                            ctx.beginPath();
                            ctx.moveTo(0, yValue);
                            ctx.moveTo(chartInstance.chartArea.left, yValue);
                            ctx.lineTo(chartInstance.chartArea.right, yValue);
                            ctx.strokeStyle = style;
                            ctx.stroke();
                          }
                          if (line.text) {
                            ctx.fillStyle = style;
                            ctx.fillText(line.text, 50, yValue+5 + ctx.lineWidth);
                          }
                        }
                        return;
                      };
                    }
                  };
    
                Chart.pluginService.register(horizonalLinePlugin);

            }else{
                let ctx = document.getElementById('strategy_evolution'+this.strategy.token).getContext('2d');

                const config = {
                    type: 'line',
                    
                    data:{
                        labels: this.years,
                        
                        datasets: [{
                            label: this.strategy.indicator,
                            data: this.dataSets,
                            fill: false,
                            borderColor: '#1AB394',
                            backgroundColor: '#1AB394',
                            tension: 0.2,
                            
                        }],
                    },
    
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        },
                
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
    
                        scales: {
                            yAxes:[{
    
    
                                ticks: {
                                    beginAtZero: true
                                },
                               
                            }]
                        }
    
                    }
                }

                this.chart = new Chart(ctx, config);
            }
            
            
        


            

            
            


        } );
    }

    formatValue(number){
        let value = number
        value = value.replace('.', ',');
        return value;
        
    }
}

export default StrategyEvolution;