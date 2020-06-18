@extends('backend.layout.app')

@section('page_title')
    Menus
@endsection

@section('buttons')
    <a href="/admin/menus/add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> menu</a>
@endsection

@section('content')
    <ul id="menu-list">
        <li style="background-color: #2a3f54; color: #fff;">
            <span class="item" style="width:70%;">Name</span>
            <span class="item" style="width:10%;">Status</span>
            <span class="item" style="width:10%;">Delete</span>
            <span class="item" style="width:10%;">Edit</span>
        </li>
        @php
            print $menuStr;
        @endphp
    </ul>
@endsection

@section('css')
    <!-- Datatables -->
    <link href="/backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <style>
        #menu-list .p-0{
            margin:0px;
        }
        #menu-list {
            width: 100%;
            text-decoration: none;
            list-style:none;
            padding:0px;
            margin:0px;
        }
        #menu-list li {
            display: table;
            width:100%;
            padding: 7px;
            margin-bottom:5px;
            background-color: #f9f9f9;
            color: #2a3f54;
        }
        #menu-list li span.item {
            display: table;
            float:left;
            text-align: left;
            font: 14.46px/22px Arial;
        }
        #menu-list  .btn-circle {
            border-radius: 50%;
            width: 22px;
            height: 22px;
        }
    </style>
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