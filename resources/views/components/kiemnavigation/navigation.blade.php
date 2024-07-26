<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">{{ config('app.name') }}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <x-kiemnavigation.nav-link :route="url('/')" :label="__('Home')" :active="request()->is('/')" />
        <x-kiemnavigation.nav-link :route="route('dashboard')" :label="__('Dashboard')" :active="request()->routeIs('dashboard')" />
        <x-kiemnavigation.nav-link :route="route('customers.create')" :label="__('Add a Ticket')" :active="request()->routeIs('customers.create')" />
      </ul>
    </div>
  </div>
</nav>