<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Province;

class LocationController extends Controller
{
    public function getCities($provinceId)
    {
        try {
            // Add validation to check if province exists
            $province = Province::find($provinceId);
            if (!$province) {
                return response()->json(['error' => 'Province not found'], 404);
            }

            $cities = City::where('province_id', $provinceId)
                         ->orderBy('name', 'asc')
                         ->get(['id', 'name']);
            
            // Log for debugging
            \Log::info('Fetching cities for province: ' . $provinceId);
            \Log::info('Cities found: ' . $cities->count());
            
            return response()->json($cities);
        } catch (\Exception $e) {
            \Log::error('Error fetching cities: ' . $e->getMessage());
            return response()->json(['error' => 'Error loading cities'], 500);
        }
    }
}