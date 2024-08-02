<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">  
        {{ __('Overzicht Ticketten') }}
    </h2>
</x-slot> 
<script src="{{ asset('js/luxon.js') }}"></script> 
<link rel="stylesheet" href="{{ asset('css/tabulator.min.css') }}">
<script src="{{ asset('js/tabulator.min.js') }}"></script>   
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
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
<div id="tickets-table"></div>

<script>
function formatDate(value, data, type, params, component) {
  const date = new Date(value);
  const formattedDate = date.toLocaleDateString('nl-BE', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  });

    return formattedDate;
}  

var rowPopupFormatter = function (e, row, onRendered) {
  var container = document.createElement("div");
  container.classList.add("popup-container");
  var data = row.getData();
  contents = `<ul class='row-popup ml-2'>
  <li><strong>Naam:</strong> ${data.name}</li>
  <li><strong>E-mail:</strong> ${data.email}</li>
  <li><strong>Afbeelding:</strong> ${data.images}</li>`;
  s = '';
  if (data.images.includes('.pdf')) {
    s = `<li><iframe src='{{ url('/') }}/images/tickets/${data.images}' width='100%' height='300px'></iframe></li>
    </ul>`;  
  }
  else {
    s = `<li><img class='mt-4' style='height:300px;' src='{{ url('/') }}/images/tickets/${data.images}' alt='Image'></li>
     </ul>`;  
  }
  
 
  container.innerHTML = contents + s;

  return container;
}

var rowUpdater = function (e, row, onRendered) {
  var container = document.createElement("div");
  
  var data = row.getData();
  var updatedData = {};  
  


content = `<form method="POST" action="{{ route('customers.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" class="form-control" id="id" name="id" value="${data.id}" required>
    <div class="form-group">
        <label for="name">Naam:</label>
        <input type="text" class="form-control" id="name" name="name" value="${data.name}" required>
    </div>

    <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" class="form-control" id="email" name="email" value="${data.email}" required>
    </div>

    <div class="form-group">
        <label for="images">Afbeelding:</label>
        <input type="file" class="form-control" id="images" name="images">            
        @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success mt-4">Aanpassen</button>
</form>`;

  container.innerHTML = content;
  return container;
};
var tabledata = {!! json_encode($tickets) !!};
var table = new Tabulator("#tickets-table", {
    data: tabledata,
    layout: "fitColumns",
    height: "600px",
    selectableRange:1, 
    selectableRangeClearCells:true,
    placeholderHeaderFilter: "Geen data gevonden",
    pagination: true,
    paginationSize: 10,
    paginationSizeSelector: [10, 25, 50, 100, true],
    printAsHtml:true,
    printHeader:"<h1>Kiemkracht Tickets<h1>",
    footerElement:"<button id='print-table' class='btn btn-success'>Afdrukken</button>&nbsp;&nbsp;<button class='btn btn-success' id='print-all-table'>Alles Afdrukken</button>",
    rowDblClickPopup: rowPopupFormatter,
    rowContextPopup: rowUpdater,
    columns:[
    {title:"Naam", field:"name",resizable: true, headerFilter: "input"},
    {title:"E-mail", field:"email",resizable: true, headerFilter: "input"},
    {title:"Afbeelding", field:"images",resizable: true, headerFilter: "input"},
    {title:"Datum", field:"created_at",resizable: true, headerFilter: "input", mutator: formatDate},
    ],
});
table.on("tableBuilt", function(){
    document.getElementById("print-table").addEventListener("click", function(){
      table.print(false, true);
    });
    document.getElementById("print-all-table").addEventListener("click", function(){
      table.print("all", true);
    });
    {!! session('script') !!}
  });
</script>
</x-app-layout>