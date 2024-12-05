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
        <title>SVC - Gestionar Artículos</title>
        <link rel="stylesheet" href="../resources/css/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <?php 
        require_once('../utils/alert.php');
        require_once('../entities/Article.php');
        require_once('../dao/ArticleDAO.php');

        // Sesion
        if(!isset($_SESSION)) session_start(); // Si no se ha iniciado sesion la iniciamos

        $base='svc';
        $daoarticle = new DaoArticle($base);
        $alert = new AlertGenerator();

        // Si no eres uusario no puedes acceder
        if(!isset($_SESSION['client']) || $_SESSION['client']['role'] == 'client') {
            header("Location: /svc/");
        }

        if(isset($_POST['Crear'])) {
            $title = $_POST['title'];
            $paragrahp1 = $_POST['paragrahp1'];
            $paragrahp2 = $_POST['paragrahp2'];
            $paragrahp3 = $_POST['paragrahp3'];
            $logo = '';

            if (isset($_FILES['image']) && $_FILES['image']['tmp_name'] != "") {
                $temp = $_FILES['image']['tmp_name'];
                $contenido = file_get_contents($temp);
                $contenido = base64_encode($contenido);
                $logo = $contenido;
            }

            $article = new Article();
            $article->__set("title", $title);
            $article->__set("paragrahp1", $paragrahp1);
            $article->__set("paragrahp2", $paragrahp2);
            $article->__set("paragrahp3", $paragrahp3);
            $article->__set("image", $logo);
            $article->__set("emailBrand", $_SESSION['client']['name']);
            $daoarticle->insertArticle($article);
            echo $alert->successAlert("El artículo ha sido creado correctamente");
        }

        if(isset($_POST['Delete'])) {
            $articleid = $_POST['Delete'];
            $daoarticle->delete($articleid);
            echo $alert->successAlert("El artículo ha sido eliminado correctamente");
        }

        if(isset($_POST['Modificar'])) {
            $articleid = $_POST['Modificar'];
            $title = $_POST['title'];
            $paragrahp1 = $_POST['paragrahp1'];
            $paragrahp2 = $_POST['paragrahp2'];
            $paragrahp3 = $_POST['paragrahp3'];

            $article = new Article();
            $article->__set("title", $title);
            $article->__set("id", $articleid);
            $article->__set("paragrahp1", $paragrahp1);
            $article->__set("paragrahp2", $paragrahp2);
            $article->__set("paragrahp3", $paragrahp3);
            $daoarticle->update($article);
            echo $alert->successAlert("El artículo ha sido actualizado correctamente");
        }

        require_once('../views/header.php'); // Header de la pagina
    ?>
    <body class='bg-color'>
        <div class='container mt-5'>
            <div class='row'>
                <h2 class="text-center mb-4">
                    <span class="text-red">G</span>ESTIONAR <span class="text-red">A</span>RTICULOS
                </h2>
                <div class="container d-flex justify-content-center mb-4"> 
                    <button type="button" class="btn btn-danger btn-sm w-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Crear artículo
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Artículos</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form name="fextrabrand" method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Introdzca el título del artículo</label>
                                        <textarea type="text" maxlength="100" name="title" class="form-control" placeholder="Titulo del articulo." required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paragrahp1" class="form-label">Introduzca el primer párrafo del artículo</label>
                                        <textarea type="text"  maxlength="800" name="paragrahp1" class="form-control" placeholder="Introduccion del articulo." required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paragrahp2" class="form-label">Introduzca el segundo párrafo del artículo</label>
                                        <textarea type="text" maxlength="800" name="paragrahp2" class="form-control" placeholder="Introduccion del articulo." required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paragrahp3" class="form-label">Introduzca la conclusión del artículo</label>
                                        <textarea type="text" maxlength="800" name="paragrahp3" class="form-control" placeholder="Introduccion del articulo." required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Imagen del artículo</label>
                                        <input class='form-label' type='file' name='image' accept='image/jpg'>
                                    </div>
                                    <div class="d-grid gap-2 mb-3" class="form-label">
                                        <input type="submit" class="btn btn-primary" name="Crear" value="Crear">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <form name="farticlebrand" method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                    <?php 
                        $daoarticle->getarticles($_SESSION['client']['name']);
                    
                        if(count($daoarticle->articles) != 0) {
                            echo '<div class="row">';  
                            foreach($daoarticle->articles as $value) {
                                echo '<div class="col-md-4 mb-4 d-flex align-items-stretch">';
                                echo '<div class="card shadow-sm border-0 h-100 w-100">';  
                                    echo "<div class='product-content p-3 bg-dark text-white'>";
                                        echo '<h5 class="product-title mb-1 fw-bold">' . $value->__get('title'). '</h5>';
                    
                                        echo '<div class="d-flex flex-column mb-3">';
                                            echo "<p class='card-text'>Introduccion: ".$value->__get('paragrahp1')."</strong></p>";
                                        echo "</div>";
                    
                                        echo "<button class='btn btn-danger mt-3' type='submit' name='Delete' value='".$value->__get('id')."'>Eliminar</button>";
                                        echo '<button type="button" class="btn btn-secondary mt-3 ms-3" data-bs-toggle="modal" data-bs-target="#modal2">';
                                            echo 'Modificar Articulo';
                                        echo '</button>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';       
                                        echo '<div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true">';
                                        echo '  <div class="modal-dialog">';
                                        echo '    <div class="modal-content">';
                                        echo '      <div class="modal-header">';
                                        echo '        <h1 class="modal-title fs-5" id="modal2Label">Actualizar artículo</h1>';
                                        echo '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                                        echo '      </div>';
                                        echo '      <div class="modal-body">';
                                        echo "  <div class='mb-3'>";
                                        echo "    <label for='title' class='form-label'>Introduzca el título del artículo</label>";
                                        echo "    <input type='text' name='title' class='form-control' value='".$value->__get('title')."' required>";
                                        echo "  </div>";
                                        echo "  <div class='mb-3'>";
                                        echo "    <label for='paragrahp1' class='form-label'>Introduzca el primer párrafo del artículo</label>";
                                        echo "    <input type='text' name='paragrahp1' class='form-control' value='".$value->__get('paragrahp1')."' required>";
                                        echo "  </div>";
                                        echo "  <div class='mb-3'>";
                                        echo "    <label for='paragrahp2' class='form-label'>Introduzca el segundo párrafo del artículo</label>";
                                        echo "    <input type='text' name='paragrahp2' class='form-control' value='".$value->__get('paragrahp2')."' required>";
                                        echo "  </div>";
                                        echo "  <div class='mb-3'>";
                                        echo "    <label for='paragrahp3' class='form-label'>Introduzca la conclusión del artículo</label>";
                                        echo "    <input type='text' name='paragrahp3' class='form-control' value='".$value->__get('paragrahp3')."' required>";
                                        echo "  </div>";
                                        echo "  <div class='d-grid gap-2 mb-3'>";
                                        echo "<button class='btn btn-danger mt-3' type='submit' name='Modificar' value='".$value->__get('id')."'>Modificar</button>";
                                        echo "  </div>";
                                        echo '      </div>';
                                        echo '    </div>';
                                        echo '  </div>';
                                        echo '</div>';
                                }
                            echo '</div>'; 
                        } else {
                            echo "<p class='text-center'>Lo sentimos. No hay artículos disponibles. Puede crear uno nuevo.</p>";
                        }
                    ?>
                </form>
            </div>
        </div>
        <?php 
        require_once('../views/footer.php');
        require_once('../utils/scripts.php'); ?>
        <script type="module" src="../resources/js/index.js"></script>
    </body>
</html>