<template>
  <div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid">
      <!--begin::Aside-->
      <div class="login-aside d-flex flex-column flex-row-auto">
        <!--begin::Aside Top-->
        <div class="d-flex flex-column-auto flex-column pt-15">
          <!--begin::Aside header-->
          <a href="#" class="login-logo text-center  pb-10">
            <img src="/admin/assets/media/logos/timetable.png" class="max-h-70px" alt="" />
          </a>
          <!--end::Aside header-->
          <!--begin::Aside Title-->
          <h3 class="font-weight-bolder text-center font-size-h4 text-dark-50 line-height-xl">User Timetable</h3>
          <!--end::Aside Title-->
        </div>
        <!--end::Aside Top-->
        <!--begin::Aside Bottom-->
        <div class="aside-img d-flex bgi-no-repeat bgi-position-x-center" style="background-position-y: calc(100% + 5rem); background-image: url(/admin/assets/media/svg/illustrations/login-visual-5.svg)"></div>
        <!--end::Aside Bottom-->
      </div>
      <!--begin::Aside-->
      <!--begin::Content-->
      <div class="login-content flex-row-fluid d-flex flex-column p-10">
        <!--begin::Top-->
        <div class="text-right d-flex justify-content-center">
          <div class="top-signin text-right d-flex justify-content-end pt-5 pb-lg-0 pb-10">
            <span class="font-weight-bold text-muted font-size-h4">Having issues?</span>
            <a href="javascript:;" class="font-weight-bold text-primary font-size-h4 ml-2" id="kt_login_signup">Get Help</a>
          </div>
        </div>
        <!--end::Top-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-center">
          <!--begin::Signin-->
          <div class="login-form">
            <!--begin::Form-->
            <form class="form" id="kt_login_singin_form" action="">
              <!--begin::Title-->
              <div class="pb-5 pb-lg-15">
                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h3>
              </div>
              <!--begin::Title-->
              <!--begin::Form group-->
              <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark">Your Email</label>
                <input v-model="auth.email" class="form-control h-auto py-7 px-6 rounded-lg border-0" :class="(errors.email) ? ' is-invalid' :''" type="text" name="username" autocomplete="off" />
                <span class="invalid-feedback" role="alert" v-if="errors.email">
                    <strong>{{errors.email[0]}}</strong>
                </span>
              </div>
              <!--end::Form group-->
              <!--begin::Form group-->
              <div class="form-group">
                <div class="d-flex justify-content-between mt-n5">
                  <label class="font-size-h6 font-weight-bolder text-dark pt-5">Your Password</label>
                </div>
                <input v-model="auth.password"  class="form-control h-auto py-7 px-6 rounded-lg border-0" :class="(errors.password) ? ' is-invalid' :''" type="password" name="password" autocomplete="off" />
                <span class="invalid-feedback" role="alert" v-if="errors.password">
                    <strong>{{errors.password[0]}}</strong>
                </span>
              </div>
              <!--end::Form group-->
              <!--begin::Action-->
              <div class="pb-lg-0 pb-5">
                <a href="javascript:void(0)" type="submit"  @click="login" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">{{ processing ? "Please wait" : "Login" }}</a>
              </div>
              <!--end::Action-->
            </form>
            <!--end::Form-->
          </div>
          <!--end::Signin-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Content-->
    </div>
    <!--end::Login-->
  </div>
</template>

<script>

import { mapActions } from 'vuex'
export default {
  name:"Login",
  data(){
    return {
      auth:{
        email:"",
        password:""
      },
      errors:{},
      processing:false
    }
  },
  methods:{
    ...mapActions({
      signIn:'auth/login'
    }),
    async login(){
      this.processing = true
      await axios.get('/sanctum/csrf-cookie')
      await axios.post('/login',this.auth).then((response)=>{
       axios.defaults.headers.common["Authorization"] = "Bearer " + response.data.token;
        this.signIn()
      }).catch((errors)=>{
        this.errors = errors.response.data.errors
      }).finally(()=>{
        this.processing = false
      })
    },
  }
}
</script>

<style scoped>

</style>
