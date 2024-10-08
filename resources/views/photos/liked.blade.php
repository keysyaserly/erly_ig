<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foto Disukai - InstaClone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styling global untuk seluruh halaman */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
            color: #333;
        }

        h1 {
            margin: 20px;
            font-size: 36px;
            color: #333;
        }

        .photo-feed {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            margin: 0 auto;
            max-width: 1200px;
        }

        .photo {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .photo:hover {
            transform: translateY(-5px);
        }

        .photo img {
            width: 100%;
            height: auto;
            display: block;
            border-bottom: 1px solid #ddd;
        }

        .photo-info {
            padding: 15px;
            text-align: left;
        }

        .photo-info p {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            margin: 0 0 10px;
        }

        .photo-info small {
            font-size: 14px;
            color: #666;
        }

        /* Efek hover untuk gambar */
        .photo img:hover {
            filter: brightness(90%);
        }

        /* Media queries untuk memastikan responsif */
        @media (max-width: 600px) {
            .photo-info p {
                font-size: 14px;
            }

            .photo-info small {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <h1>Foto Disukai</h1>
    <div class="photo-feed">
        @foreach ($photos as $photo)
            <div class="photo">
                <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Foto">
                <div class="photo-info">
                    <p>{{ $photo->caption }}</p>
                    <small>Diunggah oleh {{ $photo->user->name }} pada {{ $photo->created_at->format('d M Y') }}</small>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
