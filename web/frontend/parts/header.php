<header>
<a href="<?=htmlspecialchars(\Aternos\Mclogs\Util\URL::getBase()->toString()); ?>" class="logo">
<img src="img/logo.png" alt="Logo" height="42" class="logo-icon">

<span class="logo-text"><?= htmlspecialchars(\Aternos\Mclogs\Config\Config::getInstance()->getName()); ?></span>
</a>
    <div class="tagline">
        <h1 class="tagline-main"><span class="title-verb">Vlož</span> své logy.</h1>
        <div class="tagline-sub">Vytvořeno pro Minecraft a Hytale</div>
    </div>
    <script>
        const titles = ["Vlož", "Sdílej", "Analyzuj"];
        let currentTitle = 0;
        let speed = 30;
        let pause = 3000;
        const titleElement = document.querySelector('.title-verb');

        setTimeout(nextTitle, pause);

        function nextTitle() {
            currentTitle++;
            if (typeof (titles[currentTitle]) === "undefined") {
                currentTitle = 0;
            }

            const title = titleElement.innerHTML;
            for (let i = 0; i < title.length - 1; i++) {
                setTimeout(function () {
                    titleElement.innerHTML = titleElement.innerHTML.substring(0, titleElement.innerHTML.length - 1);
                }, i * speed);
            }

            const newTitle = titles[currentTitle];
            for (let i = 1; i <= newTitle.length; i++) {
                setTimeout(function () {
                    titleElement.innerHTML = newTitle.substring(0, titleElement.innerHTML.length + 1);
                }, title.length * speed + i * speed);
            }

            setTimeout(nextTitle, title.length * speed + newTitle.length * speed + pause);
        }
    </script>
</header>
