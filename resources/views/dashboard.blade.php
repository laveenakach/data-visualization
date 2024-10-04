<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0; /* Remove default margin */
        }

        #filters {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap; /* Allow wrapping of filters */
            gap: 10px; /* Space between filters */
            justify-content: center; /* Center align */
        }

        select {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            flex: 1; /* Allow select to grow */
            min-width: 150px; /* Minimum width for each dropdown */
        }

        .chart-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .chart-container {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        canvas {
            max-width: 100%;
            height: auto;
        }

        .filters {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <h1>Data Dashboard</h1>

    <!-- Filter Section -->
    <div id="filters" class="filters">
        <select id="yearFilter">
            <option value="">End Year</option>
            @foreach($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>

        <select id="topicFilter">
            <option value="">All Topics</option>
            @foreach($topics as $topic)
                <option value="{{ $topic }}">{{ $topic }}</option>
            @endforeach
        </select>

        <select id="sectorFilter">
            <option value="">Select Sector</option>
            @foreach($sectors as $sector)
                <option value="{{ $sector }}">{{ $sector }}</option>
            @endforeach
        </select>

        <select id="regionFilter">
            <option value="">Select Region</option>
            @foreach($regions as $region)
                <option value="{{ $region }}">{{ $region }}</option>
            @endforeach
        </select>

        <select id="pestFilter">
            <option value="">Select PEST</option>
            @foreach($pestle as $p)
                <option value="{{ $p }}">{{ $p }}</option>
            @endforeach
        </select>

        <select id="sourceFilter">
            <option value="">Select Source</option>
            @foreach($sources as $source)
                <option value="{{ $source }}">{{ $source }}</option>
            @endforeach
        </select>

        <select id="swotFilter">
            <option value="">Select SWOT</option>
            @foreach($swot as $s)
                <option value="{{ $s }}">{{ $s }}</option>
            @endforeach
        </select>

        <select id="countryFilter">
            <option value="">Select Country</option>
            @foreach($countries as $country)
                <option value="{{ $country }}">{{ $country }}</option>
            @endforeach
        </select>

        <select id="cityFilter">
            <option value="">Select City</option>
            @foreach($cities as $city)
                <option value="{{ $city }}">{{ $city }}</option>
            @endforeach
        </select>
    </div>

    <!-- Chart Grid -->
    <div class="chart-grid">
        <div class="chart-container">
            <h3>Pie Chart</h3>
            <canvas id="pieChart"></canvas>
        </div>
        <div class="chart-container">
            <h3>Year Bar Chart</h3>
            <canvas id="yearChart"></canvas>
        </div>
        <div class="chart-container">
            <h3>Countries Bar Chart</h3>
            <canvas id="countryChart"></canvas>
        </div>
        <div class="chart-container">
            <h3>Cities Bar Chart</h3>
            <canvas id="cityChart"></canvas>
        </div>
        <div class="chart-container">
            <h3>Regions Bar Chart</h3>
            <canvas id="regionChart"></canvas>
        </div>
        <div class="chart-container">
            <h3>Topics Bar Chart</h3>
            <canvas id="topicChart"></canvas>
        </div>
    </div>

    <script>
        let pieChart, yearChart, countryChart, cityChart, regionChart, topicChart;

        function fetchDataAndRenderCharts(year = '', topic = '', region = '') {
            let url = '/data'; // Change to your route URL

            // Construct query parameters
            const params = new URLSearchParams();
            if (year) params.append('year', year);
            if (topic) params.append('topics', topic);
            if (region) params.append('region', region);
            if (params.toString()) url += `?${params.toString()}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const yearsCount = {};
                    const countriesCount = {};
                    const citiesCount = {};
                    const regionsCount = {};
                    const topicsCount = {};
                    const intensity = [];
                    const relevance = [];
                    const likelihood = [];

                    data.forEach(item => {
                        yearsCount[item.year] = (yearsCount[item.year] || 0) + 1;
                        countriesCount[item.country] = (countriesCount[item.country] || 0) + 1;
                        citiesCount[item.city] = (citiesCount[item.city] || 0) + 1;
                        regionsCount[item.region] = (regionsCount[item.region] || 0) + 1;
                        topicsCount[item.topics] = (topicsCount[item.topics] || 0) + 1;

                        intensity.push(item.intensity);
                        relevance.push(item.relevance);
                        likelihood.push(item.likelihood);
                    });

                    // Prepare the chart data
                    const prepareChartData = (labels, data, label, backgroundColor) => ({
                        labels,
                        datasets: [{
                            label,
                            data,
                            backgroundColor
                        }]
                    });

                    // Pie Chart
                    const pieData = {
                        labels: ['Intensity', 'Likelihood', 'Relevance'],
                        datasets: [{
                            data: [intensity.reduce((a, b) => a + b, 0), likelihood.reduce((a, b) => a + b, 0), relevance.reduce((a, b) => a + b, 0)],
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)'
                            ]
                        }]
                    };

                    if (pieChart) pieChart.destroy();
                    const pieCtx = document.getElementById('pieChart').getContext('2d');
                    pieChart = new Chart(pieCtx, {
                        type: 'pie',
                        data: pieData,
                        options: { responsive: true }
                    });

                    // Year Chart
                    if (yearChart) yearChart.destroy();
                    yearChart = new Chart(document.getElementById('yearChart').getContext('2d'), {
                        type: 'bar',
                        data: prepareChartData(
                            Object.keys(yearsCount),
                            Object.values(yearsCount),
                            'Year Distribution',
                            'rgba(255, 99, 132, 0.6)'
                        ),
                        options: { responsive: true }
                    });

                    // Countries Chart
                    if (countryChart) countryChart.destroy();
                    countryChart = new Chart(document.getElementById('countryChart').getContext('2d'), {
                        type: 'bar',
                        data: prepareChartData(
                            Object.keys(countriesCount),
                            Object.values(countriesCount),
                            'Countries Distribution',
                            'rgba(75, 192, 192, 0.6)'
                        ),
                        options: { responsive: true }
                    });

                    // Cities Chart
                    if (cityChart) cityChart.destroy();
                    cityChart = new Chart(document.getElementById('cityChart').getContext('2d'), {
                        type: 'bar',
                        data: prepareChartData(
                            Object.keys(citiesCount),
                            Object.values(citiesCount),
                            'Cities Distribution',
                            'rgba(153, 102, 255, 0.6)'
                        ),
                        options: { responsive: true }
                    });

                    // Regions Chart
                    if (regionChart) regionChart.destroy();
                    regionChart = new Chart(document.getElementById('regionChart').getContext('2d'), {
                        type: 'bar',
                        data: prepareChartData(
                            Object.keys(regionsCount),
                            Object.values(regionsCount),
                            'Regions Distribution',
                            'rgba(255, 159, 64, 0.6)'
                        ),
                        options: { responsive: true }
                    });

                    // Topics Chart
                    if (topicChart) topicChart.destroy();
                    topicChart = new Chart(document.getElementById('topicChart').getContext('2d'), {
                        type: 'bar',
                        data: prepareChartData(
                            Object.keys(topicsCount),
                            Object.values(topicsCount),
                            'Topics Distribution',
                            'rgba(255, 206, 86, 0.6)'
                        ),
                        options: { responsive: true }
                    });
                });
        }

        // Fetch initial data
        fetchDataAndRenderCharts();

        // Filter Event Listeners
        document.querySelectorAll('#filters select').forEach(select => {
            select.addEventListener('change', () => {
                const year = document.getElementById('yearFilter').value;
                const topic = document.getElementById('topicFilter').value;
                const region = document.getElementById('regionFilter').value;
                fetchDataAndRenderCharts(year, topic, region);
            });
        });
    </script>
</body>
</html>
