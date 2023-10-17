<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lead;
use Illuminate\Support\Facades\Auth;

class CrudController extends Controller
{
    //
    public function leaddetailfn()
    {
        $users=User::all();
        $leads=Lead::get(); 
        return view('exec',compact('users','leads'));
    }
    
    public function addleadpage()
    {
        return view('addlead');
    }
    public function execdetailfn()
    {
        $users=User::all();
        $leads=Lead::all(); 
        return view('exec',compact('users','leads'));
    }
    public function addleadfn() //Add leads
    {
        // $request = request('type');
        // return $request;
        request()->validate([
            'name'=>'required',
            'category'=>'required',
            'type'=>'required',
            'remark'=>'required',
        ]);
        $leads=Lead::all();
        $currentUser=Auth::user();
        $id=$currentUser->id;
        $isDuplicate = Lead::where('detail', request('detail'))->first();
        if ($isDuplicate)
        {
            // A duplicate is found, create a new lead with the same "detail" and mark it as a duplicate
            $leads = Lead::create([
                'name' => request('name'),
                'type' => request('type'),
                'detail' => request('detail'),
                'remark' => request('remark'),
                'check' => true,
                'category' => request('category'),
                'creator_id' => $id,
            ]);
        } 
        else 
        {
            // No duplicate found, create a new lead with the requested "detail"
            $leads = Lead::create([
                'name' => request('name'),
                'type' => request('type'),
                'detail' => request('detail'),
                'remark' => request('remark'),
                'check' => false, // Mark it as not a duplicate
                'category' => request('category'),
                'creator_id' => $id,
            ]);
        }
        return redirect()->route('home')->with('message','Added Successfully');
    }
    public function EditLeadPagefn($id)
    {
        $lead=Lead::find($id);
        return view('edit',compact('lead'));
    }
    public function EditUserPagefn($id)
    {
        $user=User::find($id);
        return view('edituser',compact('user'));
    }
    public function EditLeadfn($id)
    {
        request()->validate([
            'name'=>'required',
            'category'=>'required',
            'type'=>'required',
            'remark'=>'required',
        ]);
        
        $lead=Lead::find($id);
        $isDuplicate = Lead::where('detail', request('detail'))->first();

        if ($isDuplicate) 
        {
            // A duplicate is found, update a new lead with the same "detail" and mark it as a duplicate
            $lead->update([
                'name' => request('name'),
                'type' => request('type'),
                'detail' => request('detail'),
                'remark' => request('remark'),
                'check' => true,
                'category' => request('category'),
            ]);
        } 
        else 
        {
            // No duplicate found, create a new lead with the requested "detail"
            $leads->update([
                'name' => request('name'),
                'type' => request('type'),
                'detail' => request('detail'),
                'remark' => request('remark'),
                'check' => false, // Mark it as not a duplicate
                'category' => request('category'),
                'creator_id' => $id,
            ]);
        }
        return redirect()->route('home')->with('message','Edited Successfully');
    }
    public function EditUserfn($id)
    {
        request()->validate([
            'name'=>'required',
            'email'=>'required',
            'status'=>'required',
        ]);
        
        $user=User::find($id);
        $user->update([
            'name'=>request('name'),
            'email'=>request('email'),
            'status'=>request('status'),
        ]);
        return redirect()->route('home')->with('message','Edited Successfully');
    }
    public function DeleteLeadfn($id)
    {
        $lead=Lead::find($id);
        $lead->delete();
        return redirect()->route('home')->with('message','Deleted Successfully');
    }
    public function DeleteUserfn($id)
    {
        $user=User::find($id);
        $user->delete();
        return redirect()->route('home')->with('message','Deleted Successfully');
    }
}
