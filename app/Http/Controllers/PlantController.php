<?php

namespace App\Http\Controllers;

use App\Models\PlantModel;
use Illuminate\Http\Request;
use \Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PlantController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    try {
      // Get all plants with pagination (15 records per page)
      $plants = PlantModel::paginate(15);

      return response()->json([
        'message' => 'Plants retrieved successfully',
        'data' => $plants->items(),
        'pagination' => [
          'total' => $plants->total(),
          'per_page' => $plants->perPage(),
          'current_page' => $plants->currentPage(),
          'last_page' => $plants->lastPage(),
          'from' => $plants->firstItem(),
          'to' => $plants->lastItem(),
        ],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Failed to retrieve plants',
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //TODO: implement save record functionality
  }

  /**
   * Display the specified resource.
   */
  public function show(PlantModel $plantController)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, PlantModel $plantController)
  {
    //TODO : implement update record functionality
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(PlantModel $plant)
  {
    //TODO : implement delete record functionality
  }
}
