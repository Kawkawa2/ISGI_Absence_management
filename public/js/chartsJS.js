const ctx1 = document.getElementById("chart-1").getContext("2d");
const myChart = new Chart(ctx1, {
    type: "polarArea",
    data: {
        labels: ["Justifié", "Non Justifié"],
        datasets: [
            {
                label: "# of Votes",
                data: chartData,
                backgroundColor: ["#337ab7", "#D90429"],
            },
        ],
    },
    options: {
        responsive: true,
    },
});

const ctx2 = document.getElementById("chart-2").getContext("2d");
const myChart2 = new Chart(ctx2, {
    type: "bar",
    data: {
        labels: ["Certificat", "Autorisation", "Sanction"],
        datasets: [
            {
                label: "Taux de Type de justif",
                data: chartData2,
                backgroundColor: [
                    "rgba(255, 99, 132, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(54, 162, 235, 1)",
                ],
            },
        ],
    },
    options: {
        responsive: true,
    },
});
