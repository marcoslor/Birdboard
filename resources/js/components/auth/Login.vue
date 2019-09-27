<template>
    <div class="">
        <div class="flex" style="min-height: 100vh;">
            <div class="lg:w-1/2"
                 style="background-image: url('https://picsum.photos/id/1015/1200/1200'); background-size: cover; background-position: center;"></div>
            <div class="w-full lg:w-1/2 flex">
                <div class="card m-auto p-12">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label class="" for="email">E-mail adress</label>
                                <div class="">
                                    <input autocomplete="email" autofocus class="form-control" id="email" name="email"
                                           required type="email" v-model="form.email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="" for="password">Password</label>

                                <div class="">
                                    <input autocomplete="current-password" class="form-control " id="password"
                                           name="password" required type="password" v-model="form.password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" id="remember" name="remember" type="checkbox">
                                        <label class="form-check-label" for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button class="btn btn-primary" v-on:click="login">
                                        Login
                                    </button>

                                    <a class="btn btn-link" href="">
                                        Forgot your password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import {login} from "../../helpers/auth.js"

  export default {
    name: 'login',
    data: function () {
      return {
        form: {
          email: '',
          password: ''
        }
      }
    },
    methods: {
      authenticate() {
        this.$store.dispatch('login');

        login(this.$data.form).then((res) => {
          this.$store.commit("login_success", {res})

        }).catch((error) => {
          this.$store.commit("login_failed", {error})
        })
      }
    }
  }
</script>
