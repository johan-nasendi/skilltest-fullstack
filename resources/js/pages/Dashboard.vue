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
                <div class="row">
                    <div class="col-lg-6 col-xl-3">
                        <div class="card-box bg-pattern  bg-dark">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-md bg-secondary rounded">
                                        <i class="fe-list avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-white my-1"><span data-plugin="counterup">50</span></h3>
                                        <p class="text-muted mb-0 text-truncate">My Task</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-box-->
                    </div> <!-- end col -->

                    <div class="col-lg-6 col-xl-3">
                        <div class="card-box bg-pattern bg-dark">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-md bg-blue rounded">
                                        <i class="fe-layers avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-white my-1"><span data-plugin="counterup"> 50 </span></h3>
                                        <p class="text-muted mb-0 text-truncate"> Todo List </p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-box-->
                    </div> <!-- end col -->

                    <div class="col-lg-6 col-xl-3">
                        <div class="card-box bg-pattern  bg-dark">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-md bg-success rounded">
                                        <i class="fe-users avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-white my-1"><span data-plugin="counterup">50</span></h3>
                                        <p class="text-muted mb-0 text-truncate">Mebers</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-box-->
                    </div> <!-- end col -->
                    <div class="col-lg-6 col-xl-3">
                        <div class="card-box bg-pattern bg-dark">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-md bg-danger rounded">
                                        <i class="fe-check avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-white my-1"><span data-plugin="counterup">50</span></h3>
                                        <p class="text-muted mb-0 text-truncate">Other Items</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-box-->
                    </div> <!-- end col -->
                </div>
                <!-- end row card-->


            </div>
        </div>
    </div>
</template>

<script>
export default {
  name:'Dashboard',
  data() {
      return {
        user: {},
        serverErros:'',
        loginType: '',
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
       setUser() {
          this.user = JSON.parse(localStorage.getItem('user'))
          this.isLoggedIn = localStorage.getItem('token') != null

           axios.get('https://testskill-fullstack.herokuapp.com/api/user',{ useCredentails: true })
            .then(response => {
                this.user = response.data
                this.loginType = response.data.roles[0].name
            })
            .catch(error => {
            if (error.response.status === 422) {
                localStorage.clear();
                this.$router.push('/login')
            }
           if(error.response.status === 500){
                    this.serverErros = error.response.message + ' Opsss... Internal Server Error,Try once Again!'
             }
            })
        },

        getDataCount(){
            axios.get('/api/user/dailyreport')
                .then(response => {
                    this.daily = response.data.daily
            }).catch(error => {
                console.error(error);
                this.daily = []
            }).catch(error => {
                if(error.response.status === 500){
                    this.serverErros = error.response.status + ' Opsss... Internal Server Error,Try once Again!'
                }
            });
        },

    }
}
</script>
