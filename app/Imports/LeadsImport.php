<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use App\Models\Lead;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Validator;

class LeadsImport implements ToCollection, WithStartRow, SkipsEmptyRows
{
    use Importable;

    protected $import;
    protected $validationErrors = [];
    protected $validRows = [];

    public function __construct($import)
    {
        $this->import = $import;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $columnNames = [
            0 => 'SI No',
            1 => 'First Name',
            2 => 'Last Name',
            3 => 'Email',
            4 => 'Mobile Number',
            5 => 'Street 1',
            6 => 'Street 2',
            7 => 'City',
            8 => 'State',
            9 => 'Country',
            10 => 'Lead Source',
        ];
        
        $messages = [
            '0.required' => 'The SI No field is required.',
            '0.numeric' => 'The SI No must be a number.',
            '1.required' => 'The First Name field is required.',
            '2.required' => 'The Last Name field is required.',
            '3.required' => 'The Email field is required.',
            '3.email' => 'The Email must be a valid email address.',
            '3.unique' => 'The Email has already been taken.',
            '4.required' => 'The Mobile Number field is required.',
            '4.digits' => 'The Mobile Number must be 10 digits.',
            '4.unique' => 'The Mobile Number has already been taken.',
            '5.required' => 'The Street 1 field is required.',
            '7.required' => 'The City field is required.',
            '8.required' => 'The State field is required.',
            '9.required' => 'The Country field is required.',
            '10.required' => 'The Lead Source field is required.',
        ];
        
        foreach ($rows as $row) 
        {
            $rowData = [
                'SI No' => $row[0],
                'First Name' => $row[1],
                'Last Name' => $row[2],
                'Email' => $row[3],
                'Mobile Number' => $row[4],
                'Street 1' => $row[5],
                'Street 2' => $row[6] ?? null,
                'City' => $row[7],
                'State' => $row[8],
                'Country' => $row[9],
                'Lead Source' => $row[10],
            ];
    
            $validator = Validator::make($rowData, [
                'SI No' => 'required|numeric',
                'First Name' => 'required|string',
                'Last Name' => 'required|string',
                'Email' => 'required|email|unique:leads,email',
                'Mobile Number' => 'required|digits:10|unique:leads,mobile_number',
                'Street 1' => 'required|string',
                'City' => 'required|string',
                'State' => 'required|string',
                'Country' => 'required|string',
                'Lead Source' => 'required|string',
            ], $messages);        
        
            if ($validator->fails()) {

                foreach ($validator->errors()->toArray() as $field => $messages) {
        
                    foreach ($messages as $message) {
                        $this->validationErrors[] = [
                            'row' => $row[0],
                            'field' => $field,
                            'message' => $message
                        ];
                    }
                }

                // return null;
            }
            else {
                $this->validRows[] =  [
                    'import_id' => $this->import->id,
                    'first_name' => $row[1],
                    'last_name' => $row[2],
                    'email' => $row[3],
                    'mobile_number' => $row[4],
                    'street_1' => $row[5],
                    'street_2' => $row[6] ?? null,
                    'city' => $row[7],
                    'state' => $row[8],
                    'country' => $row[9],
                    'lead_source' => $row[10],
                    'status' => 0,
                ];
            }
        }

        if (!empty($this->validationErrors)) {
            $this->import->errors = $this->validationErrors;
            $this->import->save();
        }
        else {
            Lead::insertOrIgnore($this->validRows);
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
