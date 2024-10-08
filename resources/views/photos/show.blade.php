@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $photo->caption }}</h1>
    <img src="{{ Storage::url($photo->photo_path) }}" alt="Photo" class="img-fluid">

    <h3>Comments ({{ $photo->comments->count() }})</h3>

    @if($photo->comments->isEmpty())
        <p>No comments yet.</p>
    @else
        <ul>
            @foreach($photo->comments as $comment)
                <li>{{ $comment->content }} - {{ $comment->user->name ?? 'Unknown' }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="photo_id" value="{{ $photo->id }}">
        <div class="form-group">
            <label for="comment">Add a comment:</label>
            <input type="text" name="comment" id="comment" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
