<?php

namespace App\Http\Controllers;

use DataTables;

use App\Customer;
// use App\Classes\SSP;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function data(Request $request)
    {

        // Database connection info
        $dbDetails = array(
            "host" => "localhost",
            "user" => "root",
            "pass" => "",
            "db" => "laravel_datatable"
        );

        // DB table to use
        $table = 'customers';

        // Table's primary key
        $primaryKey = "id";


        //// Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database.
        // The `dt` parameter represents the DataTables column identifier.
        $columns = [
            ['db' => "id", 'dt' => 0],
            ['db' => "first_name", 'dt' => 1],
            ['db' => "last_name", 'dt' => 2],
            ['db' => "email", 'dt' => 3],
            ['db' => "gender", 'dt' => 4]
        ];

        $searchFilter = array();
        if (!empty($_GET['search_keywords'])) {
            $searchFilter['search'] = array(
                'first_name' => $_GET['search_keywords'],
                'last_name' => $_GET['search_keywords'],
                'email' => $_GET['search_keywords'],
            );
        }


        if (!empty($_GET['filter_option'])) {
            $searchFilter['filter'] = array(
                'gender' => $_GET['filter_option']
            );
        }



        include(app_path() . '\ssp.class.php');

        echo json_encode(SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $searchFilter));
    }


    public function index()
    {
        $customers = Customer::all();
        $cities = $customers->unique('address');
        $genders = $customers->unique('gender');
        $maxSalary = Customer::max("salary");
        $minSalary = Customer::min("salary");

        return view("welcome", compact("customers", "maxSalary", "minSalary", "genders", "cities"));
    }

    public function getCustomers(Request $request)
    {

        $data = [];
        if ($request->gender != null  || $request->age != null || $request->minSalary != null || $request->maxSalary != null || $request->city != null) {
            $data = Customer::where("gender", $request->gender)->orWhere("age", $request->age)->orWhere("address", $request->city)
                ->orWhereBetween("salary", [$request->minSalary, $request->maxSalary])->get();
        } else if ($request->gender != null  && $request->age != null || $request->minSalary != null || $request->maxSalary != null || $request->city != null) {
            $data = Customer::where("age", $request->age)->where("address", $request->city)
                ->get();
        } else {
            $data = Customer::all();
        }

        return datatables($data)->make(true);
    }
}
