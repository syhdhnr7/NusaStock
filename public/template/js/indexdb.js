document.addEventListener("DOMContentLoaded", function () {

    // PIE CHART


    // BAR CHART
    const barEl = document.getElementById('barChart');
    if (barEl) {
        new Chart(barEl, {
            type: 'bar',
            data: {
                labels: days,
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: incomingData,
                        backgroundColor: '#57B657'
                    },
                    {
                        label: 'Barang Keluar',
                        data: outcomingData,
                        backgroundColor: '#FF4747'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10
                        }
                    }
                }
            }
        });
    }

});