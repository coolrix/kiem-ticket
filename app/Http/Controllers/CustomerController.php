<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::getCustomers();
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
        'phone' => 'required',
        // Add more validation rules as needed
    ]);

    // Create a new customer record
    $customer = Customer::createCustomer($validatedData);

    // Redirect to the index page with a success message
    return redirect()
        ->route('customers.create')
        ->with('success', 'Ticket created successfully. Add another one');
}
}
