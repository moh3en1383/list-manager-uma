<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operations on List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Operations on List</h1>

    @isset($message)
        <div class="alert alert-info">
            {{ $message }}
        </div>
    @endif

    @if(isset($list) && is_array($list))
        <h3>Current List:</h3>
        <pre>
        [
        @foreach($list as $key => $value)
                @if(is_array($value))
                    "{{ $key }}" => [
                    @foreach($value as $subKey => $subValue)
                        "{{ $subKey }}" => "{{ $subValue }}",
                    @endforeach
                    ],
                @else
                    "{{ $key }}" => "{{ $value }}",
                @endif
            @endforeach
        ]
    </pre>
    @else
        <h3>List is empty</h3>
    @endif


    <!-- Insert Form -->
    <form action="{{ route('list.insert') }}" method="POST">
        @csrf
        <input type="hidden" name="list" value="{{ json_encode($list) }}">
        <div class="mb-3">
            <label for="index" class="form-label">Index</label>
            <input type="number" class="form-control" id="index" name="index" required>
        </div>
        <div class="mb-3">
            <label for="value" class="form-label">Value</label>
            <input type="text" class="form-control" id="value" name="value" required>
        </div>
        <button type="submit" class="btn btn-primary">Insert</button>
    </form>

    <!-- Delete by Value Form -->
    <form action="{{ route('list.deleteByValue') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="list" value="{{ json_encode($list) }}">
        <div class="mb-3">
            <label for="value" class="form-label">Value to Delete</label>
            <input type="text" class="form-control" id="value" name="value" required>
        </div>
        <button type="submit" class="btn btn-danger">Delete by Value</button>
    </form>

    <!-- Delete by Index Form -->
    <form action="{{ route('list.deleteByIndex') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="list" value="{{ json_encode($list) }}">
        <div class="mb-3">
            <label for="index" class="form-label">Index to Delete</label>
            <input type="number" class="form-control" id="index" name="index" required>
        </div>
        <button type="submit" class="btn btn-danger">Delete by Index</button>
    </form>

    <!-- Append Form -->
    <form action="{{ route('list.append') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="list" value="{{ json_encode($list) }}">
        <div class="mb-3">
            <label for="value" class="form-label">Value to Append</label>
            <input type="text" class="form-control" id="value" name="value" required>
        </div>
        <button type="submit" class="btn btn-success">Append</button>
    </form>

    <!-- Reverse List Form -->
    <form action="{{ route('list.reverse') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="list" value="{{ json_encode($list) }}">
        <button type="submit" class="btn btn-secondary">Reverse List</button>
    </form>

    <!-- Search by Value Form -->
    <form action="{{ route('list.search') }}" method="POST" class="mt-10">
        @csrf
        <input type="hidden" name="list" value="{{ json_encode($list) }}">
        <div class="mb-3">
            <label for="value" class="form-label">Value to Search</label>
            <input type="text" class="form-control" id="value" name="value" required>
        </div>
        <button type="submit" class="btn btn-info">Search by Value</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
