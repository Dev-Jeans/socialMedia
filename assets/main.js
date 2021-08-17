const urlLoginRS= "controller/loginRS.php";
var app = new Vue({
    el: '#app',
    data: {
        form_email: '',
        form_password:'',
    },
    methods: {
        SubmitLogin(){
            console.log(this.form_email);
            console.log(this.form_password);
        },
        validateLogin(loginRS){
            let parametros = {
                email: loginRS.email,
                IDaccount: loginRS.id,
                redSocial: 'facebbok'
            }

            axios.post(urlLoginRS,parametros).then(response => {
                // console.log(response);
            });
        },
        async logInWithFacebook() {
            FB.getLoginStatus(function(response) {   
                if (response.status === 'connected') {
                    app.testAPI();
                } else {
                   window.FB.login(function(response) {
                        if (response.status === 'connected') {
                            app.testAPI();
                        }   
                   }) 
                }
              });
            return false;
          },

        testAPI(){
            window.FB.api('/me',{fields: 'first_name,last_name,email'}, function(response) {
                app.validateLogin(response);
            });
        },
        async initFacebook() {
            window.fbAsyncInit = function() {
              window.FB.init({
                appId: "3124447344451970", //You will need to change this
                cookie: true,
                xfbml: true,
                version: "v11.0"
              });
              FB.AppEvents.logPageView();
            };
        },
        async loadFacebookSDK(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);;
        },
    },
    mounted() {},
    created() {
        this.loadFacebookSDK(document, "script", "facebook-jssdk");
        this.initFacebook();
    },
    updated() {},
    computed: {}
})