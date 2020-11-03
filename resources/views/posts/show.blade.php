@extends('layouts.app',['title' => $post->title])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if ($post->thumbnail)
                    <img style="height:500px;object-fit:cover;object-position:top;" class="rounded w-100" src="{{ $post->takeImage }}">
                @endif
                <div class="my-4">
                    <h1>{{ $post->title }}</h1>
                </div>
                <div class="text-secondary mb-3">
                    <a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a> 
                    &middot; {{ $post->category->created_at->format('d M, Y') }}
                    &middot; 
                    @foreach ($post->tags as $tag)
                        <a href="/tags/{{ $tag->slug }}">{{ $tag->name }}</a>
                    @endforeach

                    <div class="media align-items-center my-3">
                        <img width="60" class="rounded-circle mr-3" src="{{ $post->author->gravatar() }}" >
                        <div class="media-body">
                            <div>
                                {{ $post->author->name }}
                            </div>
                            {{  "@" . $post->author->username }}
                        </div>
                    </div>
                </div>

                <p class="text-justify">{!! nl2br($post->body) !!}</p>
                
                <div>

                    <!-- Button trigger modal -->
                    @can('delete', $post)
                        <div class="flex mt-3">
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">
                                Delete
                            </button>
                            <a href="/posts/{{ $post->slug }}/edit" class="btn btn-sm btn-success">Edit</a>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Apakah anda ingin menghapusnya?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h4>{{ $post->title }}</h4>
                                        <div class="text-secondary">
                                            <small>
                                                Published on : {{ $post->created_at }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="/posts/{{ $post->slug }}/delete" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                            <button type="submit" class="btn btn-primary">Ya, Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-center my-5">
                    <h4><b>Other Blogs from Category: {{ $post->category->name }}</b></h4>
                </div>
                <hr style="margin-top:-13%;">
                @foreach ($posts as $post)
                    <div class="card mb-4">
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
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection