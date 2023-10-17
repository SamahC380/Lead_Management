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
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container">
        @if(session('message'))
        <div class="alert alert-success m-4" role="alert">
            {{session('message')}}
        </div>
        @endif
        <a href="{{route('addleadpage')}}"><button class='btn btn-success m-3'>Add Lead</button></a>

    </div>
    <div class="font-semibold text-xl text-white leading-tight text-center">
            <h2>Leads Listing</h2>
        </div>
    <table class="table table-dark table-striped table-hover table-bordered w-100 text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lead Name</th>
                    <th>Contact Type</th>
                    <th>Contact Details</th>
                    <th>Category</th>
                    <th>Remark</th>
                    <th>Check</th>
                    <th>Created By</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $counter = 1;
                @endphp
                @foreach($users as $user)
                @foreach($leads as $lead)
                @if($user->id == $lead->creator_id ) 
                <tr>
                    <td>{{$counter}}</td>
                    @php
                    $counter++;
                    @endphp
                    <td>{{$lead->name}}</td>
                    <td>{{$lead->type}}</td>
                    <td>{{$lead->detail}}</td>
                    <td>{{$lead->category}}</td>
                    <td>{{$lead->remark}}</td>
                    <td>{{$lead->check}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{ $lead->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>
                        <!-- Add actions for executives here -->
                        <a href="{{route('EditLeadPage',$lead->id)}}" class="btn btn-primary">Edit Lead</a>
                        <a href="{{route('DeleteLead',$lead->id)}}" class='btn btn-danger'>Delete Lead</a>
                    </td>
                </tr>
                @endif
                @endforeach
                @endforeach
            </tbody>
        </table>
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


