<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styling seperti sebelumnya */
    </style>
</head>

<body>
    <div class="container">
        <h1>Galeri Foto</h1>

        <!-- Tampilkan foto terbaru -->
        <div class="photo-feed">
            @foreach ($photos as $photo)
                <div class="photo">
                    <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Foto">
                    <div class="photo-info">
                        <p>{{ $photo->caption }}</p>
                        <small>Uploaded by {{ $photo->user->name }}</small>
                    </div>

                    <!-- Tampilkan Komentar -->
                    <div class="photo-comments">
                        @if ($photo->comments->isNotEmpty())
                            @foreach ($photo->comments as $comment)
                                <p>{{ $comment->content }}</p>
                                <small>By {{ $comment->user->name }}</small>
                            @endforeach
                        @else
                            <p>No comments yet.</p>
                        @endif
                    </div>

                    <!-- Form Komentar -->
                    <form action="{{ route('photo.comment', $photo->id) }}" method="POST">
                        @csrf
                        <textarea name="comment" rows="2" placeholder="Add a comment"></textarea>
                        <button type="submit">Comment</button>
                    </form>

                    <!-- Link Edit dan Hapus Foto (Hanya jika user punya izin) -->
                    @can('update', $photo)
                        <a href="{{ route('photos.edit', $photo->id) }}"><i class="fas fa-edit"></i></a>
                    @endcan

                    @can('delete', $photo)
                        <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"><i class="fas fa-trash"></i></button>
                        </form>
                    @endcan
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>
