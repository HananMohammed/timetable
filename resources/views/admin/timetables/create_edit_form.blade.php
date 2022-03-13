@push('css')
    <style>
        .select2{
            width: 100%!important;
        }
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush

<div class="modal fade" id="timetableModal" tabindex="-1" role="dialog" aria-labelledby="timetableModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timetableLabel">Create TimeTable</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="timetableForm">
                    <input type="hidden" name="start_date" id="start_date">
                    <input type="hidden" name="end_date" id="end_date">
                    <div class="form-group">
                        <label>User <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="kt_select2_3" name="user_id">
                            <option required selected disabled>Select User</option>
                            @if(!empty($users))
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="invalid-feedback " role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Range Date <span class="text-danger">*</span></label>
                        <input type='text' value="" class="form-control" id="kt_daterangepicker_1" readonly placeholder="Select date range" name="range_date"/>
                        <span class="invalid-feedback start_date" role="alert" id=""></span>
                        <span class="invalid-feedback end_date" role="alert" id=""></span>
                    </div>
                </form>
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="save">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignLabel">Assign Pharmacy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="AssignForm">
                    <input type="hidden" value="" name="date_id" id="date_id">
                    <div class="form-group">
                        <label>Pharmacy <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="kt_select2_4" name="pharmacy_id" multiple="multiple">
                            @if(!empty($pharmacies))
                                @foreach($pharmacies as $pharmacy)
                                    <option value="{{$pharmacy->id}}">{{$pharmacy->name}}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="invalid-feedback " role="alert"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Time <span class="text-danger">*</span></label>
                                <input class="form-control" id="kt_timepicker_1" readonly placeholder="Select time" name="time_from" type="text"/>
                                <span class="invalid-feedback" role="alert" id=""></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Time <span class="text-danger">*</span></label>
                                <input class="form-control" id="kt_timepicker_1" readonly placeholder="Select time" name="time_to" type="text"/>
                                <span class="invalid-feedback" role="alert" id=""></span>
                            </div>
                        </div>
                    </div>

                </form>
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="assign_save">Save changes</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        var KTSelect2 = function() {
            var demos = function() {
                $('#kt_select2_3').select2({
                    placeholder: "Select User Status",
                });
                $('#kt_select2_4').select2({
                    placeholder: "Select Pharmacies",
                });
            }
            // Public functions
            return {
                init: function() {
                    demos();
                }
            };
        }();
        var KTBootstrapDaterangepicker = function () {
            var demos = function () {
                $('#kt_daterangepicker_1, #kt_daterangepicker_1_modal').daterangepicker({
                    buttonClasses: ' btn',
                    applyClass: 'btn-primary',
                    cancelClass: 'btn-secondary',
                }, function(start, end, label) {
                    $("#start_date").val(start.format('YYYY-MM-DD'))
                    $("#end_date").val(end.format('YYYY-MM-DD'))
                    $('#kt_daterangepicker_1 .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                }).val('');
            }
            return {
                init: function() {
                    demos();
                }
            };
        }();
        var KTBootstrapTimepicker = function () {
            var demos = function () {
                // minimum setup
                $('#kt_timepicker_1, #kt_timepicker_1_modal').timepicker().val('');
            }
            return {
                // public functions
                init: function() {
                    demos();
                }
            };
        }();
        // Initialization
        jQuery(document).ready(function() {
            KTSelect2.init();
            KTBootstrapDaterangepicker.init();
            KTBootstrapTimepicker.init();
        });

        let bindErrorMessages = (index, value, element)=>{
            $(`${element}[name=${index}]`).addClass('is-invalid')
            $(`${element}[name=${index}]`).parent().children('.invalid-feedback').html(`<strong>${value}</strong>`)
        }
        $('#timetableModal').on('hidden.bs.modal', function () {
             $("#timetableLabel").text('Create Timetable')
             let elements = $("#timetableForm input, #timetableForm select")
             elements.each(function( index ) {
                if( $(this).is('select') ) {
                    $(this).val('').trigger('change')
                }else{
                    $(this).val('')
                }
                $(this).removeClass('is-invalid')
                $(this).parent().children('.invalid-feedback').text('')
             });
        })
        $('#assignModal').on('hidden.bs.modal', function () {
            let elements = $("#AssignForm input, #AssignForm select")
            elements.each(function( index ) {
                if( $(this).is('select') ) {
                    $(this).val('').trigger('change')
                }else{
                    $(this).val('')
                }
                $(this).removeClass('is-invalid')
                $(this).parent().children('.invalid-feedback').text('')
            });
        })
        $(document).on('click','.editRow',function (){
            let date_id = $(this).data('id');
            $("#date_id").val(date_id)
            $("#assignModal").modal('show')
        });
    </script>
@endpush