<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerService
{
    /**
     * Create a new customer.
     *
     * @param  array  $data
     * @return \App\Models\Customer
     */
    public function createCustomer(array $data)
    {
        return Customer::create([
            'fullname' => $data['fullname'],
            'phonenumber' => $data['phonenumber'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Get a customer by ID or email.
     *
     * @param  mixed  $identifier
     * @return \App\Models\Customer
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getCustomerById($identifier)
    {
        if (is_numeric($identifier)) {
            return Customer::findOrFail($identifier);
        } else {
            return Customer::where('email', $identifier)->firstOrFail();
        }
    }

    /**
     * Get all customers.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCustomers()
    {
        return Customer::orderBy('id', 'desc')->get();
    }

    /**
     * Get the rewards status for a specific customer.
     *
     * @param  int  $id
     * @return \App\Models\Customer
     */
    public function getCustomerRewardsStatus(int $id)
    {
        return Customer::with(['points', 'redemptions.reward'])->findOrFail($id);
    }
}
