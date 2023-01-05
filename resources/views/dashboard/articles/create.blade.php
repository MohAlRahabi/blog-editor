@extends('dashboard.layout.main')
@section('content')
    <div class="p-4">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form id="frm_add" class="add-form" action="{{route("articles.store")}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="content" id="content"/>
            <div class="row align-items-center">
                <div class="form-group col-md-12">
                    <label class="required-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}">
                </div>
                <div class="form-group col-md-12">
                    <label class="required-label">Content</label>
                    <div id="editorjs" >

                    </div>
                </div>
            </div>



            <div class="row justify-content-end">
                <div class="form-group mt-2">
                    <button type="button" id="saveBtn" class="edit btn btn-primary px-5" >
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>

    @component('dashboard.articles.gif_images_modal')
    @endcomponent

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script src="{{asset('js/GifImageTool.js')}}"></script>
    <script>
        const editor = new EditorJS({
            holder: 'editorjs',
            autofocus: true ,
            tools: {
                image:
                {
                class: GifImageTool,
                    inlineToolbar: true,
                    config: {
                        endpoint: "{{env('GIF_ENDPOINT')}}",
                    }
                }
            }
        })

        $("#saveBtn").on('click',function (event) {
            event.preventDefault();
            editor.save().then( savedData => {
                console.log(savedData)
                $("#content").val(JSON.stringify(savedData, null, 4));
                $("#frm_add").submit();
            })
        })

    </script>
@endpush
