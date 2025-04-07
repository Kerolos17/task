<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/tasks', [TaskController::class]);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    return ['token' => $user->createToken('api-token')->plainTextToken];
});
