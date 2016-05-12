<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TemplateCreateController extends Controller
{
    public function create(Request $request)
    {
        return view('admin.createTemplate')->with('pageTitle','Create New Template');        
    }
    
    public function store(Request $request)
    {
      /*  $this->validate($request, [
            'type' => 'required',
            'tag' => 'required'
        ]);  */  
        
        return redirect('/admin/template')->with('success', $request['title'].' has been added.');
    }
}
