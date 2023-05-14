<?php include('header-scripts.php'); ?>
<link rel="stylesheet" type="text/css" href="src/assets/css/light/apps/blog-post.css">
<style>
    .featured-image {
  position: relative;
  background: url(images/about.jpg) no-repeat fixed center;
  height: 650px;
  background-position: center;
  background-size: cover;
  background-attachment: inherit;
  border-radius: 20px;
  overflow: hidden;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
</style>
<body class="layout-boxed" layout="full-width">

    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <?php include('header.php'); ?>
    <div class="main-container " id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>
        <?php include('nav-sidebar.php'); ?>
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">
                    <div class="row layout-top-spacing">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
                            <div class="single-post-content">
                                <div class="featured-image mb-5">
                                    <div class="featured-image-overlay"></div>
                                    <div class="post-header">
                                        <div class="post-title">
                                            <h1 class="mb-0">About Us</h1>
                                        </div>
                                        <div class="post-meta-info d-flex justify-content-between">
                                            <div class="media">
                                              <!--   <img src="src/assets/img/profile-12.jpeg" alt="profile">
                                                <div class="media-body">
                                                    <h5>Jane Doe</h5>
                                                    <p>Chief Executive Officer</p>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-info">
                                    <div class="post-comments">
                                        <div class="media mb-5 pb-5 primary-comment">
                                            <div class="avatar me-4" style="width: 10rem;height: 10rem;">
                                                <img alt="avatar" src="src/assets/img/amaya.jpg" class="rounded-circle" />
                                            </div>
                                            <div class="media-body mt-5">
                                                <h1 class="mb-1">Haven Louiam Amaya</h1>
                                                <div class="meta-info mb-0"><h4 class="text-warning">Hustler/Hipster</h4></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-info">
                                    <div class="post-comments">
                                        <div class="media mb-5 pb-5 primary-comment">
                                            <div class="avatar me-4" style="width: 10rem;height: 10rem;">
                                                <img alt="avatar" src="src/assets/img/rodfil.jpg" class="rounded-circle" />
                                            </div>
                                            <div class="media-body mt-5">
                                                <h1 class="mb-1">Rodfil Tayong</h1>
                                                <div class="meta-info mb-0"><h4 class="text-warning">Hacker </h4></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-info">
                                    <div class="post-comments">
                                        <div class="media mb-5 pb-5 primary-comment">
                                            <div class="avatar me-4" style="width: 10rem;height: 10rem;">
                                                <img alt="avatar" src="src/assets/img/prince.jpg" class="rounded-circle" />
                                            </div>
                                            <div class="media-body mt-5">
                                                <h1 class="mb-1">Prince Martin Siera</h1>
                                                <div class="meta-info mb-0"><h4 class="text-warning">Hipster/ Tecnhical Writer </h4></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-info">
                                    <div class="post-comments">
                                        <div class="media mb-5 pb-5 primary-comment">
                                            <div class="avatar me-4" style="width: 10rem;height: 10rem;">
                                                <img alt="avatar" src="src/assets/img/ribo.png" class="rounded-circle" />
                                            </div>
                                            <div class="media-body mt-5">
                                                <h1 class="mb-1">Kevin Ribo </h1>
                                                <div class="meta-info mb-0"><h4 class="text-warning">Hacker</h4></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-info">
                                    <div class="post-comments">
                                        <div class="media mb-5 pb-5 primary-comment">
                                            <div class="avatar me-4" style="width: 10rem;height: 10rem;">
                                                <img alt="avatar" src="src/assets/img/cristine.png" class="rounded-circle" />
                                            </div>
                                            <div class="media-body mt-5">
                                                <h1 class="mb-1">Cristine Ducal </h1>
                                                <div class="meta-info mb-0"><h4 class="text-warning">Hipster </h4></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer-wrapper.php'); ?>
        </div>
    </div>
    <?php include('footer-scripts.php'); ?>
</body>
</html>