<template>
    <div class="content-page mt-1" v-if="isLoggedIn">
        <div class="content" v-if="loginType === 'user'">
            <div class="container-fluid">
                <!-- Start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>
                             <h4 class="page-title">Dashboard</h4>
                        </div>
                    </div>
                </div>
                 <!-- Eend page titile -->
                 <div v-if="serverErros" class="alert bg-danger text-white alert-dismissible fade show" role="alert">
                    <strong><i class="mdi mdi-information-outline mdi-18px mr-1"></i>
                        {{serverErros}}
                     </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                 <!-- Start Card  -->





            </div>
        </div>
    </div>
</template>

<script>
export default {
  name:'TodoList',
  data() {
      return {
        user: {},
        serverErros:'',
        loginType: '',
        todo:[],
        isLoggedIn: false,
      }
    },
    created() {
        if (this.$route.params.message !== undefined) {
            this.message = this.$route.params.message}

      axios.defaults.headers.common['Content-Type'] = 'application/json'
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')

    },
     mounted() {
      this.setUser()
    },
    methods: {
      async setUser() {
          this.user = JSON.parse(localStorage.getItem('user'))
          this.isLoggedIn = localStorage.getItem('token') != null

          await axios.get('https://testskill-fullstack.herokuapp.com/api/user',{ useCredentails: true })
            .then(response => {
                this.user = response.data
                this.loginType = response.data.roles[0].name
            })
            .catch(error => {
            if (error.response.status === 401) {
                localStorage.clear();
                this.$router.push('/login')
            }
           if(error.response.status === 500){
                    this.serverErros = error.response.status + ' Opsss... Internal Server Error,Try once Again!'
             }
            })
        },

        GetdataTodo(){
            axios.get('#')
                .then(response => {
                    this.todo = response.data.todo
            }).catch(error => {
                console.error(error);
                this.todo = []
            }).catch(error => {
                if(error.response.status === 500){
                    this.serverErros = error.response.status + ' Opsss... Internal Server Error,Try once Again!'
                }
            });
        },

    }
}
</script>
