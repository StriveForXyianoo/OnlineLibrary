<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image" href="pics/WIT-Logo.png">
    <link rel="stylesheet" href="path/to/custom-lightbox.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <title>WIT Administration library</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
</head>

<body>

    <div class="maintitle">
        <h1>WESTERN INSTITUTE ADMINISTRATION LIBRARY</h1>
    </div>

    <div class="back-btn"><a href="Admin Main.php">Back to Admin Panel</a></div>

    <div class="background-main">
        <img src="pics/WIT-LOGO.png" class="mainlogo" alt="">
    </div>

    <div id="RecordsForm" class="form-container-records">
        <h2>Records Form</h2>

        <div class="selector">
            <label for="selectMonth">Select Month:</label>
            <select id="selectMonth">
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>

        <canvas id="barChart" width="400" height="200"></canvas>

        <button id="downloadButton" class="download-btn">Download as PDF</button>
        <script>
        const customLabels = (section) => {
            let customLabel;

            if (section === 'Graduate School Library Thesis/Dissertation Section' || section === 'Graduate School Library Thesis/Dissertations Section') {
                customLabel = 'Thesis/Dissertations - Graduate School';
            } else {
                const labelMappings = {
                    'Graduate School Library Archive Section': 'Archive - Graduate School Library',
                    'Graduate School Library Circulation Section': 'Circulation - Graduate School Library',
                    'Graduate School Library Filipinana Section': 'Filipinana - Graduate School Library',
                    'Graduate School Library Periodical Section': 'Periodical - Graduate School Library',
                    'Graduate School Library Reference Section': 'Reference - Graduate School Library',
                    'Graduate School Library Reserve Section': 'Reserve - Graduate School Library',
                    'Main Library Archive Section': 'Archive - Main Library',
                    'Main Library Circulation Section': 'Circulation - Main Library',
                    'Main Library Fiction Section': 'Fiction - Main Library',
                    'Main Library Filipinana Section': 'Filipinana - Main Library',
                    'Main Library Periodical Section': 'Periodical - Main Library',
                    'Main Library Reference Section': 'Reference - Main Library',
                    'Main Library Reserve Section': 'Reserve - Main Library',
                    'Main Library Thesis/Dissertation Section': 'Thesis/Dissertations - Main Library',
                    'RTS Library Archive Section': 'Archive - RTS Library',
                    'RTS Library Circulation Section': 'Circulation - RTS Library',
                    'RTS Library Fiction Section': 'Fiction - RTS Library',
                    'RTS Library Filipinana Section': 'Filipinana - RTS Library',
                    'RTS Library Periodical Section': 'Periodical - RTS Library',
                    'RTS Library Reference Section': 'Reference - RTS Library',
                    'RTS Library Reserve Section': 'Reserve - RTS Library',
                    'RTS Library Thesis/Dissertation Section': 'Thesis/Dissertations - RTS Library',
                };

                customLabel = labelMappings[section] || section;
            }

            return customLabel;
        };

    document.getElementById('selectMonth').addEventListener('change', function () {
        var selectedMonth = this.value;

        fetch('count_books.php?month=' + selectedMonth)
            .then(response => response.json())
            .then(data => {
                data.sections = data.sections.map(section => customLabels(section));
                renderBarChart(data);
            });
    });

document.getElementById('downloadButton').addEventListener('click', function () {
    const element = document.getElementById('barChart');
    const selectedMonth = document.getElementById('selectMonth').value;

    // Set options for PDF generation
    const options = {
        margin: 10,
        filename: `${getMonthName(selectedMonth)} Graph Data.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
    };

    html2pdf(element, options);
});

// Function to get month name based on month number
function getMonthName(monthNumber) {
    const months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    return months[parseInt(monthNumber, 10) - 1];
}


    function renderBarChart(data) {
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.sections,
                datasets: [{
                    label: 'Books Borrowed',
                    data: data.borrowedCount,
                    backgroundColor: '#ff7700',
                    borderColor: 'black',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>


        <button class="close-btn" onclick="window.location='Admin Main.php'">Hide</button>
    </div>

</body>

</html>
