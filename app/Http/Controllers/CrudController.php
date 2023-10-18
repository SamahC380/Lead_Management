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
        $isDuplicate = Lead::where('detail', request('detail'))->exists();
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
        elseif(request('type') == 'emailid')
        {
        if ($isDuplicate)
        {
            // A duplicate is found, create a new lead with the same "detail" and mark it as a duplicate
            $leads = Lead::create([
                'name' => request('name'),
                'type' => request('type'),
                'detail' => request('email'),
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
                'detail' => request('email'),
                'remark' => request('remark'),
                'check' => false, // Mark it as not a duplicate
                'category_id' => $category_id,
                'creator_id' => $id,
            ]);
        }
        }
        else
        {
            return redirect()->route('home')->with('message','Please Specificy Contact Type Successfully');
        }
        return redirect()->route('home')->with('message','Added Successfully');
    }
    public function filterfn(Request $request)
    {

        $filter = $request->post('filter');
            if($filter == 'all')
            {
                // $users=User::all();
                $categories=Category::all();
                $users=User::all();  
                $leads=Lead::all(); 
                return view('leads',compact('leads','users','categories'));
            }
            else
            {
                $categories=Category::all();
                $users=User::all();   
                $leads=Lead::where('creator_id',$filter)->get();   
                $html = view('leads',compact('leads','users','categories'))->render();
                return $html;
            }
            
    }
    public function catfilterfn(Request $request)
    {

        $filter = $request->post('catfilter');
            if($filter == 'all')
            {
                $users=User::all();
                $leads=Lead::all(); 
                $categories=Category::all();
                return view('leads',compact('leads','users','categories'));
            }
            else
            {
                $users=User::all();   
                $categories=Category::where('id',$filter)->get(); 
                $leads=Lead::where('category_id',$filter)->get();  
                $html = view('leads',compact('leads','users','categories'))->render();
                return $html;
            }
            
    }
    public function datefilterfn(Request $request)
    {

        $filter = $request->post('datefilter');
        $categories=Category::all();
        $users=User::all();
            if($filter == 'newest')
            {
                // $users=User::all();
               // $categories=Category::all();
               // $users=User::all();  
                $leads = Lead::orderBy('created_at', 'asc')->get();
                return view('leads',compact('leads','users','categories'));
            }
            elseif($filter == 'oldest')
            {
               // $categories=Category::all();
               // $users=User::all();   
                $leads = Lead::orderBy('created_at', 'desc')->get();  
                $html = view('leads',compact('leads','users','categories'))->render();
                return $html;
            }
            else
            {
              //  return ('error');
              $leads = Lead::orderBy('name', 'asc')->get();  
              $html = view('leads',compact('leads','users','categories'))->render();
              return $html;
            }
            
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

        $user=User::where('id', request('creator_id'))->get();
        $creator=request('creator_id');
        if(Auth()->user()->usertype == 'admin')
        {
            request()->validate([
                // 'name'=>'required',
                // 'category_id'=>'required',
                // 'type'=>'required',
                // 'remark'=>'required',
            ]);
            $lead=Lead::find($id);
            $creator=request('creator_id');
            $isDuplicate = Lead::where('detail', request('detail'))->exists();
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
                    'creator_id'=> $creator,

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
                    'creator_id' => $creator,
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
                    'detail' => request('email'),
                    'remark' => request('remark'),
                    'check' => true,
                    'category_id' => request('category_id'),
                    'creator_id'=> $creator,
                ]);
            } 
            else 
            {
                // No duplicate found, create a new lead with the requested "detail"
                $lead->update([
                    'name' => request('name'),
                    'type' => request('type'),
                    'detail' => request('email'),
                    'remark' => request('remark'),
                    'check' => false, // Mark it as not a duplicate
                    'category_id' => request('category_id'),
                    'creator_id' => $creator,
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
                // 'name'=>'required',
                // 'category_id'=>'required',
                // 'type'=>'required',
                // 'remark'=>'required',
            ]);
            $lead=Lead::find($id);
            $isDuplicate = Lead::where('detail', request('detail'))->exists();
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
