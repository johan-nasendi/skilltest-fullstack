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
                                    <li class="breadcrumb-item active">Edit Todo</li>
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
                                        <h5 class="header-title text-white"><i class="mdi mdi-pencil mdi-24px mr-1"></i>Edit Todo </h5>
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
                                <div class="alert bg-danger text-white dark-dismissible fade show" role="alert">
                                    <strong><i class="mdi mdi-information-outline mdi-18px mr-1"></i>{{errors}} </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <div v-if="serverErros">
                                <div class="alert bg-danger text-white alert-dismissible fade show" role="alert">
                                    <strong><i class="mdi mdi-information-outline mdi-18px mr-1"></i>
                                        {{serverErros}}
                                    </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <br>
                            <form  @submit.prevent="handleUpdateTask">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="text-white">Title</label>
                                                <input type="hidden"  v-model="taskedit.author" >
                                                <input type="text"  class="form-control bg-dark text-white" v-model="taskedit.title" placeholder="Enter Title"
                                                required autocomplete="on" autofocus>
                                            </div>

                                            <div class="form-group">
                                                <label class="text-white"> Description </label>
                                                <textarea class="form-control bg-dark text-white" v-model="taskedit.description"  rows="4" placeholder="Enter Description.."  required autocomplete="on" autofocus />
                                            </div>
                                        </div> <!-- end col-->
                                    </div>
                                    <!-- end row -->
                                    <div class="row mt-3">
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle mr-1"></i> Updated</button>
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
        name:'TOdoEdit',
        props: ['id'],
            data() {
                return {
                    isLoggedIn: false,
                    errors: null,
                    user:{},
                    loginType: '',
                    serverErros: '',
                    taskedit :{
                        title: '',
                        description: '',
                        author:'',
                    },
                }
            },

        created() {
            if (this.$route.params.message !== undefined) {
            this.message = this.$route.params.message
            }

        },

        mounted() {
            this.getDataTask()
            this.setUser()
        },

        methods: {
           async  handleUpdateTask() {
                 await axios.put(`https://testskill-fullstack.herokuapp.com/api/todo/update/${this.$route.params.id}`,this.taskedit)
                    .then((response) => {
                        if(response.data.status) {
                            this.$notify({
                                type: "success",
                                title: "Success",
                                text: response.data.message,
                            });
                            this.$router.push({
                                name: 'todolist',
                            })
                        }
                    }).catch((e) => {
                        if(e.response.status === 500){
                            this.serverErros = e.response.message + ' Opsss... Internal Server Error,Try once Again!'
                        }
                        this.errors  = e.response.data.message
                    })
            },

           async getDataTask(){
                   await axios.get('https://testskill-fullstack.herokuapp.com/api/todo/edit/'+this.id).then(response => {
                        this.taskedit = {
                            title: response.data.title,
                            author: response.data.author ,
                            description: response.data.description,
                        }
                    })
                    .catch(function (e) {
                        if(e.response.status === 500){
                                this.serverErros = e.response.message + ' Opsss... Internal Server Error,Try once Again!'
                        }
                        this.taskedit = []
                    });
            },

          async  setUser() {
                this.user = JSON.parse(localStorage.getItem('user'))
                this.isLoggedIn = localStorage.getItem('token') != null
                if(this.isLoggedIn === false ){
                 this.$router.push('/')
                }
            }
        },


    }
</script>


