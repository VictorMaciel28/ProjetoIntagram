<!doctype html>
<html lang="en">
    <head>
        <title>Watson Tone Analyzer Example</title>
        <meta charset="utf-8"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    </head>

    <body>
        <h2>This is an example of client side call to Watson Tone analyzer service using an authorization token.</h2>
        <div id="myoutput"></div>
    </body>
</html>
<script>

    var vetlegendas;
    var informacoes;
    var token;
    var maiorsentimento = [];
    getlegendas();
    gettoken();

    function main(){
    }   

    // Função que vai recuperar as legendas em forma de vetor
    function getlegendas(){
        legendasv=[];
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
                    if (aux1.score>aux2.score){
                        maiorsentimento=aux1;
                    }else{
                        maiorsentimento=aux2;
                    }
                    function findmaior(vetsentimentos){
                        for (i=0;i<4;i++){
                            if (vetsentimentos[i].score > vetsentimentos[i+1].score){
                                maior=vetsentimentos[i];
                            }else{
                                maior=vetsentimentos[i+1];
                            }
                        };
                    return maior;
                    };    
                    function findmaior2(vetsocial){
                        for (i=0;i<4;i++){
                            if (vetsocial[i].score > vetsocial[i+1].score){
                                maior2=vetsocial[i];
                            }else{
                                maior2=vetsocial[i+1];
                            }
                        }
                    return maior2;
                    }
                }       
            });
        };
    };   
</script>