<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #343a40;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .form-group textarea {
            resize: none;
            height: 100px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .save-btn,
        .cancel-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            color: white;
        }

        .save-btn {
            background-color: #007bff;
        }

        .save-btn:hover {
            background-color: #0056b3;
        }

        .cancel-btn {
            background-color: #6c757d;
        }

        .cancel-btn:hover {
            background-color: #343a40;
        }

        .form-group img {
            max-width: 100%;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Edit Foto</h1>

        <form action="{{ route('photo.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="caption">Caption</label>
                <textarea name="caption" id="caption" required>{{ old('caption', $photo->caption) }}</textarea>
            </div>

            <div class="form-group">
                <label for="photo">Upload Foto Baru (Opsional)</label>
                <input type="file" name="photo" id="photo">
                @if ($photo->photo_path)
                    <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Foto Lama">
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="save-btn">Simpan</button>
                <a href="{{ route('profile.show', auth()->user()->id) }}" class="cancel-btn">Batal</a>
            </div>
        </form>
    </div>

</body>

</html>
