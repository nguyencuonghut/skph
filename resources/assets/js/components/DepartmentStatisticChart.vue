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
                        labels: ["HCNS" + ": " + this.statistics[0], "Sale Admin" + ": " + this.statistics[1], "Kế Toán" + ": " + this.statistics[2]
                            , "KSNB" + ": " + this.statistics[3], "Bảo Trì" + ": " + this.statistics[4], "Sản Xuất" + ": " + this.statistics[5]
                            , "Thu Mua" + ": " + this.statistics[6], "Kỹ Thuật" + ": " + this.statistics[7], "QLCL" + ": " + this.statistics[8],
                            "Kho" + ": " + this.statistics[9]],
                        datasets: [
                            {
                                backgroundColor: ["#FF6384", "#71397C", "#61BA95", "red", "green", "gray", "blue", "orange", "black", "#000099"],
                                data: this.statistics
                                //data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
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