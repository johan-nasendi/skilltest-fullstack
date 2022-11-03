<template >
    <footer class="footer bg-dark"
    :class="{ [`footer-${type}`]: type }"
    :data-background-color="backgroundColor"
    v-if="isLoggedIn">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                      {{year}} &copy; Skill Test theme by <a href="https://www.instagram.com/johan.nasendi/" class="text-info" target="_blank">Johan Nasendi</a>
                </div>
                <div class="col-md-6">
                    <div class="text-md-right footer-links d-none d-sm-block">
                        <a href="javascript:void(0);">About Us</a>
                        <a href="javascript:void(0);">Help</a>
                        <a href="javascript:void(0);">Contact Us</a>
                    </div>
                        </div>
                    </div>
                </div>
    </footer>
</template>

<script>
export default {
props: {
backgroundColor: String,
type: String
},
data() {
  return {
    user: null,
    isLoggedIn: false,
    year: new Date().getFullYear()
  }
},
mounted() {
  this.setUser()
},
created() {
    axios.defaults.headers.common['Content-Type'] = 'application/json'
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')

    if(this.isLoggedIn)
    {
    } else if(this.user = JSON.parse(localStorage.getItem('user'))) {
        axios.get(`https://testskill-fullstack.herokuapp.com/api/user`,{ useCredentails: true })
        .then(response => {
                this.user = response.data
                this.loginType = response.data.roles[0].name
        })
        .catch(error => {
        if (error.response.status === 401) {
            localStorage.clear();
            this.$router.push('/login')
        }
        console.error(error);
        })
    } else {
        console.log("Welcome")
    }
},

methods: {
  setUser() {
      this.user = JSON.parse(localStorage.getItem('user'))
      this.isLoggedIn = localStorage.getItem('token') != null
    }
}
}
</script>

