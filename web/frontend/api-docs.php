<?php

use Aternos\Mclogs\Config\Config;
use Aternos\Mclogs\Config\ConfigKey;
use Aternos\Mclogs\Util\URL;

$config = Config::getInstance();
?>
<!DOCTYPE html>
<html lang="cs">
    <head>
        <?php include __DIR__ . '/parts/head.php'; ?>
        <title>API Dokumentace - <?= htmlspecialchars($config->getName()); ?></title>
        <meta name="description" content="API dokumentace pro <?= htmlspecialchars($config->getName()); ?> - Integrujte sdílení logů přímo do svého server panelu nebo hostingového softwaru." />
        <meta name="theme-color" content="#2ecc71" />
    </head>
    <body>
    <?php include __DIR__ . '/parts/header.php'; ?>
            <main>
                <div class="api-docs-header">
                    <div class="api-docs-header-content">
                        <h1>API Dokumentace</h1>
                        <p>Integrujte <strong><?= htmlspecialchars($config->getName()); ?></strong> přímo do svého server panelu, hostingového softwaru nebo čehokoliv jiného. Tato platforma byla vytvořena pro vysoce výkonnou automatizaci a lze ji snadno integrovat do jakéhokoli existujícího softwaru prostřednictvím našeho HTTP API.</p>
                    </div>
                </div>
                <div class="api-docs-toc">
                    <h3>Rychlé odkazy</h3>
                    <nav class="api-docs-toc-nav">
                        <a href="#create-log">Vytvořit log</a>
                        <a href="#get-log-info">Získat informace a obsah</a>
                        <a href="#delete-log">Smazat log</a>
                    </nav>
                </div>
                <div class="api-docs-section" id="create-log">
                    <h2>Vytvořit log</h2>

                    <div class="api-endpoint">
                        <span class="api-method">POST</span> <span class="api-url"><?= htmlspecialchars(URL::getApi()->withPath("/1/log")->toString()); ?></span> <span class="content-type">application/json</span>
                    </div>
                    <div class="api-note">
                        Odesílání obsahu s typem <span class="content-type">application/x-www-form-urlencoded</span> je stále podporováno z důvodu zpětné kompatibility, ale nepodporuje nastavení metadat.
                    </div>
                    <table class="api-table">
                        <tr>
                            <th>Pole</th>
                            <th>Povinné</th>
                            <th>Typ</th>
                            <th>Popis</th>
                        </tr>
                        <tr>
                            <td class="api-field">content</td>
                            <td class="api-required required"><i class="fa-solid fa-square-check"></i></td>
                            <td class="api-type">string</td>
                            <td class="api-description">
                                Hrubý obsah souboru logu jako řetězec.
                                Omezeno na <?= number_format($config->get(ConfigKey::STORAGE_LIMIT_BYTES) / 1024 / 1024, 2); ?> MiB a <?= number_format($config->get(ConfigKey::STORAGE_LIMIT_LINES)); ?> řádků.
                                Pokud to bude nutné, obsah bude zkrácen, ale doporučuje se zkracování provádět na straně klienta.
                            </td>
                        </tr>
                        <tr>
                            <td class="api-field">source</td>
                            <td class="api-required"><i class="fa-solid fa-square-xmark"></i></td>
                            <td class="api-type">string</td>
                            <td class="api-description">Název zdroje, např. doména nebo název softwaru.</td>
                        </tr>
                        <tr>
                            <td class="api-field">metadata</td>
                            <td class="api-required"><i class="fa-solid fa-square-xmark"></i></td>
                            <td class="api-type">array</td>
                            <td class="api-description">Pole položek metadat.</td>
                        </tr>
                    </table>

                    <h3>Příklad těla požadavku <span class="content-type">application/json</span></h3>
                    <pre class="api-code">{
    "content": "[obsah log souboru...]",
    "source": "example.org"
}</pre>

                    <h3>Metadata</h3>
                    <p>
                        Společně s obsahem logu můžete odeslat metadata, která se zobrazí na stránce logu a/nebo budou čitelná pro jiné aplikace prostřednictvím tohoto API.
                        To je zcela volitelné, ale může to pomoci poskytnout další kontext, např. interní ID serveru, verze softwaru atd.
                    </p>
                    <p>
                        Položka metadat je objekt s následujícími poli:
                    </p>
                    <table class="api-table">
                        <tr>
                            <th>Pole</th>
                            <th>Povinné</th>
                            <th>Typ</th>
                            <th>Popis</th>
                        </tr>
                        <tr>
                            <td class="api-field">key</td>
                            <td class="api-required required"><i class="fa-solid fa-square-check"></i></td>
                            <td class="api-type">string</td>
                            <td class="api-description">Klíč metadat. Lze použít k pozdější identifikaci položky ve vašem kódu.</td>
                        </tr>
                        <tr>
                            <td class="api-field">value</td>
                            <td class="api-required required"><i class="fa-solid fa-square-check"></i></td>
                            <td class="api-type">string|int|float|bool|null</td>
                            <td class="api-description">Hodnota metadat.</td>
                        </tr>
                        <tr>
                            <td class="api-field">label</td>
                            <td class="api-required"><i class="fa-solid fa-square-xmark"></i></td>
                            <td class="api-type">string</td>
                            <td class="api-description">Zobrazovaný popisek. Pokud není uveden, použije se jako popisek klíč.</td>
                        </tr>
                        <tr>
                            <td class="api-field">visible</td>
                            <td class="api-required"><i class="fa-solid fa-square-xmark"></i></td>
                            <td class="api-type">bool</td>
                            <td class="api-description">Zda mají být tato metadata viditelná na stránce logu, nebo dostupná pouze přes API. Výchozí je true.</td>
                        </tr>
                    </table>

                    <h3>Příklad těla s metadaty <span class="content-type">application/json</span></h3>
                    <pre class="api-code">{
    "content": "[obsah log souboru...]",
    "source": "example.org",
    "metadata": [
        {
            "key": "server_id",
            "value": 12345,
            "visible": false
        },
        {
            "key": "software_version",
            "value": "1.2.3",
            "label": "Verze Softwaru",
            "visible": true
        }
    ]
}</pre>

                    <h3>Odpovědi</h3>
                    <h4>Úspěch <span class="content-type">application/json</span></h4>
                    <div class="api-note">
                        Token poskytnutý v této odpovědi lze později použít ke smazání tohoto logu. Uložte jej bezpečně nebo jej zahoďte, znovu se již nezobrazí.
                    </div>
                    <pre class="api-code">{
    "success":true,
    "id":"WnMMikq",
    "source":null,
    "created":1769597979,
    "expires":1777373979,
    "size":157369,
    "lines":1201,
    "errors":8,
    "url": "<?= htmlspecialchars(URL::getBase()->withPath("/WnMMikq")->toString()); ?>",
    "raw": "<?= htmlspecialchars(URL::getApi()->withPath("/1/raw/WnMMikq")->toString()); ?>",
    "token":"78351fafe495398163fff847f9a26dda440435dcf7b5f92e8e36308f3683d771",
    "metadata": [
        {
            "key": "server_id",
            "value": 12345,
            "visible": false
        },
        {
            "key": "software_version",
            "value": "1.2.3",
            "label": "Verze Softwaru",
            "visible": true
        }
    ]
}</pre>
                    <h4>Chyba <span class="content-type">application/json</span></h4>
                    <pre class="api-code">
{
    "success": false,
    "error": "Required field 'content' not found."
}</pre>
                </div>

                <div class="api-docs-section" id="get-log-info">
                    <h2>Získat informace a obsah logu</h2>
                    <div class="api-endpoint">
                        <span class="api-method">GET</span> <span class="api-url"><?= htmlspecialchars(URL::getApi()->toString()); ?>/1/log/[id]</span>
                    </div>
                    <p>
                        Tento koncový bod (endpoint) ve výchozím nastavení vrací pouze informace o logu a metadata (stejná odpověď jako při vytvoření logu).
                        V rámci stejného požadavku můžete získat i obsah v různých formátech povolením příslušných GET parametrů.
                        Můžete kombinovat více parametrů a získat tak více formátů obsahu najednou, mějte ale na paměti, že to zvětší velikost odpovědi.
                    </p>
                    <table class="api-table">
                        <tr>
                            <th>GET Parametr</th>
                            <th>Pole v odpovědi</th>
                            <th>Popis</th>
                        </tr>
                        <tr>
                            <td class="api-field">raw</td>
                            <td class="api-type">content.raw</td>
                            <td class="api-description">Zahrne do odpovědi hrubý obsah logu jako řetězec.</td>
                        </tr>
                        <tr>
                            <td class="api-field">parsed</td>
                            <td class="api-type">content.parsed</td>
                            <td class="api-description">Zahrne do odpovědi zpracovaný obsah logu jako pole/objekty.</td>
                        </tr>
                        <tr>
                            <td class="api-field">insights</td>
                            <td class="api-type">content.insights</td>
                            <td class="api-description">Zahrne do odpovědi automaticky detekovanou analýzu (problémy/informace).</td>
                        </tr>
                    </table>
                    <h3>Odpovědi</h3>
                    <h4>Úspěch <span class="content-type">application/json</span></h4>
                    <div class="api-note">
                        Všechna pole obsahu jsou zahrnuta pouze v případě, že je zadán odpovídající parametr GET.
                        Pokud není zadán žádný parametr obsahu, celý objekt obsahu je z odpovědi vynechán.
                    </div>
                    <pre class="api-code">{
    "success":true,
    "id":"WnMMikq",
    "source":null,
    "created":1769597979,
    "expires":1777373979,
    "size":157369,
    "lines":1201,
    "errors":8,
    "url": "<?= htmlspecialchars(URL::getBase()->withPath("/WnMMikq")->toString()); ?>",
    "raw": "<?= htmlspecialchars(URL::getApi()->withPath("/1/raw/WnMMikq")->toString()); ?>",
    "metadata": [
        {
            "key": "server_id",
            "value": 12345,
            "visible": false
        },
        {
            "key": "software_version",
            "value": "1.2.3",
            "label": "Verze Softwaru",
            "visible": true
        }
    ],
    "content": {
        "raw": "[obsah log souboru...]",
        "parsed": [ /* zpracované položky logu */ ],
        "insights": { "problems": [ /* detekované problémy */ ], "information": [ /* detekované informace */ ] }
    }
}</pre>
                    <h4>Chyba <span class="content-type">application/json</span></h4>
                    <pre class="api-code">
{
    "success": false,
    "error": "Log not found."
}</pre>
                </div>
                <div class="api-docs-section" id="delete-log">
                    <h2>Smazat log</h2>
                    <div class="api-note">
                        Smazání logu vyžaduje token, který byl poskytnut při jeho vytvoření.
                    </div>

                    <div class="api-endpoint">
                        <span class="api-method">DELETE</span> <span class="api-url"><?= htmlspecialchars(URL::getApi()->toString()); ?>/1/log/[id]</span>
                    </div>

                    <h3>Hlavičky (Headers)</h3>
                    <table class="api-table">
                        <tr>
                            <th>Hlavička</th>
                            <th>Příklad</th>
                            <th>Popis</th>
                        </tr>
                        <tr>
                            <td class="api-field">Authorization</td>
                            <td class="api-type">Authorization: Bearer 78351fafe495398163f...</td>
                            <td class="api-description">Typ (vždy "Bearer") a token logu obdržený při jeho vytvoření.</td>
                        </tr>
                    </table>

                    <h3>Odpovědi</h3>
                    <h4>Úspěch <span class="content-type">application/json</span></h4>
                    <pre class="api-code">{
    "success": true
}</pre>
                    <h4>Chyba <span class="content-type">application/json</span></h4>
                    <pre class="api-code">
{
    "success": false,
    "error": "Invalid token."
}</pre>
                </div>
                <div class="api-docs-section" id="get-raw">
                    <h2>Získat hrubý obsah logu</h2>
                    <div class="api-note">
                        Tento koncový bod použijte pouze v případě, že opravdu potřebujete jen hrubý obsah logu. Pro většinu případů se doporučuje získat informace a obsah společně z endpointu pro log.
                    </div>
                    <div class="api-endpoint">
                        <span class="api-method">GET</span> <span class="api-url"><?= htmlspecialchars(URL::getApi()->toString()); ?>/1/raw/[id]</span>
                    </div>
                    <table class="api-table">
                        <tr>
                            <th>Pole</th>
                            <th>Typ</th>
                            <th>Popis</th>
                        </tr>
                        <tr>
                            <td class="api-field">[id]</td>
                            <td class="api-type">string</td>
                            <td class="api-description">ID log souboru, získané z endpointu pro vložení nebo z URL (<?= htmlspecialchars(URL::getBase()->toString()); ?>/[id]).</td>
                        </tr>
                    </table>

                    <h3>Úspěch <span class="content-type">text/plain</span></h3>
                    <pre class="api-code">
[18:25:33] [Server thread/INFO]: Starting minecraft server version 1.16.2
[18:25:33] [Server thread/INFO]: Loading properties
[18:25:34] [Server thread/INFO]: Default game type: SURVIVAL
...
</pre>
                    <h3>Chyba <span class="content-type">application/json</span></h3>
                    <pre class="api-code">
{
    "success": false,
    "error": "Log not found."
}</pre>
                </div>
                <div class="api-docs-section" id="get-insights">
                    <h2>Získat analýzu (Insights)</h2>
                    <div class="api-note">
                        Tento koncový bod je ponechán hlavně kvůli zpětné kompatibilitě. U nových aplikací se doporučuje získávat analýzu společně s informacemi o logu z hlavního endpointu.
                    </div>
                    <div class="api-endpoint">
                        <span class="api-method">GET</span> <span class="api-url"><?= htmlspecialchars(URL::getApi()->toString()); ?>/1/insights/[id]</span>
                    </div>
                    <table class="api-table">
                        <tr>
                            <th>Pole</th>
                            <th>Typ</th>
                            <th>Popis</th>
                        </tr>
                        <tr>
                            <td class="api-field">[id]</td>
                            <td class="api-type">string</td>
                            <td class="api-description">ID log souboru, získané z endpointu pro vložení nebo z URL (<?= htmlspecialchars(URL::getBase()->toString()); ?>/[id]).</td>
                        </tr>
                    </table>

                    <h3>Úspěch <span class="content-type">application/json</span></h3>
                    <pre class="api-code">
{
  "id": "name/type",
  "name": "Název softwaru, např. Vanilla",
  "type": "Název typu, např. Server Log",
  "version": "Verze, např. 1.12.2",
  "title": "Kombinovaný název, např. Vanilla 1.12.2 Server Log",
  "analysis": {
    "problems": [
      {
        "message": "Zpráva vysvětlující problém.",
        "counter": 1,
        "entry": {
          "level": 6,
          "time": null,
          "prefix": "Prefix tohoto záznamu, obvykle část obsahující čas a úroveň logu.",
          "lines": [
            {
              "number": 1,
              "content": "Celý obsah řádku."
            }
          ]
        },
        "solutions": [
          {
            "message": "Zpráva vysvětlující možné řešení."
          }
        ]
      }
    ],
    "information": [
      {
        "message": "Popisek: hodnota",
        "counter": 1,
        "label": "Popisek této informace, např. Verze Minecraftu",
        "value": "Hodnota této informace, např. 1.12.2",
        "entry": {
          "level": 6,
          "time": null,
          "prefix": "Prefix tohoto záznamu, obvykle část obsahující čas a úroveň logu.",
          "lines": [
            {
              "number": 6,
              "content": "Celý obsah řádku."
            }
          ]
        }
      }
    ]
  }
}</pre>
                    <h3>Chyba <span class="content-type">application/json</span></h3>
                    <pre class="api-code">
{
    "success": false,
    "error": "Log not found."
}</pre>
                </div>
                <div class="api-docs-section" id="analyse">
                    <h2>Analyzovat log bez uložení</h2>
                    <p>
                        Pokud chcete využít pouze funkce analýzy této služby bez uložení logu, můžete použít tento koncový bod.
                        Prosím, neukládejte logy, které chcete pouze analyzovat, protože to plýtvá úložným prostorem a zdroji.
                    </p>

                    <div class="api-endpoint">
                        <span class="api-method">POST</span> <span class="api-url"><?= htmlspecialchars(URL::getApi()->withPath("/1/analyse")->toString()); ?></span> <span class="content-type">application/x-www-form-urlencoded</span> <span class="content-type">application/json</span>
                    </div>
                    <table class="api-table">
                        <tr>
                            <th>Pole</th>
                            <th>Typ</th>
                            <th>Popis</th>
                        </tr>
                        <tr>
                            <td class="api-field">content</td>
                            <td class="api-type">string</td>
                            <td class="api-description">Hrubý obsah souboru logu jako řetězec. Maximální délka je 10MiB a 25 tisíc řádků, v případě potřeby bude zkrácen.</td>
                        </tr>
                    </table>

                    <h3>Úspěch <span class="content-type">application/json</span></h3>
                    <pre class="api-code">
{
  "id": "name/type",
  "name": "Název softwaru, např. Vanilla",
  "type": "Název typu, např. Server Log",
  "version": "Verze, např. 1.12.2",
  "title": "Kombinovaný název, např. Vanilla 1.12.2 Server Log",
  "analysis": {
    "problems": [
      {
        "message": "Zpráva vysvětlující problém.",
        "counter": 1,
        "entry": {
          "level": 6,
          "time": null,
          "prefix": "Prefix tohoto záznamu, obvykle část obsahující čas a úroveň logu.",
          "lines": [
            {
              "number": 1,
              "content": "Celý obsah řádku."
            }
          ]
        },
        "solutions": [
          {
            "message": "Zpráva vysvětlující možné řešení."
          }
        ]
      }
    ],
    "information": [
      {
        "message": "Popisek: hodnota",
        "counter": 1,
        "label": "Popisek této informace, např. Verze Minecraftu",
        "value": "Hodnota této informace, např. 1.12.2",
        "entry": {
          "level": 6,
          "time": null,
          "prefix": "Prefix tohoto záznamu, obvykle část obsahující čas a úroveň logu.",
          "lines": [
            {
              "number": 6,
              "content": "Celý obsah řádku."
            }
          ]
        }
      }
    ]
  }
}</pre>
                    <h3>Chyba <span class="content-type">application/json</span></h3>
                    <pre class="api-code">
{
    "success": false,
    "error": "Required field 'content' is empty."
}</pre>
                </div>
                <div class="api-docs-section" id="check-limits">
                    <h2>Zkontrolovat limity úložiště</h2>

                    <div class="api-endpoint">
                        <span class="api-method">GET</span> <span class="api-url"><?= htmlspecialchars(URL::getApi()->withPath("/1/limits")->toString()); ?></span>
                    </div>
                    <h3>Úspěch <span class="content-type">application/json</span></h3>
                    <pre class="api-code">
{
  "storageTime": 7776000,
  "maxLength": 10485760,
  "maxLines": 25000
}</pre>
                    <table class="api-table">
                        <tr>
                            <th>Pole</th>
                            <th>Typ</th>
                            <th>Popis</th>
                        </tr>
                        <tr>
                            <td class="api-field">storageTime</td>
                            <td class="api-type">integer</td>
                            <td class="api-description">Doba v sekundách, po kterou je log uložen od posledního zobrazení.</td>
                        </tr>
                        <tr>
                            <td class="api-field">maxLength</td>
                            <td class="api-type">integer</td>
                            <td class="api-description">Maximální délka souboru v bajtech. Logy přesahující tento limit budou zkráceny.</td>
                        </tr>
                        <tr>
                            <td class="api-field">maxLines</td>
                            <td class="api-type">integer</td>
                            <td class="api-description">Maximální počet řádků. Řádky navíc budou odstraněny.</td>
                        </tr>
                    </table>
                </div>
                <div class="api-docs-section" id="check-limits">
                    <h2>Získat filtry</h2>
                    <p>
                        Filtry upravují obsah logu před jeho uložením. Aplikují se automaticky při vytváření nového logu na straně serveru.
                        Z tohoto koncového bodu můžete získat seznam aktivních filtrů, pokud chcete aplikovat stejné filtry na straně klienta před odesláním logu.
                    </p>
                    <div class="api-endpoint">
                        <span class="api-method">GET</span> <span class="api-url"><?= htmlspecialchars(URL::getApi()->withPath("/1/filters")->toString()); ?></span>
                    </div>
                    <h3>Úspěch <span class="content-type">application/json</span></h3>
                    <pre class="api-code">
<?=htmlspecialchars(json_encode(\Aternos\Mclogs\Filter\Filter::getAll(), JSON_PRETTY_PRINT)); ?></pre>
                    <h3>Typy filtrů</h3>
                    <table class="api-table">
                        <tr>
                            <th>Typ</th>
                            <th>Popis</th>
                        </tr>
                        <tr>
                            <td class="api-field">trim</td>
                            <td class="api-description">
                                Odstraní bílé znaky ze začátku a konce obsahu logu.
                            </td>
                        </tr>
                        <tr>
                            <td class="api-field">limit-bytes</td>
                            <td class="api-description">
                                Omezí obsah logu na maximální počet bajtů (data.limit). Obsah přesahující tento limit bude zkrácen.
                            </td>
                        </tr>
                        <tr>
                            <td class="api-field">limit-lines</td>
                            <td class="api-description">
                                Omezí obsah logu na maximální počet řádků (data.limit). Řádky navíc budou odstraněny.
                            </td>
                        </tr>
                        <tr>
                            <td class="api-field">regex</td>
                            <td class="api-description">
                                Aplikuje nahrazení regulárních výrazů na obsah logu. Každý vzor v data.patterns bude aplikován v pořadí a nahrazen poskytnutou náhradou, pokud shodný řetězec neodpovídá jednomu z výjimek v data.exemptions.
                            </td>
                        </tr>
                    </table>
                    <div class="api-note">
                        Ujistěte se, že chyby filtrů (např. neznámé typy filtrů) zpracováváte elegantně, protože v budoucnu mohou být přidány nové typy filtrů.
                    </div>
                </div>
            </main>
        <?php include __DIR__ . '/parts/footer.php'; ?>
    </body>
</html>
