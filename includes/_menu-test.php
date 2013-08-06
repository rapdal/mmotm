        <div id="header-wrapper">
            <div id="header" class="self-clear">
                <a href="http://www.mmo.tm" id="logo"><img src="/images/mmoTM.png" alt="mmo.TM" /></a>
                <div id="login">
                    <?php if($_COOKIE['userORM'] == null) { ?>
                    <a href="signup.php"><img src="/images/signup.png" alt="Signup" /></a><a href="#login-box" class="login-window"><img src="images/login.png" alt="Login" /></a>
                    <?php } else { ?>
                    <?php if($_COOKIE['gmORM'] == 1) { ?><span class="userInfoHeader">[GM] </span><?php } ?><span class="userInfoHeader"><?php echo $_COOKIE['userORM']; ?></span>
                    <a href="logout.php"><img src="/images/logout.png" alt="Logout" />Logout</a>
                    <?php } ?>
                </div>
                <ul>
                    <li>
                        <a href="/forum">Community</a>
                        <a href="/guides.php">Guides</a>
                        <a href="/forum/index.php#support.4">Help</a>
                        <a href="/item-mall.php">Item Shop</a>
                        <a href="/media.php">Media</a>
                        <a href="/swag.php">DS Swag</a>
                    </li>
                </ul>
                
                
                <div id="login-box" class="login-popup" style="background-image: url('../images/bg-ds.jpg'); background-position: center center; repeat: no-repeat; height: 183px; color: orange; text-size: 250%; font-weight: bold; border: 0px;">
                    <a href="#" class="close"><img src="close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
                    <form method="post" class="signin" action="#">
                        <fieldset class="textbox">
                        <label class="username" for="inputEmail">
                        <span>Username or email</span>
                        <input type="email" required="required" id="inputEmail" name="username" placeholder="Email" />
                        </label>
                        
                        <label class="password">
                        <span>Password</span>
                        <input type="password" required="required" id="inputPassword" name="pass" placeholder="Password" />
                        </label>
                        
                        <button class="submit button" type="submit">Sign in</button>
                        </fieldset>
                    </form>
                </div>
            </div>