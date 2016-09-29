<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <button data-target=".navbar-inverse-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="index.php" class="navbar-brand">Find Your Favourite Beverage</a>
    </div>
    <div class="navbar-collapse collapse navbar-inverse-collapse">
        <?php
            $cookie = json_decode($_COOKIE["favourite_beverage"]);
            print_r($cookie);
            if(empty($cookie->user)) {
        ?>
        <ul class="nav navbar-nav navbar-right" id="login-register">
            <a href="register.php" class="navbar-brand login">Login / Register</a>
        </ul>
        <?php } else { ?>
        <ul class="nav navbar-nav navbar-right" id="logout">
            <a href="logout.php" class="navbar-brand login">Logout</a>
        </ul>
        <ul class="nav navbar-nav navbar-right" id="history">
            <a href="history.php" class="navbar-brand login">View History</a>
        </ul>
        <?php } ?>
        <ul class="nav navbar-nav navbar-right">
            <a href="#" id="user" class="navbar-brand"></a>
        </ul>
    </div>
</div>