@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between">
        <div>
            @isset($category)
                <h4>Category : {{ $category->name }}</h4>
            @endisset
            
            @isset($tag)
                <h4>Tag : {{ $tag->name }}</h4>    
            @endisset

            @if (!isset($category) && !isset($tag))
                <h4>All Post</h4>
            @endif
            <hr>
        </div>

        @auth
            <div>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">New Post</a>
            </div>
        @endauth
    </div>
    <div class="row">
        @forelse ($posts as $post)
            <div class="col-md-4">
                <div class="card mb-4">
                    @if ($post->thumbnail)
                        <a href="{{ route('posts.show', $post->slug) }}">
                            <img style="height:270px;object-fit:cover;object-position:center;" class="card-img-top" src="{{ $post->takeImage }}">
                        </a>
                    @else 
                        <a href="{{ route('posts.show', $post->slug) }}">
                            <img style="height:270px;object-fit:cover;object-position:center;" class="card-img-top" src="https://yaoizbsyarnz.managedwp.com.au/wp-content/uploads/2020/06/no-image.jpg">
                        </a>
                    @endif

                    <div class="card-body">
                        <div>
                            <a href="{{ route('categories.show', $post->category->slug) }}" class="text-secondary">
                                <small>
                                    {{ $post->category->name }} 
                                </small>
                            </a>
                            -
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('tags.show', $tag->slug) }}" class="text-secondary">
                                    <small>
                                        {{ $tag->name }}
                                    </small>
                                </a>
                            @endforeach
                        </div>
                        <a class="text-dark" href="{{ route('posts.show', $post->slug) }}" class="card-title">
                            <h5>
                                {{ $post->title }}
                            </h5>
                        </a>
                        <div class="text-secondary my-3">
                            {{ Str::limit($post->body,90) }}
                        </div>
                        <hr>
                        <div class="media align-items-center mt-2">
                            <img width="40" class="rounded-circle mr-3" src="{{ $post->author->gravatar() }}" >
                            <div class="media-body">
                                <div>
                                    {{ $post->author->name }}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-secondary align-items-center mt-2">
                            <small>
                                Published on {{ $post->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        <div class="alert alert-info">
            There's no Post
        </div>
        @endforelse    
    </div>    
    <div class="d-flex justify-content-center">
        <div>
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection