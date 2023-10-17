<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Lead;
use App\Http\Controllers\CrudController;

class AuthController extends Controller
{
    public function authFn(){
        $users=User::all();
        $currentUser=Auth::user();
        $id=$currentUser->id;
        if(Auth::id())
        {
            if(Auth()->user()->usertype=='admin')
            {
                $leads=Lead::all();
                return view('admindashboard',compact('users','leads'));
            }
            else
            {   
                $leads=Lead::where('creator_id',$id)->get();
                return view('dashboard',compact('users','leads'));
            }
        }
    }
}
