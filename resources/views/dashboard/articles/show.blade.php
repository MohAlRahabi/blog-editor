@extends('dashboard.layout.main')
@section('content')
    <div class="p-4">
        <h2>{{$article->title}}</h2>
        <div class="row">
            <div class="col-md-12" id="content">
            </div>
        </div>
    </div>

    @component('dashboard.articles.gif_images_modal')
    @endcomponent

@endsection

@push('scripts')
    <script>
        $(function () {
            let json = JSON.parse(@json($article->content));
            let blocks = json.blocks
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


