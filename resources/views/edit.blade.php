<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lead Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400&display=swap" rel="stylesheet">
</head>
<style>
    body {
        font-family: 'Figtree', sans-serif;
        background-color: rgb(17, 24, 39);
        color: rgb(175, 175, 175);
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .container {
        text-align: center;
        background-color: rgba(255, 255, 255, 0.2);
        padding: 1rem;
        border-radius: 10px;
    }
    .form-group {
        margin: 1rem;
    }
    .form-control, input {
        border: 1px solid black;
        width: 60vw;
    }
    .alert {
        padding: 0.1rem;
        color: red;
    }
    h1 {
        font-size: 2rem;
        color: white;
        margin-bottom: 1rem;
    }
</style>
<body>
    <div class="container">
        <h1>Edit Lead Details</h1>
        <form action="{{route('EditLead',$lead->id)}}" method='post' class='form'>
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Lead Name
                    <input type="text" name='name' class="form-control" required value='{{$lead->name}}'>
                    @error('name') <p class='alert mt-2'>{{$message}}</p> @enderror
                </label>
            </div>
            <div class="form-group">
                <select id="type" name="type" class="form-control mx-auto">
                    <option value="mobile">Mobile</option>
                    <option value="emailid">Email ID</option>
                </select>
            </div>
            <div class="form-group" id="contact-detail-container">
                <label for="mobile" class="form-label">Mobile Detail with Phone Code
                    <input type="text" name='mobile' class="form-control" value="{{$lead->detail}}">
                    @error('mobile') <p class='alert mt-2'>{{ $message }}</p> @enderror
                </label>
            </div>
            <div class="form-group" id="email-id-container" style="display: none;">
                <label for="emailid" class="form-label">Email ID
                    <input type="text" name='email' class="form-control" value="{{$lead->detail}}">
                    @error('emailid') <p class='alert mt-2'>{{ $message }}</p> @enderror
                </label>
            </div>
            <div class="form-group">
                <label for="category_id" class="form-label">Category 
                    <select name="category_id" class="form-control">
                        <option value="1">Hot</option>
                        <option value="2">Warm</option>
                        <option value="3">Cold</option>
                    </select>
                    @error('category') <p class="alert mt-2">{{ $message }}</p> @enderror
                </label>
            </div>
            @if(auth()->user()->usertype == 'admin')
            <div class="form-group">
                <label for="creator_id" class="form-label">Assign Task To 
                    <select name="creator_id" class="form-control">
                    @foreach($users as $user)
                    @if($user->usertype != 'admin' && $user->status != 'Inactive')
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                    @endforeach
                    </select>
                @error('assign') <p class="alert mt-2">{{ $message }}</p> @enderror
                </label>
            </div>
            @endif
            <div class="form-group">
                <label for="remark" class="form-label">Remark
                    <input type="text" name='remark' class="form-control" value="{{ $lead->remark }}">
                    @error('remark') <p class="alert mt-2">{{ $message }}</p> @enderror
                </label>
            </div>
            <div class="form-group">
                <input type="submit" value='Edit' class='btn btn-primary'>
            </div>
        </form>
    </div>
</body>
<script>
        const typeSelect = document.getElementById('type');
        const contactDetailContainer = document.getElementById('contact-detail-container');
        const emailIdContainer = document.getElementById('email-id-container');
    
        typeSelect.addEventListener('change', function () {
            if (typeSelect.value == 'mobile') {
                contactDetailContainer.style.display = 'block';
                emailIdContainer.style.display = 'none';
            } else if (typeSelect.value == 'emailid') {
                contactDetailContainer.style.display = 'none';
                emailIdContainer.style.display = 'block';
            } else {
                contactDetailContainer.style.display = 'block';
                emailIdContainer.style.display = 'none';
            }
        });
    </script>
</html>
