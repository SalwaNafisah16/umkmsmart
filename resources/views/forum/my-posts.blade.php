<h3>Postingan Saya</h3>

@foreach ($posts as $post)
    <h4>{{ $post->title }}</h4>
    <p>{{ $post->content }}</p>
@endforeach
