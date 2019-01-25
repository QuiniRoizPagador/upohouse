$(document).ready(function () {
    if (typeof (lb) !== 'undefined') {
        var ctx = document.getElementById("countRegistrations");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: lb,
                datasets: [{
                        data: ds,
                        lineTension: 0,
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        borderWidth: 4,
                        pointBackgroundColor: '#007bff'
                    }]
            },
            options: {
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                },
                legend: {
                    display: false,
                }
            }
        });
    }
});
