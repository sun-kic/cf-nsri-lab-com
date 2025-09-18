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
  <h1>Carbon Monitor</h1>
</header>
  <main>
  @else
  <body>
  <main class="no-login">
@endauth
    {{$slot}}
  </main>
      @auth
  <nav class="navbar">
    <div>
    <ul class="menu">
        <li class="home"><a href="/" class="icon_home">HOME</a></li>
        <li class="profile"><a href="/profile" class="icon_profile">Profile</a></li>
        <li class="activity"><a href="/today" class="icon01">TODAY' Activity</a></li>
        <li class="kaizen"><a href="/kaizen" class="icon_kaizen">Kaizen Action</a></li>
        <li class="data"><a href="/data" class="icon_data">DATA</a></li>
        <li class="about"><a href="/about" class="icon_about">ABOUT</a></li>
    </ul>
    <ul class="logout">
        <li>
        <form class="inline" method="POST" action="/logout">
          @csrf
          <button type="submit">Logout</button>
        </form>
      </li>
    </ul>
  </div>
</nav>
      @else

      @endauth

<footer id="footer"><p class="copyright">Copyrights &copy; 2022 NSRI All rights reserved.</p></footer>

</body>

</html>