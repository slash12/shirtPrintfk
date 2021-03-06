<?php
require('includes/dbconnect.php');
if(!isset($_SESSION['user_login']))
{
  require('includes/session_timer.php');
}

if(isset($_SESSION['admin']))
{
  header('Location:webadmin/crudtshirt.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Index</title>
  <link rel="stylesheet" href="css/style.css" type="text/css" media="all">
  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap-magnify.css" type="text/css">
  <script src="http://code.jquery.com/jquery-1.11.3.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap-magnify.js"></script>
  <script src="js/popper.js"></script>
  <script src='js/scrolljquery.min.js'></script>
  <script src='js/ScrollToTop.js'></script>
  <style media="screen">
  .example{
    height: auto;
    width: 100%;
    margin: 0 auto;
  }

  .sidebar{
    height: auto;
    width: auto;

  }
  </style>

</head>
<body>

  <?php
  require("includes/navbar.php");
  ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="col-md-12">
          <div class="example sidebar">
            <ul class="list-group">

              <li class="list-group-item"> <h5 style="text-align:center;">Discover</h5> </li>
              <li class="list-group-item">  <a href="#">Easter Shirts</a></li>
              <li class="list-group-item">  <a href="#">Earth day Shirts</a></li>
              <li class="list-group-item">  <a href="#">Feminist Shirts</a></li>
              <li class="list-group-item"><a href="#">Country Music Shirts</a></li>
              <li class="list-group-item"><a href="#">Horoscope Shirts</a></li>
              <li class="list-group-item">  <a href="#">Funny Shirts</a></li>

              <li class="list-group-item"> <h5 style="text-align:center;">Our Favorites</h5> </li>

              <li class="list-group-item"> <a href="#">Inspirational Shirts</a></li>
              <li class="list-group-item"><a href="#">Make up T-Shirts</a></li>
              <li class="list-group-item"><a href="#">Football Shirts</a></li>

              <li class="list-group-item"> <h5 style="text-align:center;">Most Trending</h5> </li>

              <li class="list-group-item"> <a href="#">Vintage T-Shirts</a></li>
              <li class="list-group-item"><a href="#">Gaming T-Shirts</a></li>
              <li class="list-group-item"><a href="#">Vegan T-Shirts</a></li>
              <li class="list-group-item"> <a href="#">Graphic T-Shirts</a></li>

            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12">
            <div class="example">

              <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img class="d-block w-100" src="images/banner1.jpg" height="300px" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="images/banner2.jpg" height="300px"  alt="Second slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="images/banner3.jpg"  height="300px" alt="Third slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="images/banner4.jpg"  height="300px" alt="forth slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>




            </div>
          </div>

          <div class="col-md-12">
            <div class="example">

              <div class="row">
                <div class="col-sm">

                  <div class="card">

                    <div id="menshirtslide" class="carousel slide" data-ride="carousel">
                      <p class="carouselcap" style="text-align:center;font-weight: bold;">Men</p>
                      <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                          <img class="card-img-top" src="images/man_unisex.jpg" alt="man_unisex img cap">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Plain Shirt</h5>

                        </div>
                        <div class="carousel-item">
                          <img class="d-block img-fluid" src="images/lsleevemen.jpg" alt="Second slide">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Long-Sleeve Shirt</h5>

                        </div>
                        <div class="carousel-item">
                          <img class="d-block img-fluid" src="images/polosmen.jpg" alt="Third slide">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Polos Shirt</h5>

                        </div>
                        <div class="carousel-item">
                          <img class="d-block img-fluid" src="images/hoodmen.jpg" alt="Fourth slide">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Hoddies</h5>

                        </div>
                        <div class="carousel-item">
                          <img class="d-block img-fluid" src="images/ttopmen.jpg" alt="Fifth slide">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Tank Top</h5>

                        </div>
                      </div>
                    </div>


                  </div>


                </div>
                <div class="col-sm">
                  <div class="card">
                    <div id="womenshirtslide" class="carousel slide" data-ride="carousel">
                      <p class="carouselcap" style="text-align:center;font-weight: bold;">Women</p>

                      <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                          <img class="card-img-top" src="images/woman.jpg" alt="woman image cap">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">V-neck Shirt</h5>

                        </div>
                        <div class="carousel-item">
                          <img class="d-block img-fluid" src="images/lsleevewoman.jpg" alt="Second slide">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Long-Sleeve Shirt</h5>

                        </div>
                        <div class="carousel-item">
                          <img class="d-block img-fluid" src="images/poloswoman.jpg" alt="Third slide">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Polos Shirt</h5>
                        </div>

                        <div class="carousel-item">
                          <img class="d-block img-fluid" src="images/hoodwoman.jpg" alt="Fourth slide">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Hoddies</h5>

                        </div>
                        <div class="carousel-item">
                          <img class="d-block img-fluid" src="images/ttopwoman.jpg" alt="Fifth slide">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Tank Top</h5>
                        </div>

                      </div>
                    </div>

                  </div>



                </div>
                <div class="col-sm">
                  <div class="card">
                    <div id="kidsshirtslide" class="carousel slide" data-ride="carousel">
                      <p class="carouselcap" style="text-align:center;font-weight: bold;">Kids</p>

                      <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                          <img class="card-img-top" src="images/kids_babies.jpg" alt="kids_babies image cap">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Short-Sleeve Shirt</h5>

                        </div>
                        <div class="carousel-item">
                          <img class="d-block img-fluid" src="images/lsleevekid.jpg" alt="Second slide">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Long-Sleeve Shirt</h5>

                        </div>
                        <div class="carousel-item">
                          <img class="d-block img-fluid" src="images/poloskid.jpg" alt="Third slide">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Polos Shirt</h5>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm">
                  <div class="card">
                    <div id="coupleshirtslide" class="carousel slide" data-ride="carousel">
                      <p class="carouselcap" style="text-align:center;font-weight: bold;">Couples</p>

                      <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                          <img class="card-img-top" src="images/couples.jpg" alt="couples image cap">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Short-Sleeve Shirts</h5>

                        </div>
                        <div class="carousel-item">
                          <img class="d-block img-fluid" src="images/lsleevecouple.jpg" alt="Second slide">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Long-Sleeve Shirts</h5>

                        </div>
                        <div class="carousel-item">
                          <img class="d-block img-fluid" src="images/poloscouple.jpg" alt="Third slide">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                          <h5 class="carouselcap">Polos Shirts</h5>

                        </div>
                      </div>
                    </div>

                  </div>


                </div>
              </div>

            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
  <?php
  require("includes/footer.php");
  ?>

</body>
</html>
