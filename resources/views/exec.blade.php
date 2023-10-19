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
            <h2>Executive Details</h2>
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
                        <button type="button" class="btn btn-danger bg-red-700" onclick="Delete({{ $user->id }})">Delete User</button>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        <div class='p-3'>

</div>
</x-app-layout>
<script>
    function Delete(user_id) 
    {
        if (confirm('Are you sure you want to delete this lead?')) {
            window.location.href = "{{ route('DeleteUser', ':user_id') }}".replace(':user_id', user_id);
        }
    }
</script>