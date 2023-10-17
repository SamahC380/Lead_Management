<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Lead</title>
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
        width: 50vw;
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
        <h1>Add Lead</h1>
        <form action="{{ route('addlead') }}" method='post' class='form'>
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Lead Name
                    <input type="text" name='name' class="form-control">
                    @error('name') <p class='alert mt-2'>{{ $message }}</p> @enderror
                </label>
            </div>
            <div class="form-group">
                <select id="type" name="type" class="form-control">
                    <option value="">Contact</option>
                    <option value="mobile">Mobile</option>
                    <option value="emailid">Email ID</option>
                </select>
            </div>
            <div class="form-group" id="contact-detail-container">
                <label for="mobile" class="form-label">Mobile Detail with Phone Code
                    <input type="text" name='detail' class="form-control" >
                    @error('mobile') <p class='alert mt-2'>{{ $message }}</p> @enderror
                </label>
            </div>
            <div class="form-group" id="email-id-container" style="display: none;">
                <label for="emailid" class="form-label">Email ID
                    <input type="text" name='detail' class="form-control">
                    @error('emailid') <p class='alert mt-2'>{{ $message }}</p> @enderror
                </label>
            </div>
            <div class="form-group">
                <label for="category" class="form-label">Category
                    <select name="category" class="form-control">
                        <option value="Hot">Hot</option>
                        <option value="Warm">Warm</option>
                        <option value="Cold">Cold</option>
                    </select>
                    @error('category') <p class="alert mt-2">{{ $message }}</p> @enderror
                </label>
            </div>
            <div>
                <input type="hidden" name="created_at" value="{{ time() }}" />
            </div>
            <div class="form-group">
                <label for="remark" class="form-label">Remark
                    <input type="text" name='remark' class="form-control">
                    @error('remark') <p class="alert mt-2">{{ $message }}</p> @enderror
                </label>
            </div>
            <div class="form-group">
                <input type="submit" value='Add' class='btn btn-primary'>
            </div>
        </form>
    </div>
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
</body>
</html>