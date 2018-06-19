window.Legendas = {
    getLegendas: function(){
       var URL = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=859867556.1677ed0.f05bf2fc29444a568ed673012397e6ff';
       $.ajax({
            type:'GET',
            url: URL,
            data:'jsonp',
            success:function(response) {
                i=0;
                legendas = [];
                for (i=0;i<20;i++){
                    legendas[i] = response.data[i].caption.text;
                }
            console.log(legendas);
            },
            error:function(){
            alert("Deu algum erro.");
            }
        });
    },
    
};




