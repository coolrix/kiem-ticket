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
     * Constructor for the class.
     *
     * Initializes a new instance of the class and creates a new Customer object.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cust = new Customer();
    }
    public function index()
    {
        $customers = $this->cust->getCustomers();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store the validated form data and create a new customer.
     *
     * the function retrieves the stored file from the tickets directory, 
     * encodes it as a base64 string, and constructs a success message with
     * the base64-encoded image.
     * 
     * @param Request $request The HTTP request object containing the form data.
     * @throws \Illuminate\Validation\ValidationException If the form data fails validation.
     * @return \Illuminate\Http\RedirectResponse The redirect response to the create customer page with a success message and a base64-encoded image.
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

        $filePath = 'tickets/'.$filename;
        $fileContent = Storage::get($filePath);
        $base64Content = base64_encode($fileContent);
        $contentType = Storage::disk('tickets')->mimeType($filename);

        return redirect()
            ->route('customers.create')
            ->with('success', 'Ticket created successfully.<br><img class="mt-2 mb-2" style="height:150px;" src="data:'.$contentType.';base64,'.$base64Content.'" alt="Base64 Image"><br> Add another one.');
    }

    
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
            $uid =  $this->cust->getCustomerById($validatedData['id'])->images;
            $image = $request->file('images');
            $filename = $uid;
            Storage::disk('local')->putFileAs('tickets', $image, $filename);
            $validatedData['images'] = $filename;

            $filePath = 'tickets/'.$filename;
            $fileContent = Storage::get($filePath);
            $base64Content = base64_encode($fileContent);
            $contentType = Storage::disk('tickets')->mimeType($filename);
            $success = 'Ticket updated successfully.<br><img class="mt-2 mb-2" style="height:150px;" src="data:'.$contentType.';base64,'.$base64Content.'" alt="Base64 Image">';            
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

        //return response()->json(['success' =>  $success]);
    }


    /**
     * Retrieves an image from the 'tickets' disk and returns it as a base64-encoded string.
     *
     * @param string $image The name of the image file.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException If the image file does not exist.
     * @return \Illuminate\Http\Response The HTTP response containing the base64-encoded image.
     */
    public function images($image)
    {
        if (Auth::check()) {
            if(Storage::disk('tickets')->exists($image)) {
            $filePath = 'tickets/'.$image;
            $fileContent = Storage::get($filePath);
            $base64Content = base64_encode($fileContent);
            $contentType = Storage::disk('tickets')->mimeType($image);
            header('Content-Type: ' . $contentType); 
            header('Content-Length: ' . strlen(base64_decode($base64Content)));
            header('Content-Disposition: inline; filename="' . $image . '"');             
            echo base64_decode($base64Content);
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
    
    public function tickets()
    {
        $tickets = $this->cust->getCustomers();
        return view('customers.tickets', compact('tickets'));
    }
}