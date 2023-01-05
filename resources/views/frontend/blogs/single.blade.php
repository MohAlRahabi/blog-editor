@extends('frontend.layout.main')
@section('extra_meta')
    <meta name="description" content="{{env('DESCRIPTION')}}">

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{env('APP_NAME', 'laravel')}}">
    <meta itemprop="description" content="{{env('DESCRIPTION')}}">
    <meta itemprop="image" content="{{env('APP_URL')}}">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{env('APP_NAME', 'laravel')}}">
    <meta property="og:description" content="{{env('DESCRIPTION')}}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{env('APP_NAME', 'laravel')}}">
    <meta name="twitter:description" content="{{env('DESCRIPTION')}}">
@endsection
@section('content')
    <div class="container">
        <h2>{{$article->title}}</h2>
        <div class="row">
            <div class="col-md-12" id="content">
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            let json = JSON.parse(@json($article->content));
            console.log(json)
            let blocks = json.blocks
            console.log(blocks)
            blocks.map((block) => {
                let addedContent = "";
                switch (block.type) {
                    case "paragraph":
                        addedContent = block.data.text
                        break;
                    case "image":
                        addedContent = `<div><img src="${block.data.url}" alt="" /></div>`
                        break;
                    default:
                        addedContent = "";
                }
                $('#content').append(addedContent)
            })
        })
    </script>
@endpush
