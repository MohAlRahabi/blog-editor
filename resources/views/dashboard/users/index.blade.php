@extends('dashboard.layout.main')
@section('content')
    <div class="p-4">
        <div class="pt-2">
            <button
                class="edit btn btn-xs btn-dark mb-4"
                href="javascript:" onclick="openAdd()">
                <i class="fas fa-plus"></i>
                 Add New User
            </button>
        </div>

        <div style="min-height: 300px;">
            <table class="table table-bordered table-striped" id="users_table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
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
            table = $('#users_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.data') }}",
                },
                lengthMenu : [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: 'Blfrtip',
                fixedHeader: true,
                buttons: [

                ],
                columns: [
                    {"data": "user_name"},
                    {"data": "email"},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
            });

            table.on('click', '.delete', function () {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent')
                }
                var data = table.row($tr).data();
                deleteOpr(data.id, `admin/users/` + data.id, table);
            });

        });
    </script>
@endpush
