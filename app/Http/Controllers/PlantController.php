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
    try {
      // Validate the request data
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'variety' => 'required|string|max:255',
        'notes' => 'nullable|string',
        'date_planted' => 'required|date',
        'seedling_count' => 'required|integer|min:1',
        'batch_name' => 'required|string|max:255',
        'starting_fund' => 'required|numeric|min:0',
        'seedling_source' => 'required|string|max:255',
      ]);

      // Create a new plant record
      $plant = PlantModel::create($validated);

      return response()->json([
        'message' => 'Plant record created successfully',
        'data' => $plant,
      ], 201);
    } catch (ValidationException $e) {
      return response()->json([
        'message' => 'Validation failed',
        'errors' => $e->errors(),
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Failed to create plant record',
        'error' => $e->getMessage(),
      ], 500);
    }
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
    try {
      // Validate the request data (all fields optional for partial updates)
      $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'variety' => 'sometimes|string|max:255',
        'notes' => 'nullable|string',
        'date_planted' => 'sometimes|date',
        'seedling_count' => 'sometimes|integer|min:1',
        'batch_name' => 'sometimes|string|max:255',
        'starting_fund' => 'sometimes|numeric|min:0',
        'seedling_source' => 'sometimes|string|max:255',
      ]);

      // Update the plant record with only the provided fields
      $plantController->update($validated);

      return response()->json([
        'message' => 'Plant record updated successfully',
        'data' => $plantController->fresh(),
      ], 200);
    } catch (ValidationException $e) {
      return response()->json([
        'message' => 'Validation failed',
        'errors' => $e->errors(),
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Failed to update plant record',
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(PlantModel $plant)
  {
    try {
      // Store plant data before deletion for response
      $deletedPlant = $plant;

      // Delete the plant record
      $plant->delete();

      return response()->json([
        'message' => 'Plant record deleted successfully',
        'data' => $deletedPlant,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Failed to delete plant record',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
}
