<?php

use Aternos\Mclogs\Frontend\Assets\AssetLoader;
use Aternos\Mclogs\Frontend\Assets\AssetType;
use Aternos\Mclogs\Log;
use Aternos\Mclogs\Config\Config;
use Aternos\Mclogs\Config\ConfigKey;
use Aternos\Mclogs\Frontend\Settings\Setting;
use Aternos\Mclogs\Frontend\Settings\Settings;
use Aternos\Mclogs\Util\TimeInterval;

/** @var Log $log */

$settings = new Settings();
?><!DOCTYPE html>
<html lang="cs">
<head>
    <?php include __DIR__ . '/parts/head.php'; ?>
    <title><?=htmlspecialchars($log->getPageTitle()); ?></title>
    <meta name="description" content="<?=htmlspecialchars($log->getPageDescription()); ?>" />
    <meta name="theme-color" content="#2ecc71" />
</head>
<body class="log-body<?=$settings->getBodyClassesString(); ?>">
<?php include __DIR__ . '/parts/header.php'; ?>
<main>
    <div class="log-header">
        <div class="log-header-inner">
            <div class="left">
                <div class="log-title">
                    <h1>
                        <i class="fas fa-file-lines"></i>
                        <?=htmlspecialchars($log->getCodexLog()->getTitle()); ?>
                    </h1>
                    <button class="log-url-btn" data-clipboard="<?=htmlspecialchars($log->getURL()->toString()); ?>" title="Zkopírovat adresu logu">
                        <span class="log-url"><?=htmlspecialchars($log->getDisplayURL()); ?></span>
                        <i class="fa-solid fa-copy"></i>
                    </button>
                </div>
            </div>
            <div class="right">
                <div class="details">
                    <div class="log-info-actions">
                        <?php if($log->hasErrors()): ?>
                            <div class="btn btn-danger btn-small" id="error-toggle">
                                <i class="fa fa-exclamation-circle"></i>
                                <?=htmlspecialchars($log->getErrorsString()); ?>
                            </div>
                        <?php endif; ?>
                        <div class="btn btn-dark btn-small" id="down-button">
                            <i class="fa fa-arrow-circle-down"></i>
                            <?=htmlspecialchars($log->getLinesString()); ?>
                        </div>
                        <a class="btn btn-dark btn-small" id="raw" target="_blank" title="Bez formátování" href="<?=$log->getRawURL()->toString(); ?>">
                            <i class="fa fa-arrow-up-right-from-square"></i>
                            Bez formátování
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php $information = $log->getAnalysis()->getInformation(); ?>
        <?php if(count($log->getVisibleMetadata()) > 0 || count($information) > 0): ?>
            <div class="log-info-rows">
                <?php if(count($log->getVisibleMetadata()) > 0): ?>
                    <div class="log-info-row">
                        <div class="info-row-items">
                            <div class="info-row-header">
                                <i class="fa-solid fa-tags"></i>
                                <span>Metadata</span>
                            </div>
                            <?php foreach($log->getVisibleMetadata() as $metadata): ?>
                                <span class="info-item">
                                               <span class="info-label"><?=htmlspecialchars($metadata->getDisplayLabel()); ?>:</span>
                                               <span class="info-value"><?=htmlspecialchars($metadata->getDisplayValue()); ?></span>
                                           </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(count($information) > 0): ?>
                    <div class="log-info-row">
                        <div class="info-row-items">
                            <div class="info-row-header">
                                <i class="fa-solid fa-cube"></i>
                                <span>Detekováno</span>
                            </div>
                            <?php foreach($information as $info): ?>
                                <span class="info-item">
                                               <span class="info-label"><?=htmlspecialchars($info->getLabel()); ?>:</span>
                                               <span class="info-value"><?=htmlspecialchars($info->getValue()); ?></span>
                                           </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php $problems = $log->getAnalysis()?->getProblems(); ?>
        <?php if(count($problems) > 0): ?>
            <div class="problems-panel-container">
                <div class="problems-panel">
                    <div class="problems-header">
                        <span class="problems-count"><?=count($problems); ?></span>
                        <span class="problems-title">
                                        <?=count($problems) === 1 ? 'nalezený problém' : 'nalezených problémů'; ?>
                                    </span>
                    </div>
                    <div class="problems-list">
                        <?php foreach($problems as $problem): ?>
                            <?php $number = $problem->getEntry()[0]->getNumber(); ?>
                            <div class="problem-item">
                                <a href="/<?=htmlspecialchars($log->getId()->get()) . "#L" . $number; ?>" class="problem-entry" onclick="updateLineNumber('#L<?=$number; ?>');">
                                        <span class="problem-label">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                            Problém
                                        </span>
                                    <span class="problem-text"><?=htmlspecialchars($problem->getMessage()); ?></span>
                                    <span class="problem-line">Řádek <?=$number; ?></span>
                                </a>
                                <?php if(count($problem->getSolutions()) > 0): ?>
                                    <div class="problem-solutions">
                                        <span class="problem-solutions-label">Řešení:</span>
                                        <?php foreach($problem->getSolutions() as $solution): ?>
                                            <div class="problem-solution">
                                                <i class="fa-solid fa-lightbulb"></i>
                                                <span><?=preg_replace("/'([^']+)'/", "'<strong>$1</strong>'", htmlspecialchars($solution->getMessage())); ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>
<div class="log-container">
    <div class="log">
        <?php
        echo $log->getPrinter()->print();
        ?>
    </div>
</div>
<div class="log-footer">
    <div class="log-bottom">
        <div class="btn btn-small btn-dark" id="up-button" title="Nahoru">
            <i class="fa fa-arrow-circle-up"></i>
        </div>
        <div class="actions">
            <?php if ($log->hasValidTokenCookie()): ?>
                <div class="delete-wrapper popover-wrapper">
                    <button class="delete-trigger popover-trigger btn btn-small btn-danger" title="Smazat log" popovertarget="delete-overlay">
                        <i class="fa-solid fa-trash"></i>
                        Smazat
                    </button>
                    <div class="delete-overlay popover-content popover-danger" id="delete-overlay" popover>
                        <span class="delete-message">Opravdu trvale smazat tento log?</span>
                        <div class="popover-error">

                        </div>
                        <div class="delete-actions">
                            <button class="btn btn-small btn-white" popovertarget="delete-overlay">Zrušit</button>
                            <button class="btn btn-small btn-danger delete-log-button">Smazat</button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="settings-dropdown popover-wrapper">
                <button class="settings-trigger popover-trigger btn btn-small btn-dark" title="Nastavení" popovertarget="settings-overlay">
                    <i class="fas fa-cog"></i>
                    Nastavení
                </button>
                <div class="settings-overlay popover-content" id="settings-overlay" popover>
                    <?php foreach(Setting::cases() as $setting): ?>
                        <label class="setting" for="setting-<?=$setting->value; ?>">
                            <span class="setting-label"><?=$setting->getLabel(); ?></span>
                            <input type="checkbox"
                                   id="setting-<?=$setting->value; ?>"
                                   class="setting-checkbox"
                                   data-body-class="<?=$setting->getBodyClass() ?? ""; ?>"
                                   data-key="<?=$setting->value; ?>"
                                <?=($settings->get($setting)) ? " checked" : ""; ?>/>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="log-details">
        <?php
        $source = $log->getSource();
        $created = $log->getCreated()?->toDateTime()->getTimestamp();
        ?>
        <?php if ($source || $created): ?>
            <div class="meta-data">
                <?php if ($source): ?>
                    <div class="source" title="Zdroj">
                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                        <?=htmlspecialchars($source); ?>
                    </div>
                <?php endif; ?>
                <?php if ($created): ?>
                    <div class="created-time" title="Vytvořeno">
                        <i class="fa-solid fa-clock"></i>
                        <span class="created" data-time="<?=htmlspecialchars($created); ?>">
                                </span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="delete-notice">
            Tento log bude uložen po dobu <?= htmlspecialchars(TimeInterval::getInstance()->format(Config::getInstance()->get(ConfigKey::STORAGE_TTL))); ?> od posledního zobrazení.
        </div>
        <?php if ($abuseEmail = Config::getInstance()->get(ConfigKey::LEGAL_ABUSE)): ?>
            <a href="mailto:<?=htmlspecialchars($abuseEmail); ?>?subject=Report%20<?=htmlspecialchars(rawurlencode(Config::getInstance()->getName())); ?>/<?=htmlspecialchars($log->getId()->get()); ?>" class="report-link">
                <i class="fa-solid fa-flag"></i>
                Nahlásit
            </a>
        <?php endif; ?>
    </div>
</div>
<?php include __DIR__ . '/parts/footer.php'; ?>
<div class="floating-scrollbar-container">
    <div class="floating-scrollbar">
        <div class="floating-scrollbar-content">
        </div>
    </div>
</div>
<?= AssetLoader::getInstance()->getHTML(AssetType::JS, "js/log.js"); ?>
</body>
</html>
