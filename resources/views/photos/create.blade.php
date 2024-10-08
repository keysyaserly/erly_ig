<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto Baru</title>
</head>
<body>
    <h1>Upload Foto Baru</h1>
    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="photo">Pilih Foto</label>
        <input type="file" name="photo" id="photo" required>

        <label for="caption">Caption (Opsional)</label>
        <textarea name="caption" id="caption"></textarea>

        <button type="submit">Upload</button>
    </form>
</body>
</html>
