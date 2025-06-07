@extends("layouts.defaultLayout")

@section("main-content")

    <div class="test">
        <h2 class="test__h2">Adminbereich, Events feuern!</h2>
        <button  onclick="fireArtikel()" class="test_btn" >Feuere "Artikel-verkauft" Event!</button>
        <button   class="test_btn" onclick="fireWartung()" >Feuere "Wartungsarbeiten"</button>
    </div>

   <style>
       .test {
           max-width: 400px;
           margin: 2rem auto;
           background: #f9f9f9;
           text-align: center;
       }

       .test__h2 {
           font-size: 1.2rem;
           color: #333;
       }

      .test_btn {
           padding: 0.5rem 1rem;
           font-size: 1rem;
           background-color: #00bcd4;
           color: white;

       }


   </style>
    <script>

        let hostname = location.hostname;
        let id = 1;


        function fireWartung(){
            fetch('/wartung').then(response=>{
                console.log(response)
            }).catch(error =>{
                console.log(error)
            })
        }


        function fireArtikel(){

            fetch('/api/articles/'+id+"/sold", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ ab_name: "bar" })
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Antwort vom Server:", data);
                })
                .catch(error => {
                    console.error("Fehler beim POST-Request:", error);
                });

        }


    </script>

@endsection
