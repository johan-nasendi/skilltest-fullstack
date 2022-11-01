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
                                        <h3 class="text-white my-1"><span data-plugin="counterup">{{mytask.length}}</span></h3>
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
                                        <h3 class="text-white my-1"><span data-plugin="counterup"> {{daily.length}} </span></h3>
                                        <p class="text-muted mb-0 text-truncate"> Daily Report </p>
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
                                        <h3 class="text-white my-1"><span data-plugin="counterup">{{approve.length}}</span></h3>
                                        <p class="text-muted mb-0 text-truncate">Approved Report</p>
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
                                        <h3 class="text-white my-1"><span data-plugin="counterup">{{notapprove.length}}</span></h3>
                                        <p class="text-muted mb-0 text-truncate">Not yet Approved Report</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-box-->
                    </div> <!-- end col -->
                </div>
                <!-- end row card-->
                <div v-if="warningDocs.length > 0">
                    <div class="row" v-for="(docs, i) in warningDocs" :key="i">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col">
                                    <div class="card bg-dark bg-pattern">
                                        <div class="card-body">
                                            <h1 class="header-title text-white"><i class="mdi mdi-information mdi-18px mr-1"></i>INFO</h1>
                                            <p class="text-info" v-if="docs.status ==='BeingVerified'">Your data is being verified by the company</p>
                                            <p class="text-success" v-if="docs.status ==='Verified'">Your data has been successfully verified by the company</p>
                                            <span v-if="docs.status ==='Revision'">
                                                <p class="text-danger">
                                                     Oops.. Your data must be revised because it is invalid, Please re-upload your correct data
                                                </p>
                                                <p class="text-white">
                                                   <b> {{docs.message}}</b>
                                                </p>
                                            </span>

                                            <!-- cta -->
                                            <div class="row">
                                            <div class="col-sm-12">
                                                <div class="float-sm-right mt-1 mt-sm-0">
                                                    <div class="dropdown d-inline-block">
                                                       <a href="javascript:void(0);" class="text-white">
                                                        <i class="mdi mdi-book-information-variant mdi-18px mr-1 text-white"></i>Guide
                                                       </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="row mt-1">
                                                <div class="col" >
                                                    <div class="card mt-1">
                                                        <div class="card-body pb-0" >
                                                            <!-- task -->
                                                            <div class="row justify-content-sm-between task-item">
                                                                <div class="col-lg-6 mb-1">
                                                                    <div>
                                                                        <i class="mdi mdi-file mdi-18px mr-1"></i>
                                                                        <label>
                                                                            Your Documents
                                                                        </label>
                                                                    </div> <!-- end checkbox -->
                                                                </div> <!-- end col -->
                                                                <div class="col-lg-6">
                                                                    <div class="d-sm-flex justify-content-between">
                                                                        <div class="mt-3 mt-sm-0">
                                                                            <ul class="list-inline font-13 text-sm-right">
                                                                                <li class="list-inline-item" title="Guide Complete Documents">

                                                                                </li>
                                                                                <li class="list-inline-item">
                                                                                    <span class="badge badge-soft-info p-1" v-if="docs.status ==='BeingVerified'">Being Verified</span>
                                                                                    <span class="badge badge-soft-success p-1" v-if="docs.status ==='Verified'"> Successfully verified</span>
                                                                                    <span class="badge badge-soft-danger p-1" v-if="docs.status ==='Revision'">Must be Revised</span>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div> <!-- end .d-flex-->
                                                                </div> <!-- end col -->
                                                            </div>
                                                            <!-- end task -->
                                                        </div> <!-- end card-body-->
                                                    </div> <!-- end card -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div> <!-- end col -->
                    </div>
                </div>

                <div v-else>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col">
                                    <div class="card bg-dark bg-pattern">
                                        <div class="card-body">
                                            <h1 class="header-title text-warning"><i class="mdi mdi-information-outline mdi-18px mr-1"></i>Warning Message</h1>
                                            <p class="text-muted">Complete your Documents</p>
                                            <!-- cta -->
                                            <div class="row">
                                            <div class="col-sm-12">
                                                <div class="float-sm-right mt-1 mt-sm-0">
                                                    <div class="dropdown d-inline-block">
                                                       <a href="javascript:void(0);" class="text-white">
                                                        <i class="mdi mdi-book-information-variant mdi-18px mr-1 text-white"></i>Guide
                                                       </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="row mt-1">
                                                <div class="col" >
                                                    <div class="card mt-1">
                                                        <div class="card-body pb-0" >
                                                            <!-- task -->
                                                            <div class="row justify-content-sm-between task-item">
                                                                <div class="col-lg-6 mb-1">
                                                                    <div>
                                                                        <i class="mdi mdi-file mdi-18px mr-1"></i>
                                                                        <label>
                                                                            Curriculum Vitae(CV) file must be uploaded
                                                                        </label>
                                                                    </div> <!-- end checkbox -->
                                                                </div> <!-- end col -->
                                                                <div class="col-lg-6">
                                                                    <div class="d-sm-flex justify-content-between">
                                                                        <div class="mt-3 mt-sm-0">
                                                                            <ul class="list-inline font-13 text-sm-right">
                                                                                <li class="list-inline-item" title="Guide Complete Documents">

                                                                                </li>
                                                                                <li class="list-inline-item">
                                                                                    <span class="badge badge-soft-danger mr-1">Not Complete</span>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div> <!-- end .d-flex-->
                                                                </div> <!-- end col -->
                                                            </div>
                                                            <!-- end task -->
                                                        </div> <!-- end card-body-->
                                                    </div> <!-- end card -->
                                                    <div class="card mt-1">
                                                        <div class="card-body pb-0" >
                                                            <!-- task -->
                                                            <div class="row justify-content-sm-between task-item">
                                                                <div class="col-lg-6 mb-1">
                                                                    <div>
                                                                        <i class="mdi mdi-file mdi-18px mr-1"></i>
                                                                        <label>
                                                                            KTP/KTS file must be uploaded
                                                                        </label>
                                                                    </div> <!-- end checkbox -->
                                                                </div> <!-- end col -->
                                                                <div class="col-lg-6">
                                                                    <div class="d-sm-flex justify-content-between">
                                                                        <div class="mt-3 mt-sm-0">
                                                                            <ul class="list-inline font-13 text-sm-right">
                                                                                <li class="list-inline-item">
                                                                                    <span class="badge badge-soft-danger mr-1">Not Complete</span>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div> <!-- end .d-flex-->
                                                                </div> <!-- end col -->
                                                            </div>
                                                            <!-- end task -->
                                                        </div> <!-- end card-body-->
                                                    </div> <!-- end card -->
                                                    <div class="card mt-1">
                                                        <div class="card-body pb-0" >
                                                            <!-- task -->
                                                            <div class="row justify-content-sm-between task-item">
                                                                <div class="col-lg-6 mb-1">
                                                                    <div>
                                                                        <i class="mdi mdi-file mdi-18px mr-1"></i>
                                                                        <label>
                                                                            Letter of recommendation file must be uploaded
                                                                        </label>
                                                                    </div> <!-- end checkbox -->
                                                                </div> <!-- end col -->
                                                                <div class="col-lg-6">
                                                                    <div class="d-sm-flex justify-content-between">
                                                                        <div class="mt-3 mt-sm-0">
                                                                            <ul class="list-inline font-13 text-sm-right">
                                                                                <li class="list-inline-item">
                                                                                    <span class="badge badge-soft-danger mr-1">Not Complete</span>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div> <!-- end .d-flex-->
                                                                </div> <!-- end col -->
                                                            </div>
                                                            <!-- end task -->
                                                        </div> <!-- end card-body-->
                                                    </div> <!-- end card -->

                                                </div> <!-- end col -->
                                            </div> <!-- end row -->

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
    </div>
</template>

<script>
export default {
  name:'DashboardStudent',
  data() {
      return {
        user: {},
        daily: [],
        approve:[],
        notapprove:[],
        mytask:[],
        warningDocs:[],
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

          axios.get('https://testskill-fullstack.herokuapp.com/api/user/')
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

            axios.get('/api/user/countapprovereport')
                .then(response => {
                    this.approve = response.data.total
                }).catch(error => {
                console.error(error);
                this.approve = []
            }).catch(error => {
                if(error.response.status === 500){
                    this.serverErros = error.response.status + ' Opsss... Internal Server Error,Try once Again!'
                }
            });

                axios.get(`/api/user/mytasks/count`)
                .then(response => {
                    this.mytask = response.data.tasks
                }).catch(error => {
                    console.error(error);
                    this.mytask = []
                }).catch(error => {
                if(error.response.status === 500){
                    this.serverErros = error.response.status + ' Opsss... Internal Server Error,Try once Again!'
                }
            });

            axios.get('/api/user/countnotapprovereport')
                .then(response => {
                    this.notapprove = response.data.total
                }).catch(error => {
                    if(error.response.status === 500){
                        this.serverErros = error.response.status + ' Opsss... Internal Server Error,Try once Again!'
                    }
                    this.notapprove = []
            })

        },
        getDataComplateDocs(){
            axios.get('/api/user/documents')
            .then(response => {
                this.warningDocs = response.data.documents
            }).catch(error => {
                if(error.response.status === 500){
                    this.serverErros = error.response.status + ' Opsss... Internal Server Error,Try once Again!'
                }
                this.warningDocs = []
            })

        }
    }
}
</script>
