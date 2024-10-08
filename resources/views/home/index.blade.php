<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Instagram</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 0;
        }

        /* Header Navigasi */
        .header {
            background-color: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #dbdbdb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
        }

        .header-logo {
            font-family: 'Lobster', cursive;
            font-size: 24px;
            color: #333;
            text-decoration: none;
        }

        .header-icons {
            display: flex;
            gap: 20px;
        }

        .header-icons a {
            color: #333;
            font-size: 20px;
            text-decoration: none;
        }

        /* Container Utama */
        .container {
            max-width: 600px;
            margin: 100px auto 0 auto;
            padding: 0 20px;
        }

        /* Grid Foto */
        .photo-feed {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Mengubah ukuran grid */
            gap: 20px; /* Jeda antara foto ditambah */
        }

        .photo {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .photo:hover {
            transform: scale(1.02);
        }

        .photo img {
            width: 100%;
            height: 300px; /* Menjaga tinggi agar lebih lebar */
            object-fit: cover; /* Memastikan gambar menutupi area yang ada */
        }

        /* Foto Info dan Aksi */
        .photo-info {
            padding: 10px;
        }

        .photo-info p {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        .photo-info small {
            display: block;
            color: #999;
            margin-top: 5px;
        }

        .photo-actions {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background: #fafafa;
            border-top: 1px solid #dbdbdb;
        }

        .photo-actions button,
        .photo-actions a {
            background: none;
            border: none;
            cursor: pointer;
            color: #0095f6;
            font-size: 16px;
        }

        .photo-actions button:hover,
        .photo-actions a:hover {
            color: #007bbf;
        }

        /* Komentar */
        .comment-section {
            padding: 10px 15px;
            background: #fafafa;
            border-top: 1px solid #dbdbdb;
        }

        .comment-section form {
            display: flex;
            margin-bottom: 10px;
        }

        .comment-section input[type="text"] {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }

        .comment-section button {
            padding: 8px 12px;
            background-color: #0095f6;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .comment-section button:hover {
            background-color: #007bbf;
        }

        .comments {
            font-size: 14px;
            color: #333;
        }

        .comments p {
            margin: 5px 0;
        }

        /* Tombol Tambah Foto di Tengah Bawah */
        .upload-btn {
            background-color: #0095f6;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 50%;
            font-size: 24px;
            position: fixed;
            bottom: 20px;
            right: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .upload-btn:hover {
            background-color: #007bbf;
        }

        /* Footer Navigasi */
        .footer-nav {
            background-color: #fff;
            padding: 10px 15px; /* Mengurangi padding */
            border-top: 1px solid #dbdbdb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .footer-nav a {
            color: #333;
            font-size: 20px; /* Mengurangi ukuran font */
            text-decoration: none;
        }

        .footer-nav a:hover {
            color: #000;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <a href="#" class="header-logo">Instagram</a>
        <div class="header-icons">
            <a href="#"><i class="fas fa-search"></i></a>
            <a href="#"><i class="fas fa-heart"></i></a>
            <a href="#"><i class="fas fa-user-circle"></i></a>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="container">
        <!-- Feed Foto dengan Grid -->
        <div class="photo-feed">
            @foreach ($photos as $photo)
                <div class="photo">
                    <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Foto">
                    <div class="photo-info">
                        <p>{{ $photo->caption }}</p>
                        <small>Diunggah oleh {{ $photo->user->name }} pada
                            {{ $photo->created_at->format('d M Y') }}</small>
                    </div>
                    <div class="photo-actions">
                        <form action="{{ route('photos.like', $photo->id) }}" method="POST">
                            @csrf
                            <button type="submit">
                                <i class="fas fa-heart"></i>
                                {{ $photo->likes()->where('user_id', auth()->id())->exists() ? 'Batal Suka' : 'Suka' }}
                                ({{ $photo->likes_count }})
                            </button>
                        </form>
                    </div>

                    <!-- Komentar -->
                    <div class="comment-section">
                        <form action="{{ route('photos.comment', $photo->id) }}" method="POST">
                            @csrf
                            <input type="text" name="comment" placeholder="Tambah komentar..." required>
                            <button type="submit">Kirim</button>
                        </form>
                        <div class="comments">
                            @if ($photo->comments->isEmpty())
                                <p>Belum ada komentar.</p>
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

    <!-- Tombol Upload Foto -->
    <button class="upload-btn"><i class="fas fa-plus"></i></button>

    <!-- Footer Navigasi -->
    <div class="footer-nav">
        <a href="{{ route('dashboard.index') }}"><i class="fas fa-home"></i></a>
        <a href="#"><i class="fas fa-search"></i></a>
        <a href="{{ route('dashboard.index') }}"><i class="fas fa-plus-square"></i></a>
        <a href="{{ route('photos.liked') }}"><i class="fas fa-heart"></i></a>
        <a href="{{ route('profile.show', auth()->id()) }}"><i class="fas fa-user-circle"></i></a>
    </div>

</body>

</html>
