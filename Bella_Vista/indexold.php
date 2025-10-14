<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bella Vista</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>
    <header class="nav-container">
        <div class="nav" id="myTopnav">
            <div class="nav-left">
                <img src="res/img/logo.svg" alt="Bella Vista Logo" class="logo">
                <span class="logo-name">Bella Vista</span>
            </div>
            <div class="nav-center">
                <ul class="menu">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Menu</a></li>
                    <li><a href="#">Reservation</a></li>
                    <li><a href="#">Contact</a></li>
                    <li class="icon">
                        <a href="javascript:void(0);" style="font-size:15px;" onclick="myFunction()"><i class="fa fa-bars"></i></a>
                    </li>
                </ul>
            </div>
            <div class="nav-right">
                <div class="cart">
                    <span class="cart-number">1</span>
                    <a href="#"><i class="fa-solid fa-cart-shopping" style="color: #000000;"></i></a>
                </div>
                <a href="#" class="green-btn">Reserve Table</a>
            </div>
        </div>
    </header>
<!-- 
    <main class="main-container">
        <div class="banner-container">
            <img src="res/img/Main-banner.jpg" alt="Delicious Italian Dish">
            <div class="banner-text">
                <h1>Ready to Experience Bella Vista?</h1>
                <p>Join us for an unforgettable culinary journey that celebrates tradition, flavor, and hospitality.</p>
                <div class="banner-btn">
                    <a href="#" class="green-btn" style="background-color: #FFFFFF; color:#D32F2F"><i class="fa-solid fa-calendar-days"></i> Reserve Your Table</a>
                    <a href="#" class="green-btn" style="background-color: transparent; border:1px solid #FFFFFF; border-radius: 10px; color:#FFFFFF"><i class="fa-solid fa-utensils"></i> View Our Menu</a>
                </div>
            </div>
        </div>

        <div class="featured-container">
            <div class="section-title">
                <h3>Featured Dishes</h3>
                <p>Discover our most popular creations, each crafted with passion and served with excellence.</p>
            </div>
            <div class="menus">
                <div class="menu-card">
                    <img src="res/img/menu1.png" alt="Grilled Atlantic Salmon">
                    <span>Grilled Atlantic Salmon</span>
                    <p>Fresh salmon fillet with seasonal vegetables and lemon herb butter.</p>
                    <div class="price-btn">
                        <span class="price">$28</span>
                        <a href="#" class="green-btn" style="background-color: #F57C00; color:#FFFFFF">Add to Cart</a>
                    </div>
                </div>
                <div class="menu-card">
                    <img src="res/img/menu3.png" alt="Prime Beef Tenderloin">
                    <span>Prime Beef Tenderloin</span>
                    <p>8oz tenderloin with truffle mashed potatoes and red wine reduction.</p>
                    <div class="price-btn">
                        <span class="price">$42</span>
                        <a href="#" class="green-btn" style="background-color: #F57C00; color:#FFFFFF">Add to Cart</a>
                    </div>
                </div>
                <div class="menu-card">
                    <img src="res/img/menu2.png" alt="Lobster Risotto">
                    <span>Lobster Risotto</span>
                    <p>Creamy arborio rice with fresh lobster and saffron.</p>
                    <div class="price-btn">
                        <span class="price">$36</span>
                        <a href="#" class="green-btn" style="background-color: #F57C00; color:#FFFFFF">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="story-container">
            <div class="story">
                <div class="story-text">
                    <h3>Our Story</h3>
                    <p>Founded in 2015, Bella Vista began as a dream to bring authentic, farm-to-table dining to our community. Our passionate team of chefs sources the finest local ingredients to create memorable culinary experiences.</p>
                    <p>Every dish tells a story of tradition, innovation, and our commitment to excellence. We believe that great food brings people together and creates lasting memories.</p>
                    <a href="#" class="green-btn">Learn More About Us</a>
                </div>
                <div class="story-img">
                    <img src="res/img/story.png" alt="Our Story">
                </div>
            </div>
        </div>

        <div class="team-container">
            <div class="section-title">
                <h3>Meet Our Team</h3>
                <p>Get to know the passionate individuals behind Bella Vista, dedicated to delivering exceptional dining experiences.</p>
            </div>
            <div class="teams">
                <div class="team-card">
                    <img src="res/img/Head-Chef.png" alt="Chef Marcus Rivera" class="team-img">
                    <h4 class="team-name">Chef Marcus Rivera</h4>
                    <p class="team-role">Head Chef</p>
                    <p class="team-bio">15 years of culinary excellence with expertise in Mediterranean and contemporary cuisine.</p>
                </div>
                <div class="team-card">
                    <img src="res/img/Sous-Chef.png" alt="Chef Isabella Chen" class="team-img">
                    <h4 class="team-name">Chef Isabella Chen</h4>
                    <p class="team-role">Sous Chef</p>
                    <p class="team-bio">Specialized in Asian fusion techniques with a passion for innovative flavor combinations.</p>
                </div>
                <div class="team-card">
                    <img src="res/img/manager.png" alt="David Thompson" class="team-img">
                    <h4 class="team-name">David Thompson</h4>
                    <p class="team-role">Restaurant Manager</p>
                    <p class="team-bio">Dedicated to ensuring every guest has an exceptional dining experience from start to finish.</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer-container">
        <div class="footer">
            <div class="txt-logo">
                <img src="res/img/logo.svg" alt="Bella Vista Logo" class="logo">
                <span class="logo-name">Bella Vista</span>
            </div>
            <span class="desc">Authentic Italian cuisine served with passion and tradition since 1985.</span>
        </div>
        <div class="footer">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Menu</a></li>
                <li><a href="#">Reservation</a></li>
            </ul>
        </div>
        <div class="footer">
            <h3>Contact Info</h3>
            <ul>
                <li><i class="fa-solid fa-location-dot" style="color: #9CA3AF;"></i> 123 Culinary Street, Food City</li>
                <li><i class="fa-solid fa-phone" style="color: #9CA3AF;"></i> (555) 123 4567</li>
                <li><i class="fa-solid fa-envelope" style="color: #9CA3AF;"></i> hello@bellavista.com</li>
            </ul>
        </div>
        <div class="footer">
            <h3>Follow Us</h3>
            <a href="#"><i class="fa-brands fa-facebook-f" style="color: #FFFFFF; background-color:#374151; border-radius: 50%;"></i></a>
            <a href="#"><i class="fa-brands fa-twitter" style="color: #FFFFFF; background-color:#374151; border-radius: 50%;"></i></a>
        </div>
    </footer> -->

    <script src="js/script.js"></script>
</body>

</html>