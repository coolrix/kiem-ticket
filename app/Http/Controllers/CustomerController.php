<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
class CustomerController extends Controller
{
    private $cust;

    /**
     * Constructor voor de class.
     *
     * Initialiseert een nieuwe instantie van de class en creëert een nieuw Customer object.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cust = new Customer();
    }
    /**
     * Haalt alle klanten op en retourneert de view voor het weergeven van de klanten.
     *
     * @return \Illuminate\Contracts\View\View De view voor het weergeven van klanten.
     */
    public function index()
    {
        $customers = $this->cust->getCustomers();
        return view('customers.index', compact('customers'));
    }

    /**
     * Maakt een nieuw view aan voor het aanmaken van een klant.
     *
     * @return \Illuminate\Contracts\View\View De view voor het aanmaken van een klant.
     */
    public function create()
    {
        return view('customers.create');
    }


    /**
     * Slaat een nieuwe klant op in de database met een bijgevoegde afbeelding.
     *
     * @param Request $request Het HTTP request object dat de klantgegevens en de afbeeldingsbestand bevat.
     * @return \Illuminate\Http\RedirectResponse Redirect terug naar de customer creation met een succesbericht en een preview van de bijgevoegde afbeelding.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'images' => 'required|file|mimes:png,jpg,pdf|max:2048'
        ]);

       $uid =  uniqid();

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $filename = $uid . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('tickets', $image, $filename);
        }

        $validatedData['images'] = $filename;

        $customer = $this->cust->createCustomer($validatedData);
        return redirect()
            ->route('customers.create')           
            ->with('success', 'Ticket created successfully.<br> Add another one.');
    }

    
    /**
     * Werk een klant in de database bij met een bijgevoegde afbeelding of PDF.
     *
     * @param Request $request Het HTTP request object dat de klantgegevens en de afbeeldingsbestand of PDF bevat.
     * @return \Illuminate\Http\RedirectResponse Redirect naar de pagina customer tickets met een succesbericht en een preview van de bijgewerkte afbeelding of PDF.
     */
    public function update(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'images' => 'file|mimes:png,jpg,pdf|max:2048'
        ]);
        $success = 'Ticket updated successfully.';
        $script = 'const index = table.getData().findIndex(record => record.id === ' . $validatedData['id'] . ');
            const page = Math.ceil((index + 1) / table.getPageSize());
            console.log(index, page);
            table.setPage(page);';
        if ($request->hasFile('images')) {
            $uid =  uniqid();

            $old_uid =  $this->cust->getCustomerById($validatedData['id'])->images;
            Storage::disk('local')->delete('tickets/' . $old_uid);

            $image = $request->file('images');
            $filename = $uid . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('tickets', $image, $filename);
            $validatedData['images'] = $filename;
        }
        else
        {
            unset($validatedData['images']);
        }
        $customer = $this->cust->updateCustomer($validatedData, $validatedData['id']);
        return redirect()
            ->route('customers.tickets')
            ->with('success', $success)
            ->with('script', $script);
    }



    /**
     * Haalt een afbeelding of een PDF op uit het 'tickets'-folder en retourneert deze als een base64-gecodeerde tekenreeks
     * of als een PDF.
     *
     * @param string $image De naam van het afbeeldingsbestand of PDF
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException Als het afbeeldingsbestand of PDF niet bestaat.
     * @return \Illuminate\Http\Response De HTTP-respons met de base64-gecodeerde afbeelding of PDF.
     */
    public function images($image)
    {
        if (Auth::check()) {
            if(Storage::disk('tickets')->exists($image)) {
            $filePath = 'tickets/'.$image;
            $contentType = Storage::disk('tickets')->mimeType($image);
            $fileContent = Storage::get($filePath);
            if (strpos($contentType, 'pdf') !== false) {
                header('Content-Type: ' . $contentType);
                header('Content-Length: ' . strlen($fileContent));
                header('Content-Disposition: inline; filename="' . $image . '"');
                echo $fileContent;
            } else
            {
                $base64Content = base64_encode($fileContent);
                header('Content-Type: ' . $contentType); 
                header('Content-Length: ' . strlen(base64_decode($base64Content)));
                header('Content-Disposition: inline; filename="' . $image . '"');             
                echo base64_decode($base64Content);
            }
            }
            else
            {
                return response()->json(['message' => 'File not found'], 404);
            }
        }
        else
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
    /**
     * Haalt een afbeelding op uit het 'tickets'-folder en retourneert deze als een base64-gecodeerde tekenreeks.
     *
     * @param string $image De naam van het afbeeldingsbestand.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException Als het afbeeldingsbestand niet bestaat.
     * @return \Illuminate\Http\JsonResponse De HTTP-respons met de base64-gecodeerde afbeelding als een data URI, of een JSON-respons met een 'message'-key die aangeeft dat het bestand niet gevonden is of de gebruiker niet geautoriseerd is.
     */
    public function images2($image)
    {
        if (Auth::check()) {
            if(Storage::disk('tickets')->exists($image)) {
                $filePath = 'tickets/'.$image;
                $fileContent = Storage::get($filePath);
                $base64Content = base64_encode($fileContent);
                $contentType = Storage::disk('tickets')->mimeType($image);
                
                // Return the base64-encoded image as a data URI
                return "data:$contentType;base64,$base64Content";
            } else {
                return response()->json(['message' => 'File not found'], 404);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
    
    /**
     * Haalt alle tickets op uit de database en rendert de view 'customers.tickets' met de lijst van tickets.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View De gerenderde view met de lijst van tickets.
     */
    public function tickets()
    {
        $tickets = $this->cust->getCustomers();
        return view('customers.tickets', compact('tickets'));
    }
}