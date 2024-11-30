<?php

use App\Http\Controllers\CircularQueueController;
use App\Http\Controllers\SimpleQueueController;
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


Route::post('/queue/enqueue', [CircularQueueController::class, 'enqueue'])->name('queue.enqueue');
Route::post('/queue/dequeue', [CircularQueueController::class, 'dequeue'])->name('queue.dequeue');
Route::post('/queue/peek', [CircularQueueController::class, 'peek'])->name('queue.peek');
Route::post('/queue/reverse', [CircularQueueController::class, 'reverse'])->name('queue.reverse');
Route::get('/queue/display', [CircularQueueController::class, 'display'])->name('queue.display');


Route::prefix('simple/queue')->group(function () {
    Route::get('/display', [SimpleQueueController::class, 'display'])->name('simplequeue.display');
    Route::post('/enqueue', [SimpleQueueController::class, 'enqueue'])->name('simplequeue.enqueue');
    Route::post('/dequeue', [SimpleQueueController::class, 'dequeue'])->name('simplequeue.dequeue');
    Route::post('/peek', [SimpleQueueController::class, 'peek'])->name('simplequeue.peek');
    Route::post('/reverse', [SimpleQueueController::class, 'reverse'])->name('simplequeue.reverse');
    Route::post('/simple/queue/reset', [SimpleQueueController::class, 'resetQueue'])->name('simplequeue.reset');

});
