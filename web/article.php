<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="SVC Team">
        <meta name="description" content="Web destinada a la compra de vehículos de marcas emergentes.">
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Bienvenido a su compraventa de confianza!" />
        <meta property="og:url" content="https://svc.cloud" />
        <meta property="og:image" content="../public/miniatura.png" />
        <meta property="og:site_name" content="SVC" />
        </meta>
        <link rel="shortcut icon" href="../public/favicon.ico" type="image/x-icon" />
        <title>SVC - Artículos</title>
        <link rel="stylesheet" href="../resources/css/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <?php
        require_once('../dao/ArticleDAO.php');

        //BBDD de nuestro sistema
        $base = "svc";

        //Creamos las instancias de nuestros daos
        $daoarticle = new DaoArticle($base);
        $daoarticle->getAllArticles();

        require_once('../views/header.php'); // Header de la pagina
    ?>
    <body class='bg-color'>
        <div class="container">
        <?php
            if(count($daoarticle->articles) > 0){
                foreach($daoarticle->articles as $value){
                    echo "
                    <div class='container py-5'>
                        <div class='row justify-content-center'>
                            <div class='col-md-10 col-lg-8'> <!-- Aumenté el tamaño de la columna -->
                                <div class='article-card shadow-lg rounded overflow-hidden'>
                                    <div class='article-image'>
                                        <img src='data:image/jpeg;base64," . $value->__get('image') . "' class='img-fluid' alt='Imagen del artículo'>
                                    </div>
                                    <div class='article-content p-5'> <!-- Aumenté el padding -->
                                        <h2 class='article-title text-dark font-weight-bold mb-4'>".$value->__get("title")."</h2> <!-- Aumenté el margen inferior -->
                                        <p class='article-summary text-muted mb-4'>".$value->__get("paragrahp1")."</p> <!-- Aumenté el margen inferior -->
                                        <p class='article-text mb-4'>".$value->__get("paragrahp2")."</p> <!-- Aumenté el margen inferior -->
                                        <p class='article-text mb-4'>".$value->__get("paragrahp3")."</p> <!-- Aumenté el margen inferior -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    ";
                }
            } else {
                echo "<p class='text-center mt-5'>No hay artículos disponibles</p>";
            }
            
            ?>
        </div>
        <?php 
        require_once('../views/footer.php');
        require_once('../utils/scripts.php'); ?>
        <script type="module" src="../resources/js/index.js"></script>
    </body>
</html> 