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

var rowUpdater = function (e, row, onRendered) {
  var container = document.createElement("div");
  container.classList.add("popup-update-container", "form-group");
  var data = row.getData();

  var form = document.createElement("form");
  form.setAttribute("enctype", "multipart/form-data");
  form.addEventListener("submit", function(event) {
        event.preventDefault(); 

        // Get the uploaded file
        const file = document.getElementById("images").files[0];

        // Create a new FormData object
        const formData = new FormData();
        formData.append("images", file);

        updatedData = {id: data.id, name: document.getElementById("name").value, email: document.getElementById("email").value, images: formData};
        // Update the data with the uploaded file
        table.updateData([updatedData])
            .then(function(){
            // Run code after data has been updated
            })
            .catch(function(error){
            // Handle error updating data
            });
    });

  var nameLabel = document.createElement("label");
  nameLabel.textContent = "Name";
  nameLabel.classList.add("mt-2","fw-bold");
  var nameInput = document.createElement("input");
  nameInput.type = "text";
  nameInput.name = "name";
  nameInput.id = "name";
  nameInput.value = data.name; // Set the initial value
  nameInput.classList.add("form-control", "mt-2");
  nameInput.required = true;

  var emailLabel = document.createElement("label");
  emailLabel.textContent = "Email";
  emailLabel.classList.add("mt-2","fw-bold");
  var emailInput = document.createElement("input");
  emailInput.type = "email";
  emailInput.name = "email";
  emailInput.id = "email";
  emailInput.value = data.email; // Set the initial value
  emailInput.classList.add("form-control", "mt-2");
  emailInput.required = true;

  var fileLabel = document.createElement("label");
  fileLabel.textContent = "Afbeelding";
  fileLabel.classList.add("mt-2","fw-bold");
  var fileInput = document.createElement("input");
  fileInput.type = "file";
  fileInput.name = "images";
  fileInput.id = "images";
  fileInput.classList.add("form-control", "mt-2");

  // Create a separate form-group for each group of label and input elements
  var nameFormGroup = document.createElement("div");
  nameFormGroup.classList.add("form-group");
  nameFormGroup.appendChild(nameLabel);
  nameFormGroup.appendChild(nameInput);
  form.appendChild(nameFormGroup);

  var emailFormGroup = document.createElement("div");
  emailFormGroup.classList.add("form-group");
  emailFormGroup.appendChild(emailLabel);
  emailFormGroup.appendChild(emailInput);
  form.appendChild(emailFormGroup);

  var fileFormGroup = document.createElement("div");
  fileFormGroup.classList.add("form-group");
  fileFormGroup.appendChild(fileLabel);
  fileFormGroup.appendChild(fileInput);
  form.appendChild(fileFormGroup);

  var submitButton = document.createElement("button");
  submitButton.type = "submit";
  submitButton.textContent = "Update";
  submitButton.classList.add("btn", "btn-success", "mt-2");
  form.appendChild(submitButton);

  container.appendChild(form);
  return container;
};
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
  });

  /*table.updateData([{id:1, name:"bob"}])
    .then(function(){
    
    })
    .catch(function(error){
    
    });*/
</script>
</x-app-layout>