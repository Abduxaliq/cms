@extends('backend.layout.app')

@section('page_title')
    Advertising
@endsection

@section('buttons')
    <a href="/admin/ads/add" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> Advertising </a>
@endsection

@section('content')
    <p class="text-muted font-13 m-b-30">

    </p>
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
           width="100%">
        <thead>
        <tr>
            <th width="25px">#</th>
            <th>Position</th>
            <th width="50px">Delete</th>
            <th width="50px">Edit</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($ads as $key=>$ad)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$ad->position}}</td>
                <td class="text-center">
                    <button onclick="delete_item(this, '{{$ad->id}}');" class="btn btn-danger btn-xs">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
                <td class="text-center">
                    <a href="/admin/ads/edit/{{$ad->id}}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('css')
    <!-- Datatables -->
    <link href="/backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <!-- Datatables -->
    <script src="/backend/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/backend/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/backend/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/backend/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="/backend/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="/backend/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/backend/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/backend/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/backend/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="/backend/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="/backend/vendors/jszip/dist/jszip.min.js"></script>
    <script src="/backend/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="/backend/vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="/js/sweetalert2.min.js"></script>
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/messages_az.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#datatable-responsive').DataTable();
        });
        function delete_item(e, id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:'',
                        type:'POST',
                        data: {
                            '_token':' {{csrf_token()}}',
                            'id': id
                        },
                        success:function (response) {
                            Swal.fire(
                                response.title,
                                response.description,
                                response.status
                            )
                            if(response.status == 'success') {
                                e.closest('tr').remove();
                            }
                        }
                    });
                }
            })
        }
    </script>
@endsection