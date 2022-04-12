import axios from "axios";
import React from "react";

class IndicatorVariation extends React.Component {
    constructor(props) {
        super(props);

        this.state = { loading: true };

        this.objective = this.props.objective;

        this.dataSets = [];
        this.years = [];
        this.chart = {};

        this.target = 0;
    }

    render() {
        if (this.state.loading == true) {
            return (
                <div className="text-center">
                    <div className="spiner-example">
                        <div className="sk-spinner sk-spinner-double-bounce">
                            <div className="sk-double-bounce1"></div>
                            <div className="sk-double-bounce2"></div>
                        </div>
                    </div>

                    <p className="text-center">Cargando...</p>
                </div>
            );
        }

        return (
            <div className="text-center">
                <canvas id="indicator_variation" height={"200px"}></canvas>
            </div>
        );
    }

    componentDidMount() {
        axios
            .post("/ods/objective/variationChart", {
                token: this.objective.token,
            })
            .then((response) => {
                let years = response.data.years;
                let variation = response.data.variation;

                this.target = response.data.targetValue;

                if (typeof this.target == "number") {
                    $("#target_value").text(
                        this.formatValue(this.target.toFixed(3)) +
                            " " +
                            this.objective.indicator
                    );
                } else {
                    $("#target_value").text(this.target);
                }

                let data = [];

                years.map((year) => {
                    data.push(variation[year]);
                });

                this.years = years;
                this.dataSets = data;

                this.setState({ loading: false });
            })
            .then(() => {
                let ctx = document
                    .getElementById("indicator_variation")
                    .getContext("2d");

                if (typeof this.target == "number") {
                    const config = {
                        type: "line",

                        data: {
                            labels: this.years,

                            datasets: [
                                {
                                    label: this.objective.indicator,
                                    data: this.dataSets,
                                    fill: false,
                                    borderColor: "#1AB394",
                                    backgroundColor: "#1AB394",
                                    tension: 0.2,
                                },
                            ],
                        },

                        options: {
                            responsive: true,

                            interaction: {
                                mode: "index",
                                intersect: false,
                            },

                            horizontalLine: [
                                {
                                    y: this.target,
                                    style: "#ed5565",
                                    text:
                                        "Valor objetivo " +
                                        this.formatValue(
                                            this.target.toFixed(3)
                                        ),
                                },
                            ],

                            plugins: {
                                legend: {
                                    position: "top",
                                },
                            },

                            hover: {
                                mode: "nearest",
                                intersect: true,
                            },

                            scales: {
                                xAxes: {
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Años",
                                        fontColor: "white",
                                    },

                                    title: {
                                        display: true,
                                        text: "Años",
                                        color: "#343a40",
                                        font: {
                                            size: 12,
                                            weight: "bold",
                                            lineHeight: 1.2,
                                            family: '"Roboto", "Helvetica Neue", Helvetica, Arial, sans-serif',
                                        },
                                        padding: {
                                            top: 20,
                                            left: 0,
                                            right: 0,
                                            bottom: 0,
                                        },
                                    },
                                },

                                yAxes: [
                                    {
                                        display: true,

                                        ticks: {
                                            beginAtZero: true,
                                            suggestedMin: 0,
                                            suggestedMax: this.target,
                                        },
                                    },
                                ],
                            },
                        },
                    };

                    var horizonalLinePlugin = {
                        afterDraw: function (chartInstance) {
                            var yScale = chartInstance.scales["y-axis-0"];
                            var xAxis = chartInstance.scales["x-axis-0"];
                            var canvas = chartInstance.chart;
                            var ctx = canvas.ctx;
                            var index;
                            var line;
                            var style;
                            if (chartInstance.options.horizontalLine) {
                                for (
                                    index = 0;
                                    index <
                                    chartInstance.options.horizontalLine.length;
                                    index++
                                ) {
                                    line =
                                        chartInstance.options.horizontalLine[
                                            index
                                        ];
                                    if (!line.style) {
                                        style = "#ed5565";
                                    } else {
                                        style = line.style;
                                    }
                                    if (line.y) {
                                        var yValue = yScale.getPixelForValue(
                                            line.y
                                        );
                                    } else {
                                        var yValue = 0;
                                    }
                                    ctx.lineWidth = 3;
                                    if (yValue) {
                                        ctx.beginPath();
                                        ctx.moveTo(0, yValue);
                                        ctx.moveTo(
                                            chartInstance.chartArea.left,
                                            yValue
                                        );
                                        ctx.lineTo(
                                            chartInstance.chartArea.right,
                                            yValue
                                        );
                                        ctx.strokeStyle = style;
                                        ctx.stroke();
                                    }

                                    if (line.text) {
                                        ctx.fillStyle = style;
                                        // le texte

                                        ctx.fillText(
                                            line.text,
                                            50,
                                            yValue + 5 + ctx.lineWidth
                                        );
                                    }
                                }
                                return;
                            }
                        },
                    };

                    Chart.pluginService.register(horizonalLinePlugin);

                    this.chart = new Chart(ctx, config);
                } else {
                    const config = {
                        type: "line",

                        data: {
                            labels: this.years,

                            datasets: [
                                {
                                    label: this.objective.indicator,
                                    data: this.dataSets,
                                    fill: false,
                                    borderColor: "#1AB394",
                                    backgroundColor: "#1AB394",
                                    tension: 0.2,
                                },
                            ],
                        },

                        options: {
                            responsive: true,

                            interaction: {
                                mode: "index",
                                intersect: false,
                            },

                            plugins: {
                                legend: {
                                    position: "top",
                                },
                            },

                            hover: {
                                mode: "nearest",
                                intersect: true,
                            },

                            scales: {
                                xAxes: [
                                    {
                                        title: {
                                            display: true,
                                            text: "Años",
                                            color: "#343a40",
                                            font: {
                                                size: 12,
                                                weight: "bold",
                                                lineHeight: 1.2,
                                                family: '"Roboto", "Helvetica Neue", Helvetica, Arial, sans-serif',
                                            },
                                            padding: {
                                                top: 20,
                                                left: 0,
                                                right: 0,
                                                bottom: 0,
                                            },
                                        },
                                    },
                                ],

                                yAxes: [
                                    {
                                        title: {
                                            display: true,
                                            text: this.objective.indicator,
                                            color: "#343a40",
                                            font: {
                                                size: 12,
                                                weight: "bold",
                                                lineHeight: 1.2,
                                                family: '"Roboto", "Helvetica Neue", Helvetica, Arial, sans-serif',
                                            },
                                            padding: {
                                                top: 0,
                                                left: 0,
                                                right: 0,
                                                bottom: 20,
                                            },
                                        },

                                        ticks: {
                                            beginAtZero: true,
                                        },
                                    },
                                ],
                            },
                        },
                    };

                    this.chart = new Chart(ctx, config);
                }
            });
    }

    formatValue(number) {
        let value = number;
        value = value.replace(".", ",");
        return value;
    }
}

export default IndicatorVariation;
