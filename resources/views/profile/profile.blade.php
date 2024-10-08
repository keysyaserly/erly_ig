<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - {{ $user->name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-header img {
            border-radius: 50%;
            margin-right: 20px;
        }
        .follow-btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #0095f6;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }
        .follow-btn:hover {
            background-color: #007bbf;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Profil Pengguna</h1>

    <!-- Header Profil -->
    <div class="profile-header">
        <img src="{{ asset('storage/' . ($user->profile_picture ?? 'logo bn.jpg')) }}" alt="Profil" style="width: 150px; height: auto;">
        <div>
            <h2>{{ $user->name }}</h2>
            <p>Followers: {{ $user->followers->count() }}</p>
            <p>Postingan: {{ $user->photos->count() }}</p>

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
        </div>
    </div>

    <!-- Tambahkan konten lain di sini -->
</div>

</body>
</html>
