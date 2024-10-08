<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - keysya </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 123, 255, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .profile-header img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            border: 4px solid #007bff;
            margin-right: 20px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        }

        .profile-header h2 {
            margin: 0;
            font-size: 28px;
            color: #007bff;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            margin-right: auto;
            /* Agar informasi profil berada di kiri */
        }

        .followers-posts {
    display: flex; /* Menggunakan flexbox untuk sejajar */
    gap: 20px; /* Jarak antara followers dan posts */
    font-size: 16px;
    color: #6c757d; /* Warna untuk teks followers dan postingan */
    align-items: center; /* Menjajarkan secara vertikal di tengah */
}


        .profile-actions {
            margin-left: auto;
            /* Memindahkan tombol ke kanan */
            display: flex;
            align-items: center;
        }

        .follow-btn,
        .edit-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 14px;
            margin-left: 10px;
            /* Menggunakan margin-left untuk jarak */
            box-shadow: 0 3px 10px rgba(0, 123, 255, 0.2);
        }

        .follow-btn:hover,
        .edit-btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            /* Sedikit mengangkat tombol saat hover */
        }

        .photo-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .photo-item {
            border-radius: 10px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .photo-item:hover {
            transform: translateY(-5px);
        }

        .photo-list img {
            width: 100%;
            height: auto;
            transition: transform 0.3s;
        }

        .photo-list img:hover {
            transform: scale(1.05);
        }

        .photo-info {
            padding: 15px;
            background-color: #f9f9f9;
            border-top: 2px solid #007bff;
            text-align: center;
        }

        .photo-info p {
            margin: 5px 0;
            color: #007bff;
            font-weight: bold;
        }

        .comments {
            margin-top: 10px;
            padding-left: 10px;
            text-align: left;
        }

        .comment {
            margin: 5px 0;
            font-size: 14px;
            color: #6c757d;
        }

        @media (max-width: 600px) {
            .profile-header img {
                width: 120px;
                height: 120px;
            }

            .follow-btn,
            .edit-btn {
                font-size: 12px;
                padding: 8px 12px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Profil Pengguna</h1>

        <div class="profile-header">
            <img src="{{ asset('storage/' . ($user->profile_picture ?? 'download (2).jpg')) }}" alt="Profil">
            <div>
                <h2>Keysya</h2>
                <div class="followers-posts">
                    <p>Followers: {{ number_format($user->followers->count(), 0, ',', '.') }}</p>
                    <p>Postingan: {{ number_format($user->photos->count(), 0, ',', '.') }}</p>
                </div>

                <div>
                    @if ($user->followers->contains('follower_id', auth()->id()))
                        <form action="{{ route('profile.unfollow', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="follow-btn">Unfollow</button>
                        </form>
                    @else
                        <form action="{{ route('profile.follow', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="follow-btn">Follow</button>
                        </form>
                    @endif

                    <a href="{{ route('profile.edit', $user->id) }}" class="edit-btn">Edit Profil</a>
                </div>
            </div>
        </div>


        <!-- Menampilkan Posting -->
<h3>Postingan</h3>
<div class="photo-list">
    @foreach ($user->photos as $photo)
        <div class="photo-item">
            <!-- Gambar -->
            <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="{{ $photo->caption }}">

            <!-- Caption Gambar -->
            <p style="text-align: center;">{{ $photo->caption }}</p>

            <div class="photo-info">
                <p>Likes: {{ $photo->likes->count() }}</p>
                <p>Komentar: {{ $photo->comments->count() }}</p>
                <div class="comments">
                    @foreach ($photo->comments as $comment)
                        <div class="comment">{{ $comment->content }} - <strong>{{ $comment->user->name }}</strong></div>
                    @endforeach
                </div>
                <div style="margin-top: 10px;">
                    <a href="{{ route('photo.edit', $photo->id) }}" class="edit-btn">Edit</a>
                    <form action="{{ route('photo.destroy', $photo->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="follow-btn" style="background-color: red;">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


</body>

</html>
