<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'images'];

    public function createCustomer($data)
    {
        return self::create($data);
    }

    public function getCustomers()
    {
        return self::all();
    }

    public function getCustomerById($id)
    {
        return self::find($id);
    }

    public function updateCustomer($data, $id)
    {
        return self::where('id', $id)->update($data);
    }

    public function deleteCustomer($id)
    {
        return self::where('id', $id)->delete();
    }   

    public function getCustomersByEmail($email)
    {
        return self::where('email', $email)->get();
    }  

    public function getCustomersByName($name)
    {
        return self::where('name', $name)->get();
    }   
}
