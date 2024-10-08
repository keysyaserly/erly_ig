<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            color: #343a40;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2 {
            font-weight: 600;
            color: #343a40;
            margin-bottom: 15px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 15px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .profile-header img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            margin-right: 20px;
            border: 3px solid #007bff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .upload-form {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .upload-form label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #495057;
        }

        .upload-form input[type="file"],
        .upload-form textarea {
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            margin-bottom: 15px;
            transition: border 0.3s;
        }

        .upload-form input[type="file"]:focus,
        .upload-form textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        .upload-form button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s, transform 0.3s;
        }

        .upload-form button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .photo-feed {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .photo {
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .photo:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.2);
        }

        .photo img {
            width: 100%;
            height: auto;
        }

        .photo-info {
            padding: 15px;
        }

        .photo-info p {
            margin: 0;
            font-size: 14px;
            color: #343a40;
        }

        .photo-info small {
            display: block;
            color: #868e96;
            margin-top: 5px;
        }

        .photo-actions {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
        }

        .photo-actions button,
        .photo-actions a {
            background: none;
            border: none;
            cursor: pointer;
            color: #007bff;
            font-size: 16px;
            transition: color 0.3s;
        }

        .photo-actions button:hover,
        .photo-actions a:hover {
            color: #0056b3;
        }

        .comment-section {
            margin-top: 15px;
            padding: 15px;
            border-top: 1px solid #ced4da;
        }

        .comment-section form {
            display: flex;
            margin-bottom: 10px;
        }

        .comment-section input[type="text"] {
            flex: 1;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            margin-right: 10px;
        }

        .comment-section button {
            padding: 8px 12px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        .comment-section button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .comments {
            margin-top: 10px;
            font-size: 14px;
            color: #343a40;
        }

        .comments p {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Form Upload Foto -->
        <div class="upload-form">
            <h2>Upload Foto Baru</h2>
            <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="photo">Pilih Foto</label>
                <input type="file" name="photo" required>
                <label for="caption">Caption (Opsional)</label>
                <textarea name="caption" rows="3" placeholder="Tulis caption..."></textarea>
                <button type="submit">Upload</button>
            </form>
        </div>

        <!-- Feed Foto Pengguna -->
        <h2>Foto yang Diunggah</h2>
        <div class="photo-feed">
            @foreach ($photos as $photo)
                <div class="photo">
                    <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Foto">
                    <div class="photo-info">
                        <p>{{ $photo->caption }}</p>
                        <small>Uploaded on {{ $photo->created_at->format('d M Y') }}</small>
                    </div>
                    <div class="photo-actions">
                        <form action="{{ route('photos.like', $photo->id) }}" method="POST">
                            @csrf
                            <button type="submit"><i class="fas fa-heart"></i> Suka ({{ $photo->likes_count }})</button>
                        </form>
                        @can('update', $photo)
                            <a href="{{ route('profile.edit', $photo->id) }}" class="btn-edit"><i class="fas fa-edit"></i></a>
                        @endcan
                        @can('delete', $photo)
                            <form action="{{ route('profile.destroy', $photo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"><i class="fas fa-trash"></i></button>
                            </form>
                        @endcan
                    </div>

                    <!-- Komentar -->
                    <div class="comment-section">
                        <form action="{{ route('photos.comment', $photo->id) }}" method="POST">
                            @csrf
                            <input type="text" name="comment" placeholder="Tambah komentar..." required>
                            <button type="submit">Kirim</button>
                        </form>

                        <!-- Tampilkan komentar -->
                        <div class="comments">
                            @if ($photo->comments->isEmpty())
                                <p>No comments yet.</p>
                            @else
                                @foreach ($photo->comments as $comment)
                                    <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>
