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
                                    <li class="breadcrumb-item"><a><router-link class="text-dark" :to="{name: 'user'}">Dashboard</router-link></a></li>
                                    <li class="breadcrumb-item active">My Todo List</li>
                                </ol>
                            </div>
                             <h4 class="page-title"><i class="mdi mdi-format-list-checks mr-1"></i>My Todo List</h4>
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
                <div v-if="message" class="alert bg-success text-white alert-dismissible fade show" role="alert">
                    <strong ><i class="mdi mdi-information-outline mdi-18px mr-1"></i>{{message}} </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div  v-if="errors" class="alert bg-danger text-white dark-dismissible fade show" role="alert">
                    <strong><i class="mdi mdi-information-outline mdi-18px mr-1"></i>{{errors}} </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                 <!-- Start Card  -->

                 <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col">
                                <div class="card bg-dark bg-pattern">
                                    <div class="card-body">
                                        <!-- cta -->
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="float-sm-right mt-3 mt-sm-0">
                                                    <div class="d-inline-block mb-3 mb-sm-0 mr-sm-2">
                                                        <form class="search-bar form-inline">
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" placeholder="Search...">
                                                                <span class="mdi mdi-magnify"></span>
                                                            </div>
                                                        </form>
                                                     </div>
                                                     <div class="dropdown d-inline-block">
                                                        <router-link class="btn btn-light" :to="{name: 'addtodo'}">
                                                            <i class="mdi mdi-plus text-success"></i>
                                                        </router-link>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-1" data-plugin="dragula">
                                            <div class="col">
                                                 <a class="text-dark" data-toggle="collapse" href="#todayTasks" aria-expanded="false" aria-controls="todayTasks">
                                                    <h5 class="mb-0 text-white"><i class="mdi mdi-chevron-down font-18 text-white"></i> Total
                                                        <span class="text-white font-14">({{todo.todos.length}})</span>
                                                    </h5>
                                                </a>

                                                <div class="collapse show" id="todayTasks" v-for="(myt, i) in todo.todos" :key="i.id">
                                                    <div class="card mt-1 shadow-none">
                                                        <div class="card-body pb-0" id="task-list-one">
                                                            <!-- task -->
                                                            <div class="row justify-content-sm-between task-item">
                                                                <div class="col-lg-6 mb-1">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="task1">
                                                                        <label class="custom-control-label" for="task1">
                                                                           {{myt.title}}
                                                                        </label>
                                                                        <p class="truncate">{{myt.description}}</p>
                                                                    </div> <!-- end checkbox -->
                                                                </div> <!-- end col -->
                                                                <div class="col-lg-6">
                                                                    <div class="d-sm-flex justify-content-between">
                                                                        <div>
                                                                            <img v-if="todo.userimage" :src="'https://testskill-fullstack.herokuapp.com/photos/'+todo.userimage" :alt="todo.name" class="avatar-xs rounded-circle" data-toggle="tooltip" data-placement="bottom" />
                                                                            <img v-else src="/assets/images/users/user-5.jpg" lt="image" class="avatar-xs rounded-circle" data-toggle="tooltip" data-placement="bottom" title="null" />
                                                                        </div>
                                                                        <div class="mt-3 mt-sm-0">
                                                                            <ul class="list-inline font-13 text-sm-right">
                                                                                <li class="list-inline-item pr-1">
                                                                                    <i class="mdi mdi-calendar-month-outline font-16 mr-1"></i>
                                                                                    {{ new Date(myt.updated_at).toDateString() }}
                                                                                </li>
                                                                                    <a href="javascript: void(0);" @click.prevent="getdetailTodo(myt.id)">
                                                                                    <li class="list-inline-item pr-2">
                                                                                        <i class="mdi mdi-eye-outline font-16 text-info mr-1" title="DETAIL"></i>
                                                                                    </li>
                                                                                </a>
                                                                                <a href="javascript: void(0);" @click.prevent="geteditTodo(myt.id)">
                                                                                    <li class="list-inline-item pr-2">
                                                                                        <i class="mdi mdi-pencil-outline font-16 text-warning mr-1" title="EDIT"></i>
                                                                                    </li>
                                                                                </a>
                                                                                <a href="javascript: void(0);" @click.prevent="deleteTodo(myt.id)">
                                                                                    <li class="list-inline-item pr-2">
                                                                                        <i class="mdi mdi-trash-can font-16 text-danger mr-1" title="Delete"></i>
                                                                                    </li>
                                                                                </a>

                                                                            </ul>
                                                                        </div>
                                                                    </div> <!-- end .d-flex-->
                                                                </div> <!-- end col -->
                                                            </div>
                                                            <!-- end task -->
                                                        </div> <!-- end card-body-->
                                                    </div> <!-- end card -->
                                                </div> <!-- end .collapse-->

                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                        <!-- <Pagination :data="mytask" @pagination-change-page="getDataMyTasks" /> -->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- end col -->
                    <!-- task details -->
                </div>



            </div>
        </div>
    </div>
</template>

<script>
export default {
  name:'TodoList',
  props:['id'],
  data() {
      return {
        isLoggedIn: false,
        user: {},
        serverErros:'',
        errors:'',
        message:'',
        loginType: '',
        todo:[],
      }
    },
    created() {
        if (this.$route.params.message !== undefined) {
            this.message = this.$route.params.message
        }

    },
     mounted() {
      this.setUser()
      this.GetdataTodo()
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
       async GetdataTodo(){
          await  axios.get('https://testskill-fullstack.herokuapp.com/api/todo/getall')
                .then(response => {
                    this.todo = response.data
            }).catch(error => {
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
                    this.serverErros = error.response.message + ' Opsss... Internal Server Error,Try once Again!'
                }
                this.serverErros = error.response.message
                console.log(error);
            })

        },

        geteditTodo(id){
                this.$router.push({
                name: 'todoedit',
                params: {id}
            })
        },
        getdetailTodo(id){
                this.$router.push({
                name: 'tododetail',
                params: {id}
            })
        },

        deleteTodo(id){
                if(confirm('Are you sure want to delete this todo list?..')){
                 this.$axios.delete(`https://testskill-fullstack.herokuapp.com/api/todo/delete/${id}`)
                    .then(response => {
                       if(response.data.status){
                         let i = this.todo.map(item => item.id).indexOf(id); // find index of your object
                         this.todo.splice(i, 1)
                         this.$notify({
                                type: "success",
                                title: "Success",
                                text: response.data.message,
                         });
                       }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            } else {
                return false
            }
        },
    }
}
</script>
