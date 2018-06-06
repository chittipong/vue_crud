var app = new Vue({
    el:"#root",
    data:{
        showAddModal:false,
        showEditModal:false,
        showDeleteModal:false,
        errorMessage:"",
        successMessage:"",
        users:[],
        newUser:{username:"",email:"",mobile:""}
    },
    mounted:function(){
        console.log("mounted");
        this.getAllUsers();
    },
    methods:{
        getAllUsers:function(){
            axios.get("http://localhost/vue_crud/api.php?action=read")
            .then(function(response){
                //console.log(response);
                if(response.data.error){
                    app.errorMessage=response.data.message;
                }else{
                    app.users=response.data.users;
                }
            });
        },//End***

        saveUser:function(){
            //console.log(app.newUser);
            var formData=app.toFormData(app.newUser);

            axios.post("http://localhost/vue_crud/api.php?action=create", formData)
            .then(function(response){
                //console.log(response);
                app.newUser={username:"",email:"",mobile:""}
                if(response.data.error){
                    app.errorMessage=response.data.message;
                }else{
                    app.getAllUsers();
                }
            });
        },
        toFormData:function(obj){
            var form_data=new FormData();
            for(var key in obj){
                form_data.append(key,obj[key]);
            }
            return form_data;
        },
        clearMessage:function(){
            app.errorMessage="";
            app.successMessage="";
        }
    }
});