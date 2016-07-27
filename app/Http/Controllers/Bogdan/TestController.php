<?php

namespace App\Http\Controllers\Bogdan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class TestController extends Controller
{
    protected $redirectTo = '/test';
    /**
     * @return mixed
     */
    public function index()
    {

        $user_data = DB::table('leads') //select user data
            ->join('customers','leads.customer_id', '=', 'customers.id')
            ->join('open_leads','open_leads.lead_id', '=', 'leads.id')
            ->select('leads.id','leads.date','leads.name','leads.email','customers.phone')
            ->get();


        return view('bogdan.index',['user_data' => $user_data]);
    }
    protected function validator(array $data) //validate ajax request
    {
        $messages = [ //validation message
            
        ];
        return Validator::make($data, [   //validation ajax request
            'user_id' => 'integer',
        ],$messages);
    }
    public function show(Request $request) //request by ajax test.js
    {
        
        if ($request->isMethod('post')){
            // Display text here
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                $errors = $validator->errors(); //error send to ajax
                $errors =  json_decode($errors);
                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 200);
                die();
            }
            $id = $request->user_id;

            $user_data = DB::table('leads') //select user data
                ->join('customers','leads.customer_id', '=', 'customers.id')
                ->join('open_leads','open_leads.lead_id', '=', 'leads.id')
                ->select('leads.id','leads.date','leads.name','leads.email','customers.phone')
                ->where('leads.id','=',$id)
                ->first();
            $label = DB::table('leads')   //select label data for user table
                ->join('customers','leads.customer_id', '=', 'customers.id')
                ->join('open_leads','open_leads.lead_id', '=', 'leads.id')
                ->join('sphere_attributes','sphere_attributes.sphere_id','=','leads.sphere_id')
                ->select('leads.id','leads.date','leads.name','leads.email','customers.phone','sphere_attributes.label')
                ->where('leads.id','=',$id)
                ->get();
            $label_data = array(); 
            foreach ($label as $row){
                $label_data[] = $row->label; //push all label to array and send to ajax respons
            }


            return response()->json([
                'success' => true,
                'message' => $user_data, //user data
                'label' => $label_data,   //label data
            ], 200);
            die();
        } else {
            return redirect($this->redirectTo);
        }
    }
}
