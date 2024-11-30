<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CircularQueueController extends Controller
{
    private $size;

    public function __construct($size = 5)
    {
        $this->size = $size;

        if (!session()->has('queue')) {
            session()->put('queue', array_fill(0, $this->size, null));
            session()->put('front', -1);
            session()->put('rear', -1);
        }
    }

    public function enqueue(Request $request)
    {
        $value = $request->input('value');
        $queue = session('queue');
        $front = session('front');
        $rear = session('rear');

        if ($this->isFull($front, $rear)) {
            $message = 'صف پر است';
            return view('queue', ['queue' => $queue, 'message' => $message]);
        }

        if ($front == -1) {
            $front = 0;
        }

        $rear = ($rear + 1) % $this->size;
        $queue[$rear] = $value;

        session()->put('queue', $queue);
        session()->put('front', $front);
        session()->put('rear', $rear);

        $message = 'مقدار به صف اضافه شد';
        return view('queue', ['queue' => $queue, 'message' => $message]);
    }

    public function dequeue()
    {
        $queue = session('queue');
        $front = session('front');
        $rear = session('rear');

        if ($this->isEmpty($front)) {
            $message = 'صف خالی است';
            return view('queue', ['queue' => $queue, 'message' => $message]);
        }

        // حذف مقدار از ابتدای صف
        $value = $queue[$front];
        $queue[$front] = null;

        // بررسی اینکه آیا صف خالی شده است
        if ($front == $rear) {
            // اگر تنها یک مقدار در صف باشد، صف خالی می‌شود
            $front = $rear = -1;
        } else {
            // حرکت دادن front به موقعیت بعدی
            $front = ($front + 1) % $this->size;
        }

        // به‌روزرسانی سشن
        session()->put('queue', $queue);
        session()->put('front', $front);
        session()->put('rear', $rear);

        $message = 'مقدار حذف شد: ' . $value;
        return view('queue', ['queue' => $queue, 'message' => $message]);
    }

    public function peek()
    {
        $queue = session('queue');
        $front = session('front');

        if ($this->isEmpty($front)) {
            $message = 'صف خالی است';
            return view('queue', ['queue' => $queue, 'message' => $message]);
        }

        $message = 'مقدار ابتدای صف: ' . $queue[$front];
        return view('queue', ['queue' => $queue, 'message' => $message]);
    }

    public function reverse()
    {
        $queue = session('queue');
        $front = session('front');
        $rear = session('rear');

        if ($this->isEmpty($front)) {
            $message = 'صف خالی است';
            return view('queue', ['queue' => $queue, 'message' => $message]);
        }

        // معکوس کردن صف
        $reversedQueue = array_fill(0, $this->size, null);
        $j = 0;

        // معکوس کردن با توجه به اندیس‌های front و rear
        for ($i = $rear; $i != $front; $i = ($i - 1 + $this->size) % $this->size) {
            $reversedQueue[$j++] = $queue[$i];
        }
        $reversedQueue[$j] = $queue[$front];

        // تنظیم اندیس‌های جدید برای front و rear پس از معکوس کردن
        $newFront = 0; // پس از معکوس کردن، front به 0 تنظیم می‌شود
        $newRear = $j; // rear باید به آخرین عنصر معکوس‌شده تنظیم شود

        // ذخیره صف معکوس‌شده و اندیس‌های جدید در سشن
        session()->put('queue', $reversedQueue);
        session()->put('front', $newFront);
        session()->put('rear', $newRear);

        $message = 'صف معکوس شد';
        return view('queue', ['queue' => $reversedQueue, 'message' => $message]);
    }

    private function isEmpty($front)
    {
        return $front == -1;
    }

    private function isFull($front, $rear)
    {
        return ($rear + 1) % $this->size == $front;
    }

    public function display()
    {
        $queue = session('queue');
        return view('queue', ['queue' => $queue]);
    }
}
