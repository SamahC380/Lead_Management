<head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight">
            {{ __('Executive Details') }}
        </h2>
    </x-slot>

    <div class="font-semibold text-xl text-white leading-tight text-center" >
            <h2>Executive Details with their Leads</h2>
        </div>
        <table class="table table-dark table-striped table-hover table-bordered w-100 text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                $counter = 1;
                @endphp
                @foreach($users as $user)
                @if ($user->usertype !== 'admin') 
                @php
                $hasLeads = false; // Initialize a flag to check if the user has products
                @endphp
                @foreach($leads as $lead)
                @if($user->id == $lead->creator_id)
                @php
                $hasLeads = true; // Set the flag to true if the user has products
                @endphp
                <tr>
                    <td>{{$counter}}</td>
                    @php
                    $counter++;
                    @endphp
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->status}}</td>
                    <td>
                        <a href="{{route('EditUserPage',$user->id)}}" class="btn btn-primary">Edit User</a>
                        <a href="{{route('DeleteUser',$user->id)}}" class='btn btn-danger'>Delete User</a>
                    </td>
                </tr>
                @endif
                @endforeach
                @endif
                @endforeach
            </tbody>
        </table>
        <div class='p-3'>

</div>
</x-app-layout>