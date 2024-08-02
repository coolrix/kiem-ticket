<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'images'];

    /**
     * Maak een nieuw customer record aan in de database.
     *
     * @param array $data De gegevens die moeten worden opgeslagen in de customer tabel.
     * @return \Illuminate\Database\Eloquent\Model Het zojuist gemaakte customer record.
     */
    public function createCustomer($data)
    {
        return self::create($data);
    }

    /**
     * Haalt alle customers op uit de database.
     *
     * @return \Illuminate\Database\Eloquent\Collection De collectie van alle customers.
     */
    public function getCustomers()
    {
        return self::all();
    }

    /**
     * Haalt een customer record op uit de database op basis van ID.
     *
     * @param int $id De ID van de customer record die opgehaald moet worden.
     * @return \Illuminate\Database\Eloquent\Model|null De customer record met de gegeven ID, of null als deze niet gevonden wordt.
     */
    public function getCustomerById($id)
    {
        return self::find($id);
    }

    /**
     * Update een customer record in de database.
     *
     * @param array $data De gegevens die moeten worden bijgewerkt in de customer tabel.
     * @param int $id De ID van de customerrecord die moet worden bijgewerkt.
     * @return bool Geeft true terug als de update succesvol was, anders false.
     */
    public function updateCustomer($data, $id)
    {
        return self::where('id', $id)->update($data);
    }

    /**
     * Verwijdert een customer record uit de database op basis van de ID.
     *
     * @param int $id De ID van de customer record die verwijderd moet worden.
     * @return int Het aantal verwijderde rijen.
     */
    public function deleteCustomer($id)
    {
        return self::where('id', $id)->delete();
    }   

    /**
     * Haalt een collectie customer records op uit de database op basis van de email adres.
     *
     * @param string $email Het email adres om naar te zoeken.
     * @return \Illuminate\Database\Eloquent\Collection Een collectie customer records met het gegeven email adres.
     */
    public function getCustomersByEmail($email)
    {
        return self::where('email', $email)->get();
    }  

    /**
     * Haalt een collectie customer records op uit de database op basis van de naam.
     *
     * @param string $name De naam om naar te zoeken.
     * @return \Illuminate\Database\Eloquent\Collection Een collectie customer records met de gegeven naam.
     */
    public function getCustomersByName($name)
    {
        return self::where('name', $name)->get();
    }   
}
