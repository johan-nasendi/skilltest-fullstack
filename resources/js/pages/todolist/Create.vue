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
                                    <li class="breadcrumb-item active">Create Task</li>
                                </ol>
                            </div>
                            <h4 class="page-title"/>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box bg-dark bg-pattern">
                            <div class="row mb-0">
                                    <div class="col-md-6 text-left">
                                        <h5 class="header-title text-white"><i class="mdi mdi-plus mdi-24px mr-1"></i>Create Todo </h5>
                                    </div> <!-- end col -->
                                    <div class="col-md-6 text-right">
                                        <h5 class="header-title text-white">
                                            <router-link class="text-danger" :to="{name: 'todolist'}">
                                                <i class="mdi mdi-close-circle-outline mdi-24px mr-1"></i>
                                            </router-link>
                                        </h5>
                                    </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div v-if="errors">
                                <div v-for="(error, key) in errors" :key="key" class="alert bg-danger text-white dark-dismissible fade show" role="alert">
                                    <strong><i class="mdi mdi-information-outline mdi-18px mr-1"></i>{{error}} </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div v-if="serverErros">
                                <div v-for="(servererror, key) in serverErros" :key="key" class="alert bg-danger text-white alert-dismissible fade show" role="alert">
                                    <strong><i class="mdi mdi-information-outline mdi-18px mr-1"></i>
                                        {{servererror}}
                                    </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <br>
                            <form  @submit.prevent="submitFormTask">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="text-white">Title </label>
                                                <input type="hidden"  v-model="task.author" >
                                                <input type="text"  class="form-control bg-dark text-white" v-model="task.title" placeholder="Enter Title"
                                                required autocomplete="on" autofocus>
                                            </div>

                                            <div class="form-group">
                                                <label class="text-white"> Description </label>
                                                <textarea class="form-control bg-dark text-white" v-model="task.description"  rows="4" placeholder="Enter Description.."  required autocomplete="on" autofocus />
                                            </div>

                                        </div> <!-- end col-->
                                    </div>
                                    <!-- end row -->
                                    <div class="row mt-3">
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle mr-1"></i> Create</button>
                                        </div>
                                    </div>

                            </form>

                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row-->

            </div> <!-- container -->

        </div> <!-- content -->
    </div>
</template>
<script>
    export default {
        name: 'TodoCreate',
        props:['id'],
        data() {
          return {
            task: {
                title: '',
                description: '',
                author: '',
            },
            errors: '',
            user: '',
            loginType: '',
            serverErros: '',
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
           async submitFormTask() {
              await  axios.post('https://testskill-fullstack.herokuapp.com/api/todo/store',this.task)
                .then(response => {
                    this.$notify({
                        type: "success",
                        title: "Success",
                         text: response.data.message,
                    });
                    this.$router.push({
                          name: 'todolist',
                    })
                })
                .catch(error => {
                    if(error.response.status === 500){
                     this.serverErros = error.response.status + ' Opsss... Internal Server Error,Try once Again!'
                    }
                    this.errors = error.response.data.message;
                });
            },

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

              await axios.get('https://testskill-fullstack.herokuapp.com/api/user')
                .then(response => {
                    this.user = response.data
                    this.loginType = response.data.roles[0].name
                    this.task = {
                        author: response.data.id
                    }
                })
                .catch(error => {
                    if(error.response.status === 401 || error.response.status === 419)
                    {
                        localStorage.clear();
                        this.$notify({
                            type: "error",
                            title: "Authorization Token is Expired",
                            text: error.response,
                        });
                        this.$router.push('/')
                    }

                    if(error.response.status === 500){
                        this.serverErros = error.response.status + ' Opsss...Server Error,Try once Again!'
                    }

                   console.log(error);
                })
            },
        }
    }
    </script>
