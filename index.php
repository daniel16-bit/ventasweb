
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>colfar</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="styles2.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!--barra de navegacion-->
  <nav class="barra">
    <div class="logo" id="logo">
      <img src="img/Logo-Colfar.png" alt="">
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav_list">
      <li class="nav_item"><a href="index.php" class="nav_link">Inicio</a></li>
      <li class="nav_item"><a href="#SERVICIOS ESPECIALIZADOS" class="nav_link"></a></li>
      <li class="nav_item"><a href="./medicamentos/index.html" class="nav_link">Productos</a></li>
      <li class="nav_item"><a href="formulario.php" class="nav_link">Contacto</a></li>
      <li class="nav_item"><a href="./formularios/formulario.php" class="nav_btn link_button">Ingresar</a>
        <ul class="submenu">
    </ul>
      </li>
    </ul>
  </Nav>

  <section class="banner">
        <div class="content-banner">
            <p>Medicina alternativa 100% Natural</p>
            <h2>Conoce nuestros productos colfar, distribuidos en todo el territorio nacional <br />Medicamentos de alta calidad</h2>
            <a class="compra" href="medicamentos/index.html">Comprar ahora</a>
        </div> 
    </section>
  <!--informacion jenral de los productos con listado-->
<div class="container1">
    <img class="file" src="./img/file.png" alt="distribuidora colombiana">
  <div>
      <h1 class="h1" id="SERVICIOS ESPECIALIZADOS">Colfar Colombiana Farmacéutica</h1> 
      <p class="p">Comprometidos con el bienestar de miles de colombianos y con la industria nacional, proveemos a nuestros clientes productos farmacéuticos de la más alta calidad. Cubrimos gran parte de la demanda de los diferentes usuarios, ofreciendole una amplia gama de productos.</p>

    <div class="listas">  
        <div class="list1">
            <ul class="sty">
               <li><a href="medicamentos/index -categoria2-alimentosybebidas.html" class="listas_medi"><i class="fa fa-check" aria-hidden="true"></i>Alimentos y Bebidas</a></li>
               <li><a href="medicamentos/index -categoria3-fitoterapeuicosynaturales.html" class="listas_medi"><i class="fa fa-check" aria-hidden="true"></i>fitotera peuicos y naturales</a></li>
               <li><a href="medicamentos/index -categoria4-dermocosmetico.html" class="listas_medi"><i class="fa fa-check" aria-hidden="true"></i>dermocosmetico</a></li>
               <li><a href="medicamentos/index -categoria5-medicamento - page-2.html" class="listas_medi"><i class="fa fa-check" aria-hidden="true"></i>medicamento</a></li>
               <li><a href="medicamentos/index -categoria6-saludsexual.html" class="listas_medi"><i class="fa fa-check" aria-hidden="true"></i>saludsexual</a></li>
            </ul>
        </div>
        <div  class="list2"> 
           <ul class=" sty_2">
             <li><a href="medicamentos/index -categoria7-antiinflamatorios.html" class="listas_medi"><i class="fa fa-check" aria-hidden="true"></i>Antiinflamatorios</a></li>
             <li><a href="medicamentos/index -categoria8-aminoácidos.html" class="listas_medi"><i class="fa fa-check" aria-hidden="true"></i>aminoácidos esenciales </a></li>
             <li><a href="#" class="listas_medi"><i class="fa fa-check" aria-hidden="true"></i>colageno</a></li>
             <li><a href="#" class="listas_medi"><i class="fa fa-check" aria-hidden="true"></i>Sedantes</a></li>
             <li><a href="#" class="listas_medi"><i class="fa fa-check" aria-hidden="true"></i>Mucho más...</a></li>
            </ul>
        </div>
    </div> 
      <div class="botones"><a href="medicamentos/index.html" class=" link_button2">Ver Mas..</a></div>
  </div> 
</div>
<section class="container2 top-categories">
  <h1 class="heading-1">¡Mejores Categorías!</h1>
  <div class="container-categories">
<a href="medicamentos/index -categoria4-dermocosmetico.html">
  <div class="card-category category-moca">
    <p>Dermocosmetico</p>
    <span>ver más</span>
  </div>
</a>

      <a href="medicamentos/index -categoria7-antiinflamatorios.html">
  <div class="card-category category-expreso">
    <p>Antiinflamatorio-Analgésico</p>
    <span>ver más</span>
  </div>
</a>
      <a href="medicamentos/index -categoria2-alimentosybebidas.html">
  <div class="card-category category-capuchino">
    <p>Alimentos y Bebidas</p>
    <span>ver más</span>
  </div>
</a>

  </div>
</section>
<section class="container3 top-products">
  <h1 class="heading-1">¡Productos destacados!</h1>
  <div class="container-options">
      <span class="active">Destacadas</span>
      <span>Más recientes</span>
      <span>Más Vendidos</span>
  </div>
  <!--producto 1-->
  <div class="container-products">
      <div class="card-product">
          <div class="container-img">
              <img src="assets/mixagogonew.png" alt="ulcimeb"/>
              <span class="discount">-13%</span>
              <div class="button-group">
                  <span><i class="fa-solid fa-eye"></i></span>
                  <span><i class="fa-solid fa-heart"></i></span>
                  <span><i class="fa-solid fa-code-compare"></i></span>
              </div>
          </div>
          <div class="content-card-product">
              <div class="stars">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-regular fa-star"></i>
              </div>
              <h3>Ulcimeb</h3>
              <span class="add-cart"><i class="fa-solid fa-basket-shopping"></i></span>
              <p class="price">40.000$ <span>65.000$</span></p>
          </div>
      </div>
      <div class="card-product">
          <div class="container-img">
              <img src="assets/motibexnew.png" alt="Calcium D" />
              <span class="discount">-9%</span>
              <div class="button-group">
                  <span><i class="fa-solid fa-eye"></i></span>
                  <span><i class="fa-solid fa-heart"></i></span>
                  <span><i class="fa-solid fa-code-compare"></i></span>
              </div>
          </div>
          <div class="content-card-product">
              <div class="stars">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-regular fa-star"></i>
              </div>
              <h3>Calcium D</h3>
              <span class="add-cart"><i class="fa-solid fa-basket-shopping"></i></span>
              <p class="price">65.000$ <span>83.000$</span></p>
          </div>
      </div>
      <div class="card-product">
          <div class="container-img">
              <img src="assets/gastrimebnew.png" alt="Colageno"/>
              <div class="button-group">
                  <span><i class="fa-solid fa-eye"></i></span>
                  <span><i class="fa-solid fa-heart"></i></span>
                  <span><i class="fa-solid fa-code-compare"></i></span>
              </div>
          </div>
          <div class="content-card-product">
              <div class="stars">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
              </div>
              <h3>Actygen</h3>
              <span class="add-cart"><i class="fa-solid fa-basket-shopping"></i></span>
              <p class="price">70.000$</p>
          </div>
      </div>
      <div class="card-product">
          <div class="container-img">
              <img src="assets/colagenopolvonew.png" alt="Fibra"/>
              <div class="button-group">
                  <span><i class="fa-solid fa-eye"></i></span>
                  <span><i class="fa-solid fa-heart"></i></span>
                  <span><i class="fa-solid fa-code-compare"></i></span>
              </div>
          </div>
          <div class="content-card-product">
              <div class="stars">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-regular fa-star"></i>
                  <i class="fa-regular fa-star"></i>
              </div>
              <h3>Activ Fymax</h3>
              <span class="add-cart"><i class="fa-solid fa-basket-shopping"></i></span>
              <p class="price">40.000$</p>
          </div>
      </div>
  </div>
</section>
  <!--servicios especializados-->
  <div class="server">
      <h2>SERVICIOS ESPECIALIZADOS</h2>
    <div class="contenedor_3">
        <div class="columna_3">
          <i class="material-icons">business_center</i>
              <h2>Acerca De Nosotros </h2>
              <p>Distribuimos productos Farmacéuticos y Naturales a nivel nacional.</p>
        </div>
        <div class="columna_3">
          <i class="material-icons">star</i>
              <h2>Nuestro compromiso</h2>
              <p>Entregar a nuestros clientes los mejores productos y con la mas alta calidad.</p>
        </div>
        <div class="columna_3">
          <i class="material-icons">account_circle</i> 
          <h2>Nuestros aliados</h2>
          <p>Somos distribuidores autorizados de Productos KEMI ®</p>
        </div>
    </div>
  </div>
  <!--NUESTRO TRABAJO-->
  <div class="nuestro" id="nuestro-trabajo">
    <h2>Nuestro Trabajo</h2>
    <div class="contenedor_2">
      <div class="columna">
        <i class="material-icons">star</i>
        <p>Calidad en la gestión comercial y administrativa.</p>
      </div>
      <div class="columna">
        <i class="material-icons">add_shopping_cart</i>
        <p>Activa participación en el mercado farmacéutico.</p>
      </div>
      <div class="columna">
        <i class="material-icons">language</i>
        <p>Posicionamiento de nuestras marcas en los diferentes canales.</p>
      </div>
        <div class="columna">
          <i class="material-icons">trending_up</i>
          <p>Constante crecimiento a nivel comercial y corporativo.</p>
        </div>
        <div class="columna">
          <i class="material-icons">handshake</i>
          <p>Excelencia en el servicio integral al cliente.</p>
        </div>
        <div class="columna">
          <i class="material-icons">sentiment_satisfied_alt</i>
          <p> Muchos De  Nuestros Clientes Satisfechos.</p>
        </div>
    </div>
  </div>

  <!--imagen whatsapp-->
  <a href="https://wa.me/573001577611?text=¡Hola!%20Me%20interesa%20más%20información%20sobre%20la%20empresa%20Colfar" target="_blank" ><img src="./img/whatsapp.png" alt="" class="whatsapp-button"></a>

  <!--foooter-->
  <footer>
      <img class="logo_2" src="./img/colfarprecargador.png" alt="">
    <div>
      <ul class="lis_stile">
         <li class="lista_footer"><a class="lis_foo" href="index.php">Inicio</a></li>
         <li class="lista_footer"><a class="lis_foo" href="#SERVICIOS ESPECIALIZADOS">Sevicios</a></li>
         <li class="lista_footer"><a class="lis_foo" href="./colfar 2.5.5/index.php">productos</a></li>
         <li class="lista_footer"><a class="lis_foo" href="../ventaswe/formulario.php">Contactenos</a></li>
      </ul>
    </div>
    <div class="copyright">
      <p>Desarrollado por daniel camargo &copy; 2024</p>
      <img src="img/payment.png" alt="Pagos">
  </div>
  </footer>
  <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
  <!-- Bootstrap JS and Popper.js -->
  <script src="../scrip.js"></script>
</body>
</html>
