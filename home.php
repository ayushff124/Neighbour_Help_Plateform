<?php
// require 'inc/config.php';
// require 'inc/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Neighborhood Help Platform</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Poppins', sans-serif;
      color: #333;
      background-color: #f4f6f8;
      scroll-behavior: smooth;
    }
    a { text-decoration: none; }

    
    .navbar {
      background: linear-gradient(90deg, #2e7d32, #43a047);
      color: white;
      padding: 1rem 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .nav-content {
      width: 90%;
      max-width: 1200px;
      margin: auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo {
      font-size: 1.8rem;
      font-weight: 700;
      letter-spacing: 1px;
    }
    .nav-links a {
      margin-left: 20px;
      color: white;
      font-weight: 500;
      position: relative;
      transition: color 0.3s;
    }
    .nav-links a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      background: white;
      left: 0;
      bottom: -5px;
      transition: 0.3s;
    }
    .nav-links a:hover::after {
      width: 100%;
    }

    
    .menu-toggle {
      display: none;
      font-size: 1.5rem;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .nav-links {
        display: none;
        flex-direction: column;
        background: #2e7d32;
        padding: 1rem;
        border-radius: 10px;
        margin-top: 10px;
      }
      .nav-links.active {
        display: flex;
      }
      .menu-toggle {
        display: block;
      }
    }

    
    .banner {
      width: 100%;
      height: 300px;
      background: url('home.png') center/contain no-repeat;
      background-color: #d9f0d8;
    }

  
    .hero {
      text-align: center;
      padding: 3rem 1rem;
      background: white;
      position: relative;
      z-index: 1;
      border-radius: 20px;
      width: 90%;
      max-width: 1000px;
      margin: 20px auto 0 auto;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .hero h2 {
      font-size: 2.4rem;
      color: #2e7d32;
      margin-bottom: 1rem;
      animation: fadeInDown 1s ease;
    }
    .hero p {
      font-size: 1.1rem;
      margin-bottom: 1.5rem;
      color: #555;
      animation: fadeInUp 1s ease;
    }

    
    .btn-primary, .btn-secondary {
      padding: 0.75rem 1.5rem;
      border-radius: 30px;
      font-weight: 600;
      margin: 0 10px;
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .btn-primary {
      background: linear-gradient(45deg, #2e7d32, #43a047);
      color: white;
      box-shadow: 0 4px 10px rgba(46,125,50,0.3);
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(46,125,50,0.4);
    }
    .btn-secondary {
      background: white;
      color: #2e7d32;
      border: 2px solid #2e7d32;
    }
    .btn-secondary:hover {
      background: #c8e6c9;
      transform: translateY(-2px);
    }

    
    .features {
      padding: 4rem 0;
      text-align: center;
    }
    .features h3 {
      font-size: 2rem;
      margin-bottom: 2rem;
      color: #2e7d32;
    }
    .feature-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      width: 90%;
      max-width: 1200px;
      margin: auto;
    }
    .feature-card {
      background: white;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      transition: transform 0.3s, box-shadow 0.3s;
      opacity: 0;
      transform: translateY(20px);
    }
    .feature-card.show {
      opacity: 1;
      transform: translateY(0);
      transition: all 0.6s ease;
    }
    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }
    .feature-card h4 {
      font-size: 1.2rem;
      margin-bottom: 1rem;
      color: #2e7d32;
    }
    .feature-card p {
      color: #555;
      font-size: 1rem;
    }

    
    .footer {
      background: linear-gradient(90deg, #2e7d32, #43a047);
      color: white;
      text-align: center;
      padding: 1.5rem;
      margin-top: 4rem;
      font-size: 0.95rem;
    }

  
    @keyframes fadeInDown {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

  <header class="navbar">
    <div class="nav-content">
      <h1 class="logo">NeighborHelp</h1>
      <span class="menu-toggle">☰</span>
      <nav class="nav-links">
        <a href="#hero">Home</a>
        <a href="#features">How It Works</a>
        <a href="community.php">View Post</a>
        <a href="login.php">Login</a>
      </nav>
    </div>
  </header>

  
  <section class="banner"></section>

 
  <section class="hero" id="hero">
    <h2>Connecting Neighbors, Spreading Kindness</h2>
    <p>Join your community to offer or request help with just a click.</p>
    <button class="btn-primary" id="joinBtn">Join Now</button>
    <button class="btn-secondary" id="offerBtn">Offer Help</button>
  </section>

 
  <section class="features" id="features">
    <h3>How It Works</h3>
    <div class="feature-grid">
      <div class="feature-card">
        <h4>📝 Sign Up</h4>
        <p>Create your profile and connect with your neighborhood instantly.</p>
      </div>
      <div class="feature-card">
        <h4>🔍 Post or Find Help</h4>
        <p>Need something or want to help? Post your request or browse others.</p>
      </div>
      <div class="feature-card">
        <h4>🤝 Connect</h4>
        <p>Chat, coordinate, and make a positive difference together.</p>
      </div>
    </div>
  </section>

  
  <footer class="footer">
    <p>&copy; <?php echo date('Y'); ?> NeighborHelp. Building stronger communities together.</p>
  </footer>


  <script>
    
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    menuToggle.addEventListener('click', () => {
      navLinks.classList.toggle('active');
    });

   
    document.getElementById('joinBtn').addEventListener('click', () => {
      window.location.href = "register.php";
    });
    document.getElementById('offerBtn').addEventListener('click', () => {
      window.location.href = "offer_help.php";
    });

  
    const featureCards = document.querySelectorAll('.feature-card');
    const showOnScroll = () => {
      const triggerBottom = window.innerHeight * 0.85;
      featureCards.forEach(card => {
        const boxTop = card.getBoundingClientRect().top;
        if (boxTop < triggerBottom) {
          card.classList.add('show');
        }
      });
    };
    window.addEventListener('scroll', showOnScroll);
    showOnScroll();
  </script>
</body>
</html>
