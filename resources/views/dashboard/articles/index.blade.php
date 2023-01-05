@extends('dashboard.layout.main')
@section('content')
    <div class="p-4">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{$message}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="pt-2">
            <a
                class="btn btn-xs btn-dark mb-4"
                href="{{route('articles.create')}}">
                <i class="fas fa-plus"></i>
                 Add New Article
            </a>
        </div>

        <div style="min-height: 300px;">
            <table class="table table-bordered table-striped" id="article_table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop
@push('scripts')
    <script>
        let table;
        $(function () {
            table = $('#article_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('articles.data') }}",
                },
                lengthMenu : [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: 'Blfrtip',
                fixedHeader: true,
                buttons: [

                ],
                columns: [
                    {"data": "title"},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
            });

            table.on('click', '.delete', function () {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent')
                }
                var data = table.row($tr).data();
                deleteOpr(data.id, `admin/articles/` + data.id, table);
            });

        });
    </script>
@endpush
