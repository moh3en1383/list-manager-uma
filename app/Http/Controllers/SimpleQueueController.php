<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimpleQueueController extends Controller
{
    private $size;

    public function __construct($size = 5)
    {
        $this->size = $size;

        if (!session()->has('queue')) {
            session()->put('queue', array_fill(0, $this->size, null));
            session()->put('front', 0);  // front شروع به 0
            session()->put('rear', -1);  // rear شروع به -1
        }
    }

    public function enqueue(Request $request)
    {
        $value = $request->input('value');
        $queue = session('queue');
        $front = session('front');
        $rear = session('rear');

        // بررسی پر بودن صف
        if ($this->isFull($rear)) {
            $message = 'صف پر است';
            return view('queue2', ['queue' => $queue, 'message' => $message]);
        }

        // افزایش rear و اضافه کردن مقدار
        $rear++;
        $queue[$rear] = $value;

        // اگر این اولین بار است که چیزی اضافه می‌شود، مقدار front باید 0 باشد
        if ($front == -1) {
            $front = 0;
        }

        session()->put('queue', $queue);
        session()->put('rear', $rear);
        session()->put('front', $front);

        $message = 'مقدار به صف اضافه شد';
        return view('queue2', ['queue' => $queue, 'message' => $message]);
    }

    public function dequeue()
    {
        $queue = session('queue');
        $front = session('front');
        $rear = session('rear');

        // بررسی اینکه آیا صف خالی است
        if ($this->isEmpty($front, $rear)) {
            $message = 'صف خالی است';
            return view('queue2', ['queue' => $queue, 'message' => $message]);
        }

        // حذف مقدار از ابتدای صف
        $value = $queue[$front];
        $queue[$front] = null;

        // اگر صف خالی شد، اندیس‌ها را به حالت اولیه تنظیم می‌کنیم
        if ($front == $rear) {
            $front = $rear = -1;  // صف خالی شده است
        } else {
            // حرکت دادن front به موقعیت بعدی
            $front++;
        }

        session()->put('queue', $queue);
        session()->put('front', $front);
        session()->put('rear', $rear);

        $message = 'مقدار حذف شد: ' . $value;
        return view('queue2', ['queue' => $queue, 'message' => $message]);
    }

    public function peek()
    {
        $queue = session('queue');
        $front = session('front');

        // بررسی اینکه آیا صف خالی است
        if ($this->isEmpty($front, session('rear'))) {
            $message = 'صف خالی است';
            return view('queue2', ['queue' => $queue, 'message' => $message]);
        }

        $message = 'مقدار ابتدای صف: ' . $queue[$front];
        return view('queue2', ['queue' => $queue, 'message' => $message]);
    }

    public function reverse()
    {
        $queue = session('queue');
        $front = session('front');
        $rear = session('rear');

        // بررسی اینکه آیا صف خالی است
        if ($this->isEmpty($front, $rear)) {
            $message = 'صف خالی است';
            return view('queue2', ['queue' => $queue, 'message' => $message]);
        }

        // معکوس کردن صف
        $reversedQueue = array_fill(0, $this->size, null);
        $j = 0;

        for ($i = $rear; $i >= $front; $i--) {
            $reversedQueue[$j++] = $queue[$i];
        }

        session()->put('queue', $reversedQueue);
        session()->put('front', 0);
        session()->put('rear', $j - 1);

        $message = 'صف معکوس شد';
        return view('queue2', ['queue' => $reversedQueue, 'message' => $message]);
    }

    private function isEmpty($front, $rear)
    {
        return $front == -1 || $front > $rear;
    }

    private function isFull($rear)
    {
        return $rear == $this->size - 1;
    }

    public function display()
    {
        $queue = session('queue');
        return view('queue2', ['queue' => $queue]);
    }
    public function resetQueue()
    {
        // ریست کردن صف و اندیس‌ها
        $queue = array_fill(0, $this->size, null);
        $front = 0;
        $rear = -1;

        // ذخیره مقادیر در سشن
        session()->put('queue', $queue);
        session()->put('front', $front);
        session()->put('rear', $rear);

        $message = 'صف ریست شد.';
        return view('queue2', ['queue' => $queue, 'message' => $message]);
    }

}
