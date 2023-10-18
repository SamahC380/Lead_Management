<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lead;
use App\Models\Category;
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
        $categories=Category::all();
        return view('addlead',compact('categories'));
    }
    public function execdetailfn()
    {
        $users=User::all();
        $leads=Lead::all(); 
        return view('exec',compact('users','leads'));
    }
    public function addleadfn(Request $request) //Add leads
    {
        // $request = request('type');
        // return $request;
        
        request()->validate([
            'name'=>'required',
            'category_id'=>'required',
            'type'=>'required',
            'remark'=>'required',
        ]);
        $category_id = $request->input('category_id');
        $category = Category::find($category_id);
        $leads = Lead::where('category_id',$category);
        $currentUser=Auth::user();
        $id=$currentUser->id;
        $isDuplicate = Lead::where('detail', request('detail'))->first();
        if( request('type') == 'mobile')
        {
        if ($isDuplicate)
        {
            // A duplicate is found, create a new lead with the same "detail" and mark it as a duplicate
            $leads = Lead::create([
                'name' => request('name'),
                'type' => request('type'),
                'detail' => request('mobile'),
                'remark' => request('remark'),
                'check' => true,
                'category_id' => $category_id,
                'creator_id' => $id,
            ]);
        } 
        else 
        {
            // No duplicate found, create a new lead with the requested "detail"
            $leads = Lead::create([
                'name' => request('name'),
                'type' => request('type'),
                'detail' => request('mobile'),
                'remark' => request('remark'),
                'check' => false, // Mark it as not a duplicate
                'category_id' => $category_id,
                'creator_id' => $id,
            ]);
        }
        }
        elseif( request('type') == 'emailid')
        {
        if ($isDuplicate)
        {
            // A duplicate is found, create a new lead with the same "detail" and mark it as a duplicate
            $leads = Lead::create([
                'name' => request('name'),
                'type' => request('type'),
                'detail' => request('emailid'),
                'remark' => request('remark'),
                'check' => true,
                'category_id' => $category_id,
                'creator_id' => $id,
            ]);
        } 
        else 
        {
            // No duplicate found, create a new lead with the requested "detail"
            $leads = Lead::create([
                'name' => request('name'),
                'type' => request('type'),
                'detail' => request('emailid'),
                'remark' => request('remark'),
                'check' => false, // Mark it as not a duplicate
                'category_id' => $category_id,
                'creator_id' => $id,
            ]);
        }
        }
        else
        {
            return 'error';
        }
        return redirect()->route('home')->with('message','Added Successfully');
    }
    public function filterfn(Request $request)
    {

        $filter = $request->post('filter');
            if($filter == 'all')
            {
                $users=User::all();
                $leads=Lead::all(); 
                return view('leads',compact('leads','users'));
            }
                $categories=Category::all();
                $users=User::all();   
                $leads=Lead::where('creator_id',$filter)->get();   
                $html = view('leads',compact('leads','users','categories'))->render();
                return $html;
            
    }
    public function EditLeadPagefn($id)
    {
        $lead=Lead::find($id);
        $users=User::all();
        return view('edit',compact('lead','users'));
    }
    public function EditUserPagefn($id)
    {
        $user=User::find($id);
        return view('edituser',compact('user'));
    }
    public function EditLeadfn($id) //Edit Lead for Executives and Admin
    {
        $users=User::all();
        if($user->usertype == 'admin')
        {
            request()->validate([
                'name'=>'required',
                'category_id'=>'required',
                'type'=>'required',
                'remark'=>'required',
                'creator_id'=>'required',
            ]);
            $lead=Lead::find($id);
            $isDuplicate = Lead::where('detail', request('detail'))->first();
            if( request('type') == 'mobile')
            {
                if ($isDuplicate) 
            {
                // A duplicate is found, update a new lead with the same "detail" and mark it as a duplicate
                $lead->update([
                    'name' => request('name'),
                    'type' => request('type'),
                    'detail' => request('mobile'),
                    'remark' => request('remark'),
                    'check' => true,
                    'category_id' => request('category_id'),
                    'creator_id'=> request('creator_id'),

                ]);
            } 
            else 
            {
                // No duplicate found, create a new lead with the requested "detail"
                $lead->update([
                    'name' => request('name'),
                    'type' => request('type'),
                    'detail' => request('mobile'),
                    'remark' => request('remark'),
                    'check' => false, // Mark it as not a duplicate
                    'category_id' => request('category_id'),
                    'creator_id' => request('creator_id'),
                ]);
            }
            }
            elseif(request('type') == 'emailid')
            {
            if ($isDuplicate) 
            {
                // A duplicate is found, update a new lead with the same "detail" and mark it as a duplicate
                $lead->update([
                    'name' => request('name'),
                    'type' => request('type'),
                    'detail' => request('emailid'),
                    'remark' => request('remark'),
                    'check' => true,
                    'category_id' => request('category_id'),
                    'creator_id'=> request('creator_id'),
                ]);
            } 
            else 
            {
                // No duplicate found, create a new lead with the requested "detail"
                $lead->update([
                    'name' => request('name'),
                    'type' => request('type'),
                    'detail' => request('emailid'),
                    'remark' => request('remark'),
                    'check' => false, // Mark it as not a duplicate
                    'category_id' => request('category_id'),
                    'creator_id' => $id,
                ]);
            }
            }
            else
            {
                return redirect()->route('home')->with('message','Edited Invalid contact selection');
            }
        }
        else
        {
            request()->validate([
                'name'=>'required',
                'category_id'=>'required',
                'type'=>'required',
                'remark'=>'required',
            ]);
            $lead=Lead::find($id);
            $isDuplicate = Lead::where('detail', request('detail'))->first();
            if( request('type') == 'mobile')
            {
                if ($isDuplicate) 
            {
                // A duplicate is found, update a new lead with the same "detail" and mark it as a duplicate
                $lead->update([
                    'name' => request('name'),
                    'type' => request('type'),
                    'detail' => request('mobile'),
                    'remark' => request('remark'),
                    'check' => true,
                    'category_id' => request('category_id'),
                ]);
            } 
            else 
            {
                // No duplicate found, create a new lead with the requested "detail"
                $lead->update([
                    'name' => request('name'),
                    'type' => request('type'),
                    'detail' => request('mobile'),
                    'remark' => request('remark'),
                    'check' => false, // Mark it as not a duplicate
                    'category_id' => request('category_id'),
                    'creator_id' => $id,
                ]);
            }
            }
            elseif(request('type') == 'emailid')
            {
            if ($isDuplicate) 
            {
                // A duplicate is found, update a new lead with the same "detail" and mark it as a duplicate
                $lead->update([
                    'name' => request('name'),
                    'type' => request('type'),
                    'detail' => request('emailid'),
                    'remark' => request('remark'),
                    'check' => true,
                    'category_id' => request('category_id'),
                ]);
            } 
            else 
            {
                // No duplicate found, create a new lead with the requested "detail"
                $lead->update([
                    'name' => request('name'),
                    'type' => request('type'),
                    'detail' => request('emailid'),
                    'remark' => request('remark'),
                    'check' => false, // Mark it as not a duplicate
                    'category_id' => request('category_id'),
                    'creator_id' => $id,
                ]);
            }
            }
            else
            {
                return redirect()->route('home')->with('message','Edited Invalid contact selection');
            }
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
