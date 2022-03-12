@extends('admin.layouts.app')

@section('title', 'timetables')

@section('content')
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">@lang('admin.timetables')</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard.home')}}" class="text-muted">@lang('admin.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard.timetables.index')}}" class="text-muted">@lang('admin.timetables')</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid mt-5" id="kt_content">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom gutter-b" style="width: 100%;">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">@lang('admin.timetables')</h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <a href="javascript:void(0)" class="btn btn-primary font-weight-bolder d-flex " id="add_timetable"  data-toggle="modal" data-target="#timetableModal" >
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"></rect>
                                <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>@lang('admin.new-timetable')</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">
                @include('admin.timetables.create_edit_form')
                <!--begin: Datatable-->
                    <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-checkable " id="pharmacy_datatable">
                                    <thead>
                                    <tr role="row">
                                        <th>@lang('admin.id')</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>@lang('admin.created_at')</th>
                                        <th>@lang('admin.actions')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection

@push('js')
    <script src="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            var table =  $('#pharmacy_datatable')

            let timetableTable =  table.DataTable({
                lengthChange: true,
                processing: true,
                serverSide: true,
                responsive: true,
                dom: 'Blfrtip',
                "buttons": [
                    'colvis'
                ],
                paging: true,
                ajax: {
                    url :'/dashboard/get-timetables',
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {}
                },
                columns: [
                    {
                        "data": "id",
                        render: function(data, type, full, meta) {
                            return `
                                      <label class="checkbox checkbox-single">
                                          <input type="checkbox" value="${data.id}" class="checkable"/>
                                          <span></span>
                                      </label>`;
                        },
                    },
                    {data: 'user'},
                    {data: 'date'},
                    {data: 'created_at'},
                    {
                        data:'id',
                        orderable: false,
                        width: '125px',
                        render: function(data) {
                            return `
                              <a href= "javascript:void(0)" data-id="${data}" class="btn btn-sm btn-clean btn-icon mr-2 editRow" title="Assign Pharmacy" >
                                  <span class="svg-icon svg-icon-md">
                                      <i class="ki ki-solid-plus"></i>
                                  </span>
                              </a>

                               <a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon delRow"  data-id="${data}"  title="Delete">
                                  <span class="svg-icon svg-icon-md">
                                      <svg class="delete" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                              <rect x="0" y="0" width="24" height="24"></rect>
                                              <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                                              <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                                          </g>
                                      </svg>
                                  </span>
                               </a>`;
                        },
                    }


                ],
                lengthMenu: [5, 10, 25, 50],
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                }
            });
            //Create
            $("#save").on('click', function (event) {
                event.preventDefault()
                $("#timetableForm input, #timetableForm select").map((index, value)=> $(value).removeClass('is-invalid') )
                axios({
                    method: 'POST',
                    url: currentLocation,
                    data: {
                        user_id: $("select[name='user_id']").val(),
                        start_date: $("#start_date").val(),
                        end_date: $("#end_date").val(),
                    }
                }).then((response) => {
                    if(response.status){
                        Swal.fire(
                            'Good job!',
                            response.data.message,
                            'success'
                        )
                        $('#timetableModal').modal('hide');
                        timetableTable.ajax.reload();
                    }
                }, (error) => {
                    let errors = error.response.data.errors
                    $.each(errors, function( index, value ) {
                        if($(`input[name=${index}]`).length > 0){
                            if(index == 'start_date'){
                                $("#kt_daterangepicker_1").addClass('is-invalid')
                                $(`.${index}`).text(value)
                            }
                            bindErrorMessages(index, value, 'input')
                        }else if( $(`select[name=${index}]`).length > 0 ){
                            bindErrorMessages(index, value, 'select')
                        }
                    });
                });
            })
            //Delete
            $(document).on('click','.delRow',function (){
                let url = '/dashboard/timetables/'+$(this).data('id')
                swalDel(url, timetableTable);
            });

            //Assign
            $("#assign_save").on('click', function (event) {
                event.preventDefault()
                $("#AssignForm input, #AssignForm select").map((index, value)=> $(value).removeClass('is-invalid') )
                axios({
                    method: 'POST',
                    url: '/dashboard/assign-pharmacies',
                    data: {
                        pharmacy_id: $("select[name='pharmacy_id']").val(),
                        time_from: $("input[name='time_from']").val(),
                        time_to: $("input[name='time_to']").val(),
                        date_id: $("input[name='date_id']").val(),
                    }
                }).then((response) => {
                    if(response.status){
                        Swal.fire(
                            'Good job!',
                            response.data.message,
                            'success'
                        )
                        $('#assignModal').modal('hide');
                        timetableTable.ajax.reload();
                    }
                }, (error) => {
                    let errors = error.response.data.errors
                    $.each(errors, function( index, value ) {
                        if($(`input[name=${index}]`).length > 0){
                            if(index == 'start_date'){
                                $("#kt_daterangepicker_1").addClass('is-invalid')
                                $(`.${index}`).text(value)
                            }
                            bindErrorMessages(index, value, 'input')
                        }else if( $(`select[name=${index}]`).length > 0 ){
                            bindErrorMessages(index, value, 'select')
                        }
                    });
                });
            })
        });
    </script>
@endpush