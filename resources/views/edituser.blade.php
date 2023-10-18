<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Executive Details</title>
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
        <h1>Edit Executive Details</h1>
        <form action="{{route('EditUser',$user->id)}}" method='post' class='form'>
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Executive Name
                    <input type="text" name='name' class="form-control" required value='{{$user->name}}'>
                    @error('name') <p class='alert mt-2'>{{$message}}</p> @enderror
                </label>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email
                    <input type="email" name='email' class="form-control" value='{{$user->email}}'>
                </label>
            </div>
            <div class="form-group">
                <label for="status" class="form-label">Status
                    <select name="status" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    @error('category') <p class="alert mt-2">{{ $message }}</p> @enderror
                </label>
            </div>
            <div class="form-group">
                <input type="submit" value='Edit' class='btn btn-primary'>
            </div>
        </form>
    </div>
</body>
</html>
