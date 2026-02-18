# MN Pastebin - Sdílení a analýza logů

![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)
![PHP](https://img.shields.io/badge/Language-PHP-777BB4?style=for-the-badge)

Toto je open-source nástroj pro vkládání, sdílení a analýzu serverových logů, postavený na projektu [mclogs](https://github.com/aternosorg/mclogs). Je navržen primárně pro Minecraft a Hytale. Nabízí automatické skrývání citlivých údajů (např. IP adres), zvýraznění syntaxe a analýzu chyb.

## Jak spustit projekt lokálně

Chcete-li si pastebin spustit u sebe na počítači pro vývoj nebo testování, postupujte následovně:

1. **Požadavky**: Ujistěte se, že máte nainstalovaný [Docker](https://www.docker.com/), [PHP 8.5+](https://www.php.net/) a [Composer](https://getcomposer.org/).
2. **Instalace závislostí**:
   Otevřete terminál ve složce projektu a spusťte:
   ```bash
   composer install

```

3. **Spuštění vývojového prostředí**:
   Přejděte do složky `dev` a spusťte Docker kontejnery:
```bash
cd dev
docker compose up

```


Aplikace se spustí na adrese `http://localhost`.

## Struktura projektu

Projekt má následující strukturu:

```
pastebin/
├── dev/                 # Konfigurace pro lokální vývojové prostředí
├── docker/              # Produkční konfigurace (Caddy, mclogs nastavení)
├── src/                 # Zdrojový kód aplikace
│   ├── Api/             # Logika API endpointů
│   ├── Filter/          # Filtry pro cenzuru citlivých dat
│   └── Storage/         # Práce s databází (MongoDB)
├── web/
│   └── public/          # Veřejně dostupné soubory (CSS, JS, obrázky)
├── composer.json        # Závislosti projektu
└── worker.php           # Worker skript (FrankenPHP)

```

## Jak přispět?

Chcete opravit chybu nebo vylepšit analýzu logů?

1. Logika aplikace se nachází ve složce `src/`.
2. Pro úpravu vzhledu nebo frontendových skriptů editujte soubory v `web/`.
3. Konfiguraci lze upravit vytvořením souboru `config.json` (viz `example.config.json`).

## Licence

Tento projekt je licencován pod licencí [MIT](https://www.google.com/search?q=LICENSE).

Znamená to, že software je poskytován "tak jak je", bez záruky. Můžete jej volně používat, upravovat a šířit, pokud zachováte oznámení o autorských právech.