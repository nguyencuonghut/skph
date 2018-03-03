<template>
    <canvas width="750" height="400" ref="canvaschart"></canvas>
</template>

<script>
    import Chart from 'chart.js';

    export default {
        props: ['statistics'],
        methods: {
            render(data)
            {
                Chart.defaults.global.defaultFontSize = 10;
                this.Chart = new Chart(this.$refs.canvaschart.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ["Con người" + ": " + this.statistics[0], "Máy móc" + ": " + this.statistics[1],
                            "Nguyên liệu" + ": " + this.statistics[2], "Phương pháp" + ": " + this.statistics[3],
                            "Đo lường" + ": " + this.statistics[4], "Môi trường" + ": " + this.statistics[5]],
                        datasets: [
                            {
                                backgroundColor: ["#FF6384", "#71397C", "#61BA95", "red", "green", "gray"],
                                data: this.statistics
                                //data: [1, 2, 3, 4, 5, 6]
                            }

                        ]
                    },
                    options: {
                        responsive: true,
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var allData = data.datasets[tooltipItem.datasetIndex].data;
                                    var tooltipLabel = data.labels[tooltipItem.index];
                                    var tooltipData = allData[tooltipItem.index];
                                    var total = 0;
                                    for (var i in allData) {
                                        total += allData[i];
                                    }
                                    var tooltipPercentage = Math.round((tooltipData / total) * 100);
                                    return tooltipLabel + ' (' + tooltipPercentage + '%)';
                                }
                            },
                            scales: { scaleLabel: { fontSize: 8 } }
                        }
                    },
                });
            },
        },
        mounted() {
            this.render();
        },
    };
</script>