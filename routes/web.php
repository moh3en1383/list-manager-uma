<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

Route::get('/',function (){
    $list=['1','2','3'];
    return view('list',compact('list'));
});
// نمایش لیست
Route::post('/list', [ListController::class, 'display'])->name('list.display');

// عملیات‌های مختلف بر روی لیست

// افزودن مقدار به لیست در اندیس مشخص
Route::post('/list/insert', [ListController::class, 'insert'])->name('list.insert');

// حذف مقدار بر اساس مقدار (Value)
Route::post('/list/delete-by-value', [ListController::class, 'deleteByValue'])->name('list.deleteByValue');

// حذف مقدار بر اساس اندیس (Index)
Route::post('/list/delete-by-index', [ListController::class, 'deleteByIndex'])->name('list.deleteByIndex');

// افزودن مقدار به انتهای لیست
Route::post('/list/append', [ListController::class, 'append'])->name('list.append');

// معکوس کردن لیست
Route::post('/list/reverse', [ListController::class, 'reverse'])->name('list.reverse');

// جستجو برای یک مقدار در لیست
Route::post('/find_by_value',[ListController::class,'searchByValue'])->name('list.search');
