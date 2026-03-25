<x-card>
    <x-card-body>
        <h2 class="h6">
            <a href="{{ route('blog.show',$post) }}">
                {!! $post->title !!}
            </a>
        </h2>
      <div class="small text-muted">
          {{$post->created_at->diffForHumans()}}
      </div>
    </x-card-body>
</x-card>
