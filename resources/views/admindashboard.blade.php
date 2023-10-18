<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7Rxnatzjc;dSMG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
    body {
        color: white;
    }

    .container {
        margin-top: 20px;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
    <div class="container">
        @if(session('message'))
        <div class="alert alert-success m-4" role="alert">
            {{session('message')}}
        </div>
        @endif
        <a href="{{route('execdetail')}}">
            <button class='btn btn-success m-3'>Executive Details</button>
        </a>
    </div>
    <div class="font-semibold text-xl text-white leading-tight text-center">
            <h2>Leads Listing</h2>
        </div>
    <div>
    <select name="filter" id="filter" class='text-white bg-gray-800 text-center rounded-md  hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline'>
        <option value='all'>--Executive Name--</option>
        @foreach($users as $user)
        @if($user->usertype == 'executive')
        <option value='{{$user->id}}'>{{$user->name}}</option>
        @endif
        @endforeach
    </select>

    </div>
    <div class="leads-container">
        @include('leads',compact('leads'))
    </div>
        <div>
            </div>
    </div>
</x-app-layout>

<script>
    const resultbtn = document.querySelector('.alert');
    setTimeout(() => {
        resultbtn.parentNode.removeChild(resultbtn);
    }, 2000);
</script>

</html>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
<script>
    jQuery('document').ready(function(){
        jQuery('#filter').change(function(){
            let filter=jQuery(this).val();
            jQuery.ajax({
                url:'/filter',
                type:'post',
                data:'filter='+filter+'&_token={{csrf_token()}}',
                success:function(response)
                {
                console.log(response);
                jQuery('.leads-container').html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            })
        })
    })
</script>
