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
    
    // Função que vai recuperar as legendas em forma de vetor
    function main(int){
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
                analyze(legendas,int);
            },
            error:function(){ //Caso ocorra algum erro:
                alert("Deu algum erro.");
            }
        });
    };
        

    // Função que basicamente busca o Token pelo arquivo get-token.php, recebe as legendas e manda avaiar.
    function analyze(legendas,int){
        $.ajax({
            url:'get-token.php',
            type:'GET',
            success:function(token){
              callToneAnalyzer(token,legendas,int);
            },
            error: function(err) {
              console.error(err);
            }
        });
    }


    //função que avalia as legendas, é chamada pela função analyze acima.
    function callToneAnalyzer(token,legendas,int) {
        $.ajax({
            url:'https://gateway.watsonplatform.net/tone-analyzer/api/v3/tone?version=2016-05-19',
            type:'POST',
            data: JSON.stringify({text: legendas[int]}),
            contentType: 'application/json',
            headers: {
                'X-Watson-Authorization-Token': token
            },
            success:function(tone){
              $("#myoutput").text(JSON.stringify(tone));
              console.log(legendas[int]);
            },
            error: function(err) {
              $("#myoutput").text(JSON.stringify(err));
            }
        });
    }   


</script>