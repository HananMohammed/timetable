@push('css')
    <style>
        .select2{
            width: 100%!important;
        }
    </style>
@endpush

<div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-labelledby="adminModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminLabel">Create Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="adminForm">
                    <input type="hidden" value="" id="adminId" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Admin Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control"  placeholder="Enter Admin Name" name="name"/>
                                <span class="invalid-feedback " role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Admin Username<span class="text-danger">*</span></label>
                                <input type="text" class="form-control"  placeholder="Enter Admin username" name="username"/>
                                <span class="invalid-feedback " role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Admin Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control"  placeholder="Enter Admin Email" name="email"/>
                                <span class="invalid-feedback " role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control"  placeholder="Enter Admin password" name="password"/>
                                <span class="invalid-feedback " role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control"  placeholder="Confirm Admin password" name="password_confirmation"/>
                                <span class="invalid-feedback " role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Admin Status<span class="text-danger">*</span></label>
                                <select class="form-control select2" id="kt_select2_3" name="status">
                                    <option required selected disabled>Select Admin Status</option>
                                    <option value="1"> Active </option>
                                    <option value="0"> IN Active </option>
                                </select>
                                <span class="invalid-feedback " role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Assign Role <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="kt_select2_4" name="role" >
                                    <option required selected disabled>Select Admin Role</option>
                                    @if(!empty($roles))
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="invalid-feedback " role="alert"></span>
                            </div>
                        </div>
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

@push('js')
    <script>
        var KTSelect2 = function() {
            var demos = function() {
                $('#kt_select2_3').select2({
                    placeholder: "Select Admin Status",
                });
                $('#kt_select2_4').select2({
                    placeholder: "Select Role",
                });
            }
            // Public functions
            return {
                init: function() {
                    demos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function() {
            KTSelect2.init();
        });

        let bindErrorMessages = (index, value, element)=>{
            $(`${element}[name=${index}]`).addClass('is-invalid')
            $(`${element}[name=${index}]`).parent().children('.invalid-feedback').html(`<strong>${value}</strong>`)
        }
        $('#adminModal').on('hidden.bs.modal', function () {
             $("#rolesLabel").text('Create Admin')
             let elements = $("#adminForm input, #adminForm select")
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
            let url = `/dashboard/admins/${$(this).data('id')}/edit`
            axios({
                method: 'get',
                url: url,
            }).then((response) => {
                if(response.status){
                    $("#rolesLabel").text('Edit Admin')
                    for (const [key, value] of Object.entries(response.data.data)) {
                        $("input[name='"+key+"']").val(value)
                        $("select[name='"+key+"']").val(value).trigger('change')
                    }
                    $('#adminModal').modal('show');
                }
            }, (error) => {
                console.log(error)
            });

        });
    </script>
@endpush