<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StackController extends Controller
{
    private $size;

    public function __construct($size = 5)
    {
        $this->size = $size;

        // اگر استک هنوز در سشن تعریف نشده است، آن را به عنوان آرایه خالی قرار بده
        if (!session()->has('stack')) {
            session()->put('stack', []);
        }

        // اگر صف هنوز در سشن تعریف نشده است، آن را به عنوان آرایه خالی تنظیم کن
        if (!session()->has('queue')) {
            session()->put('queue', []);
        }
    }

    // متد Push برای استک
    public function push(Request $request)
    {
        $item = $request->input('item');
        $stack = session('stack');  // دریافت استک از سشن

        // بررسی پر بودن استک
        if ($this->isFull($stack)) {
            $message = 'استک پر است';
            return view('stack', ['stack' => $stack, 'message' => $message]);
        }

        // افزودن آیتم به انتهای استک با استفاده از سینتاکس آرایه
        $stack[] = $item;
        session()->put('stack', $stack);  // ذخیره استک در سشن

        $message = 'مقدار اضافه شد';
        return view('stack', ['stack' => $stack, 'message' => $message]);
    }

    // متد Pop برای استک
    public function pop()
    {
        $stack = session('stack');

        // بررسی اگر استک خالی باشد
        if ($this->isEmpty($stack)) {
            $message = 'استک خالی است';
            return view('stack', ['stack' => $stack, 'message' => $message]);
        }

        // حذف آخرین عنصر از استک
        $lastIndex = $this->getLastIndex($stack);  // دریافت اندیس آخرین عنصر
        $item = $stack[$lastIndex];  // گرفتن آخرین آیتم
        unset($stack[$lastIndex]);  // حذف آخرین آیتم از آرایه

        session()->put('stack', $stack);  // ذخیره استک جدید در سشن

        $message = 'مقدار حذف شد: ' . $item;
        return view('stack', ['stack' => $stack, 'message' => $message]);
    }

    private function getLastIndex($array)
    {
        $lastIndex = -1;
        foreach ($array as $index => $value) {
            $lastIndex = $index;  // به‌روزرسانی اندیس آخرین عنصر
        }
        return $lastIndex;
    }

    public function peek()
    {
        $stack = session('stack');


        if ($this->isEmpty($stack)) {
            $message = 'استک خالی است';
            return view('stack', ['stack' => $stack, 'message' => $message]);
        }


        $item = null;
        foreach ($stack as $currentItem) {
            $item = $currentItem;
        }

        $message = 'مقدار بالای استک: ' . $item;
        return view('stack', ['stack' => $stack, 'message' => $message]);
    }


    // متد Enqueue برای صف
    public function enqueue(Request $request)
    {
        $item = $request->input('item');
        $stack1 = session('stack1', []);  // دریافت استک 1 از سشن

        if ($this->isFull($stack1)) {
            $message = 'صف پر است';
            return view('stack', ['queue' => $stack1, 'message' => $message]);
        }

        // افزودن مقدار به انتهای صف (اضافه کردن به stack1)
        $this->pushToStack($stack1, $item);  // استفاده از متد اختصاصی pushToStack
        session()->put('stack1', $stack1);  // ذخیره stack1 در سشن

        $message = 'مقدار به صف اضافه شد';
        return view('stack', ['queue' => $stack1, 'message' => $message]);
    }

    // متد Dequeue برای صف
    public function dequeue()
    {
        $stack1 = session('stack1', []);  // دریافت استک 1 از سشن
        $stack2 = session('stack2', []);  // دریافت استک 2 از سشن

        // اگر هر دو استک خالی باشند، صف خالی است
        if ($this->isEmpty($stack1) && $this->isEmpty($stack2)) {
            $message = 'صف خالی است';
            return view('stack', ['queue' => [], 'message' => $message]);
        }

        // اگر stack2 خالی است، باید عناصر stack1 را به stack2 منتقل کنیم
        if ($this->isEmpty($stack2)) {
            while (!$this->isEmpty($stack1)) {
                $item = $this->popFromStack($stack1);  // حذف از stack1 با استفاده از popFromStack
                $this->pushToStack($stack2, $item);    // افزودن به stack2 با استفاده از pushToStack
            }
            session()->put('stack1', $stack1);  // به‌روزرسانی stack1 در سشن
            session()->put('stack2', $stack2);  // به‌روزرسانی stack2 در سشن
        }

        // حذف مقدار از بالای stack2 که معادل اولین مقدار در صف است
        $item = $this->popFromStack($stack2);  // حذف از stack2 با استفاده از popFromStack
        session()->put('stack2', $stack2);  // به‌روزرسانی stack2 در سشن

        // صف نهایی شامل عناصر باقی‌مانده از stack2 است که به عنوان صف عمل می‌کند
        $queue = $stack2;

        // نمایش پیام و صف
        $message = 'مقدار حذف شد: ' . $item;
        return view('stack', ['queue' => $queue, 'message' => $message]);
    }


    private function isEmpty($array)
    {
        foreach ($array as $item) {
            return false;
        }
        return true;
    }

    private function isFull($array)
    {
        $currentSize = 0;

        foreach ($array as $item) {
            $currentSize++;
        }

        return $currentSize >= $this->size;
    }


    // نمایش استک
    public function displayStack()
    {
        $stack = session('stack');
        return view('stack', ['stack' => $stack]);
    }

    // نمایش صف
    public function displayQueue()
    {
        $queue = session('queue');
        return view('stack', ['queue' => $queue]);
    }

    private function pushToStack(&$stack, $item)
    {
        $newStack = [];

        // کپی عناصر قبلی استک به استک جدید
        foreach ($stack as $value) {
            $newStack[] = $value;
        }

        // افزودن آیتم جدید به انتهای استک
        $newStack[] = $item;

        // به‌روزرسانی استک با مقادیر جدید
        $stack = $newStack;
    }

    private function popFromStack(&$stack)
    {
        // اگر استک خالی باشد، مقدار null برگردان
        if ($this->isEmpty($stack)) {
            return null;
        }

        // دریافت اندیس آخرین عنصر
        $lastIndex = $this->getLastIndex($stack);

        // آیتم آخرین عنصر را دریافت کن
        $item = $stack[$lastIndex];

        // ایجاد استک جدید بدون آخرین عنصر
        $newStack = [];
        foreach ($stack as $index => $value) {
            if ($index !== $lastIndex) {
                $newStack[] = $value;
            }
        }

        // به‌روزرسانی استک
        $stack = $newStack;

        return $item;  // مقدار حذف شده را برگردان
    }


}
