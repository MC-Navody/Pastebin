<?php
use Aternos\Mclogs\Config\Config;
use Aternos\Mclogs\Filter\Filter;
use Aternos\Mclogs\Frontend\Assets\AssetLoader;
use Aternos\Mclogs\Frontend\Assets\AssetType;
?><!DOCTYPE html>
<html lang="cs">
    <head>
        <?php include __DIR__ . '/parts/head.php'; ?>
        <title>Pastebin | MC Návody</title>
        <meta name="description" content="Snadno vkládejte své logy z Minecraftu, sdílejte je a analyzujte.">
        <meta name="theme-color" content="#2ecc71" />
    </head>
    <body data-name="<?=htmlspecialchars(Config::getInstance()->getName()); ?>">
    <?php include __DIR__ . '/parts/header.php'; ?>
            <main>
                <div class="paste-area" id="dropzone">
                    <div class="paste-placeholder">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p>Vlož nebo přetáhni svůj log sem</p>
                        <div class="paste-hints">
                            <button type="button" class="btn btn-transparent" title="Paste log" id="paste-clipboard"><i class="fa-solid fa-paste"></i> Vložit</button>
                            <button type="button" class="btn btn-transparent" title="Browse on files" id="paste-select-file"><i class="fa-solid fa-folder-open"></i> Procházet</button>
                            <span><i class="fa-solid fa-file-arrow-up" title="Drop file"></i> Přetáhnout</span>
                        </div>
                    </div>
                    <textarea aria-label="Paste or drop your log here" spellcheck="false" data-enable-grammarly="false" id="paste-text"></textarea>
                    <button type="button" class="btn-save btn paste-save" title="Save log" disabled><i class="fa-solid fa-save"></i> Uložit</button>
                    <div class="paste-error" id="paste-error"></div>
                </div>
            </main>
        <?php include __DIR__ . '/parts/footer.php'; ?>
        <script>
            const FILTERS = <?= json_encode(Filter::getAll()); ?>;
        </script>
        <?= AssetLoader::getInstance()->getHTML(AssetType::JS, "js/start.js"); ?>
    </body>
</html>
