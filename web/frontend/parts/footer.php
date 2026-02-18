<?php
use Aternos\Mclogs\Config\Config;
use Aternos\Mclogs\Config\ConfigKey;
use Aternos\Mclogs\Util\URL;

$imprintUrl = Config::getInstance()->get(ConfigKey::LEGAL_IMPRINT);
$privacyUrl = Config::getInstance()->get(ConfigKey::LEGAL_PRIVACY);
?>
<footer>
    <?php if($imprintUrl || $privacyUrl): ?>
        <nav class="legal">
            <?php if ($imprintUrl): ?>
                <a href="<?=htmlspecialchars($imprintUrl); ?>" class="footer-link" title="Kontakt" target="_blank">Kontakt</a>
            <?php endif; ?>
            <?php if ($imprintUrl && $privacyUrl): ?>
                <span class="footer-separator"> - </span>
            <?php endif; ?>
            <?php if ($privacyUrl): ?>
                <a href="<?=htmlspecialchars($privacyUrl); ?>" class="footer-link" title="Zásady ochrany soukromí" target="_blank">Ochrana soukromí</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
    <nav class="footer-nav">
        <a href="https://mcnavody.eu/" title="MC Návody Wiki" target="_blank">
            <i class="fa-solid fa-book"></i> Wiki
        </a>
        <a href="https://discord.mcnavody.eu/" title="Náš Discord server" target="_blank">
            <i class="fa-brands fa-discord"></i> Discord
        </a>
        <a href="https://mcnavody.eu/gdpr/" title="Ochrana osobních údajů (GDPR)" target="_blank">
            <i class="fa-solid fa-shield-halved"></i> GDPR
        </a>
        <a href="<?=htmlspecialchars(URL::getApi()->toString()); ?>" title="API">
            <i class="fa-solid fa-code"></i> API
        </a>
    </nav>
    <span class="footer-text">
        MC Návody <?= date("Y"); ?>
    </span>
</footer>