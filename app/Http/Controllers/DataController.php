<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;

class DataController extends Controller
{
    public function showDashboard()
    {
        $years = Data::distinct()->orderBy('year', 'asc')->pluck('year');
        $topics = Data::distinct()->orderBy('topics', 'asc')->pluck('topics');
        $sectors = Data::distinct()->orderBy('sector', 'asc')->pluck('sector');
        $regions = Data::distinct()->orderBy('region', 'asc')->pluck('region');
        $pestle = Data::distinct()->orderBy('pestle', 'asc')->pluck('pestle'); 
        $sources = Data::distinct()->orderBy('source', 'asc')->pluck('source'); 
        $swot = Data::distinct()->orderBy('swot', 'asc')->pluck('swot'); 
        $countries = Data::distinct()->orderBy('country', 'asc')->pluck('country');
        $cities = Data::distinct()->orderBy('city', 'asc')->pluck('city');
        return view('dashboard', compact('years', 'topics', 'sectors', 'regions', 'pestle', 'sources', 'swot', 'countries', 'cities'));
    }


    public function getData(Request $request)
    {
        $data = Data::query();

        if ($request->has('year')) {
            $data->where('year', $request->year);
        }

        if ($request->has('topics')) {
            $data->where('topics', $request->topics);
        }

        return response()->json($data->get());
    
    }
}
