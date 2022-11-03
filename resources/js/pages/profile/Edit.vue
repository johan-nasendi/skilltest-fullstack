<template>
    <div class="content-page mt-1" v-if="isLoggedIn">

       <div class="content" v-if="loginType = 'user'">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a><router-link class="text-dark" :to="{name: 'user'}">Dashboard</router-link> </a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);"><router-link class="text-dark" :to="{name: 'profile'}">My Account</router-link></a></li>
                                    <li class="breadcrumb-item active"><a href="#"></a> Edit </li>
                                </ol>
                            </div>
                            <h2 class="page-title"><i class="mdi mdi-account-edit"></i></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 offset-2">
                        <div class="card-box bg-dark bg-pattern">
                                <div class="row">
                                    <div class="col-md-6 text-left">
                                    </div> <!-- end col -->
                                    <div class="col-md-6 text-right">
                                        <h5 class="header-title text-white">
                                            <router-link class="text-danger" :to="{name: 'profile'}">
                                                <i class="mdi mdi-close-circle-outline mdi-18px mr-1"></i>
                                            </router-link>
                                        </h5>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div v-if="errors">
                                    <div  class="alert bg-danger text-white dark-dismissible fade show" role="alert">
                                        <strong><i class="mdi mdi-information-outline mdi-18px mr-1"></i>{{errors}} </strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <div v-if="serverErros" class="alert bg-danger text-white alert-dismissible fade show" role="alert">
                                    <strong><i class="mdi mdi-information-outline mdi-18px mr-1"></i>
                                        {{serverErros}}
                                    </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="handleUpdateAdmin">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-white"> Full Name</label>
                                                <input type="text"  class="form-control bg-dark text-white" v-model="profileEdit.name"  placeholder="Type..."
                                                required autocomplete="on" autofocus>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-white"> E-Mail</label>
                                                <input type="email" class="form-control bg-dark text-white" v-model="profileEdit.email" placeholder="Type..."
                                                required autocomplete="on" autofocus >
                                                <small class="text-muted">Email can't be changed or updated </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn btn-outline-info">Updated</button>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->

                                </form>
                        </div>
                    </div>
                </div>
            </div>
       </div>

    </div>
</template>

<script>
    export default {
        props: ['id'],
        name:"ProfileEdit",
            data() {
                return {
                    user:{},
                    isLoggedIn: false,
                    errors: null,
                    serverErros: '',
                    loginType: '',
                    profileEdit:{
                        name: '',
                        email: ''
                    },
                }
            },
            created() {
                if(this.isLoggedIn)
                {
                } else if(this.user = JSON.parse(localStorage.getItem('user'))) {
                    axios.get('https://testskill-fullstack.herokuapp.com/api/user')
                    .then(response => {
                            this.user =  response.data
                            this.loginType = response.data.roles[0].name
                    })
                    .catch(error => {
                    if (error.isLoggedIn) {
                        localStorage.clear();
                        this.$router.push('/login')
                    }
                    console.log(error);
                    })
                } else {}
            },
            mounted() {
                this.GetDataProfile()
                this.setUser()
            },

            methods: {
                handleUpdateAdmin() {
                this.$axios.put(`https://testskill-fullstack.herokuapp.com/api/profile/update/${this.$route.params.id}`,
                this.profileEdit).then((response) => {
                    if(response.data.status) {
                        this.$notify({
                            type: "success",
                            title: "Success",
                            text: response.data.message,
                        });
                        this.$router.push({
                            name: 'profile',
                        })
                    }
                }).catch((e) => {
                    if(e.response.status === 500){
                        this.serverErros = e.response.status + ' Opsss... Internal Server Error,Try once Again!'
                    }
                    this.errors  = e.response.data.message
                })
                },

                GetDataProfile(){
                    axios.get('https://testskill-fullstack.herokuapp.com/api/profile/edit/' +this.id).then((response) => {
                    this.profileEdit =  {
                        name: response.data.name,
                        email: response.data.email
                    }
                })
                },

                setUser() {
                    this.user = JSON.parse(localStorage.getItem('user'))
                    this.isLoggedIn = localStorage.getItem('token') != null
                }
             },

    }
</script>


