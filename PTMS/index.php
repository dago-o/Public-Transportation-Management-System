<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Management System</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <nav class="nav">
        <img class="logoimage" src="download.jpg" alt="Logo"
        style="width: 100px; border: 4px solid green;
        border-radius:50%">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#contact">Contact Us</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
        <div class="search-bar">
            <input type="text" placeholder="Search...">
            <button class="button">Search</button>
        </div>
    </nav>

    <div class="hero-section">
        <p>
           <b> WELCOME TO GADA BUS TRANSPORT SERVICE!</b><br>
            Our company provides top-notch services for its passengers.<br><br>
            <a href="register.php" class="button" style="background-color: dodgerblue;">Start Now</a>
        </p>
    </div>

    <!-- Gallery Section -->
    <div class="gallery-container">
        <div class="gallery">
            <div class="gallery-item">
                <img src="image3.jpg" alt="Bus 1">
                <p>Our premium bus service with comfortable seating and Wi-Fi.</p>
            </div>
            <div class="gallery-item">
                <img src="bus2.jpg" alt="Bus 2">
                <p>Reliable inter-city transportation ensuring safety and comfort.</p>
            </div>
            <div class="gallery-item">
                <img src="bus1.jpg" alt="Bus 3">
                <p>Luxury travel experience for long-distance routes.</p>
            </div>
            <div class="gallery-item">
                <img src="bus5.jpg" alt="Bus 4">
                <p>Eco-friendly buses with low emissions and smooth rides.</p>
            </div>
        </div>
    </div>

    <!-- About Us Section -->
    <section id="about" class="content-section">
    <br><br><br><br><br>
        <h2>About Us</h2>
        <p>
        Welcome to [GADA Bus Public Transportation Service], a trusted leader in public transportation, committed to making your journey as 
        comfortable, affordable, 
        and seamless as possible. We pride ourselves on providing high-quality transport services that cater to the diverse needs of our passengers. 
        Whether you're commuting to work, traveling between cities, or exploring new destinations, we ensure that your travel experience is stress-free 
        and enjoyable. 
        Our mission is to offer a sustainable, comfortable, and affordable transportation option for everyone. We strive to make public transportation a convenient
         choice by offering a reliable service that connects people, places, and opportunities.

Join Us for a Better Travel Experience:
We invite you to experience the difference that [GADA Bus Public Transportation Service] can make in your journey. Whether you’re traveling for work, leisure, or errands, we are here to provide you with the best transport services.
        </p>
    </section>

    <!-- Contact Us Section -->
    <section id="contact" class="content-section">
    <br><br><br><br>
        <h2>Contact Us</h2>
        <form class="contact-form">
            <label for="name">Name:</label>
            <input type="text" id="name" placeholder="Your Name">
            <label for="email">E-mail:</label>
            <input type="email" id="email" placeholder="Your Email">
            <label for="message">Message:</label>
            <textarea id="message" rows="5" placeholder="Write your thoughts here..."></textarea>
            <button class="button">Submit</button>
        </form>
    </section>

    <footer>
        <ul>
            <li><a href="company.php">Company</a></li>
            <li><a href="gallery.php">Gallery</a></li>
        </ul>
        <p>© 2024 GADA Bus Transport Management System. All rights reserved.</p>
    </footer>

</body>
</html>
