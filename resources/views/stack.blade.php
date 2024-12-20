<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت استک و صف</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">مدیریت استک و صف</h1>

    @if (isset($message))
        <div class="alert alert-info text-center">{{ $message }}</div>
    @endif

    <!-- فرم استک -->
    <div class="row">
        <div class="col-md-6">
            <h3>استک</h3>
            <form action="{{ route('stack.push') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="item" class="form-label">مقدار جدید</label>
                    <input type="text" class="form-control" id="item" name="item" required>
                </div>
                <button type="submit" class="btn btn-success w-100">افزودن به استک</button>
            </form>

            <form action="{{ route('stack.pop') }}" method="post" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-danger w-100">حذف از استک</button>
            </form>
            <form action="{{ route('stack.peek') }}" method="post" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-primary w-100">نمایش عنصر اخر استک</button>
            </form>

            <h4 class="mt-4">نمایش استک</h4>
            @if (!empty($stack) && count($stack) > 0)
                <ul class="list-group">
                    @foreach ($stack as $item)
                        <li class="list-group-item">{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-secondary text-center">استک خالی است.</div>
            @endif
        </div>

        <!-- فرم صف -->
        <div class="col-md-6">
            <h3>صف</h3>
            <form action="{{ route('queue.stack.enqueue') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="queueItem" class="form-label">مقدار جدید</label>
                    <input type="text" class="form-control" id="queueItem" name="item" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">افزودن به صف</button>
            </form>

            <form action="{{ route('queue.stack.dequeue') }}" method="post" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-warning w-100">حذف از صف</button>
            </form>

            <h4 class="mt-4">نمایش صف</h4>
            @if (!empty($queue) && count($queue) > 0)
                <ul class="list-group">
                    @foreach ($queue as $item)
                        <li class="list-group-item">{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-secondary text-center">صف خالی است.</div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
