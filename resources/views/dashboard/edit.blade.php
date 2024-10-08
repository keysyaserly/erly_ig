<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: #555;
        }
        input[type="file"],
        textarea {
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Foto</h1>
        <form action="{{ route('dashboard.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="photo">Pilih Foto Baru (Opsional)</label>
            <input type="file" name="photo">

            <label for="caption">Caption (Opsional)</label>
            <textarea name="caption" rows="3">{{ $photo->caption }}</textarea>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
