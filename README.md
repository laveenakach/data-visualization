# Data Visualization Dashboard

## Overview

The **Data Visualization Dashboard** is a Laravel-based web application designed to provide an interactive interface for visualizing and analyzing data. Users can filter various data attributes, allowing for in-depth analysis and insight extraction from large datasets.

![alt text](<Screenshot (302).png>)

![alt text](<Screenshot (303)-1.png>)

## Features

- **Dynamic Data Visualization**: Interactive charts and graphs using popular libraries like Chart.js or D3.js.
- **Data Filtering**: Users can filter data based on multiple attributes (e.g., End year, topics, sector, region, pest, source, swot, country & city.) to tailor the visualizations to their needs.


## Installation

Follow these steps to set up the project locally:

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/YourUsername/data-visualization.git

2. **Navigate to the Project Directory:**

 cd data-visualization

3. **Install Dependencies:**
composer install

4. **Set Up the Environment File:**
Set Up the Environment File:

5. **Run Migrations:**
php artisan migrate

6. **Seed the database:**
php artisan db:seed --class=DataSeeder

7. Once you have set up the project and imported the data, you can run the application using:

php artisan serve
Visit http://localhost:8000/dashboard in your web browser to access the dashboard.