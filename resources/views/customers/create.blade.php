<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add a new ticket') }}
        </h2>
    </x-slot>    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

<form method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" class="form-control" id="image" name="image">            
        @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <button type="submit" class="btn btn-primary">Create Customer</button>
</form>
</x-app-layout>