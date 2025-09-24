<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Carbon Monitor</title>
  <link rel="icon" href="images/favicon.ico" />
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}
<link href="css/main.css" rel="stylesheet">
<script src="//unpkg.com/alpinejs" defer></script>
</head>

<x-flash-message />
@auth
{{ $body_id }}
<header id="header">
  <h1>Carbon <span class="life-text">LIFE</span> Monitor</h1>
  <div class="hamburger-menu">
    <button class="hamburger-btn" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <div class="hamburger-content" id="hamburgerContent">
      <ul class="hamburger-nav">
        <li><a href="/" class="icon_home">HOME</a></li>
        <li><a href="/profile" class="icon_profile">Profile</a></li>
        <li><a href="/today" class="icon01">TODAY' Activity</a></li>
        <li><a href="/kaizen" class="icon_kaizen">Kaizen Action</a></li>
        <li><a href="/data" class="icon_data">DATA</a></li>
        <li><a href="/about" class="icon_about">ABOUT</a></li>
        <li>
          <form class="inline" method="POST" action="/logout">
            @csrf
            <button type="submit">Logout</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</header>
  <main>
  @else
  <body>
  <main class="no-login">
@endauth
    {{$slot}}
  </main>
      @auth

      @else

      @endauth

<footer id="footer"><p class="copyright">Copyrights &copy; 2025 NSRI All rights reserved.</p></footer>

<script>
function toggleMenu() {
  const content = document.getElementById('hamburgerContent');
  const btn = document.querySelector('.hamburger-btn');
  
  if (content.style.display === 'block') {
    content.style.display = 'none';
    btn.classList.remove('active');
  } else {
    content.style.display = 'block';
    btn.classList.add('active');
  }
}

// メニュー外をクリックしたら閉じる
document.addEventListener('click', function(event) {
  const menu = document.querySelector('.hamburger-menu');
  const content = document.getElementById('hamburgerContent');
  
  if (!menu.contains(event.target)) {
    content.style.display = 'none';
    document.querySelector('.hamburger-btn').classList.remove('active');
  }
});
</script>

<style>
.hamburger-menu {
  position: absolute;
  top: 20px;
  right: 20px;
  z-index: 1000;
}

.hamburger-btn {
  background: none;
  border: none;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  width: 30px;
  height: 30px;
  padding: 0;
}

.hamburger-btn span {
  width: 100%;
  height: 3px;
  background-color: #d0e2be;
  transition: all 0.3s ease;
  transform-origin: center;
}

.hamburger-btn.active span:nth-child(1) {
  transform: rotate(45deg) translate(6px, 6px);
}

.hamburger-btn.active span:nth-child(2) {
  opacity: 0;
}

.hamburger-btn.active span:nth-child(3) {
  transform: rotate(-45deg) translate(6px, -6px);
}

.hamburger-content {
  display: none;
  position: absolute;
  top: 40px;
  right: 0;
  background: white;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  min-width: 200px;
  z-index: 999;
}

.hamburger-nav {
  list-style: none;
  padding: 0;
  margin: 0;
}

.hamburger-nav li {
  border-bottom: 1px solid #eee;
}

.hamburger-nav li:last-child {
  border-bottom: none;
}

.hamburger-nav a {
  display: block;
  padding: 15px 20px;
  color: #333;
  text-decoration: none;
  transition: background-color 0.2s ease;
}

.hamburger-nav a:hover {
  background-color: #f8f9fa;
}

.hamburger-nav form {
  margin: 0;
  padding: 15px 20px;
}

.hamburger-nav button {
  background: none;
  border: none;
  color: #333;
  cursor: pointer;
  font-size: 16px;
  width: 100%;
  text-align: left;
  padding: 0;
}

.hamburger-nav button:hover {
  color: #007bff;
}

.life-text {
  color: #d0e2be;
  font-weight: bold;
  font-size: inherit;
}

#header h1 {
  color: #d0e2be;
  font-weight: bold;
  text-align: left;
  margin-left: 20px;
  font-size: 1.5em;
}

@media (max-width: 768px) {
  .hamburger-menu {
    top: 15px;
    right: 15px;
  }
  
  .hamburger-content {
    min-width: 180px;
  }
}
</style>

</body>

</html>