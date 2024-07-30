<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add a new ticket') }}
        </h2>
    </x-slot>    
    @if (session('success'))
        <div class="alert alert-success input-width-40 d-flex align-items-center justify-content-center text-center">
    
        <strong class="h4 mt-2 mb-2"> {!! session('success') !!} </strong>
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
        <input type="text" class="form-control input-width-40" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control input-width-40" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="images">Image:</label>
        <input type="file" class="form-control input-width-40" id="images" name="images">            
        @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <button type="submit" class="btn btn-success mt-4">Create Customer</button>
</form>
</x-app-layout>