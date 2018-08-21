<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>BT Printer</title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic" rel="stylesheet">

    <style>
        html {text-align: center;background-color: #444444;margin: 0;padding: 0}
        body {
            font-family: 'Roboto', sans-serif;
            max-width:1024px;margin:0 auto;
            text-align: left;
            background-color: white;
            padding:8px;
            font-size:17px;
        }
        h1,h2{text-align: center}
        blockquote {background:#eee;padding:8px;margin:4px 0;font-size:12px;}
        img {max-width:100%}
        .btn, button {background-color: darkgreen;color:white;padding: 16px;border:1px solid green}
	.btn{display:inline-block;text-decoration:none}

@media print {
    html,body{margin:0;padding:10px;	
        font-size:32px;
    }
    body{
        width : 640px; 
    }
    blockquote {background:#fff;border-left:4px solid #222; font-size:22px;}
    a {color:#000}	
  	
}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    // js demo
    // -----------------------

    function chr(x){
        return String.fromCharCode(x);
    }
    // symbolic
    var ESC = chr(27);
    var LF = chr(10);

    // user friendly command name
    var PrnAlignLeft = ESC+'a'+chr(0);
    var PrnAlignCenter = ESC+'a'+chr(1);
    var PrnAlignRight = ESC+'a'+chr(2);
    var PrnBoldOn = ESC+'G'+chr(1);
    var PrnBoldOff = ESC+'G'+chr(0);

    // send to print
    function BtPrint(prn){
        var S = "#Intent;scheme=rawbt;";
        var P =  "package=ru.a402d.rawbtprinter;end;";
        var textEncoded = encodeURI(prn);
        window.location.href="intent:"+textEncoded+S+P;
    }

    // general. Not work? see you printer manual for correct command
    function QrCode(s){
        var q = ESC+'Z'+chr(3)+chr(3)+chr(6);
        var s_len = s.length;
        q += chr(s_len%256)+chr(s_len/256);
        return q+s;
    }

    // demo document
    function slip(){
        // собираем чек
        var prn = '';
        prn += PrnAlignCenter;
        prn += PrnBoldOn+'ООО "Рога и Копыта"'+PrnBoldOff+LF;
        prn += 'г. Сочи, переулок "Два Карла"'+LF;
        prn += 'Подвал'+LF+LF;
        prn += PrnBoldOn+'КАССОВЫЙ ЧЕК № 3'+PrnBoldOff+LF;
        prn += 'ПРИХОД' +LF;
        prn += PrnAlignRight;
        prn += 'Смена: 2'+LF;
        prn += PrnAlignLeft;
        prn += 'ИНН: 7701237658'+LF;
        prn += 'Кассир: Администратор'+LF;
        prn += 'Дата/время: 16.10.2017 20:11:09'+LF;
        prn += 'Клиент: tywrtyrtyrtwwrt@ttt.tu'+LF;
        prn += '--------------------------------'+LF;

        prn += PrnAlignLeft+ 'Samsung™ S5570 > Galaxy Mini '+LF;
        prn += PrnAlignRight+ '1 x 7 300'+LF;


        prn += '--------------------------------'+LF;
        prn += PrnAlignRight+PrnBoldOn+'ИТОГ: 7300.00'+PrnBoldOff+LF;
        prn += LF;
        prn += PrnAlignLeft;
        prn += 'Зав.№ККТ : 0149060506089651'+LF;
        prn += 'ФН №     : 0149060506089651'+LF;
        prn += 'ФД №     : 3'+LF;
        prn += 'ФПД      : 846945255'+LF;

        prn += LF;

        prn += PrnAlignCenter;
        prn += QrCode('t=20171016T201109&s=7300.00&fn=0149060506089651&i=3&fp=846945255&n=1')+LF;

        prn += LF;
        prn += LF;
        // передаем на печать
        BtPrint(prn);
    }

    // for php demo call
    function ajax_print(url,btn){
        b = $(btn);
	    b.attr('data-old',b.text());
	    b.text('wait');
        $.get(url,function(data){
            var S = "#Intent;scheme=rawbt;";
            var P =  "package=ru.a402d.rawbtprinter;end;";
            window.location.href="intent:"+data+S+P;
        }).fail(function() {
            alert( "ajax error" );
        }).always(function(){
            b.text(b.attr('data-old'));
        })
    }
</script>

</head>
<body>
<h1>Example web page</h1>
Эта веб страница демонстрирует возможности интеграции с сайтом.<br/>
To see source code open in browser http://rawbt.402d.ru/app2/<br/>
<!-- ----------------------------------------------------------------------------------------------- -->
<h2>HTML</h2>
<!-- ----------------------------------------------------------------------------------------------- -->
<blockquote>
    &lt;a href = "rawbt:Hello,%20world!%0A%0A"> Hello, world! &lt;/a>
</blockquote>
Здесь : <br />
<b>rawbt:</b> - схема, которую реализует приложение (application scheme ). <br />
дальше идут данные в url кодировке, которые будут посланы на принтер.
<p>Попробуйте <a href = "rawbt:Hello,%20world!%0A%0A">Hello, world!</a></p>

<blockquote>
    &lt;a href = "test.txt">File to print&lt;/a>
</blockquote>
<br />
Чтобы распечатать текстовый файл, достаточно разместить сссылку на него.<br>
<a href="test.txt">File to print</a><br />
<br />
<blockquote>
    &lt;a href = "rawbt:base64,G0A....">Print image&lt;/a>
</blockquote>
Когда требуется, чтобы данные были отправлены точь в точь (raw mode)<br>

<a href="rawbt:base64,G0AddjAAEACUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD//AAAAAAAAAAAAAAAAAAH//8AAAAAAAAAAAAAAAAAP///wAAAAAAAAAAAAAAAAH////AAAAAAAAAAAAAAAAH////4AAAAAAAAAAAAAAAD/////AAAAAAAAAAAAAAAB/////4AAAAAAAAAAAAAAAf/////AAAAAAAAAAAAAAAP/////wAAAAAAAAAAAAAAH/////+AAAAAAAAAAAAAAB//////gAAAAAAAAAAAAAA//////8AAAAAAAAAAAAAAP//////AAAAAAAAAAAAAAD//////wAAAAAAAAAAAAAB//////+AAAAAAAAAAAAAAf//////gAAAAAAAAAAAAAH//////4AAAAAAAAAAAAAB//////+AAAAAAAAAAAAAAf//////wAAAAAAAAAAAAAH//////8AAAAAAAAAAAAAB///4H//AAAAAAAAAAAAAA/j/8A//wAAAAAAAAAAAAAPwf+AH/8AAAAAAAAAAAAAD4D/AA//AAAAAAAAAAAAAA8AfwAP/wAAAAAAAAAAAAAPAH8EB/8AAAAAAAAAAAAADwB+Dwf/AAAAAAAAAAAAAA4cPh8H/4AAAAAAAAAAAAAOPD4fh/+AAAAAAAAAAAAABj4+P4f/gAAAAAAAAAAAAAc+Pj+H/4AAAAAAAAAAAAAHPuP/h/+AAAAAAAAAAAAABz8Af4f/gAAAAAAAAAAAAAceAB8H/4AAAAAAAAAAAAAHnAAHD/+AAAAAAAAAAAAAB9AAAf//gAAAAAAAAAAAAAfgAAA//4AAAAAAAAAAAAAHwAAAD/+AAAAAAAAAAAAAB4AAAAf/gAAAAAAAAAAAAAcAAAAH/4AAAAAAAAAAAAAGQAAAx/+AAAAAAAAAAAAABmAAA4f/gAAAAAAAAAAAAA8wAAYH/4AAAAAAAAAAAAAPGAAYD/+AAAAAAAAAAAAAD4YAcBv/wAAAAAAAAAAAAA/Dg8Az/8AAAAAAAAAAAAAP8H4Aw//gAAAAAAAAAAAAH5gABwH/4AAAAAAAAAAAAB+EAAwB//AAAAAAAAAAAAA/gwAwAf/wAAAAAAAAAAAAP4GA4AH/+AAAAAAAAAAAAD+AfwAA//wAAAAAAAAAAAB/AAAAAP/8AAAAAAAAAAAA/wAAAAB//gAAAAAAAAAAAP8AAAAAf/8AAAAAAAAAAAH+AAAAAH//gAAAAAAAAAAD/gAAAAA//4AAAAAAAAAAA/4AAAAAP//AAAAAAAAAAAf8AAAAAD//4AAAAAAAAAAP/AAAAAAf//AAAAAAAAAAH/wAAAAAH//4AAAAAAAAAB/4AAAAAA//+AAAAAAAAAA/+AAAAAAP//wAAAAAAAAAf/gAAAAAD//+AAAAAAAAAP/wAAAAAAff/wAAAAAAAAD/8AAAAAAH7/8AAAAAAAAB/+AAAAAAA/f/gAAAAAAAA//gAAAAAAP7/8AAAAAAAAP3wAAAAAAB/f/AAAAAAAAH78AAAAAAAf3/4AAAAAAAD+/AAAAAAAD+/+AAAAAAAA/fgAAAAAAA/3/wAAAAAAAf34AAAAAAAH9/8AAAAAAAH78AAAAAAAB/v/gAAAAAAD+/AAAAAAAAP7/4AAAAAAA/fgAAAAAAAD+f/AAAAAAAf34AAAAAAAAf3/wAAAAAAH58AAAAAAAAH8/+AAAAAAD+/AAAAAAAAA/P/gAAAAAA/vwAAAAAAAAP7/8AAAAAAfz4AAAAAAAAD+//AAAAAAH8+AAAAAAAAAfn/wAAAAAB/fAAAAAAAAAH5/8AAAAAA/3wAAAAAAAAB+f/gAAAAAP58AAAAAAAAAPn/4AAAAAD+fAAAAAAAAAD5/+AAAAAB/ngAAAAAAAAA+f/gAAAAAf54AAAAAAAAAPH/4AAAAAH+eAAAAAAAAABx//AAAAAB/jgAAAAAAAAAAf/wAAAAA/44AAAAAAAAAAH/8AAAAAP+OAAAAAAAAABgf/AAAAAD/zAAAAAAAAAD/D/wAAAAA/8QAAAAAAAAAw+P8AAAAAP/AAAAAAAAAAYD5/AAAAAD/4AAAAAAAAAEAPPgAAAAA//AAAAAAAAADAB54AAAAAP/wAAAAAAAABwAPeAAAAAD/+AAAAAAAAA8AD3gAAAAA4PwAAAAAAAAZAA94AAAAAcB+AAAAAAAAMYAf8AAAAAOAH4AAAAAAADGAP/gAAAAHAA/AAAAAAABgwH4eAAAABgAP8AAAAAAAYOH8BwAAAAwAB/gAAAAAAGB/8AMAAAAcAAP+AAAAAADAP+ABgAAA+AAD/wAAAAAAwB+AAYAAA+AAAf+AAAAAAMAAAAGAAA+AAAH/wAAAAADAAAAAwAAcAAAA/+AAAAAAwAAAAMAAOAAAAP/gAAAAAMAAAADAADAAAAB/8AAAAADAAAAAwABgAAAAf/gAAAAAgAAAAGAAYAAAAD/4AAAAAIAAAABgAGAAAAA//AAAAAGAAAAAcABgAAAAH/wAAAABgAAAADgAYAAAAA/8AAAAAYAAAAAYAGAAAAAP/AAAAAGAAAAADABgAAAAB/gAAAABgAAAAA4AYAAAAAPwAAAAAYAAAAAGADAAAAABwAAAAAMAAAAAAwAwAAAAAcAAAAADAAAAAAMAMAAAAADgAAAAAwAAAAADADAAAAAAYAAAAAMAAAAAAwBgAAAAADAAAAAOAAAAAAYAYAAAAAAYAAAAHgAAAAAOAGAAAAAAHAAAAH4AAAAAPADAAAAAAA8AAAH8AAAAAHgAwAAAAAAPwAAH/AAAAAHgAMAAAAAAB/gAf/wAAAAHgADAAAAAAAf////8AAAAHgAAwAAAAAAH/////AAAAHgAAGAAAAAAA/////wAAADgAABwAAAAAAP////4AAADwAAAPgAAAAAH////+AAABwAAAA/8AAAAB//A//wAAA4AAAAB//AAAAfwAABcAAAcAAAAAAH+AAAMAAAADAAAOAAAAAAAD4AAHAAAAAYAAHAAAAAAAAPgADgAAAAGAADgAAAAAAAA/ADwAAAAAwABwAAAAAAAAB//4AAAAAHAB4AAAAAAAAAD/wAAAAAA8D4AAAAAAAAAAAAAAAAAAH/4AAAAAAAAAAAAAAAAAAAPwAAAAAAAAAAAAAAAAAAAAAAAAAAAK">
    Print image</a>

<!-- ----------------------------------------------------------------------------------------------- -->
<h2>JS</h2>
<!-- ----------------------------------------------------------------------------------------------- -->
Рекомендую вызывать так
<blockquote>
    function BtPrint(prn){<br>
    &nbsp;&nbsp;&nbsp;var S = "#Intent;scheme=rawbt;";<br>
    &nbsp;&nbsp;&nbsp;var P =  "package=ru.a402d.rawbtprinter;end;";<br>
    &nbsp;&nbsp;&nbsp;var textEncoded = encodeURI(prn);<br>
    &nbsp;&nbsp;&nbsp;window.location.href="intent:"+textEncoded+S+P;<br>
    }<br>
</blockquote>
В этом случае, если приложение не установлено, будет переход в Play Market.

<p>Принтер управляется специальными последовательностями, начинающимися с ESC.</p>
<blockquote>
    var ESC = chr(27);
</blockquote>

вот некоторые из них

<blockquote>
    // user friendly command name <br/>
    var PrnAlignLeft = ESC+'a'+chr(0);<br/>
    var PrnAlignCenter = ESC+'a'+chr(1);<br/>
    var PrnAlignRight = ESC+'a'+chr(2);<br/>
    var PrnBoldOn = ESC+'G'+chr(1);<br/>
    var PrnBoldOff = ESC+'G'+chr(0);<br/>
</blockquote>
Вы можете печатать товарные чеки, заказы для кухни<br/>
<br/>
<b>Для работы по 54ФЗ
    нужно предварительно зарегистрировать продажу на фискальном регистраторе,
    а уже с полученными фискальными признаками можно распечатать копию.</b>
<br/>
<br/>
<blockquote>
    function slip(){<br/>
    // create document<br/>
    var prn = '';<br/>
    prn += PrnAlignCenter;<br/>
    prn += PrnBoldOn;<br/>
    prn += 'ООО "Рога и Копыта"';<br/>
    prn += PrnBoldOff+LF;<br/>

    ...

    prn += PrnAlignCenter;<br/>
    prn += QrCode('t=20171016T...')+LF;<br/>
    prn += LF;<br/>
    // send to print<br/>
    BtPrint(prn);<br/>
    }
</blockquote>

<br/><br/>
<button onclick="slip()">Russian check (cp866  or cp1251)</button>
<br/><br/>

<style>
pre {font-family:monospace}
</style>
<pre id="pre_print">
--------------------------------
            TEST
--------------------------------
Items 1
                      3 x $20.00
Items 2
                      1 x $40.00
********************************
                   TOTAL $100.00
--------------------------------
</pre>
<button onclick="BtPrint(document.getElementById('pre_print').innerText)">Print text from &lt;pre&gt;...&lt;/pre&gt;</button>
<br/><br/>



<!-- ----------------------------------------------------------------------------------------------- -->
<h2>PHP Mike42\Escpos</h2>
<!-- ----------------------------------------------------------------------------------------------- -->
<a href="https://github.com/mike42/escpos-php/tree/development/example">Исходные примеры</a> были модифицированы следующим образом.<br>
<b>Fixed in examples:</b><br><br>
1. Замените (replace)
<blockquote>
use Mike42\Escpos\PrintConnectors\FilePrintConnector;<br>
...<br>
$connector = new FilePrintConnector("php://stdout");<br>
</blockquote>
на
<blockquote>
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;<br>
...<br>
$connector = new DummyPrintConnector();<br>
</blockquote>
2. Добавить между (Add beetween)  cut() & close()
<blockquote>
 $printer->cut();<br>
    <br>
    // send to app<br>
    echo "base64,".base64_encode($connector -> getData());<br>
    <br>
    $printer->close();<br>
</blockquote>


<h3>Examples</h3>
<b>Attention! Внимание</b>
<ul>
<li>Some listings are long(Распечатки некоторых демо примеров длинные.).</li>
<li>Examples are designed for 80mm (Примеры расчитаны на 80мм)</li>
</ul>
<p>Demonstrates output using a large subset of availale features.</p>
<button onclick="ajax_print('demo/demo.php',this)">DEMO</button><br/><br/>
<button onclick="ajax_print('demo/receipt-with-logo.php',this)">RECEIPT WITH LOGO</button><br/><br/>
<button onclick="ajax_print('demo/text-size.php',this)">TEXT SIZE</button><br/><br/>


<p>Prints QR & Bar codes, if your printer supports it.</p>
<button onclick="ajax_print('demo/qr-code.php',this)">QR-CODE</button><br/><br/>
<button onclick="ajax_print('demo/barcode.php',this)">BARCODE</button><br/><br/>
<button onclick="ajax_print('demo/pdf417-code.php',this)">PDF417 CODE</button><br/><br/>

<p>Prints a images to the printer using the "bit image" or graphics commands. </p>
<button onclick="ajax_print('demo/bit-image.php',this)">BIT IMAGE</button><br/><br/>
<button onclick="ajax_print('demo/graphics.php',this)">GRAPHICS</button><br/><br/>

<p>Shows available character encodings. Change from the DefaultCapabilityProfile to get more useful output for your specific printer.</p>
<button onclick="ajax_print('demo/character-encodings.php',this)">CHARACTER ENCODINGS</button><br/><br/>
<p>Prints a compact character code table for each available character set. Used to debug incorrect output from character-encodings.php</p>
<button onclick="ajax_print('demo/character-tables.php',this)">CHARACTER TABLES</button><br/><br/>
<p>Yandex start page load and rendering on server by command xvfb-run wkhtmltoimage</p>
<button onclick="ajax_print('demo/print-from-html.php',this)">PRINT FROM HTML</button><br/><br/>
<p>Loads a PDF and prints each page. Rendering by server. Used Imagick extension for php.</p>
<button onclick="ajax_print('demo/print-from-pdf.php',this)">PRINT FROM PDF</button><br/><br/>

<h3>Php demo button onclick</h3>
<blockquote>
&nbsp;    function ajax_print(url){<br/>
    &nbsp;&nbsp;        $.get(url,function(data){<br/>
    &nbsp;&nbsp;&nbsp;        var S = "#Intent;scheme=rawbt;";<br/>
    &nbsp;&nbsp;&nbsp;        var P =  "package=ru.a402d.rawbtprinter;end;";<br/>
    &nbsp;&nbsp;&nbsp;        window.location.href="intent:"+data+S+P;<br/>
    &nbsp;&nbsp;    })<br/>
&nbsp;    }<br/>
</blockquote>
<br>
где data => результат echo "base64,".base64_encode($connector -> getData());<br>
<br>
<br>
<br>



</body>
</html>