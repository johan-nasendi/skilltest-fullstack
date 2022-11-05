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
                                <li class="breadcrumb-item active">My Account</li>
                                </ol>
                            </div>
                            <h4 class="page-title"><i class="mdi mdi-account-circle mr-1"></i>My Account</h4>
                        </div>
                    </div>
                </div>

                <div v-if="message" class="alert bg-success text-white alert-dismissible fade show" role="alert">
                     <strong ><i class="mdi mdi-information-outline mdi-18px mr-1"></i>{{message}} </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div v-if="serverErros" class="alert bg-danger text-white alert-dismissible fade show" role="alert">
                    <strong><i class="mdi mdi-information-outline mdi-18px mr-1"></i>
                        {{serverErros}}
                     </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="card-box bg-dark bg-pattern text-center">
                            <img v-if="user.userimage" :src="'https://testskill-fullstack.herokuapp.com/photos/'+user.userimage" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image" />
                            <div v-else>
                                <img  src="/assets/images/users/user-5.jpg" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image" />
                                <p class="text-muted"><i class="text-danger">* Upload your Photo !!</i></p>
                            </div>
                            <h4 class="mb-0 text-white"> {{user.name}}  </h4>
                            <p class="text-muted"> {{user.email}}  </p>
                            <a class="btn btn-dark btn-xs btn-outline-warning mr-2" href="javascript: void(0);" @click.prevent="EditProfile(user.id)">
                                <i class="mdi mdi-account-edit mr-1"></i>Edit
                            </a>
                            <a class="btn btn-dark btn-xs btn-outline-success" href="javascript: void(0);" @click.prevent="UploadPhoto(user.id)">
                                <i class="mdi mdi-file-upload-outline mr-1"></i>Upload Photo
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-8 col-xl-8">
                        <div class="card-box bg-dark bg-pattern">
                            <h5 class="mb-2 text-uppercase text-white"><i class=" fas fa-user-circle text-white mr-1"></i>  INFO PROFILE  </h5>
                            <div class="tab-content">
                                <div class="tab-pane show active">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-white">Full Name</label>
                                                    <input type="text" class="form-control bg-dark text-white" v-model="user.name" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-white">E-mail</label>
                                                    <input type="text" class="form-control bg-dark text-white"  v-model="user.email" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
    name: "Profile",
    data() {
      return {
        user:{},
        loginType: '',
        message:'',
        serverErros:'',
        isLoggedIn: false
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
        async  setUser() {
          this.user = JSON.parse(localStorage.getItem('user'))
          this.isLoggedIn = localStorage.getItem('token') != null

          if(this.isLoggedIn === false ){
                 this.$router.push('/')
            }
        },

        EditProfile(id) {
            this.$router.push({
                name: 'profileedit',
                params: {id}
            })
        },

        UploadPhoto(id) {
            this.$router.push({
                name: 'profileupload',
                params: {id}
            })
        },
    }
}
</script>
