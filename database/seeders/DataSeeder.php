<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use League\Csv\Reader; 
use App\Models\Data;
use Illuminate\Support\Facades\Log;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('seeders/data.csv');

        if (!file_exists($csvPath)) {
            Log::error('CSV file not found at: ' . $csvPath);
            return;
        }

        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setHeaderOffset(0); 

        Log::info('CSV headers: ' . json_encode($csv->getHeader()));

        foreach ($csv as $record) {
            Log::info('CSV record: ' . json_encode($record)); 

            if (isset($record['start_year'], $record['intensity'], $record['likelihood'], $record['relevance'])) {
                try {
                    Data::create([
                        'intensity' => $record['intensity'],
                        'likelihood' => $record['likelihood'],
                        'relevance' => $record['relevance'],
                        'year' => $record['start_year'], 
                        'country' => $record['country'] ?? null,
                        'topics' => $record['topic'] ?? null,
                        'region' => $record['region'] ?? null,
                        'city' => $record['city'] ?? null,
                        'sector' => $record['sector'] ?? null,
                        'pestle' => $record['pestle'] ?? null,
                        'source' => $record['source'] ?? null,
                        'swot' => $record['swot'] ?? null,
                    ]);
                    Log::info('Data inserted for year: ' . $record['start_year']); 
                } catch (\Exception $e) {
                    Log::error('Error inserting data for year: ' . $record['start_year'] . '. Error: ' . $e->getMessage());
                }
            } else {
                Log::warning('Missing required fields in CSV record: ' . json_encode($record));
            }
        }
    }
}
