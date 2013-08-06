<?php include '../includes/_header.php'; ?>

<div id="index">

    <div id="header-wrapper" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<div id="header" style="text-align:center; position:relative;">
			<?php include '../includes/_menu.php'; ?>
		</div>	
		<div style="height: 436px;">
		</div>
	</div><!--herder-wrapper-->

        <div id="content">

            <div class="two-col self-clear">
				<div class="col-menu">
					<span>
						<ul>
							<a onclick="scrollView('slasher')"><li>Slasher</li></a>
							<a onclick="scrollView('priest')"><li>Priest</li></a>
							<a onclick="scrollView('fighter')"><li>Fighter</li></a>
							<a onclick="scrollView('mage')"><li>Mage</li></a>
							<a onclick="scrollView('soon-1')"><li><span class="soon">Coming Soon<span></li></a>
							<a onclick="scrollView('soon-2')"><li><span class="soon">Coming Soon</span></li></a>
						</ul>
					</span>
				</div>
                <div class="col-0">
					<div id="slasher" class="class-section">
						<img src="guides/classes/slasher.png" class="class-img left" />
						<div class="class-box right">
							<div class="class-head">
								<b>Slasher</b>
							</div>
							<img src="guides/skills/skills-slasher.gif" class="skill-img"/>
						</div>
					</div>
					<div id="priest" class="class-section">
						<img src="guides/classes/priest.png" class="class-img right" />
						<div class="class-box left">
							<div class="class-head">
								<b>Priest</b>
							</div>
						</div>
					</div>	
					<div id="fighter" class="class-section">
						<img src="guides/classes/fighter.png" class="class-img left" />
						<div class="class-box right">
							<div class="class-head">
								<b>Fighter</b>
							</div>
							<img src="guides/skills/skills-fighter.gif" class="skill-img"/>
						</div>
					</div>
					<div id="mage" class="class-section">
						<img src="guides/classes/mage.gif" class="class-img right" />
						<div class="class-box left">
							<div class="class-head">
								<b>Mage</b>
							</div>
							<img src="guides/skills/skills-mage.png" class="skill-img"/>
						</div>
					</div>	
					<div id="soon-1" class="class-section">
						<img src="guides/classes/coming_soon_1.gif" class="class-img left" />
						<div class="class-box right">
							<div class="class-head">
								<b>Coming Soon</b>
							</div>
						</div>
					</div>
					<div id="soon-2" class="class-section">
						<img src="guides/classes/coming_soon_2.gif" class="class-img right" />
						<div class="class-box left">
							<div class="class-head">
								<b>Coming Soon</b>
							</div>
						</div>
					</div>	
                </div>
            </div>

        </div>

    </div>

<?php include '../includes/_footer.php'; ?>