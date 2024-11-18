<?php

namespace App\Http\Controllers;

use App\Models\Import;
use App\Models\Lead;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Jobs\ProcessLeadsImportJob;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DataTables $datatables)
    {
        if($request->ajax()){
        
            $query = Import::select('imports.*')->orderBy('id','DESC');
     
            return $datatables->eloquent($query)
            ->editColumn('status', function (Import $import) {
                switch ($import->status) {
                    case 1:
                        return '<span class="label label-lg font-weight-bold label-light-primary label-inline">Ready to Import</span>';
                    case 2:
                        return '<span class="label label-lg font-weight-bold label-light-success label-inline">Success</span>';
                    case 3:
                        return '<span class="label label-lg font-weight-bold label-light-danger label-inline">Failure</span>';
                    default:
                        return '<span class="label label-lg label-light-warning label-inline">Processing</span>';
                }
            })
            
            ->addColumn('action', function (Import $import) {
                $buttons = '';
            
                if ($import->status == 1) {
                    $buttons .= '<a href="' . route('imports.verify', $import->id) . '" class="btn btn-sm btn-clean btn-icon" title="Verify"><i class="la la-edit"></i></a>';
                }
                elseif ($import->status == 3) {
                    $buttons .= '<a href="' . route('imports.errors', $import->id) . '" class="btn btn-sm btn-clean btn-icon" title="Errors"><i class="la la-exclamation"></i></a>';
                }
                $buttons .= '<a href="' . asset('uploads/imports/'.$import->file_name) . '" class="btn btn-sm btn-clean btn-icon" title="Download" download><i class="la la-download"></i></a>';
                return $buttons;
            })
           
           ->rawColumns(['status', 'action'])
           ->make(true);
        }
        return view('imports.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('imports.form')->with([
            'import'  => new Import(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'excel' => 'required|mimes:xlsx',
        ]);

        $file = $request->file('excel') ;
        $fileName = 'leads-'.time().'.'.$file->getClientOriginalExtension();
        $destinationPath = base_path().'/public/uploads/imports';
        $file->move($destinationPath,$fileName);

        $data = $request->all();
        $data['file_name'] = $fileName;
        $data['status'] = 0;

        $import = Import::create($data);

        ProcessLeadsImportJob::dispatch($fileName, $import->id);

        return redirect()->route('imports.index')->with('message', 'File uploaded successfully, processing in background.');
    }

    public function verify(Request $request, DataTables $datatables, $id)
    {
        if($request->ajax()){
        
            $query = Lead::query()->select('leads.*')->where('status', 0)->where('import_id', $id)->orderBy('id','DESC');
     
            return $datatables->eloquent($query)
            ->make(true);
        }

        return view('imports.verify')->with([
            'import' => Import::find($id),
        ]);
    }

    public function changeStatus(Request $request, $id)
    {
        $import = Import::findOrFail($id);
        $import->update(['status'=> 2]);
        Lead::where('import_id', $import->id)->update(['status'=> 1]);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function errors(Request $request, $id)
    {
        $import = Import::find($id);
        return view('imports.errors', compact('import'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Import $import)
    {
        //
    }
}
