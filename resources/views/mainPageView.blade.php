@extends("layouts.defaultLayout")
@section("title", "Home")
@section("main-content")
    <script src="{{asset("/js/mainPage.js")}}"></script>
<h1 class="h1Tag" >Abalo</h1>


      <p class="defaultContainer" >Herzlich willkommen, Sie suchen einen Artikel; etwas Neues, was alt ist?
          Nulla consequat massa quis
          enim. Donec pede justo, fringilla vel, aliquet nec,
      </p>

<hr>

      <div id="btnContainer" class="btnContainer">
          <button class="btn" id="artikelBtn" > Zu den Artikeln..</button>
          <button class="btn" id="newArticle">Neue Artikel einfügen</button>
          <button class="btn" id="3-ajax1-staticBtn">Aufgabe 1</button>
          <button class="btn" id="adminBtn"> Artikel löschen (Admin) </button>

      </div>

    <script>
      document.addEventListener("DOMContentLoaded", function (){
          const artikelBtn = document.getElementById("artikelBtn");
          artikelBtn.addEventListener("click", function (){
              location.href="/articles";
          })

          const newBtn = document.getElementById("newArticle");
          newBtn.addEventListener("click", function (){
              location.href="/newarticle";
          })

          const ajax1staticBtn = document.getElementById("3-ajax1-staticBtn");
          ajax1staticBtn.addEventListener("click", function (){
              location.href="/3-ajax1-static";
          })


      })

    </script>

<hr>
<p class="defaultContainer">Lorem ipsum dolor sit amet, consectetuer adipiscing
    elit. Aenean commodo ligula eget dolor. Aenean massa
    <strong>strong</strong>. Cum sociis natoque penatibus
    et magnis dis parturient montes, nascetur ridiculus
    mus. Donec quam felis, ultricies nec, pellentesque
    eu, pretium quis, sem. Nulla consequat massa quis
    enim. Donec pede justo, fringilla vel, aliquet nec,
    vulputate eget, arcu. In enim justo, rhoncus ut,
    imperdiet a, venenatis vitae, justo. Nullam dictum
    felis eu pede <a class="external ext" href="#">link</a>
    mollis pretium. Integer tincidunt. Cras dapibus.
    Vivamus elementum semper nisi. Aenean vulputate
    eleifend tellus. Aenean leo ligula, porttitor eu,
    consequat vitae, eleifend ac, enim. Aliquam lorem ante,
    dapibus in, viverra quis, feugiat a, tellus. Phasellus
    viverra nulla ut metus varius laoreet. Quisque rutrum.
    Aenean imperdiet. Etiam ultricies nisi vel augue.
    Curabitur ullamcorper ultricies nisi.</p>

<div class="gallery" >
    <img  class="mySlides" src="{{asset("images/1.jpg")}}" alt="Bild 1">
    <img class="mySlides"  src="{{asset("images/2.jpg")}}" alt="Bild 2">
    <img  class="mySlides" src="{{asset("images/3.jpg")}}" alt="Bild 3">
    <button class="w3-button w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
    <button class="w3-button w3-display-right" onclick="plusDivs(+1)">&#10095;</button>
</div>
<div class="defaultContainer" >
    <p>Sie möchten persönlich mit uns reden ? Dann kommen Sie vorbei!</p>
</div>

<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5047.6547912602255!2d6.078152792546339!3d50.76023409192758!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c09b924b9ddc91%3A0x37a64c44b566a700!2sFH%20Aachen%2C%20Geb%C3%A4ude%20D!5e0!3m2!1sde!2sde!4v1746440201711!5m2!1sde!2sde" width="600" height="450"
        style="border:0; margin:25px " allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
<script>

    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
        showDivs(slideIndex += n);
    }

    function showDivs(n) {
        var i;
        var x = document.getElementsByClassName("mySlides");
        if (n > x.length) {slideIndex = 1}
        if (n < 1) {slideIndex = x.length} ;
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        x[slideIndex-1].style.display = "block";
    }
</script>
@endsection
