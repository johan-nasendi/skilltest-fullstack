<template>
    <div class="content-page mt-1" v-if="isLoggedIn">
        <div class="content" v-if="loginType = 'user'">
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
                                        <h3 class="text-white my-1"><span data-plugin="counterup">60</span></h3>
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
                                        <p class="text-muted mb-0 text-truncate"> Members </p>
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
                                        <i class="fe-check avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-white my-1"><span data-plugin="counterup">40</span></h3>
                                        <p class="text-muted mb-0 text-truncate"> Data </p>
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
                                        <h3 class="text-white my-1"><span data-plugin="counterup">30</span></h3>
                                        <p class="text-muted mb-0 text-truncate">Other Items</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-box-->
                    </div> <!-- end col -->
                </div>


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
            this.message = this.$route.params.message
        }
    },
     mounted() {
      this.setUser()

    },
    methods: {
     async setUser() {
          this.user = JSON.parse(localStorage.getItem('user'))
          this.isLoggedIn = localStorage.getItem('token') != null

          if(this.isLoggedIn === false ){
            this.$notify({
                type: "error",
                title: "Authorization",
                text: "Please Log In!",
            });
            this.$router.push('/')
          }
        },
    }
}
</script>
