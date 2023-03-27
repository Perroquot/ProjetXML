<?php 
session_start();
require_once 'fonction.php';

save_user_pref();
$theme = get_user_pref();


$my_cookie_aray=check_cookies();

$xml_sport = simplexml_load_file('http://www.lepoint.fr/sport/rss.xml');
$titles_sport = $xml_sport->xpath('//item/title');
$img_sport = $xml_sport->xpath('//item/enclosure/@url');
$link_sport = $xml_sport->xpath('//item/link');

$xml_societe = simplexml_load_file('http://www.lepoint.fr/content/system/rss/24H/24H_doc.xml');
$titles_societe = $xml_societe->xpath('//item/title');
$img_societe = $xml_societe->xpath('//item/enclosure/@url');
$link_societe = $xml_societe->xpath('//item/link');


$xml_monde = simplexml_load_file('https://www.lefigaro.fr/rss/figaro_voyages.xml');
$titles_monde = $xml_monde->xpath('//item/title');
$img_monde = $xml_monde->xpath('//item/media:content/@url');
$link_monde = $xml_monde->xpath('//item/link');


$xml_culture = simplexml_load_file('https://www.lepoint.fr/culture/rss.xml');
$titles_culture = $xml_culture->xpath('//item/title');
$img_culture = $xml_culture->xpath('//item/enclosure/@url');
$link_culture = $xml_culture->xpath('//item/link');



?>
<!DOCTYPE html>
<html lang="fr"class="<?= $theme ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>ProjetXML</title>
</head>
<body>
    
    <header>
        <svg class="image-1-1" width="99" height="68" viewBox="0 0 99 68" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g clip-path="url(#clip0_38_119)">
                <path d="M99 0H0V68H99V0Z" fill="url(#pattern0)" />
            </g>
            <defs>
                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                    <use xlink:href="#image0_38_119" transform="matrix(0.00476992 0 0 0.00694444 -0.00561167 0)"/>
                </pattern>

                <clipPath id="clip0_38_119">
                    <rect width="99" height="68" fill="white" />
                </clipPath>
                <image id="image0_38_119" width="212" height="144" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAANQAAACQCAYAAABwF0ViAAAaSklEQVR4nO2dXWwb15XH//TSdlQ6mUkiKQmkxvLEC6lGZbJBMeqDDctS1S4QCrHbbeQAAuKAsrPARqmbp27pojIi9zVa+mXbyogDuDCdOI1T66GwIIqKZETUQzS01oaEVUgZpppEpGCOS1YOyHD2YebKI5qUhp8zlO4PGFiy+HF5ef9zzr33nHNNoKTToFzZEABEy9QWvWEB2Nb5exRyf1AUTHo3QCfIQGlV/mUBHCJ/tNvtGQfJ0tJS1dTUVCMAcBy3GAgE5gF4IQ8qLypTaI/0BcMwPxBF8Qkge18AwO3bt2sCgUAdsKY/hLRrS7GVBGUDcES5rDzPz3V3d3/1/e9/H83NzQzLstVms7le64tFIhEhFot94/P5Vi5evMgODQ3ZeJ6fm5qa+huACzD2YLIBOM7z/L9NTU01FtoXwNr+GB4erhodHa1fXl5+XBTFUQBXlasSbzgUFQ0A+jiOC3EcF3I6nePBYHAylUpFpRIQDAYnnU7nOMMwIs/zswCOQ7YARoBFhr4oRT8QEonEXY/H43U4HJMAJMiiOqJvN1DyoQGylZDKMXAyIQjCuN1un2YYRgTQB/2EtdoXDodjUo++kCRJSqVSUY/H4yWChnyzoRicBgAXGIYR3W73aCKRuKvH4FETDoenVcIq5yBiIQtZcjqd40boC4IgCOM8z88qwqIWy4CsDh6Xy+UtlUtXCOFweFoZQF6sv4pYDFo5jgvZ7fZpIwkpHUEQxsvYJxSN2MjgicVis3oPkvVIpVJRl8vlLbG1GmAYRtTLtcuVtD6h1kpnTgGQPB6PV++BkQvhcJi4gBeK2Bcsz/OzPM/PGtkqZUPVJwNF7BOKRlgAFziOCxndKmUjlUpFlZVAAYUvWNgYhhGdTue43p+rEBKJxF2lT64WoU8oGmF5np+12+3TRpwr5UIqlYo6nc5xZRDlO4BsDMOIlWals1HkGw1lA1ie52cr/U6cTgGisjEMIwqCsKn6I01UlBKxKcVEyENUm1JMBJWoijnPpChsajER7Hb7NOT5w0Y0bGYxEVKpVFRZVj9V4vG15fA6HI6KWAYuBNVdeb2Vri1xcyHEYrFZZfWvtUxjbdMzwPP8bKUvQGglkUjc3WBP5upWuLmoISFLoIsUBXOEYRixEvdVCiEYDE4qokqPHujbSjcXNYo7TPeoCoCtpB3/YuNyubyQQ3IIrQzDiJW671YoKsu9XsIjZR2ubpV5QibSJuTsVliE2Ai32z2KtTcZikaOMAwjbkXXRo0qHGfLzZsykUqlonSBIg84jgtt9bsxgSQsbvWbC8Hj8aS7wobCiCnwfXa7/eVr165RXxmAJEni8vJysLq6mvYH5P548sknTaIovgwDCutf9G5AGizDMJc9Hs+973znO8/q3RgjYDKZHqN98RCTyfTYnj17Prty5coeaNsELyvb9G5AGkcOHjwYoHdjynr8/Oc/3wvgNRhwX8pQForjuCG3232PZdmcKu5Qthbbtm17IhQK+aanp2MwWACtkSxUKwA0NDS06N0QivHp7e1NwIAxfkYS1PHf//73/6d3IyiVwf79+5sBWGEwt88wgmIY5qjiG1MoG2IymRilqq2h6lAYRVBHGhsbv8y1Willa/P2228bbpPXMIJ6++23v9S7EZTKguf5ZzmO+7He7VBjCEFxHPfj9vZ2Q/nCFONjsVgal5eXH4eBavoZQVANgUCgju49UfLh4MGDARgoAt0IgrKtd2QKhbIe3d3dUVBBrcGmdAqFkjMtLS1VMNDChCEE1dTUZNa7EZTKpKamhuU4zjDbLboPZJ7nm+rq6lb0bgelMrFYLI2BQEDvZqxihPQNSZIkvdtAqWBYlr0viqIVwILebTGCy0ehFISy0meIpXO9BdXKcdyizm2gbA4MsY+pt6Cwb9++sN5toFQ2Rlo6111QFMpmQvdVvkpDkiTx5s2bM7Ozs8mZmRlzc3NzsqmpyWy1Wg/o3bZ8icfjc0NDQ18uLS2ZamtrJQCw2+3PWSyWRr3bVmlQQeXAwsKCz2azfU8UxW8BjAGIQq41fiwSiSzevHkzVkmDUJIk8cSJE7NXrlz5niiKf4P8eQD5MIIX33nnnbHe3t5DerZRC8o+piFcPr1ptdvt03qWpdJKLBabBSAh+9m4fRzHhfRuZy44HI5JZD8tkOV5frYSDnILh8PTMEgFJDqH0sixY8dWAPwK2c8r6quuro75/f6JMjYrb/x+/8To6Gg95BtEptCv6NTU1H/09PQYJgqhEqCC0kAkEhFu375dgw2K1U9NTf3Phx9+WKZWFcbJkydrAoHAaWQWE8G7vLz8eDKZDJWrXZUOFZQGLl26JAYCgSsaHioMDw/XlLxBBZJMJkNzc3PPQcPpgKIoTodCIbpXqBEqKA1cvHjxWWgrquidmpoy/KJEKBRaFEUxBXlOmO2KQp6X7O3v79erqRUHFZQGFJEYYtJbDHw+3wrHcfENHsYAOASg7uuvv95ZhmZtCqigNiCZTIYYhrmv9fEcxy3G4/G5UrapUGZmZsyDg4PzkiQh25VIJELhcFhwOp0TL774YkzvNlcKVFAbEI1GI6IoTmt4aAOAI4FAIBkKhZZL3a5C8Pv9u5qbm5n1HmM2m+urq6ttp06d2vX555/vKlfbKh26sZsfrZA3Em2QhbRm8/Pvf//7QmOj4adSlBJABaWNZyGviNkgVyt9BIZh7h88eDDg9/vpSRlbGCoobTwG+bQHAPI86fDhw6GOjo6V9vZ2lmXZaqVIp62zs1PYyJ2ilAQz5IgPXeuTUEFp4MCBA/988803ve3t7ezTTz+9x2Qy1QGo07tdlDVUA7gH4BPIWxxXoYO4qKA0wLLsN11dXYaprFMo8Xh8+8DAwL3m5uasWwFNTU3murq6XTMzM2IikXiynO3LE7Jw8rJyvQdZXBdQxoPZqKC2IPF43Hz27FnN6SY8zxt6GwAA7HZ7+OOPP5bGx8e/+PWvf/2ssndIxCVCFtYASlx3ggpqC2KxWJIA3sf6g8sGeU7C7tixY0dZGlYgZrO5/vDhw/U+nw/JZDL00Ucfzf/mN7/510AgUAfgl8o1BqAPJdqop4LaglgslgTkO7aWQdXKsuy7JW5S0TGbzfVdXV31XV1dWFhY8PX39+P8+fMtkLc4RgHcgSysDeMZc4Fu7BZIMpkMLSws+C5fvuzt7OwU6LK58WhoaGgZHBxsSSQSIZfLNaZEvuyGPM9aQPYct5yhFioHkslk6NatWwuffvrpt9evX2eGhoZsAOqVa/VhAL7Sp4WU9TCbzfW9vb31b775pvjBBx9433jjjRdFUSTCOo4iuIJUUBq4cePGHqWYYrp4AHnCK6guw537SlmLyWRiurq6Wl955RW1sIgr+AmyJ11uCHX5NHDv3j2LKIpPQBbPGIAzAI4C2AN54t4KWUgXoPPGIkU7RFj37t2TnE4nybR+GbIbmNeNkQpKG7cA/AAPxdMHeW9D99K/FJl4PL493+eaTCamv7//QCwWm1O2CBgA7yJ7vY2sUEFpIwrZnaMYlM8+++yFF154YbGQmh4Wi6XR5/M1ut1uMo8i1kpzRSUqKErFc+fOnX88ePDAHAgE6mw224FChdXV1dUai8XmlDLhDIBpaFwJ1FNQDQD+Xcf3p2wSdu/e/TiAGwBeB3CHCKuzs1PIN9nTYrE0zs/P73I4HD7lv96DhnmVHoJqgDx5DwL4z6WlpSod2kDZnFyAPL7OABCHhoZsu3btarx8+XJeS+Emk4kZHBxsUS1YvIsNNoLLKSi1kEgqhH/Hjh2pMraBsjXogzzePgGAY8eOtXZ2dgqSJIn5vFh/f/8BQRCIqF7DOu5fOQTFQv6AgtIY2O12IRwOC+FwWGJZ9psytIGy9YgCOALZDRSHhoZse/fujeXrAlqt1gMej2dM+ZVsBD9CqQV1HPIqye8AMERI165ds1VXV9Na1JRycAHyVsedQCBQV1dX91y+ojp8+PAhlfs3gAyrf6USlA1yCMd7ABiO4xaDwaCPComiEwLkMekXRfGJtrY2FOL+2e12AfLq3yPzqWILioWs3GkAhxiGue92u71ffPFFXUNDQ0uR34tCyYUoFEs1NTXVeOLEidl8X+ivf/3rHiXA1gp5OrNKMQXVCvlO8EsAcDgcvkgkcn8zZbpSKh4yr8L58+dbFhYWfBs8PiMmk4kZGxu7qfx6CqpoimIJagByYOFu4t4NDg62KIVLKBQjIUBeVkd7e3ve49Nqtapdv9X9qUIFZYPKKjmdzon5+fld1L2jGJwBAGIgEKjL10oBwLlz58gKdVEEdQTywoOVYZj7wWDQ19/ff8BkMmkuoXXnzp1/FPD+FEq+RKEsKAwODibyfZGGhoYWVXjSESB/QQ0A+BjKUngkErmfi1WSJEk8d+7c2A9/+MODi4uLtMwvRQ+uAkChxw+dOnVqXvkxL0GxSkN+CQAul2vs2rVrtlzmSpFIRNi7d2/srbfeOgQAoijS0COKHniB1ZNV8ubVV18lHlkrkFvGLqs0wgoAgiBMWK3WnA40vnz5svfYsWNk1e8OgIF9+/a9Blo0klKhqPZVdwPaLdSqmBiGuR+LxeasVqvmum6SJImdnZ2CSkzv4+GCBoVS0ajqFrZqsVBrxLS4uPilxWLRbCbj8fhcW1sbpqambJBTyEmqOIWiJzZgVQwFuX21tbUr5OeNBFWwmOrq6p5T1WMgm78Uit60AkBHR0cYBQpKzXouXzHF5IccTk/FRDEKxwGgp6cn71oUmVhPUAMonphaQasBUYxDK5SxXYwgBFWSbDSboE5ByV2an58P5CImSZLEtrY2UDFRDMwAAPzhD3/4vBgvplp6FzIJygY51Rcej2cs13SLEydOzCpvQOZMVEwUI9EHwMpx3OIrr7zyg0JfLBKJkGmMH8js8l0A5Gjxw4cP57TPtLCw4FMKsgNUTBTj0Qo52RUjIyOhXMLksnHp0iWSV+UFHhVUHxTf8k9/+lNTri+uit49A7oAQTEWNijhRi6Xa6xYAdwDAwN7lR8fERQLJWp2bGzsZq7q9fv9E8o5PHeg+KgUikEgGeQMz/Nzvb29OXle2YhEIoJqzF8F1gpqAEqway5REISTJ0+SIMM+UFePYhzWiGlycrJoxw29/vrr5MfVQAUiKBZKtOx7772X8wsnk8mQaqWjbOeZUigb0Io0MRVj3gTI1kk5zghQeWREUMfJm+ZTROXWrVukaP4noNaJYgxOQc4iL7qYgDXW6QxUY14tKPzxj38M5/Pis7OzSeVHuhBB0RuSYvQuIGeRF1tMo6OjY4p1EpG2XmCGHBJkBYD9+/c3F+tNKRQdaIUsJgYA3G63t9hFguLx+NzRo0fJ/tUppHlkZqURcDgcPpPJRGtBUCqOlZWVBIAmyC4eOI5b9Pl84erq6qKKKS0KaAxZ6vKRqNuV9D9SKEbH7/dPNDU17QPwDCAbhvn5+V2lKKj629/+dkYVBXQk02OIy4f29vacTmpT09LSQoIDjyCt8B+FUgoikYjw0ksvVU1NTR0A1lilknhZ586dGzt79izZv8oaBbQNSqJVVVVV3rUddu/eTaIqrFAESqGUgmQyGers7BRqampsU1NTjaQ6camsEiBbQVIDBfLhA1kX37ZBmcDlElGejslkYlRF1KmFohSdZDIZOn369MT27dvryf6P0+mcINWJi7mKp8bv90/YbDYS6HAG5Tofqq+vj1im16DMyyiUQolEIkJPT49v+/bt9WfPnj0AyMchxWKxuf7+/gOlrE48Ojo6phLT+9BgLLZBnmAhmUyGCnlzs9lc73K5yPk5F5Dj6dkUihq/3z9BXDuSwaA+DqkQj0oLp0+fnmhrayNu3vvI4YxdAQCi0Wik0Eb09vYeUope7IYc8kFFRdGMJEni5cuXvS+88MKizWY7oHbtYrHYXDmOQ5IkSezp6fERawjgV9AoJkAW1AIAzMzM5HVeTjo3btywqI76oKKibEgkEhFOnz49sW3bNubYsWOtgUCgjmGY+y6XayyRSIT6+/sPlNoiAfKm7Y9+9KOvVDl9ryPHzIlVC/XnP//5sWI0ymw21y8uLn6pEtUC6JyKkkYymQwRa1RTU2MjFoHn+TlBECbu3bsn9fb2HirXCS4LCwu+urq651T7TIeRR7m7bVCiw8+fP9+S76lu6VgslsZIJHJfcf8YyDvYdPVvi5NMJkOjo6NjLS0tc9u3b69XWyPi1vl8vkar1ZrToROFQOrs79mzp0VVB4WkfOQMcfn8AOD1eosW3Go2m+snJyefVS2n/w7UWm050kXU1tZ2iKT6OBwOnyAIE9Fo9IlyuXVqiIun2mP6b8hiWljnaZo4DkDiOC4klYBgMDjJMIwIQFIuL2Rhtdrt9ulSvGexCIfD08jtbuUNh8OG/kx2u30a2m9sOX9HsVhs1u12j/I8P6v6ziUAksPhmBQEYTyVSkVL9fm04Ha7R1XtWj3ZsJgsAJDcbvdoKT5AKpWKulwub1oHCzzPz5bi/YoFFdTGgkqlUtFgMDjpdDrHOY4LwaAikiT5+0xr41WUaOHsOACJYRgxkUjcLdUHSiQSd51O57i6wzmOCxmlw9OhgsosqHA4PO1yubyZrBDHcSGn0zkeDAYnjfKdZhh3JbFK6XgBSOVwwzIJC4BEvohSv79WqKDQ+tOf/tQfDAYnXS6XV3mulH7Z7fZpj8fjjcVihvI4UqlU1O12j6ZNOcoWeNAAWbklc/0yfWCPx+NNdxUYhhGNcJfbooJqxcNTUr5CBgHxPD/rcrkM/VkFQUh3QYUNPndJOE4aIAjCeDk7IBaLzTqdzvG0u8nqHdDtdo+W+wvc5IJisVY8Qnq/693/+ZBhnhRFDtEOpeACdBIVIRaLzbpcrkcsF9K+4FJbsM0iqHA4PC0Iwrjb7R598skn7yGL5YFifZxO57gRXbj1CIfD02kuaRTy/mfZonVM6/ztApQDA5TjP3Ou1Vcskslk6NatWwsffvghLl26tEcpLrgGjuMW9+3bF+7u7o62tLRU7dq1a2cx4r4ikYhQU1ND6rRrwRsOh5lSx5ylI0mSuLy8HIzFYt/4fL6VmZkZs9/v3zU+Ps4pG5YZ4Xl+rqOjI9ze3v5tc3Nz2dtdDPx+/8TJkydrVKXsSPGUAZS5Ctd6ggIMJCo1RGCffvrpt9evX2dU9dEegQjtJz/5iVhbWysRsbEsW60lrMUIgiJiAeSYy6WlJWlpacl0/fp1ZmlpqUrLwcs8z881NzdHOzo6Vvbv37/j+eeff7rcG6nFRJIk8ebNmzM/+9nP1DdY3YRE2EhQgEpUTqdz4p133mkuV1hILsTj8blwOBz1+Xwrw8PDVTMzM6zWE77tdvtqhEh3d/eaL2Lnzp04evRoNYDeDE/N5AquCkothEyMjIysea/h4eGqr7/+eicgnzmU6wnlPM/P1dbWrpDP0N7ezlZVVVVVsnDSSSaToY8++mj+jTfeeFFleeMAIpCjHHStC6lFUIA8aX0XkL80j8dTUIZvOUkmk6FoNBohd3YyaG/fvl2TyXU0KkT0Vqs11tzcnAQe1gF5+umn9xjxJldMIpGIMDAwEFOlVYDjuMW//OUvwaeeemrn888//08YIKxNq6CAMtQ80wvVGT+rLhX5/eLFi2w0Gt3Jsuw36udotSBq65cOcUPJ77W1tabm5uZVYVTifKaYSJIker1eoaenZ6/65me324Vz5859Q07QyMMtNwykKufqjrgRV7QolU0wGJx0OByTwNp9SZfL5c0UxZPHSqzhOAJlAxjKEjYVFqUQsu1B2u326Y22bjaDoADZWg0gLWyokvYtKPqSba+R47iQ2+0e1RpTulkERWiAaiMY1GJR1oHEBGYKNXO5XHltJG82QREeERbHcSGPx+M1SsQxpfykUqmoIAjjmdw5dbxmIe+xWQVFaMDDjTXDRpFTSsd6CYYcx4XytUTZ2OyCIrCQAxLXBFySuxKda20eYrHYrMfj8TocjvTM7LKkdmwVQakhVmsBaeI6c+bMp9RyVRbhcHh6PQGVO8FwKwpKTSvkudYalxBKqrTH48m410DRh0Qicff27ds31ksuZBhGJGnuenx3RhJULpESpeCt7373u/+1ffv2b9PDgDiOW3z11VeDv/jFL7B3796aSgl1qmSSyWQoFAot+ny+lYsXL7LZItWN9t1UcqREsVmtV5BIJO6u50YwDCOqk9zoymH+pFKpKHHbiOXJ1Ofqvne5XN5gMDhpRO+BWqiHtNrt9nevXbv2SMxaJBIRRkZGosPDw1VXrlz5XqY7JcMw9w8ePBjo7u6ONjU1mevq6kp2RlAlQmIUR0ZGour8KLPZnFxeXn4qy9PGIC8kkYvN9h0ZBSNZKLPeDchGdXW1raurC11dXRgcHEQ8Hp+bn58Pq3OgRFF8YmhoyDY0NLTmudlyoDZTVLakSg0haSAkkl7lqq0ngi8A/C/WiidTgUfdB2klYVhBpWOxWBqtVmuj1WpFb6+cmqTOgbp48SJLUjLIlS40AhEcsDb/SX0sqtYExGJB0kzI7+qod2JdAEAlFgbrC+aRG0t7ezvLsmz10aNHI0NDQ7+CQdykzUTFCCoTFoul0WKxoKGhAV1dXav/H4/H51ZWVlZGRkaiJLMVAEhmLxGc8n8bvs9jjz228uDBgyriYhba7iyT/Xrl0gxJKCQ5UsTtVd0M6pQrnYKPLqJkpqIFlQ0iNCIyYtEIRHCk/gIAqIUHrB30Dx48qAIA4mKWos3pYn3mmWe+6ejoWAHW5kmlZeDSlU+DsSkFtRFEcNXV1WhoeHjGdrrwgEcmvDZsXEFnwOPxRNWJgulkcSc3mvNQKoAtKagC0HI6SbRSqwdRCqdoh1ZTKBQqKAqlqFBBUShFhAqKQikiVFAUShHRfZVvfHyc6+zsLNrZvsVmaWmpCnKJX8289NJLVbW1tYb9TOPj41yuj99s31Gp0Ds4lkVl7L1EoW3JHNC2V2UEBGgrW7wZv6OS8f9kYzoFI8+q1QAAAABJRU5ErkJggg==" />
            </defs>
        </svg>
    </header>
    <main>
        <nav id="navbar">
            <a href="#">Accueil</a>
            <a href="./preference.php">Préférences</a>
        </nav>
        <section id="entrer">
            <div class="article-start">
                <div>
                    <h1><?php echo $titles_sport[2]?></h1>
                </div>
                <div>
                <a href="<?php echo $link_sport[2]?>" target="_blank"><img src="<?php echo $img_sport[2]?>"></a>
                </div>

            <!-- <div class="pub"><a href="https://lamanu.fr/" target="_blank"><img src="./assets/img/pub-lamanu.png" alt="" class="pub-manu"></a></div> -->
        </section>

    </main> 
    <!-- Container catégories -->
    <section>

        <div class="container-categories1">
            <h2>Catégories :</h2>
            <div class="card-categories">
                <div class="card card1">
                    <img src="./assets/img/Rectangle 164.png" alt="">
                    <div class="card-text">
                        <h4>Sport</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                <div class="card card2">
                    <img src="./assets/img/Rectangle 166.png" alt="">
                    <div class="card-text">
                        <h4>Société</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                <div class="card card3">
                    <img src="./assets/img/Rectangle 168.png" alt="">
                    <div class="card-text">
                        <h4>Monde</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                <div class="card card4">
                    <img src="./assets/img/Rectangle 170.png" alt="">
                    <div class="card-text">
                        <h4>Culture</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
            </div>
            </div>
    </section>
            
            
        <div class="container-article">
            <h2>Préférences : </h2>
            <?php if(empty($my_cookie_aray)){?>
            <h3>Veuillez définir des préférences</h3>
            <?php } ?>
        <?php if($my_cookie_aray) if(in_array('sport',$my_cookie_aray)){?>
            <h3>Sport : </h3>
            <div class="article-categories-row1">
                <div class="article article1">
                    <div class="article-img">
                        <img src="<?php echo $img_sport[0] ?>">
                    </div>
                    <div class="article-title">
                        <a href="<?php echo $link_sport[0]?>" target="_blank"><?php echo $titles_sport[0] ?></a>
                    </div>
                </div>
                <div class="article article2">
                    <div class="article-img">
                        <img src="<?php echo $img_sport[1] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_sport[1]?>" target="_blank"><?php echo $titles_sport[1] ?></a>
                    </div>
                </div>
                <div class="article article3">
                    <div class="article-img">
                        <img src="<?php echo $img_sport[3] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_sport[3]?>" target="_blank"><?php echo $titles_sport[3] ?></a>
                    </div>
                </div>
                <div class="article article4">
                    <div class="article-img">
                        <img src="<?php echo $img_sport[4] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_sport[4]?>" target="_blank"><?php echo $titles_sport[4] ?></a>
                    </div>
                </div>
            </div>
    <?php } ?>
    <?php if($my_cookie_aray) if(in_array('politique',$my_cookie_aray)){?>
            <h3>Société : </h3>
            <div class="article-categories-row1">
                <div class="article article1">
                    <div class="article-img">
                        <img src="<?php echo $img_societe[0] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_societe[0]?>" target="_blank"><?php echo $titles_societe[0] ?></a>
                    </div>
                </div>
                <div class="article article2">
                    <div class="article-img">
                        <img src="<?php echo $img_societe[1] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_societe[1]?>" target="_blank"><?php echo $titles_societe[1] ?></a>
                    </div>
                </div>
                <div class="article article3">
                    <div class="article-img">
                        <img src="<?php echo $img_societe[3] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_societe[3]?>" target="_blank"><?php echo $titles_societe[3] ?></a>
                    </div>
                    <a href="<?php echo $link_sport[0]?>" target="_blank"><a href="<?php echo $link_sport[0]?>" target="_blank"><a href="<?php echo $link_sport[0]?>" target="_blank"><a href="<?php echo $link_sport[0]?>" target="_blank"><a href="<?php echo $link_sport[0]?>" target="_blank"><a href="<?php echo $link_sport[0]?>" target="_blank"><a href="<?php echo $link_sport[0]?>" target="_blank"><a href="<?php echo $link_sport[0]?>" target="_blank"></div>
                <div class="article article4">
                    <div class="article-img">
                        <img src="<?php echo $img_societe[4] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_societe[4]?>" target="_blank"><?php echo $titles_societe[4] ?></a>
                    </div>
                </div>
            </div>
    <?php } ?>
    <?php if($my_cookie_aray) if(in_array('monde',$my_cookie_aray)){?>
            <h3> Monde :</h3>
            <div class="article-categories-row1">
                <div class="article article1">
                    <div class="article-img">
                    <img src="<?php echo $img_monde[0] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_monde[0]?>" target="_blank"><?php echo $titles_monde[0] ?></a>
                    </div>
                </div>
                <div class="article article2">
                    <div class="article-img">
                        <img src="<?php echo $img_monde[1] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_monde[1]?>" target="_blank"><?php echo $titles_monde[1] ?></a>
                    </div>
                </div>
                <div class="article article3">
                    <div class="article-img">
                        <img src="<?php echo $img_monde[3] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_monde[3]?>" target="_blank"><?php echo $titles_monde[3] ?></a>
                    </div>
                </div>
                <div class="article article4">
                    <div class="article-img">
                        <img src="<?php echo $img_monde[4] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_monde[4]?>" target="_blank"><?php echo $titles_monde[4] ?></a>
                    </div>
                </div>
            </div>
    <?php } ?>
    <?php if($my_cookie_aray) if(in_array('culture',$my_cookie_aray)){?>
            <h3>Culture :</h3>
            <div class="article-categories-row1">
                <div class="article article1">
                    <div class="article-img">
                        <img src="<?php echo $img_culture[0] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_culture[0]?>" target="_blank"><?php echo $titles_culture[0] ?></a>
                    </div>
                </div>
                <div class="article article2">
                    <div class="article-img">
                        <img src="<?php echo $img_culture[1] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_culture[1]?>" target="_blank"><?php echo $titles_culture[1] ?></a>
                    </div>
                </div>
                <div class="article article3">
                    <div class="article-img">
                        <img src="<?php echo $img_culture[3] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_culture[3]?>" target="_blank"><?php echo $titles_culture[3] ?></a>
                    </div>
                </div>
                <div class="article article4">
                    <div class="article-img">
                        <img src="<?php echo $img_culture[4] ?>">
                    </div>
                    <div class="article-title">
                    <a href="<?php echo $link_culture[4]?>" target="_blank"><?php echo $titles_culture[4] ?></a>
                    </div>
                </div>
            </div>
    <?php } ?>
        </div>
    <footer>
        <div class="reseaux">
            <div><p>Suivez nous <br> sur les reseaux sociaux</p></div>
            <div class="reseaux-sociaux"><img src="./assets/img/FB-white.png" alt=""><img src="./assets/img/Insta-white.png" alt=""><img src="./assets/img/LinkInd-white.png" alt=""><img src="./assets/img/Twitter-white.png" alt=""></div>
        </div>
        <div class="container-dark-part-footer">
            <div class="nav-dark-part-footer">
                <div class=img-footer>
                    <img src="./assets/img/logo.png" alt="">
                </div>
                <div class="lst-footer categories-footer">
                        <li><span>Catégorie</span></li>
                        <li>Sport</li>
                        <li>Politique France</li>
                        <li>Monde</li>
                        <li>Culture</li>
                </div>

                <div class="lst-footer navigation-footer">
                        <li><span>Navigation</span></li>
                        <li>Accueil</li>
                        <li>Préférences</li>
                </div>
            </div>
            <div class="copyright">
                <p>© 2023 - La Manews tous droits résérvés</p>
            </div>
        </div>
    </footer>
    <!-- <script type="text/javascript" src="/assets/js/script.js"></script> -->
</body>
</html>