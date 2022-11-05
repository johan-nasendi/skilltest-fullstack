<template>
    <div class="content-page mt-1" v-if="isLoggedIn">
        <div class="content" v-if="loginType = 'user'">
            <!-- Start Content-->
             <div class="container-fluid">

                <!-- start page title -->
                 <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a><router-link class="text-dark" :to="{name: 'user'}">Dashboard</router-link></a></li>
                                    <li class="breadcrumb-item"><a><router-link class="text-dark" :to="{name: 'todolist'}">My Todo List</router-link></a></li>
                                    <li class="breadcrumb-item active">Detail</li>
                                </ol>
                            </div>
                            <h4 class="page-title">
                                <a>
                                    <router-link class="text-dark" :to="{name: 'todolist'}">
                                        <i class="mdi mdi-close-circle mr-1 mdi-24px text-danger" title="BACK"></i>
                                    </router-link>
                                </a>
                            </h4>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <!-- project card -->
                        <div class="card bg-dark bg-pattern d-block">
                            <div class="card-body ">
                                <h4 class="text-white"> {{task.title}} </h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- assignee -->
                                        <p class="mt-2 mb-1 text-muted">Author</p>
                                        <div class="media" >
                                            <img v-if="user.userimage" :src="'https://testskill-fullstack.herokuapp.com/photos/'+user.userimage" alt="" class="rounded-circle mr-2" height="24" />
                                            <img v-else src="/assets/images/users/user-5.jpg" alt="Arya S" class="rounded-circle mr-2" height="24">
                                            <div class="media-body">
                                                <h5 class="mt-1 font-size-14 text-white">
                                                    {{user.name}}
                                                </h5>
                                            </div>
                                        </div>
                                        <!-- end assignee -->
                                    </div> <!-- end col -->



                                    <div class="col-md-4">
                                        <!-- start due date -->
                                        <p class="mt-2 mb-1 text-muted">Date</p>
                                        <div class="media">
                                            <i class="mdi mdi-calendar-month-outline font-18 text-success mr-1"></i>
                                            <div class="media-body">
                                                <h5 class="mt-1 font-size-14 text-white">
                                                    {{ new Date(task.created_at).toDateString() }}
                                                 </h5>
                                            </div>
                                        </div>
                                        <!-- end due date -->
                                    </div> <!-- end col -->

                                    <div class="col-md-4">
                                        <!-- start due date -->
                                        <p class="mt-2 mb-1 text-muted">Description</p>
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="mt-1 font-size-14 text-white">
                                                    {{task.description}}
                                                 </p>
                                            </div>
                                        </div>
                                        <!-- end due date -->
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                        <!-- end card-->
                    </div> <!-- end col -->

                </div>

            </div> <!-- container -->

        </div> <!-- content -->
    </div>
</template>
<script>
    export default {
        name: "TodoDetail",
        props:['id'],
        data() {
          return {
            error: null,
            isLoggedIn: false,
            loginType: '',
            message: '',
            task:{
                title: '',
                description: '',
                created_at:'',
            },
            user:{}
          }
        },
        created() {
            if (this.$route.params.message !== undefined) {
              this.message = this.$route.params.message
            }


        },
        mounted() {
          this.setUser()
          this.getDataTasks()
        },
        methods: {
          async setUser() {
              this.user = JSON.parse(localStorage.getItem('user'))
              this.isLoggedIn = localStorage.getItem('token') != null

              if(this.isLoggedIn === false ){
                 this.$router.push('/')
                 }
            },

            async getDataTasks() {
              await  axios.get(`https://testskill-fullstack.herokuapp.com/api/todo/show/${this.$route.params.id}`)
                .then(response => {
                this.task = {
                    title: response.data.title,
                    description: response.data.description,
                    created_at: response.data.created_at,
                }
            })
            .catch(function (error) {
                if(error.response.status === 500){
                        this.serverErros = error.response.status + ' Opsss...Server Error,Try once Again!'
                }
                 this.task = []
                 console.log(error)
            });

            },
        }

    }
    </script>
