<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

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
            'image' => 'required|file|mimes:png,jpg,pdf|max:2048'
        ]);

        unset($validatedData['image']);
        
        $customer = $this->cust->createCustomer($validatedData);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $customer->id . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $filename);
        }

        return redirect()
            ->route('customers.create')
            ->with('success', 'Ticket created successfully. Add another one');
    }
}
