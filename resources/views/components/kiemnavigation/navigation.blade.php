<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <svg  height="80px" xmlns="http://www.w3.org/2000/svg" class="logo" viewBox="0 0 442 315">
        <path d="M397.274 252.196h27.157v-90.131h17.077v-28.83h-61.302v28.83h17.078v90.131h-.01Zm-93.776 0h27.849V206.29h9.94v45.906h27.998V133.225h-27.998v46.748h-9.94v-46.748h-27.849v118.971Zm-43.664 1.672h1.401c31.352 0 31.352-25.756 31.352-39.47V196.63H266.13v16.517c0 9.099-.56 11.902-4.474 11.902h-1.402c-3.503 0-3.924-3.083-3.924-12.183v-40.311c0-9.099.561-12.312 3.924-12.312h1.262c4.064 0 4.624 2.803 4.624 12.032v15.256h26.447v-16.657c0-13.714-.14-39.47-31.352-39.47h-1.401c-30.371 0-30.511 26.737-30.511 39.47v43.524c0 12.743 0 39.47 30.511 39.47Zm-77.819-46.738.28-.7c.28-.421.421-1.402.421-1.962l2.802-29.53c.421-2.933.561-7.418.561-9.8h1.121c0 2.102.14 6.857.561 9.8l2.943 29.53c0 .56.14 1.541.28 1.962l.42.7-.7.561-.421-.14c-.56-.28-.981-.421-1.681-.421h-3.924c-.701 0-1.122.141-1.682.421l-.421.14-.56-.561Zm-33.865 45.066h27.148l3.504-20.571h15.676l3.353 20.571h27.438l-20.011-118.971h-37.087L148.15 252.196Zm-43.954-67.598v-22.533h5.035c5.175 0 5.455 3.924 5.455 5.035v12.733c0 1.261-.42 4.755-5.315 4.755h-5.175v.01Zm-26.867 67.598h26.867v-41.292h3.924c4.615 0 5.035 6.577 5.035 6.857v34.435h28.129c-.281-6.016-.701-26.036-.701-33.314 0-10.64-5.876-19.039-12.873-19.039v-1.121c8.398 0 15.115-13.013 15.115-21.272v-13.573c0-25.196-18.058-30.652-33.174-30.652H77.319v118.971h.01Zm-77.329 0h26.867v-28.689c0-3.924-.98-9.8-1.401-12.593l1.121-.14c.42 2.663 1.542 7.838 2.663 10.921l8.678 30.511h31.913l-22.112-59.62 20.99-59.341H37.229l-8.259 31.633c-.7 2.102-1.962 8.258-2.382 10.36l-1.121-.14c.56-3.073 1.401-10.22 1.401-13.294v-28.549H0v118.941ZM180.964 118.971h25.476l-.14-38.91c0-3.924-.421-12.733-.981-16.797l1.121-.14c.28 2.102.841 6.857 1.401 9.66l5.456 32.893h18.759l5.175-31.211c.701-3.224 1.401-8.82 1.682-11.342l1.121.14c-.421 3.774-.981 11.202-.981 15.956l-.14 39.751h25.476V0h-34.576l-5.035 34.425c-.7 4.475-1.681 16.377-1.681 19.88h-1.122c0-3.363-.56-15.395-1.401-19.88L215.539 0h-34.565v118.971h-.01Zm-63.545 0h51.222v-28.83h-24.354V72.645h24.354V46.187h-24.354V28.829h24.354V0h-51.222v118.971Zm-40.16 0h27.848V0H77.258v118.971Zm-77.259 0h26.867v-28.69c0-3.923-.98-9.8-1.401-12.592l1.121-.14c.42 2.662 1.542 7.838 2.663 10.92l8.678 30.512h31.913l-22.112-59.62L68.718.02H37.229l-8.259 31.632c-.7 2.102-1.962 8.258-2.382 10.36l-1.121-.14c.56-3.073 1.401-10.22 1.401-13.293V0H0v118.971ZM91.153 315c13.634 0 24.244-10.611 24.244-24.245 0-12.883-10.61-24.244-24.244-24.244-13.384 0-24.245 10.861-24.245 24.244C66.908 304.139 77.77 315 91.153 315Z"></path>
      </svg>
      </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <x-kiemnavigation.nav-link :route="url('/')" :label="__('Home')" :active="request()->is('/')" />
        <x-kiemnavigation.nav-link :route="route('customers.create')" :label="__('Ticketten Toevoegen')" :active="request()->routeIs('customers.create')" />
        @if (auth()->check())
        <x-kiemnavigation.nav-link :route="route('customers.tickets')" :label="__('Overzicht Ticketten')" :active="request()->routeIs('customers.tickets')" />
        @endif
      </ul>
      @if (auth()->check())
      <form method="POST" class="d-flex" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-success" type="submit">Uitloggen</button>
      </form>
      @else
        <a href="{{ route('login') }}" class="btn btn-success">Inloggen</a>
      @endif
    </div>
  </div>
</nav>