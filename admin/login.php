<!DOCTYPE html>
<html lang="en">

<head>
  <title>MicroTech &mdash; Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Favicons -->
  <link href="../assets/img/miit.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700,900" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/style.css">

</head>


<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>


    <header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">

      <div class="container-fluid">
        <div class="d-flex align-items-center">
          <div class="site-logo mr-auto w-25"><a href="index.html">MicroTech</a></div>

          <div class="mx-auto text-center">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mx-auto d-none d-lg-block  m-0 p-0">
                <li><a href="#home-section" class="nav-link">Home</a></li>
                <li><a href="#courses-section" class="nav-link">Courses</a></li>
                <li><a href="#programs-section" class="nav-link">Principles</a></li>
                <li><a href="#teachers-section" class="nav-link">Administrative</a></li>
                <li><a href="#about-section" class="nav-link">About Us</a></li>
              </ul>
            </nav>
          </div>

          <div class="ml-auto w-25">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu site-menu-dark js-clone-nav mr-auto d-none d-lg-block m-0 p-0">
                <li class="cta"><a href="login.php" class="nav-link" style="display:none"><span>Log In</span></a></li>
              </ul>
            </nav>
            <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black float-right"><span class="icon-menu h3"></span></a>
          </div>
        </div>
      </div>

    </header>

    <div class="intro-section" id="home-section">
      <div class="slide-1 bg-cover" style="background-image: url('images/miit.png');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
          <div class="row align-items-center">
            <div class="col-12">
              <div class="row align-items-center">
                <div class="col-lg-6 text-light" data-aos="fade-up" data-aos-delay="100">
                  <h1 class="display-4">MicroTech</h1>
                  <p class="lead mb-4">A school portal designed to enhance school operations and management.</p>
                </div>

                <div class="col-lg-5 ml-auto" data-aos="fade-up" data-aos-delay="300">
                  <div class="card shadow login-card">
                    <div class="card-body">
                      <h5 class="card-title text-center pb-3 fs-4 text-black">Login to Your Account</h5>
                      <form action="includes/login.inc.php" method="post">
                        <div class="mb-3">
                          <label for="identifier" class="form-label" style="color: black;">Username or School ID</label>
                          <div class="input-group">
                            <span class="input-group-text">@</span>
                            <input type="text" name="identifier" class="form-control" id="identifier" required>
                            <div class="invalid-feedback">Please enter your username or school ID.</div>
                          </div>
                        </div>
                        <div class="mb-3">
                          <label for="yourPassword" class="form-label" style="color: black;">Password</label>
                          <input type="password" name="password" class="form-control" id="yourPassword" required>
                          <div class="invalid-feedback">Please enter your password!</div>
                        </div>
                        <div class="mb-3 form-check">
                          <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                          <label class="form-check-label" for="rememberMe" style="color: black;">Remember me</label>
                        </div>
                        <button class="btn btn-primary w-100 login-btn" type="submit" name="login" onclick="loginAlert()">Login</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section courses-title bg-dark text-light" id="courses-section">
      <div class="container">
        <div class="row mb-5 justify-content-center">
          <div class="col-lg-12 text-center" data-aos="fade-up">
            <h2 class="section-title">Courses</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section courses-entry-wrap" data-aos="fade-up" data-aos-delay="100">
      <div class="container">
        <div class="row">

          <div class="owl-carousel col-12 nonloop-block-14">

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <a href="course-single.html"><img src="images/bsoa.jpg" alt="Image" class="img-fluid"></a>
              </figure>
              <div class="course-inner-text py-4 px-4">
                <span class="course-price bg-dark">$20</span>
                <div class="meta"><span class="icon-clock-o"></span>2 Semester / year</div>
                <h3><a href="BSOA.html">Bachelor of Science in Office Administration</a></h3>
                <p> is a four year degree program designed to provide students with knowledge and skills in business management and office processes needed in different workplaces such as general business offices, legal or medical offices.</p>
              </div>
              <div class="d-flex border-top stats">
                <div class="py-3 px-4"><span class="icon-users"></span> 200 students</div>
                <div class="py-3 px-4 w-25 ml-auto border-left"><span class="icon-chat"></span> 2</div>
              </div>
            </div>

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <a href="course-single.html"><img src="images/bsba.png" alt="Image" class="img-fluid"></a>
              </figure>
              <div class="course-inner-text py-4 px-4">
                <span class="course-price bg-dark">$99</span>
                <div class="meta"><span class="icon-clock-o"></span>2 Semester / year</div>
                <h3><a href="BSBA.html">Bachelor of Science in Business Administration</a></h3>
                <p>Major in Business Economics program (BSBA-BUSEC) is designed to provide students with a strong foundation and an understanding of the world of economics, covering local and global economic conditions as well as the methods and applications of economic analysis. </p>
              </div>
              <div class="d-flex border-top stats">
                <div class="py-3 px-4"><span class="icon-users"></span> 200 students</div>
                <div class="py-3 px-4 w-25 ml-auto border-left"><span class="icon-chat"></span> 2</div>
              </div>
            </div>

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <a href="BSIT.html"><img src="images/bsit.jpg" alt="Image" class="img-fluid"></a>
              </figure>
              <div class="course-inner-text py-4 px-4">
                <span class="course-price bg-dark">$99</span>
                <div class="meta"><span class="icon-clock-o"></span>2 Semester / year</div>
                <h3><a href="BSIT.html">Bachelor of Science in Information Technology</a></h3>
                <p>A Bachelor of Science in Information Technology degree program typically takes three to four years depending on the country. This degree is primarily focused on subjects such as software, databases, and networking.</p>
              </div>
              <div class="d-flex border-top stats">
                <div class="py-3 px-4"><span class="icon-users"></span> 100 students</div>
                <div class="py-3 px-4 w-25 ml-auto border-left"><span class="icon-chat"></span> 2</div>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-7 text-center">
            <button class="customPrevBtn btn btn-primary m-1" style="background-color: green;">Prev</button>
            <button class="customNextBtn btn btn-primary m-1" style="background-color: green;">Next</button>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section" id="programs-section">
      <div class="container">
        <!-- Section Header -->
        <div class="row mb-5 justify-content-center">
          <div class="col-lg-7 text-center" data-aos="fade-up">
            <h2 class="section-title">Foundational Statements</h2>
            <p class="lead">Microsystems International Institute of Technology: mission, vision, and core values</p>
          </div>
        </div>

        <!-- Vision Section -->
        <div class="row mb-5 align-items-center">
          <div class="col-lg-7 mb-5" data-aos="fade-up" data-aos-delay="100">
            <img src="images/vision.webp" alt="Vision Image" class="img-fluid rounded shadow">
          </div>
          <div class="col-lg-4 ml-auto" data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-dark mb-4">Vision</h3>
            <p class="mb-4">To become an educational institute whose quality education in all fields of study is anchored on technology and economic development in the 21st century.</p>
          </div>
        </div>

        <!-- Mission Section -->
        <div class="row mb-5 align-items-center">
          <div class="col-lg-7 mb-5 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
            <img src="images/mission.webp" alt="Mission Image" class="img-fluid rounded shadow">
          </div>
          <div class="col-lg-4 mr-auto order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-dark mb-4">Mission</h3>
            <p class="mb-4">To establish, operate, and promote quality education and training-based institute in the field of science and technology, and all other fields of study, at affordable fees for every individual.</p>
          </div>
        </div>

        <!-- Core Values Section -->
        <div class="row mb-5 align-items-center">
          <div class="col-lg-7 mb-5" data-aos="fade-up" data-aos-delay="100">
            <img src="images/values.webp" alt="Core Values Image" class="img-fluid rounded shadow">
          </div>
          <div class="col-lg-4 ml-auto" data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-dark mb-4">Core Values</h3>
            <p class="mb-4">
              <b>Magnanimity</b> - As a Christian institute of higher learning, MIIT prides itself on fostering academic excellence through personalized instruction and hands-on learning, open communication, and quality performance among students and staff, always bearing in mind the MIIT student as a responsible learner.
            </p>
            <p class="mb-4">
              <b>Integrity</b> - MIIT promotes integrity, honesty, and respect for the individual through its dedicated and diverse faculty and staff, emphasizing ethics and professional behavior in the pursuit of academic freedom and in the process of respecting the worth of each individual.
            </p>
            <p class="mb-4">
              <b>Innovativeness</b> - MIIT believes in continuous improvement as it endeavors to serve the community through its various outreach activities, particularly when it aims to contribute to the nation’s academic progress.
            </p>
            <p class="mb-4">
              <b>Technology-Driven Teamwork</b> - MIIT fosters a healthy knowledge-based environment that encourages technology transfer, nurtures service excellence not only in academics but also in research, molding students to be globally competitive.
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section" id="teachers-section">
      <div class="container">

        <div class="row mb-5 justify-content-center">
          <div class="col-lg-7 mb-5 text-center" data-aos="fade-up" data-aos-delay="">
            <h2 class="section-title">Administrative & Faculty Members </h2>
            <p class="mb-5">Individuals managing daily operations and organizational aspects of a school. And Educators and academic professionals responsible for teaching, research, and student development.</p>
          </div>
        </div>

        <div class="row">

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/director.png" alt="Director's Image" class="img-fluid rounded-circle teacher-image mb-3">
              <h3 class="teacher-name">Alfredo S. Moreno Jr., Ed D.</h3>
              <p class="teacher-position">School Director</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/registrar.jpg" alt="Image"class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Mariza M. Leyco, BSED</h3>
                <p class="position"> Registrar / Chairman, Gen. Ed.</p>
            </div>
          </div>
          
          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/default.png" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Jericho Vicente A. Cutas </h3>
                <p class="position">MSBA / College Dean / HR Officer</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/maam_rose.png" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Rosemarie R. Jipulan, BSIT</h3>
                <p class="position">Scholarship Coordinator</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/maam_jessa.png" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Jessa Mae s. Carzano, </h3>
                <p class="position">BSIT / Accounting Officer</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/estrera.jpg" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Romulo M. Estrera, Ph D.</h3>
                <p class="position">Chairman, Information Tech.</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/default.png" alt=" Image" class="img-fluid rounded-circle teacher-image mb-3">
              <div class="py-2">
                <h3 class="teacher-name">Renaben G. Raganas, BSOA</h3>
                <p class="position">Marketing Officer</p>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/daniel.png" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
              <div class="py-2">
                <h3 class="teacher-name">Gad Daniel Z. Flormata</h3>
                <p class="position"> BSIT / Laboratory Technicians</p>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/sir_mike.jpg" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
              <div class="py-2">
                <h3 class="teacher-name">Michael John Bustamante</h3>
                <p class="position">BSIT / IT Instructor</p>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/bsoa_instructor.png" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Metciho R. Jipulan,</h3>
                <p class="position"> BSED/ NSTP / SAO / ALUMNI</p>
            </div>
          </div>


          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/bsba_instructor.jpg" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Nerissa M. Auxilo</h3>
                <p class="position">BSC-MBA / Instructor</p>
            </div>
          </div>


          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/rene.jpg" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Rene R. Ababan, </h3>
                <p class="position">BSIT / IT Instructor</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/sunshine.jpg" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Sunshin Jill L. Bilagantol,</h3>
                <p class="position">BEED / Guidance Councilor</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/maam_angela.jpg" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Angela S. Gravines, MAED </h3>
                <p class="position">Major in Mathematics / Instructor</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/maam_bolen.jpg" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Ethel M. Bolen, AB -English</h3>
                <p class="position">Insructor</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/default.png" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Luzmindo L. Bolongaita</h3>
                <p class="position">BSBA-MM / Instructor</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/default.png" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Raul A. Dulusa, AB - Englsih</h3>
                <p class="position">MAED / Instructor</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="teacher-profile text-center">
              <img src="images/ella.jpg" alt="Image" class="img-fluid rounded-circle teacher-image mb-3">
                <h3 class="teacher-name">Ella Marrie E. Gabasa, BIT</h3>
                <p class="position">GAD Coordinator</p>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="site-section" id="about-section">
      <div class="container">

        <div class="row mb-5 justify-content-center">
          <div class="col-lg-7 mb-5 text-center" data-aos="fade-up" data-aos-delay="">
            <h2 class="section-title">ABOUT MIIT</h2>
          </div>
        </div>
          
        <div class="col-md-12 about-us-section">
          <h3 class="section-titles">About Us</h3>
          <p class="section-text">
            Microsystems International Institute of Technology, Inc. (MIIT) is a premier educational institution dedicated to fostering
            academic excellence and personal growth. Our mission is to inspire and prepare students for global competitiveness
            through a distinctively Christian environment that values learning, service excellence, and quality performance.
            <br><br>
            Founded in 2001 by Filipino educators, engineers, and businessmen, MIIT addresses the demand for a highly educated and
            well-trained workforce. We offer cutting-edge programs and emphasize research and innovation, with strong ties to
            industry and community partners. MIITinians are expected to uphold high standards of conduct, embodying our values of
            respect, helpfulness, and professionalism.
          </p>
          
          <h3 class="section-titles">Our Goals</h3>
          <ul class="section-text">
            <li>To promote the value of learning, self-worth, quality performance among students and staff, and transition for students to productive and responsible participation in society.</li>
            <li>To promote and nurture service excellence.</li>
            <li>To reach, educate, inspire, grow, and nurture today's generation.</li>
            <li>To provide a distinctively-Christian environment of educational excellence while challenging the academically accelerated individual.</li>
            <li>To prepare the students to be globally competitive in the industry.</li>
            <li>To continue on new roads of research and discovery in our existing areas of expertise, in emerging disciplines, and in related interdisciplinary areas.</li>
            <li>To provide the educational resource that working professionals need to keep pace with developments in their field.</li>
            <li>To magnify our positive impact in serving regional, state, national, and global needs by building mutually beneficial linkages with business, industry, community colleges, and other constituencies.</li>
          </ul>

          <h3 class="section-titles">Our History</h3>
          <p class="section-text">
            On November 2001, a group of Filipino educators, engineers, and businessmen convened and discussed the possibility of establishing a science and technology school to address the opportunities brought by the 21st-century technology and economic advancements. The Philippines, however, is far behind compared to other developed countries regarding this development. The need for a highly educated and well-trained workforce in the Philippines and globally created an industry for itself. In fact, millions of workers, not only Filipinos, seek and find employment in foreign companies located within their country or abroad to fill up this yawning need.
          </p>

          <h3 class="section-titles" >Our Norms of Conduct</h3>
          <p class="section-text">
            Students of Microsystems International Institute of Technology are expected to behave as worthy members of the institute. As MIITinians, whether inside or outside the campus, their conduct should be an asset to the school, to themselves, and to their parents. The Administration looks upon each student as a guardian of school regulations and holds each one responsible for their observance.
            <br><br>
            <strong class="section-text">A. In the Campus</strong>
            <ol class="section-text">
              <li>At MIIT, everyone is expected to be friendly, respectful, and helpful to one another at all times as MIITinians should practice.</li>
              <li>Students should behave properly at all times and should be courteous to the Faculties, Administrative personnel, Board of Directors, parents, and visitors.</li>
              <li>Students should take good care of the school property and facilities; vandalism is prohibited and is subject to disciplinary action.</li>
              <li>Cleanliness should always be observed. Littering is strictly prohibited. Silence should always be observed.</li>
              <li>Students are expected to wear the prescribed uniform with an identification card at all times during school days and official school activities.</li>
              <li>English should be spoken at all times within the campus.</li>
              <li>All students are required to wear the uniform prescribed by the school from Monday to Friday except Wednesday, which is a wash day.</li>
              <li>For reasons of decency and neatness, all boys are required to have haircuts.</li>
              <li>All students are encouraged to be simple in appearance. Girls are prohibited from wearing dangling or multiple earrings. The color of ribbons, hair bands, or hairclips must match the uniform and not be multi-colored.</li>
              <li>Alcohol, prohibited drugs, gambling, and all illegal activities are not allowed on the school campus.</li>
              <li><strong>Dress code for women:</strong>
                <ul>
                  <li>Should wear the prescribed uniform with ID.</li>
                  <li>Black closed shoes.</li>
                </ul>
              </li>
              <li><strong>Dress code for men:</strong>
                <ul>
                  <li>Should wear the prescribed uniform with ID.</li>
                  <li>Leather black shoes.</li>
                </ul>
              </li>
            </ol>

            <strong class="section-text">B. Inside the Classroom</strong>
            <ol class="section-text">
              <li>Prayer should be said reverently and clearly before and after each class.</li>
              <li>No one is allowed to transfer from one seat to another without the teacher's permission.</li>
              <li>Students should maintain the academic posture.</li>
              <li>A student caught and confirmed cheating in any test gets zero for that particular test.</li>
              <li>Writing, drawing, or carving on the walls, chairs, or tables are strictly prohibited.</li>
              <li>Assigned working students should take charge of putting off electric fans and lights inside the classroom after use.</li>
            </ol>

            <strong class="section-text">C. At the Comfort Rooms</strong>
            <ol class="section-text">
              <li>Students are expected to keep the comfort rooms clean by not throwing pieces of paper on the floor and by not putting marks on the walls, especially indecent markings.</li>
            </ol>
          </p>
        </div>

        <style>
          .section-title {
            font-family: 'Arial', sans-serif;
            font-size: 1.8rem;
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 10px;
          }

          .section-text {
            font-family: 'Arial', sans-serif;
            font-size: 1.1rem;
            color: #34495e;
            line-height: 1.6;
            text-align: justify;
          }

          .section-text ul,
          .section-text ol {
            padding-left: 20px;
          }

          .section-text ol {
            margin-bottom: 20px;
          }

          .section-text li {
            margin-bottom: 10px;
          }

          .about-us-section {
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
          }
        </style>

      </div>
    </div>
  </div>

  <footer class="footer-section bg-light"  id="footer-section ">
    <div class="container">
      <div class="row">

      <div class="col-md-4">
        <h3 class="footer-title">Links</h3>
        <ul class="list-unstyled footer-links">
          <li><a href="login.php" class="footer-link">Home</a></li>
          <li><a href="#courses-section" class="footer-link">Courses</a></li>
          <li><a href="#programs-section" class="footer-link">Principles</a></li>
          <li><a href="#teachers-section" class="footer-link">Administrative</a></li>
        </ul>
      </div>

      <div class="col-md-4">
        <h3 class="footer-title">Account</h3>

        <!-- Social Links -->
        <div class="social-links" style="display: flex; gap: 15px;">
          <!-- Facebook Link with Icon -->
          <a href="https://www.facebook.com/MIITOFFICIALPAGE" target="_blank" title="Follow us on Facebook" class="social-icon facebook">
            <i class="fab fa-facebook-f"></i> <!-- Font Awesome Facebook Icon -->
          </a>

          <!-- Twitter Link with Icon -->
          <a href="#" target="_blank" title="Follow us on Twitter" class="social-icon twitter">
            <i class="fab fa-twitter"></i> <!-- Font Awesome Twitter Icon -->
          </a>

          <!-- Instagram Link with Icon -->
          <a href="#" target="_blank" title="Follow us on Instagram" class="social-icon instagram">
            <i class="fab fa-instagram"></i> <!-- Font Awesome Instagram Icon -->
          </a>
        </div>
      </div>

      <!-- Add this CSS in the <style> section of your HTML or in an external stylesheet -->
      <style>
        /* Footer Links */
        .footer-title {
          font-size: 24px;
          font-weight: bold;
          margin-bottom: 15px;
          color: #333;
        }

        .footer-links li {
          margin: 5px 0;
        }

        .footer-link {
          font-size: 16px;
          text-decoration: none;
          color: #007bff;
          transition: color 0.3s ease;
        }

        .footer-link:hover {
          color: #0056b3;
        }

        /* Social Links */
        .social-links {
          display: flex;
          gap: 15px;
        }

        .social-icon {
          font-size: 24px;
          text-decoration: none;
          transition: transform 0.3s ease;
        }

        .social-icon:hover {
          transform: scale(1.1);
        }

        /* Specific Icon Colors */
        .facebook {
          color: #3b5998;
        }

        .twitter {
          color: #1da1f2;
        }

        .instagram {
          color: #c13584;
        }

        .social-icon:hover {
          color: #000;
        }
      </style>

      </div>
      <div class="row pt-5 mt-5 text-center">
        <div class="col-md-12">
          <div class="border-top pt-5">
            <p>
              Copyright &copy;
              <script>
                document.write(new Date().getFullYear());
              </script> All rights reserved |Microsystems International Institute of Technology, Inc.
            </p>
          </div>
        </div>

      </div>
    </div>
  </footer>

  </div> <!-- .site-wrap -->

<!-- Load JS at the end to improve performance and avoid blocking rendering -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/aos.js"></script>
<script src="js/jquery.fancybox.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/main.js"></script>


  <style>
      /* Basic Layout and Backgrounds */
    .intro-section {
      position: relative;
      color: #ffffff;
    }

    .bg-cover {
      background-size: cover;
      background-position: center;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.4); /* Dark overlay for readability */
    }

    .section-title {
      font-family: 'Poppins', sans-serif;  /* Clean and modern sans-serif font */
      font-size: 3rem;                     /* Responsive font size */
      font-weight: 700;                    /* Bold font weight */
      margin-bottom: 1.25rem;              /* Spacing below the title */
      color: #222;                         /* Slightly softer black for readability */
      text-transform: uppercase;
      letter-spacing: 1.5px;               /* Increased letter spacing for emphasis */
      line-height: 1.2;                    /* Adjusted line height for better readability */
      text-align: center;                  /* Center-align for a balanced layout */
    }

    @media (max-width: 768px) {
      .section-title {
        font-size: 2.5rem;                 /* Smaller font on medium screens */
      }
    }

    @media (max-width: 576px) {
      .section-title {
        font-size: 2rem;                   /* Further reduced font size on small screens */
      }
    }

    .section-titles {
      font-family: 'Poppins', sans-serif;  /* Clean and modern sans-serif font */
      font-size: 1.5rem;               /* Responsive font size */
      font-weight: 700;              /* Bold font weight */
      margin-bottom: 1.25rem;        /* Spacing below the title */
      color: #222;                   /* Slightly softer black for readability */
      text-transform: uppercase;
      letter-spacing: 1.5px;         /* Increased letter spacing for emphasis */
      line-height: 1.2;              /* Adjusted line height for better readability */
      text-align: left;            /* Center-align for a balanced layout */
    }


    .site-section.courses-title {
      padding: 80px 60;
      background: #343a40;
      color: #f8f9fa;
      text-align: center;
    }

    .courses-title .section-title {
      font-size: 48px;
      font-weight: bold;
      color: #f8f9fa;
    }

    /* Typography for Content */
    .lead {
      font-size: 1.125rem;
      font-weight: 400;
      color: #666;
      margin-bottom: 40px;
    }

    /* Image Styling */
    .img-fluid {
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      max-width: 100%;
      height: auto;
    }

    .course figure img {
      width: 100%;
      border-bottom: 1px solid #ddd;
    }

    /* Login Form */
    .login-card {
      border: none;
      border-radius: 8px;
      padding: 2rem;
      background-color: #ffffff;
    }

    .login-btn {
      background-color: green;
      color: #ffffff;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    .login-btn:hover {
      background-color: darkgreen;
    }

    /* Course Card Styles */
    .courses-entry-wrap .course {
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .courses-entry-wrap .course:hover {
      transform: translateY(-10px);
    }

    .course-inner-text {
      padding: 20px;
      color: #495057;
    }

    .course-inner-text h3 {
      font-size: 20px;
      font-weight: 600;
      color: #343a40;
      margin-bottom: 15px;
    }

    .course-inner-text p {
      font-size: 14px;
      color: #6c757d;
      margin-bottom: 15px;
    }

    .course-price {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #28a745;
      color: #fff;
      font-size: 14px;
      padding: 5px 10px;
      border-radius: 5px;
    }

    .meta {
      font-size: 12px;
      color: #6c757d;
      margin-bottom: 10px;
    }

    /* Statistics Section */
    .stats {
      background: #f8f9fa;
    }

    .stats div {
      color: #6c757d;
    }

    .stats div span {
      margin-right: 5px;
      color: #28a745;
    }

    /* Carousel Navigation Buttons */
    .customPrevBtn, .customNextBtn {
      color: #fff;
      background-color: #28a745;
      border: none;
      font-size: 14px;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    .customPrevBtn:hover, .customNextBtn:hover {
      background-color: #218838;
    }

    /* Teacher Profile Card */
    .teacher-profile {
      padding: 2em;
      border: 1px solid #ddd;
      border-radius: 10px;
      background-color: #f9f9f9;
      transition: transform 0.3s ease;
    }

    .teacher-profile:hover {
      transform: scale(1.05);
      background-color: #fff;
    }

    .teacher-image {
      width: 60%;
      max-width: 150px;
      border: 3px solid #007bff;
    }

    .teacher-name {
      font-size: 1.2em;
      color: #333;
      margin: 0.5em 0 0.2em;
    }

    .teacher-position {
      font-size: 0.95em;
      color: #777;
    }

    /* Responsive Adjustments for Small Screens */
    @media (max-width: 768px) {
      .order-1, .order-2 {
        order: unset;
      }
    }

  </style>

</body>

</html>