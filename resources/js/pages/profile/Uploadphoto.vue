<template>

    <div class="content-page mt-1" v-if="isLoggedIn">
        <div class="content" >

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a><router-link class="text-dark" :to="{name: 'user'}">Dashboard</router-link> </a></li>
                                    <li class="breadcrumb-item"><a><router-link class="text-dark" :to="{name: 'profile'}">My Account</router-link> </a></li>
                                    <li class="breadcrumb-item active">Upload Photo</li>
                                </ol>
                            </div>
                            <h4 class="page-title"/>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
            <div class="row mt-2" v-if="loginType = 'user'">
                <div class="col-md-8 offset-2">
                    <div class="card-box bg-dark bg-pattern">
                        <div class="row">
                                <div class="col-md-6 text-left">
                                    <h5 class="header-title text-white"><i class="mdi mdi-file-upload-outline mr-1"></i>Upload Photo </h5>
                                </div> <!-- end col -->
                                <div class="col-md-6 text-right  mt-1">
                                    <h5 class="header-title text-white">
                                        <router-link class="text-danger" :to="{name: 'profile'}">
                                            <i class="mdi mdi-close-circle-outline mdi-24px mr-1"></i>
                                        </router-link>
                                    </h5>
                                </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div v-if="errors">
                            <div class="alert bg-danger text-white alert-dismissible fade show" role="alert">
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

                        <form  @submit.prevent="submitUpload">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-white">File</label>
                                        <input  type="file" class="form-control bg-dark text-white" accept="image/jpg,image/jpeg,image/png" required autocomplete="userimage" autofocus @change="upload" />
                                        <label class="text-danger">The file must be of type jpg, jpeg, png</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6 offset-0" >
                                        <div class="form-group" >
                                            <label class="text-white"></label>
                                            <img :src="previewimage" width="100">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-outline-success">
                                        Submit
                                    </button>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                        </form>
                    </div>
                </div>
            </div>

         </div> <!-- container -->

     </div> <!-- content -->
 </div>

</template>


<script>
export default {
    props: ['id'],
    name: "ProfileUpload",
    data() {
    return {
        user:{},
        loginType: '',
        isLoggedIn: false,
        previewimage: null,
        userimage: null,
        errors: '',
        serverErros: '',
    }
    },
    mounted() {
         this.setUser()
    },
    created() {
        if (this.$route.params.message !== undefined) {
            this.message = this.$route.params.message
         }
    },

    methods: {
      async  setUser() {
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
        upload(e) {
                let files = e.target.files[0]
                this.previewimage = URL.createObjectURL(files)
                this.userimage = files
        },

        submitUpload () {
                let formData = new FormData()
                formData.append('userimage', this.userimage)
                 axios.post('https://testskill-fullstack.herokuapp.com/api/profile/upload-photo/'+this.id, formData)
                .then(response => {
                    this.$notify({
                        type: "success",
                        title: "Success",
                        text: response.data.message,
                    });
                    this.$router.push({
                         name: 'profile',
                    })
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
                    this.serverErros = error.response.status + ' Opsss... Internal Server Error,Try once Again!'
                    }
                    this.errors = error.response.data.errors;
                });
        }
    }
}
</script>
