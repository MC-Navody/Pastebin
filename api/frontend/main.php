<?php
$urls = Config::Get("urls");
$legal = Config::Get('legal');
?>
<!DOCTYPE html>
<html lang="cs">
    <head>
        <meta charset="utf-8" />
        <meta name="theme-color" content="#2ECC71"/

        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Play:400,700">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:300,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet" />

        <title>API Dokumentace | MC Návody</title>

        <base href="//log.mcnavody.eu/" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/btn.css" />
        <link rel="stylesheet" href="css/mclogs.css?v=071224" />

        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />

        <meta name="description" content="Easily paste your Minecraft logs to share and analyse them.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <script>
            let _paq = window._paq = window._paq || [];
            _paq.push(['disableCookies']);
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function() {
                _paq.push(['setTrackerUrl', '/data']);
                _paq.push(['setSiteId', '5']);
                let d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                g.async=true; g.src='/data.js'; s.parentNode.insertBefore(g,s);
            })();
        </script>
    </head>
    <body>
        <header class="row navigation">
            <div class="row-inner">
                <a href="/" class="logo">
                    <img src="img/logo.png" />
                </a>
                <div class="menu">
                    <a class="menu-social btn btn-black btn-notext btn-large btn-no-margin" href="https://github.com/aternosorg/mclogs" target="_blank">
                        <i class="fa fa-github"></i>
                    </a>
                </div>
            </div>
        </header>
        <div class="row docs dark">
            <div class="row-inner">
                <div class="docs-text">
                    <h1 class="docs-title">Dokumentace API</h1>
                     Integrujte <strong>log.mcnavody.eu</strong> přímo do svého serverového panelu, hostingového softwaru nebo
            čehokoli jiného. Tato platforma
            byla vytvořena pro vysoce výkonnou automatizaci a lze ji snadno integrovat do jakéhokoli stávajícího
            softwaru prostřednictvím naší
            HTTP API.
                </div>
                <div class="docs-icon">
                    <i class="fa fa-code"></i>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row-inner">
                <h2>Vložení logu</h2>

                <div class="endpoint">
                    <span class="method">POST</span> <span class="endpoint-url"><?=$urls['apiBaseUrl']?>/1/log</span> <span class="content-type">application/x-www-form-urlencoded</span>
                </div>
                <table class="endpoint-table">
                    <tr>
                        <th>Pole</th>
                        <th>Typ</th>
                        <th>Popis</th>
                    </tr>
                    <tr>
                        <td class="endpoint-field">content</td>
                        <td class="endpoint-type">string</td>
                        <td class="endpoint-description">Obsah logu jako řetězec. Maximální délka je 10 MiB a 25 tisíc řádků, bude zkráceno, pokud to bude nutné.</td>
                    </tr>
                </table>

                <h3>cURL <span class="command-description">Nahraj log z shellu.</span></h3>
                <pre class="answer">
curl -X POST --data-urlencode 'content@path/to/latest.log' '<?=$urls['apiBaseUrl']?>/1/log'</pre>
                <h3>Success <span class="content-type">application/json</span></h3>
                <pre class="answer">
{
    "success": true,
    "id": "8FlTowW",
    "url": "<?=$urls['baseUrl']?>/8FlTowW",
    "raw": "<?=$urls['apiBaseUrl']?>/1/raw/8FlTowW"
}</pre>
                <h3>Error <span class="content-type">application/json</span></h3>
                <pre class="answer">
{
    "success": false,
    "error": "Required POST argument 'content' is empty."
}</pre>
            </div>
        </div>
        <div class="row">
            <div class="row-inner">
                <h2>Získej obsah logu</h2>
                <div class="endpoint">
                    <span class="method">GET</span> <span class="endpoint-url"><?=$urls['apiBaseUrl']?>/1/raw/[id]</span>
                </div>
                <table class="endpoint-table">
                    <tr>
                        <th>Pole</th>
                        <th>Typ</th>
                        <th>Popis</th>
                    </tr>
                    <tr>
                        <td class="endpoint-field">[id]</td>
                        <td class="endpoint-type">string</td>
                        <td class="endpoint-description">ID logu, získané z koncového bodu pro vložení nebo z URL. (<?=$urls['baseUrl']?>/[id]).</td>
                    </tr>
                </table>

                <h3>Success <span class="content-type">text/plain</span></h3>
                <pre class="answer">
[18:25:33] [Server thread/INFO]: Starting minecraft server version 1.21.4
[18:25:33] [Server thread/INFO]: Loading properties
[18:25:34] [Server thread/INFO]: Default game type: SURVIVAL
...
</pre>
                <h3>Error <span class="content-type">application/json</span></h3>
                <pre class="answer">
{
    "success": false,
    "error": "Log not found."
}</pre>
            </div>
        </div>
        <div class="row">
            <div class="row-inner">
                <h2>Získej přehled</h2>

                <div class="endpoint">
                    <span class="method">GET</span> <span class="endpoint-url"><?=$urls['apiBaseUrl']?>/1/insights/[id]</span>
                </div>
                <table class="endpoint-table">
                    <tr>
                        <th>Pole</th>
                        <th>Typ</th>
                        <th>Popis</th>
                    </tr>
                    <tr>
                        <td class="endpoint-field">[id]</td>
                        <td class="endpoint-type">string</td>
                        <td class="endpoint-description">ID logu, získané z koncového bodu pro vložení nebo z URL. (<?=$urls['baseUrl']?>/[id]).</td>
                    </tr>
                </table>

                <h3>Success <span class="content-type">application/json</span></h3>
                <pre class="answer">
{
  "id": "name/type",
  "name": "Software name, e.g. Vanilla",
  "type": "Type name, e.g. Server Log",
  "version": "Version, e.g. 1.21.4",
  "title": "Combined title, e.g. Vanilla 1.21.4 Server Log",
  "analysis": {
    "problems": [
      {
        "message": "A message explaining the problem.",
        "counter": 1,
        "entry": {
          "level": 6,
          "time": null,
          "prefix": "The prefix of this entry, usually the part containing time and loglevel.",
          "lines": [
            {
              "number": 1,
              "content": "The full content of the line."
            }
          ]
        },
        "solutions": [
          {
            "message": "A message explaining a possible solution."
          }
        ]
      }
    ],
    "information": [
      {
        "message": "Label: value",
        "counter": 1,
        "label": "The label of this information, e.g. Minecraft version",
        "value": "The value of this information, e.g. 1.21.4",
        "entry": {
          "level": 6,
          "time": null,
          "prefix": "The prefix of this entry, usually the part containing time and loglevel.",
          "lines": [
            {
              "number": 6,
              "content": "The full content of the line."
            }
          ]
        }
      }
    ]
  }
}</pre>
                <h3>Error <span class="content-type">application/json</span></h3>
                <pre class="answer">
{
    "success": false,
    "error": "Log not found."
}</pre>
            </div>
        </div>
        <div class="row">
            <div class="row-inner">
                <h2>Zkontroluj limity úložiště</h2>

                <div class="endpoint">
                    <span class="method">GET</span> <span class="endpoint-url"><?=$urls['apiBaseUrl']?>/1/limits</span>
                </div>
                <h3>Success <span class="content-type">application/json</span></h3>
                <pre class="answer">
{
  "storageTime": 7776000,
  "maxLength": 10485760,
  "maxLines": 25000
}</pre>
                <table class="endpoint-table">
                    <tr>
                        <th>Pole</th>
                        <th>Typ</th>
                        <th>Popis</th>
                    </tr>
                    <tr>
                        <td class="endpoint-field">storageTime</td>
                        <td class="endpoint-type">integer</td>
                        <td class="endpoint-description">Doba v sekundách, po kterou je log uchováván od posledního zobrazení.</td>
                    </tr>
                    <tr>
                        <td class="endpoint-field">maxLength</td>
                        <td class="endpoint-type">integer</td>
                        <td class="endpoint-description">Maximální délka souboru v bajtech. Logy přesahující tento limit budou zkráceny na tuto délku.</td>
                    </tr>
                    <tr>
                        <td class="endpoint-field">maxLines</td>
                        <td class="endpoint-type">integer</td>
                        <td class="endpoint-description">Maximální počet řádků. Přebytečné řádky budou odstraněny.</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row dark api-notes docs">
            <div class="row-inner">
                <div class="docs-text">
                    <h2>Poznámka</h2>
                    API má aktuálně limit 60 požadavků za minutu na jednu IP adresu. Tento limit je nastaven pro zajištění funkčnosti služby. Pokud máš případ použití, který vyžaduje vyšší limit, neváhej nás kontaktovat.
                    <div class="notes-buttons">
                        <a class="btn btn-small btn-no-margin btn-blue" href="mailto:podpora@mcnavody.eu">
                            <i class="fa fa-envelope"></i> Kontaktuj nás
                        </a>
                    </div>
                </div>
                <div class="docs-icon">
                    <i class="fa fa-sticky-note"></i>
                </div>
            </div>
        </div>
        <div class="row footer">
            <div class="row-inner">
                MC Návody <?=date("Y"); ?>
            </div>
        </div>
    </body>
</html>
