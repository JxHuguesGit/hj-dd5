<!-- HEADER TOP -->
<header class="topbar">
    <div class="container topbar-inner">
        <div class="logo">&nbsp;</div>
        <div class="user-area">
        <!--
            <a href="#" class="login-link">
                <i class="fa-solid fa-user"></i> Connexion
            </a>
        -->
        </div>
    </div>
</header>

<!-- HEADER NAVIGATION -->
<header class="nav-header">
    <div class="container nav-inner">

        <!-- Burger icon for mobile -->
        <div class="burger" onclick="toggleMenu()">
            <i class="fa-solid fa-bars"></i>
        </div>

        <nav class="main-nav" id="mainMenu">
            %1$s
        </nav>
<!--
        <div class="nav-search">
            <input type="text" placeholder="Rechercher…">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
-->
    </div>
</header>

%2$s

<!-- FOOTER -->
<footer>
    <div class="container footer-inner">
        <p>© 2026 – DD5 2024</p>
        <p><a href="#">Mentions légales</a> — <a href="#">Contact</a></p>
    </div>
</footer>

<!-- JS Burger -->
<script>
function toggleMenu() {
    document.getElementById("mainMenu").classList.toggle("show");
}
</script>