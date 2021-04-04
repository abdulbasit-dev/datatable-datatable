<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getCustomers()
    {
        $query = Customer::select('first_name', 'last_name', 'email');
        return datatables($query)->make(true);
    }
}
