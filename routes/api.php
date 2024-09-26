<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;

Route::post('/login/users', [UserController::class, 'login']);
Route::post('/register/users', [UserController::class, 'register']);
Route::post('/logout/users', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']); 
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/edit/users/{id}', [UserController::class, 'update']); 
    Route::delete('/delete/users/{id}', [UserController::class, 'destroy']); 
});
Route::get('/shifts', [ShiftController::class, 'index']);
Route::post('/shifts', [ShiftController::class, 'store']);
Route::get('/shifts/{id}', [ShiftController::class, 'show']);
Route::put('/shifts/{id}', [ShiftController::class, 'update']);
Route::delete('/shifts/{id}', [ShiftController::class, 'destroy']);

Route::get('/offices', [OfficeController::class, 'index']);
Route::post('/offices', [OfficeController::class, 'store']);
Route::get('/offices/{id}', [OfficeController::class, 'show']);
Route::put('/offices/{id}', [OfficeController::class, 'update']);
Route::delete('/offices/{id}', [OfficeController::class, 'destroy']);

Route::get('/roles', [RoleController::class, 'index']);      
Route::post('/roles', [RoleController::class, 'store']);     
Route::get('/roles/{id}', [RoleController::class, 'show']);  
Route::put('/roles/{id}', [RoleController::class, 'update']); 
Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

Route::get('/schedules', [ScheduleController::class, 'index']);
Route::post('/schedules', [ScheduleController::class, 'store']);
Route::get('/schedules/{id}', [ScheduleController::class, 'show']);
Route::put('/schedules/{id}', [ScheduleController::class, 'update']);
Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy']);

Route::get('/attendances', [AttendanceController::class, 'index']);        
Route::post('/attendances', [AttendanceController::class, 'store']);       
Route::get('/attendances/{id}', [AttendanceController::class, 'show']);    
Route::put('/attendances/{id}', [AttendanceController::class, 'update']);  
Route::delete('/attendances/{id}', [AttendanceController::class, 'destroy']);