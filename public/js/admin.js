/**
 * Renders a user registration chart using Chart.js
 *
 * @param {HTMLElement} chartElement - The canvas element for the chart
 */
function renderUserChart(chartElement) {
    if (!chartElement) return;

    // Get data from element's data attributes
    const labels = JSON.parse(chartElement.dataset.labels || "[]");
    const values = JSON.parse(chartElement.dataset.values || "[]");

    // Chart.js configuration
    const ctx = chartElement.getContext("2d");
    new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "新規ユーザー登録数",
                    data: values,
                    backgroundColor: "rgba(208, 90, 110, 0.1)",
                    borderColor: "#D05A6E",
                    borderWidth: 2,
                    pointBackgroundColor: "#D05A6E",
                    pointBorderColor: "#fff",
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.3,
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                    },
                },
            },
            plugins: {
                legend: {
                    position: "top",
                    labels: {
                        boxWidth: 12,
                        usePointStyle: true,
                        pointStyle: "circle",
                    },
                },
                tooltip: {
                    backgroundColor: "#1A2639",
                    titleColor: "#fff",
                    bodyColor: "#fff",
                    padding: 10,
                    cornerRadius: 4,
                    displayColors: false,
                    callbacks: {
                        title: function (tooltipItems) {
                            return tooltipItems[0].label;
                        },
                        label: function (context) {
                            return `新規ユーザー: ${context.parsed.y} 人`;
                        },
                    },
                },
            },
        },
    });
}

/**
 * Confirms and submits the block/unblock user form
 *
 * @param {number} userId - The user ID
 * @param {string} userName - The user's name
 * @param {boolean} isBlocked - Whether the user is currently blocked
 */
function toggleBlockUser(userId, userName, isBlocked) {
    const action = isBlocked ? "unblock" : "block";
    const message = isBlocked
        ? `本当に ${userName} さんのブロックを解除しますか？`
        : `本当に ${userName} さんをブロックしますか？`;

    if (confirm(message)) {
        document.getElementById(`block-form-${userId}`).submit();
    }
}

/**
 * Confirms and submits the admin role toggle form
 *
 * @param {number} userId - The user ID
 * @param {string} userName - The user's name
 * @param {boolean} isAdmin - Whether the user is currently an admin
 */
function toggleAdminRole(userId, userName, isAdmin) {
    const action = isAdmin ? "削除" : "付与";
    if (confirm(`本当に ${userName} さんの管理者権限を${action}しますか？`)) {
        document.getElementById(`admin-form-${userId}`).submit();
    }
}

/**
 * Confirms and submits the delete user form
 *
 * @param {number} userId - The user ID
 * @param {string} userName - The user's name
 */
function deleteUser(userId, userName) {
    if (
        confirm(
            `警告: この操作は取り消せません。\n本当に ${userName} さんを削除しますか？`
        )
    ) {
        document.getElementById(`delete-form-${userId}`).submit();
    }
}
