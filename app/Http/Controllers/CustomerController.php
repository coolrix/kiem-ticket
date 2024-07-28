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
            $image->move(public_path('uploads'), $filename);
            //Storage::disk('tickets')->put($filename, file_get_contents($image));
            //$imageUrl = Storage::disk('tickets')->url($filename);

        }

        $validatedData['images'] = $filename;

        $customer = $this->cust->createCustomer($validatedData);

        return redirect()
            ->route('customers.create')
            ->with('success', 'Ticket created successfully. Add another one ('.$imageUrl.')');
    }
    public function images($image)
    {
        $path = "";
        $this->middleware('auth');
        if (Auth::check()) {
        if(Storage::disk('tickets')->exists($image)) {
        $filePath = 'tickets/'.$image;
        $path = storage_path($filePath);
        $fileContent = Storage::get($filePath);
        $base64Content = base64_encode($fileContent);
        $contentType = Storage::disk('tickets')->mimeType($image);
        header('Content-Type: ' . $contentType); 
        header('Content-Length: ' . strlen($base64Content));
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
}