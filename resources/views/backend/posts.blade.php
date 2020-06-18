@extends('backend.layout.app')

@section('page_title')
    Xəbər siyahısı
@endsection

@section('buttons')
    <a href="/admin/posts/add" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> Post </a>
@endsection

@section('content')
    <p class="text-muted font-13 m-b-30">
        <input id="filter" class="date-picker form-control col-md-7 col-xs-12" type="text" value="{{ $date }}">
    </p>
    <hr>
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive" cellspacing="0"
           width="100%">
        <thead>
        <tr>
            <th width="10px">#</th>
            <th>Title</th>
            <th>Category</th>
            <th>Image</th>
            <th width="100px">Date</th>
            <th width="25px">Status</th>
            <th width="25px">Delete</th>
            <th width="25px">Edit</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($posts as $key=>$post)
            <tr>
                <td>{{$key+1}}</td>
                <td>{!! $post->title !!} <span style="color:#FF0000">{{$post->short_title}}</span></td>
                <td>{{$post->category_data->name}}</td>
                <td><img src="{{\App\Http\Helpers::getImageUrl($post->image, 'small')}}" width="100px"></td>
                <td>{{$post->date}}</td>
                <td class="text-center">
                    @if ($post->active == 1)
                        <span class="btn btn-xs btn-success">&#10004;</span>
                    @else
                        <span class="btn btn-xs btn-danger">x</span>
                    @endif
                </td>
                <td class="text-center">
                    <button onclick="delete_item(this, '{{$post->slug}}');" class="btn btn-danger btn-xs">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
                <td class="text-center">
                    <a href="/admin/posts/edit/{{$post->slug}}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('css')
    <!-- bootstrap-daterangepicker -->
    <link href="/backend/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="/backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <!-- bootstrap-daterangepicker -->
    <script src="/backend/vendors/moment/min/moment.min.js"></script>
    <script src="/backend/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
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

            $('#filter').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
            }, function(start, end, label) {
                location.href = '/admin/posts/' + start.format('YYYY-MM-DD')
            });
        });
        function delete_item(e, slug) {
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
                            'slug': slug
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