<template>
  <div class="diynamic_container">
    <div class="loginPage">
      <div class="img_containr">
        <img src="/front/images/login.png" alt="">
      </div>
      <div class="login_part">
        <div class="login_card">
          <form action="javascript:void(0)">
            <div v-if="submitted && fail" class="heightError">
              <small  class="form-text text-danger">{{fail}}</small>
            </div>
            <label for="email">{{ $t('login.email') }}</label>
            <div class="input_row_login">

              <input type="email"
                     :placeholder="$t('login.enter_email')"
                     v-model="auth.email"
                     id="email"
                     @blur="validate('email')"
                     @keypress="validate('email')"
              >
              <!--                            <div v-if="submitted && errors.hasOwnProperty('email')" class="heightError">-->
              <!--                                <small  class="form-text text-danger">{{errors.email[0] }}</small>-->
              <!--                            </div>-->
              <div v-if="!!errors.email" class="heightError">
                <small class="form-text text-danger">{{(typeof errors.email == 'object' ? errors.email[0] : errors.email) }}</small>
              </div>


            </div>
            <label for="password">{{ $t('login.password') }}</label>
            <div class="input_row_login">
              <div class="password_input">
                <input
                    id="password"
                    :type="[showPassword ? 'text' : 'password']"
                    class="form-control"
                    name="password"
                    :placeholder="$t('login.enter_password')"
                    v-model="auth.password"
                    @blur="validate('password')"
                    @keypress="validate('password')"
                >
                <span toggle="#password" :class="[showPassword ? 'fas fa-eye-slash' : 'fas fa-eye' ]" @click="showPassword = !showPassword"></span>
              </div>
              <!--                            <div v-if="submitted && errors.hasOwnProperty('password')" class="heightError">-->
              <!--                                <small class="form-text text-danger">{{errors.password[0] }}</small>-->
              <!--                            </div>-->

              <div v-if="!!errors.password" class="heightError">
                <small class="form-text text-danger">{{errors.password }}</small>
              </div>
            </div>


            <button type="submit" class="login_btn" value="Login" @click.prevent="login" >{{ $t('login.logins') }}</button>
            <router-link to="/forget-password" class="forget_password">{{ $t('login.forget_password') }}</router-link>
            <p class="continue_with">{{ $t('login.Continue_With') }}</p>
            <div class="socail_links">
              <a href="javascript:void(0)" class="face_icon"><img src="/front/images/facebook.png" alt=""></a>
              <a href="javascript:void(0)" class="gmail_icon"><img src="/front/images/gmail.png" alt=""></a>
              <a href="javascript:void(0)" class="insta_icon"><img src="/front/images/instagram.png" alt=""></a>
            </div>
            <div class="have_account">
              <span>{{ $t("login.not_have_account") }}</span>
              <router-link to="/register" class="register_btn">{{$t('login.register')}}</router-link>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import axios from "axios";
import * as yup from 'yup';

const loginFormSchema = yup.object().shape({
  email: yup.string().required().email(),
  password: yup.string().required().min(8).max(12),
});

export default {
  name:"login",
  data(){
    return {
      errors: {
        email: "",
        password: "",
      },
      auth:{
        email:"",
        password:""
      },
      showPassword:false,
      submitted:false,
      validated:false
    }
  },
  computed:{
    ...mapGetters({
      fail:'auth/error'
    })
  },
  methods:{
    ...mapActions({
      signIn:'auth/login',
    }),
    login(){
      loginFormSchema
          .validate(this.auth, { abortEarly: false })
          .then(() => {
            this.errors = {};
            this.userLogin()
          })
          .catch(err => {
            err.inner.forEach(error => {
              this.errors = { ...this.errors, [error.path]: error.message };
            });
          });

    },
    validate(field) {
      loginFormSchema
          .validateAt(field, this.auth)
          .then(() => {
            this.errors[field] = "";
          })
          .catch(err => {
            this.errors[field] = err.message;
          });
    },
    userLogin(){
      this.submitted = true
      axios.get('/sanctum/csrf-cookie')
      axios.post('/login',this.auth).then((response)=>{
        axios.defaults.headers.common["Authorization"] = "Bearer " + response.data.token;
        this.signIn()
      }).catch((errors)=>{
        this.errors = errors.response.data.errors
      })
    }

  },
}
</script>
<style scoped>
.heightError{
  color: red;
  margin-bottom: 10px;
}
#email, .password_input{
  margin-bottom: 15px;
}
</style>
