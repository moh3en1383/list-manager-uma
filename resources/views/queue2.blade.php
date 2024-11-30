<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت صف ساده</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">مدیریت صف ساده</h1>

    <!-- نمایش پیام‌ها -->
    @if (isset($message))
        <div class="alert alert-info text-center">{{ $message }}</div>
    @endif

    <div class="row">
        <!-- افزودن به صف -->
        <div class="col-md-6">
            <form action="{{ route('simplequeue.enqueue') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="value" class="form-label">مقدار جدید</label>
                    <input type="text" class="form-control" id="value" name="value" required>
                </div>
                <button type="submit" class="btn btn-success w-100">افزودن به صف</button>
            </form>
        </div>

        <!-- حذف از صف -->
        <div class="col-md-6">
            <form action="{{ route('simplequeue.dequeue') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger w-100 mt-4">حذف از صف</button>
            </form>
        </div>
    </div>

    <div class="row mt-4">
        <!-- مشاهده مقدار ابتدای صف -->
        <div class="col-md-6">
            <form action="{{ route('simplequeue.peek') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-info w-100">مشاهده مقدار ابتدای صف</button>
            </form>
        </div>

        <!-- معکوس کردن صف -->
        <div class="col-md-6">
            <form action="{{ route('simplequeue.reverse') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-warning w-100">معکوس کردن صف</button>
            </form>
        </div>
    </div>

    <!-- دکمه ریستارت صف -->
    <div class="row mt-4">
        <div class="col-md-12">
            <form action="{{ route('simplequeue.reset') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger w-100">ریستارت صف</button>
            </form>
        </div>
    </div>

    <!-- نمایش صف -->
    <div class="mt-5">
        <h2>نمایش صف</h2>
        @if(!empty($queue) && count(array_filter($queue, fn($item) => $item !== null)) > 0)
            <ul class="list-group">
                @foreach ($queue as $item)
                    @if ($item !== null)
                        <li class="list-group-item">{{ $item }}</li>
                    @else
                        <li class="list-group-item text-muted">خالی</li>
                    @endif
                @endforeach
            </ul>
        @else
            <div class="alert alert-secondary text-center">صف خالی است.</div>
        @endif
    </div>
</div>

<!-- اضافه کردن بوت‌استرپ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
