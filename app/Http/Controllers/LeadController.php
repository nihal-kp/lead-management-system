<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DataTables $datatables)
    {
        if($request->ajax()){
        
            $query = Lead::select('leads.*')->where('status', 1)->orderBy('id','DESC');
     
            return $datatables->eloquent($query)
           ->make(true);
        }

        return view('leads.index');
    }
}
