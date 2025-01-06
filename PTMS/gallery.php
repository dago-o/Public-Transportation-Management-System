<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - GADA Bus Transport</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        #gallery {
            padding: 40px;
            background-color: #fff;
        }

        #gallery h2 {
            font-size: 2.5rem;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .gallery-item {
            flex: 1 1 calc(30% - 20px);
            box-sizing: border-box;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .gallery-item img {
            width: 100%;
            display: block;
            height: auto;
        }

        .gallery-item p {
            padding: 15px;
            font-size: 1rem;
            text-align: center;
            background-color: #f9f9f9;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }

        footer a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>
<body>

    <!-- Gallery Section -->
    <section id="gallery">
        <h2>Gallery</h2>
        <div class="gallery-container">
            <div class="gallery-item">
                <img src="bus1.jpg" alt="Luxury Bus">
                <p>Modern luxury buses for long-distance travel.</p>
            </div>
            <div class="gallery-item">
                <img src="bus2.jpg" alt="City Bus">
                <p>Efficient city transport for daily commuters.</p>
            </div>
            <div class="gallery-item">
                <img src="bus3.jpg" alt="Eco-Friendly Bus">
                <p>Eco-friendly buses with low carbon emissions.</p>
            </div>
            <div class="gallery-item">
                <img src="bus4.jpg" alt="Spacious Bus">
                <p>Spacious seating and premium interiors.</p>
            </div>
            <div class="gallery-item">
                <img src="bus5.jpg" alt="Family Bus">
                <p>Family-friendly buses with extra legroom.</p>
            </div>
            <div class="gallery-item">
                <img src="bus6.jpg" alt="Night Bus">
                <p>Comfortable night buses with sleeping arrangements.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>© 2024 GADA Bus Transport Management System. All rights reserved.</p>
    </footer>

</body>
</html>
