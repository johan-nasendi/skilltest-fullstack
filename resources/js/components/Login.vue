<template>
    <div class="account-pages mt-3 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern bg-dark">
                            <div class="card-body p-4">
                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                               <img src="/assets/images/logo-sm.png" alt="logo" height="44">
                                            </span>
                                        </a>
                                        <a  class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="/assets/images/logo-sm-light.png" alt="logo" height="44">
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin panel.</p>
                                </div>

                                <p class="text-success mb-4 mt-3" v-if="showLoading">
                                   Loading....
                                 </p>

                                <div v-if="message" class="alert bg-success text-dark alert-dismissible fade show" role="alert">
                                    <strong >
                                        <i class="mdi mdi-information-outline mdi-18px mr-1"></i> {{message}}
                                    </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div v-if="error" class="alert bg-danger text-white dark-dismissible fade show" role="alert">
                                    <strong >
                                        <i class="mdi mdi-information-outline mdi-18px mr-1"></i>{{error}}
                                    </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div v-if="serverErros" class="alert bg-danger text-white alert-dismissible fade show" role="alert">
                                    <strong >
                                        <i class="mdi mdi-information-outline mdi-18px mr-1"></i>{{serverErros}}
                                    </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>


                                <form @submit.prevent="loginForm">
                                    <div class="form-group mb-3">
                                        <label>Email address</label>
                                        <input id="email" type="email" class="form-control bg-dark text-white"
                                        placeholder="Enter your email"  v-model="email" name="email" required autocomplete="on" autofocus >
                                    </div>
                                     <div class="form-group mb-3">
                                        <label>Password</label>
                                        <div class="input-group input-group-merge">
                                            <input v-if="showPassword" type="text"  class="form-control bg-dark text-white"
                                            placeholder="Enter your password"  v-model="password" />
                                            <input v-else type="password"  class="form-control bg-dark text-white"
                                            required autocomplete="on" autofocus placeholder="Enter your password" v-model="password">
                                            <div class="input-group-append">
                                                <div class="input-group-text bg-dark" @click="toggleShow">
                                                    <span class="fas text-white" :class="{ 'fa-eye-slash': showPassword, 'fa-eye': !showPassword }"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-outline-success btn-block" type="submit" @click="showLoading = true">
                                            Log In
                                        </button>
                                    </div>
                                </form>
                                 <p class="text-muted text-right mb-4 mt-3">
                                    <router-link class="text-white ml-1" :to="{name: 'sendemail'}">Forgot Password</router-link>
                                 </p>
                                 <p class="text-muted mb-4 mt-3">I don't have an account yet?
                                    <router-link class="text-white ml-1" :to="{name: 'register'}"> Sign Up Now</router-link>
                                 </p>

                                 <!-- <p class="text-muted mb-4 mt-3">
                                   <a href="https://testskill-fullstack.herokuapp.com/api/documentation" class="text-white ml-1" target="_blank">Docs API</a>
                                 </p> -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
export default {
    name:"Login",
    data() {
      return {
        error: '',
        showPassword: false,
        hidePassword: null,
        showLoading: false,
        email: '',
        password: '',
        message: '',
        serverErros: '',
      }
    },
    created() {
      if (this.$route.params.message !== undefined) {
        this.message = this.$route.params.message + ' Please login!'
      }
    },
    computed: {
        buttonLabelFirst() {
        return (this.showPassword) ? "Hide" : "Show";
        },
    },
    methods: {
    async loginForm() {
       await axios.post('https://testskill-fullstack.herokuapp.com/api/login',
        {email: this.email,password: this.password})
          .then(response => {
            localStorage.setItem('user', JSON.stringify(response.data.user))
            localStorage.setItem('token', response.data.token)

            let loginType = response.data.user.roles[0].name
            if (loginType === 'user') {
                this.$notify({
                    type: "success",
                    title: "Welcome",
                    text: response.data.message,
                });
                this.$router.push({
                    name: 'user',
                })

            } else if (loginType === 'admin') {
                this.$notify({
                    type: "success",
                    title: "Hi Admin",
                    text: response.data.message,
                });
              this.$router.push({
                    name: 'admin',
              })
            } else if (loginType === 'mentor') {
                this.$notify({
                    type: "success",
                    title: "Hi Mentor",
                    text: response.data.message,
                });
              this.$router.push({
                    name: 'mentor',
              })
            } else {
              this.$router.push('home')
            }

            this.$emit('loggedIn')

          })
          .catch(error => {
              if(error.response.message === 500){
                 this.serverErros = error.response.message + ' Opsss... Internal Server Error,Try once Again!'
              }
              this.error = error.response.data.message
          });
      },
      toggleShow() {
            this.showPassword = !this.showPassword;
        },

    }
}
</script>
