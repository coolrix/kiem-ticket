<x-app-layout>
<x-kiemnavigation.header :title="__('Ticketten toevoegen')" />
    @if (session('success'))
        <div id="idSuc" class="alert alert-success input-width-40 d-flex align-items-center justify-content-center text-center">    
        <strong class="h4 mt-2 mb-2"> {!! session('success') !!} </strong>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById("idSuc").remove();
            }, 2500);
        </script>
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
        <label class="fw-bold" for="name">Naam:</label>
        <input type="text" class="form-control input-width-40" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label class="fw-bold" for="email">E-mail:</label>
        <input type="email" class="form-control input-width-40" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label class="fw-bold" for="images">Kassaticket:</label>
        <input type="file" class="form-control input-width-40" id="images" name="images" required>            
        @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <button type="submit" class="btn btn-success mt-4">Aanmaken</button>
</form>
</x-app-layout>