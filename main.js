    var vetlegendas;
    var informacoes;
    var token;
    var maiorsentimento = [];
    getlegendas();
    gettoken();

    // Função que vai recuperar as legendas em forma de vetor
    function getlegendas(){
        
        legendasv=[];
        // URL com acess token completo sem ter que montar.
        var URL = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=<seu acess token>';
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
                };
                vetlegendas=legendas;
                informacoes = response.data;
            },
            error:function(){ //Caso ocorra algum erro:
                alert("Deu algum erro.");
            }
        });
    };
        
    // Função que busca o Token pelo arquivo get-token.php.
    function gettoken(){
        $.ajax({
            url:'get-token.php',
            type:'GET',
            success:function(response){
                token=response;
            },
            error: function(err) {
              console.error(err);
            }
        });
    }

    //função que avalia alguma legenda.
    function avaliar(int){
        $("#p1").html(vetlegendas[int]);
        callToneAnalyzer(token,int);
        function callToneAnalyzer(token,int) {
            $.ajax({
                url:'https://gateway.watsonplatform.net/tone-analyzer/api/v3/tone?version=2016-05-19',
                type:'POST',
                data: JSON.stringify({text: vetlegendas[int]}),
                contentType: 'application/json',
                headers: {
                    'X-Watson-Authorization-Token': token
                },
                success:function(tone){
                    $("#myoutput").text(JSON.stringify(tone));
                    vetsentimentos=(tone.document_tone.tone_categories[0].tones);
                    vetsocial=(tone.document_tone.tone_categories[2].tones);
                    aux1=findmaior(vetsentimentos);
                    aux2=findmaior2(vetsocial);
                    $("#p2").html(maiorsentimento.tone_name);
                    $("#p3").html(maiorsentimento.score);
                    $("#img").attr("src", informacoes[int].images.standard_resolution.url);
                    if (aux1.score>aux2.score){
                        maiorsentimento=aux1;
                    }else{
                        maiorsentimento=aux2;
                    }
                    function findmaior(vetsentimentos){
                        maior = 0;
                        for (i=0;i<4;i++){
                            if (vetsentimentos[i].score > maior){
                                maior=vetsentimentos[i];
                            }
                        };
                    return maior;
                    };    
                    function findmaior2(vetsocial){
                        maior2 = 0;
                        for (i=0;i<4;i++){
                            if (vetsocial[i].score > maior2){
                                maior2=vetsocial[i];
                            }
                        }
                    return maior2;
                    }
                }       
            });
        };
    };   
