window.Comentarios = {
    // Credenciais , Settings
    config:{},
    
    getComments: function(){
       var URL = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=859867556.1677ed0.f05bf2fc29444a568ed673012397e6ff';
       $.ajax({
        type:'GET',
        url: URL,
        data:'json',
        success:function(response) {
            console.log(response);
        },
        error:function(){
            alert("Deu algum erro.");
        }
    });
    },
};



