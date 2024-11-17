<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListController extends Controller
{

    public function insert(Request $request)
    {
        $list = json_decode($request->input('list'));
        $index = $request->input('index');
        $value = $request->input('value');
        if ($index < 0 || $index > count($list)) {
            $message='اندیس نامعتبر است';
            return view('list',compact('list','message'));
        }

        $newList = [];
        $inserted = false;

        foreach ($list as $key => $item) {
            if ($key == $index && !$inserted) {
                $newList[] = $value;
                $inserted = true;
            }
            $newList[] = $item;
        }

        if (!$inserted) {

            $newList[] = $value;
        }

        return view('list', ['list' => $newList]);
    }


    public function deleteByValue(Request $request)
    {
        $list = json_decode($request->input('list'));
        $value = $request->input('value');
        $newList = [];

        foreach ($list as $item) {
            if ($item != $value) {
                $newList[] = $item;
            }
        }

        return view('list', ['list' => $newList]);
    }


    public function deleteByIndex(Request $request)
    {
        $list = json_decode($request->input('list'));
        $index = $request->input('index');
        $newList = [];

        // Manually remove item by index
        foreach ($list as $key => $item) {
            if ($key != $index) {
                $newList[] = $item;
            }
        }

        return view('list', ['list' => $newList]);
    }


    public function display()
    {
        $list = [];
        return view('list', ['list' => $list]);
    }


    public function append(Request $request)
    {
        $list = json_decode($request->input('list'));
        $value = $request->input('value');


        $list[] = $value;

        return view('list', ['list' => $list]);
    }


    public function reverse(Request $request)
    {
        $list = json_decode($request->input('list'));
        $newList = [];


        for ($i = count($list) - 1; $i >= 0; $i--) {
            $newList[] = $list[$i];
        }

        return view('list', ['list' => $newList]);
    }


    public function searchByValue(Request $request)
    {
        $list = json_decode($request->input('list'));
        $value = $request->input('value');
        $index = -1;


        foreach ($list as $key => $item) {
            if ($item == $value) {
                $index = $key;
                break;
            }
        }

        if ($index != -1) {
            return  view('list',compact('list'))->with('message', "مقدار یافت شد در اندیس: $index");
        }

        return  view('list',compact('list'))->with('message', 'مقدار یافت نشد');
    }
}
