<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">  
        {{ __('Overview Tickets') }}
    </h2>
</x-slot> 
<script src="{{ asset('js/luxon.js') }}"></script> 
<link rel="stylesheet" href="{{ asset('css/tabulator.min.css') }}">
<script src="{{ asset('js/tabulator.min.js') }}"></script>   

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
  var imgContent = 'Hallo';
  var imgC = '';
 /*const directoryPath = './images/products/' + data.id;
  fs.readdir(directoryPath, (err, files) => {
    if (err) {
      console.error(err);
    }
    else {
      const imagePaths = files.filter(file => {
        const fileExtension = file.split('.').pop();
        return ['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension.toLowerCase());
      });

      imagePaths.forEach(path => {
        imgC = `${directoryPath}/${path}`;
        console.log(imgC);
        if (!imgContent.includes(imgC)) {
          imgContent += "<image class='row-popup-image' src='" + imgC + "'/>";
        }  
      });*/
      container.innerHTML += imgContent;
      console.log(imgContent);
    
  //});

  contents = "<ul class='row-popup ml-2'>";
  contents += "<li><strong>Naam:</strong> " + data.name + "</li>";
  contents += "<li><strong>E-mail:</strong> " + data.email + "</li>";
  contents += "<li><strong>Afbeelding:</strong> " + data.images + "</li>";
  contents += "<li><img class='mt-4' style='height:300px;' src='http://127.0.0.1:8000/images/tickets/" + data.images + "' alt='Image'></li>";
  contents += "</ul>";
///images/tickets2/{image}
  container.innerHTML = contents;

  return container;
}
var tabledata = {!! json_encode($tickets) !!};
var table = new Tabulator("#tickets-table", {
    data: tabledata,
    layout: "fitColumns",
    height: "600px",
    selectableRange:1, //allow only one range at a time
    //selectableRangeColumns:true,
    //selectableRangeRows:true,
    selectableRangeClearCells:true,
    placeholderHeaderFilter: "Geen data gevonden",
    pagination: true, //enable.
    paginationSize: 10,
    paginationSizeSelector: [10, 25, 50, 100, true],
    printAsHtml:true,
    printHeader:"<h1>Kiemkracht Tickets<h1>",
    footerElement:"<button id='print-table' class='btn btn-success'>Afdrukken</button>&nbsp;&nbsp;<button class='btn btn-success' id='print-all-table'>Alles Afdrukken</button>",
    rowDblClickPopup: rowPopupFormatter,
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
  });
</script>
</x-app-layout>