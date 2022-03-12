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

<div class="modal fade" id="pharmacyModal" tabindex="-1" role="dialog" aria-labelledby="pharmacyModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pharmacyLabel">Create Pharmacy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="pharmacyForm">
                    <input type="hidden" value="" id="pharmacyId" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pharmacy Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control"  placeholder="Pharmacy Name" name="name"/>
                                <span class="invalid-feedback " role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pharmacy Phone<span class="text-danger">*</span></label>
                                <input type="number" class="form-control"  placeholder="Pharmacy Phone" name="phone"/>
                                <span class="invalid-feedback " role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pharmacy Address<span class="text-danger">*</span></label>
                                <input type="text" class="form-control"  placeholder="Pharmacy Address" name="address"/>
                                <span class="invalid-feedback " role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pharmacy Website<span class="text-danger">*</span></label>
                                <input type="url" class="form-control"  placeholder="Pharmacy Website" name="website"/>
                                <span class="invalid-feedback " role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User Status<span class="text-danger">*</span></label>
                                <select class="form-control select2" id="kt_select2_3" name="status">
                                    <option required selected disabled>Select User Status</option>
                                    <option value="1"> Active </option>
                                    <option value="0"> IN Active </option>
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
                    placeholder: "Select User Status",
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
        $('#userModal').on('hidden.bs.modal', function () {
             $("#pharmacyLabel").text('Create User')
             let elements = $("#userForm input, #userForm select")
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
            let url = `/dashboard/pharmacies/${$(this).data('id')}/edit`
            axios({
                method: 'get',
                url: url,
            }).then((response) => {
                if(response.status){
                    $("#pharmacyLabel").text('Edit Pharmacy')
                    for (const [key, value] of Object.entries(response.data.data)) {
                        $("input[name='"+key+"']").val(value)
                        $("select[name='"+key+"']").val(value).trigger('change')
                    }
                    $('#pharmacyModal').modal('show');
                }
            }, (error) => {
                console.log(error)
            });

        });
    </script>
@endpush