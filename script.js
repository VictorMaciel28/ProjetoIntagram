window.Legendas = {

    // Função que vai recuperar as legendas em forma de vetor
    getLegendas: function(){
        // URL com acess token completo sem ter que montar.
       var URL = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=859867556.1677ed0.f05bf2fc29444a568ed673012397e6ff';
       $.ajax({ //abertura do ajax
            type:'GET', //especificação do método. também poderia ser POST
            url: URL, // URL é aquela ali duas linhas acima, que recupera os 20 últimos posts
            data:'jsonp', // formatação dos dados. Forma que desejamos.
            success:function(response) {    
                i=0; 
                legendas = [];
                for (i=0;i<20;i++){ 
                    // guardando as legendas dos posts de JSON para um vetor legendas[]
                    legendas[i] = response.data[i].caption.text; 
                }
            console.log(legendas); //mandando printar no console as 20 legendas, de 0 a 19:
            },
            error:function(){ //Caso ocorra algum erro:
            alert("Deu algum erro.");
            }
        });
    },
    
};




