"""
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Whoops! There was an error.</title>

    <style>.cf:before, .cf:after {content: " ";display: table;} .cf:after {clear: both;} .cf {*zoom: 1;}
        body {
            font: 14px helvetica, arial, sans-serif;
            color: #2B2B2B;
            background-color: #D4D4D4;
            padding:0;
            margin: 0;
            max-height: 100%;
        }
        a {
            text-decoration: none;
        }

        .container{
            height: 100%;
            width: 100%;
            position: fixed;
            margin: 0;
            padding: 0;
            left: 0;
            top: 0;
        }

        .branding {
            position: absolute;
            top: 10px;
            right: 20px;
            color: #777777;
            font-size: 10px;
            z-index: 100;
        }
        .branding a {
            color: #CD3F3F;
        }

        header {
            padding: 30px 20px;
            color: white;
            background: #272727;
            box-sizing: border-box;
            border-left: 5px solid #CD3F3F;
        }
        .exc-title {
            margin: 0;
            color: #616161;
            text-shadow: 0 1px 2px rgba(0, 0, 0, .1);
        }
        .exc-title-primary { color: #CD3F3F; }
        .exc-message {
            font-size: 32px;
            margin: 5px 0;
            word-wrap: break-word;
        }

        .stack-container {
            height: 100%;
            position: relative;
        }

        .details-container {
            height: 100%;
            overflow: auto;
            float: right;
            width: 70%;
            background: #DADADA;
        }
        .details {
            padding: 10px;
            padding-left: 5px;
            border-left: 5px solid rgba(0, 0, 0, .1);
        }

        .frames-container {
            height: 100%;
            overflow: auto;
            float: left;
            width: 30%;
            background: #FFF;
        }
        .frame {
            padding: 14px;
            background: #F3F3F3;
            border-right: 1px solid rgba(0, 0, 0, .2);
            cursor: pointer;
        }
        .frame.active {
            background-color: #4288CE;
            color: #F3F3F3;
            box-shadow: inset -2px 0 0 rgba(255, 255, 255, .1);
            text-shadow: 0 1px 0 rgba(0, 0, 0, .2);
        }

        .frame:not(.active):hover {
            background: #BEE9EA;
        }

        .frame-class, .frame-function, .frame-index {
            font-weight: bold;
        }

        .frame-index {
            font-size: 11px;
            color: #BDBDBD;
        }

        .frame-class {
            color: #4288CE;
        }
        .active .frame-class {
            color: #BEE9EA;
        }

        .frame-file {
            font-family: "Inconsolata", "Fira Mono", "Source Code Pro", Monaco, Consolas, "Lucida Console", monospace;
            word-wrap:break-word;
        }

        .frame-file .editor-link {
            color: #272727;
        }

        .frame-line {
            font-weight: bold;
            color: #4288CE;
        }

        .active .frame-line { color: #BEE9EA; }
        .frame-line:before {
            content: ":";
        }

        .frame-code {
            padding: 10px;
            padding-left: 5px;
            background: #BDBDBD;
            display: none;
            border-left: 5px solid #4288CE;
        }

        .frame-code.active {
            display: block;
        }

        .frame-code .frame-file {
            background: #C6C6C6;
            color: #525252;
            text-shadow: 0 1px 0 #E7E7E7;
            padding: 10px 10px 5px 10px;

            border-top-right-radius: 6px;
            border-top-left-radius:  6px;

            border: 1px solid rgba(0, 0, 0, .1);
            border-bottom: none;
            box-shadow: inset 0 1px 0 #DADADA;
        }

        .code-block {
            padding: 10px;
            margin: 0;
            box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        }

        .linenums {
            margin: 0;
            margin-left: 10px;
        }

        .frame-comments {
            box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            border: 1px solid rgba(0, 0, 0, .2);
            border-top: none;

            border-bottom-right-radius: 6px;
            border-bottom-left-radius:  6px;

            padding: 5px;
            font-size: 12px;
            background: #404040;
        }

        .frame-comments.empty {
            padding: 8px 15px;
        }

        .frame-comments.empty:before {
            content: "No comments for this stack frame.";
            font-style: italic;
            color: #828282;
        }

        .frame-comment {
            padding: 10px;
            color: #D2D2D2;
        }
        .frame-comment a {
            color: #BEE9EA;
            font-weight: bold;
            text-decoration: none;
        }
        .frame-comment a:hover {
            color: #4bb1b1;
        }

        .frame-comment:not(:last-child) {
            border-bottom: 1px dotted rgba(0, 0, 0, .3);
        }

        .frame-comment-context {
            font-size: 10px;
            font-weight: bold;
            color: #86D2B6;
        }

        .data-table-container label {
            font-size: 16px;
            font-weight: bold;
            color: #4288CE;
            margin: 10px 0;
            padding: 10px 0;

            display: block;
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px dotted rgba(0, 0, 0, .2);
        }
        .data-table {
            width: 100%;
            margin: 10px 0;
        }

        .data-table tbody {
            font: 13px "Inconsolata", "Fira Mono", "Source Code Pro", Monaco, Consolas, "Lucida Console", monospace;
        }

        .data-table thead {
            display: none;
        }

        .data-table tr {
            padding: 5px 0;
        }

        .data-table td:first-child {
            width: 20%;
            min-width: 130px;
            overflow: hidden;
            font-weight: bold;
            color: #463C54;
            padding-right: 5px;

        }

        .data-table td:last-child {
            width: 80%;
            -ms-word-break: break-all;
            word-break: break-all;
            word-break: break-word;
            -webkit-hyphens: auto;
            -moz-hyphens: auto;
            hyphens: auto;
        }

        .data-table span.empty {
            color: rgba(0, 0, 0, .3);
            font-style: italic;
        }
        .data-table label.empty {
            \tdisplay: inline;
        }

        .handler {
            padding: 10px;
            font: 14px "Inconsolata", "Fira Mono", "Source Code Pro", Monaco, Consolas, "Lucida Console", monospace;
        }

        .handler.active {
            color: #BBBBBB;
            background: #989898;
            font-weight: bold;
        }

        /* prettify code style
        Uses the Doxy theme as a base */
        pre .str, code .str { color: #BCD42A; }  /* string  */
        pre .kwd, code .kwd { color: #4bb1b1;  font-weight: bold; }  /* keyword*/
        pre .com, code .com { color: #888; font-weight: bold; } /* comment */
        pre .typ, code .typ { color: #ef7c61; }  /* type  */
        pre .lit, code .lit { color: #BCD42A; }  /* literal */
        pre .pun, code .pun { color: #fff; font-weight: bold;  } /* punctuation  */
        pre .pln, code .pln { color: #e9e4e5; }  /* plaintext  */
        pre .tag, code .tag { color: #4bb1b1; }  /* html/xml tag  */
        pre .htm, code .htm { color: #dda0dd; }  /* html tag */
        pre .xsl, code .xsl { color: #d0a0d0; }  /* xslt tag */
        pre .atn, code .atn { color: #ef7c61; font-weight: normal;} /* html/xml attribute name */
        pre .atv, code .atv { color: #bcd42a; }  /* html/xml attribute value  */
        pre .dec, code .dec { color: #606; }  /* decimal  */
        pre.prettyprint, code.prettyprint {
            font-family: "Inconsolata", "Fira Mono", "Source Code Pro", Monaco, Consolas, "Lucida Console", monospace;
            background: #333;
            color: #e9e4e5;
        }
        pre.prettyprint {
            white-space: pre-wrap;
        }

        pre.prettyprint a, code.prettyprint a {
            text-decoration:none;
        }

        .linenums li {
            color: #A5A5A5;
        }

        .linenums li.current{
            background: rgba(255, 100, 100, .07);
            padding-top: 4px;
            padding-left: 1px;
        }
        .linenums li.current.active {
            background: rgba(255, 100, 100, .17);
        }

        #plain-exception {
            \tdisplay: none;
        }

        #copy-button {
            \tdisplay: none;
            \tfloat: right;
            \tcursor: pointer;\t
        \tborder: 0;
        }

        .clipboard {
            \twidth:            29px;
            \theight:           28px;
            \tbackground-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB0AAAAcCAYAAACdz7SqAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3gUUB ▶
            \tbackground-repeat: no-repeat;
            }

            .help button {
            \tcursor: help;
            \theight:   28px;
            \tfloat: right;
            \tmargin-left: 10px;
            }

            .help button:hover + #help-overlay {
            \tdisplay: block;
            }

            #help-overlay {
            \tpointer-events: none;
            \tdisplay: none;
            \tposition: absolute;
            \ttop: 0;
            \tleft: 0;
            \twidth: 100%;
            \theight: 100%;
            \tbackground-color: rgba(54, 54, 54, 0.5);
        }

        #help-overlay div {
            \twidth: 200px;
            \tpadding: 5px;
            \tcolor: #463c54;
            \tbackground-color: white;
            \tborder-radius: 10px;
        }

        #help-clipboard {
            \tposition: absolute;
            \tright: 30px;
            \ttop: 90px;
        }

        #help-framestack {
            \tposition: absolute;
            \tleft: 200px;
            \ttop: 50px;
        }

        #help-exc-message {
            \tposition: absolute;
            \tleft: 65%;
            \ttop: 10px;
        }

        #help-code {
            \tposition: absolute;
            \tright: 30px;
            \ttop: 250px;
        }

        #help-request {
            \tposition: absolute;
            \tright: 30px;
            \ttop: 480px;
        }

        #help-appinfo {
            \tposition: absolute;
            \tright: 30px;
            \ttop: 550px;
        }

        /* inspired by githubs kbd styles */
        kbd {
            -moz-border-bottom-colors: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            background-color: #fcfcfc;
            border-color: #ccc #ccc #bbb;
            border-image: none;
            border-radius: 3px;
            border-style: solid;
            border-width: 1px;
            box-shadow: 0 -1px 0 #bbb inset;
            color: #555;
            display: inline-block;
            font-size: 11px;
            line-height: 10px;
            padding: 3px 5px;
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="Whoops container">

    <div class="stack-container">
        <div class="frames-container cf ">
            <div class="frame active" id="frame-line-0">
                <div class="frame-method-info">
                    <span class="frame-index">22.</span>
                    <span class="frame-class">ErrorException</span>
                    <span class="frame-function"></span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;crons/&shy;emons/&shy;config.php<!--
   --><span class="frame-line">13</span>
    </span>
            </div>
            <div class="frame " id="frame-line-1">
                <div class="frame-method-info">
                    <span class="frame-index">21.</span>
                    <span class="frame-class">Illuminate\Exception\Handler</span>
                    <span class="frame-function">handleError</span>
                </div>

                <span class="frame-file">
      <#unknown><!--
   --><span class="frame-line">0</span>
    </span>
            </div>
            <div class="frame " id="frame-line-2">
                <div class="frame-method-info">
                    <span class="frame-index">20.</span>
                    <span class="frame-class">mysqli</span>
                    <span class="frame-function">mysqli</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;crons/&shy;emons/&shy;config.php<!--
   --><span class="frame-line">13</span>
    </span>
            </div>
            <div class="frame " id="frame-line-3">
                <div class="frame-method-info">
                    <span class="frame-index">19.</span>
                    <span class="frame-class"></span>
                    <span class="frame-function">require_once</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;crons/&shy;emons/&shy;emons_send.php<!--
   --><span class="frame-line">8</span>
    </span>
            </div>
            <div class="frame " id="frame-line-4">
                <div class="frame-method-info">
                    <span class="frame-index">18.</span>
                    <span class="frame-class"></span>
                    <span class="frame-function">include</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;app/&shy;models/&shy;ApiHelper.php<!--
   --><span class="frame-line">645</span>
    </span>
            </div>
            <div class="frame " id="frame-line-5">
                <div class="frame-method-info">
                    <span class="frame-index">17.</span>
                    <span class="frame-class">ApiHelper</span>
                    <span class="frame-function">SendEmons</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;app/&shy;controllers/&shy;ApiController.php<!--
   --><span class="frame-line">421</span>
    </span>
            </div>
            <div class="frame " id="frame-line-6">
                <div class="frame-method-info">
                    <span class="frame-index">16.</span>
                    <span class="frame-class">ApiController</span>
                    <span class="frame-function">EasyApi</span>
                </div>

                <span class="frame-file">
      <#unknown><!--
   --><span class="frame-line">0</span>
    </span>
            </div>
            <div class="frame " id="frame-line-7">
                <div class="frame-method-info">
                    <span class="frame-index">15.</span>
                    <span class="frame-class"></span>
                    <span class="frame-function">call_user_func_array</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Routing/&shy;Controller.php<!--
   --><span class="frame-line">231</span>
    </span>
            </div>
            <div class="frame " id="frame-line-8">
                <div class="frame-method-info">
                    <span class="frame-index">14.</span>
                    <span class="frame-class">Illuminate\Routing\Controller</span>
                    <span class="frame-function">callAction</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Routing/&shy;ControllerDispatcher.php<!--
   --><span class="frame-line">93</span>
    </span>
            </div>
            <div class="frame " id="frame-line-9">
                <div class="frame-method-info">
                    <span class="frame-index">13.</span>
                    <span class="frame-class">Illuminate\Routing\ControllerDispatcher</span>
                    <span class="frame-function">call</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Routing/&shy;ControllerDispatcher.php<!--
   --><span class="frame-line">62</span>
    </span>
            </div>
            <div class="frame " id="frame-line-10">
                <div class="frame-method-info">
                    <span class="frame-index">12.</span>
                    <span class="frame-class">Illuminate\Routing\ControllerDispatcher</span>
                    <span class="frame-function">dispatch</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Routing/&shy;Router.php<!--
   --><span class="frame-line">967</span>
    </span>
            </div>
            <div class="frame " id="frame-line-11">
                <div class="frame-method-info">
                    <span class="frame-index">11.</span>
                    <span class="frame-class">Illuminate\Routing\Router</span>
                    <span class="frame-function">Illuminate\Routing\{closure}</span>
                </div>

                <span class="frame-file">
      <#unknown><!--
   --><span class="frame-line">0</span>
    </span>
            </div>
            <div class="frame " id="frame-line-12">
                <div class="frame-method-info">
                    <span class="frame-index">10.</span>
                    <span class="frame-class"></span>
                    <span class="frame-function">call_user_func_array</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Routing/&shy;Route.php<!--
   --><span class="frame-line">109</span>
    </span>
            </div>
            <div class="frame " id="frame-line-13">
                <div class="frame-method-info">
                    <span class="frame-index">9.</span>
                    <span class="frame-class">Illuminate\Routing\Route</span>
                    <span class="frame-function">run</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Routing/&shy;Router.php<!--
   --><span class="frame-line">1033</span>
    </span>
            </div>
            <div class="frame " id="frame-line-14">
                <div class="frame-method-info">
                    <span class="frame-index">8.</span>
                    <span class="frame-class">Illuminate\Routing\Router</span>
                    <span class="frame-function">dispatchToRoute</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Routing/&shy;Router.php<!--
   --><span class="frame-line">1001</span>
    </span>
            </div>
            <div class="frame " id="frame-line-15">
                <div class="frame-method-info">
                    <span class="frame-index">7.</span>
                    <span class="frame-class">Illuminate\Routing\Router</span>
                    <span class="frame-function">dispatch</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Foundation/&shy;Application.php<!--
   --><span class="frame-line">781</span>
    </span>
            </div>
            <div class="frame " id="frame-line-16">
                <div class="frame-method-info">
                    <span class="frame-index">6.</span>
                    <span class="frame-class">Illuminate\Foundation\Application</span>
                    <span class="frame-function">dispatch</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Foundation/&shy;Application.php<!--
   --><span class="frame-line">745</span>
    </span>
            </div>
            <div class="frame " id="frame-line-17">
                <div class="frame-method-info">
                    <span class="frame-index">5.</span>
                    <span class="frame-class">Illuminate\Foundation\Application</span>
                    <span class="frame-function">handle</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Session/&shy;Middleware.php<!--
   --><span class="frame-line">72</span>
    </span>
            </div>
            <div class="frame " id="frame-line-18">
                <div class="frame-method-info">
                    <span class="frame-index">4.</span>
                    <span class="frame-class">Illuminate\Session\Middleware</span>
                    <span class="frame-function">handle</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Cookie/&shy;Queue.php<!--
   --><span class="frame-line">47</span>
    </span>
            </div>
            <div class="frame " id="frame-line-19">
                <div class="frame-method-info">
                    <span class="frame-index">3.</span>
                    <span class="frame-class">Illuminate\Cookie\Queue</span>
                    <span class="frame-function">handle</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Cookie/&shy;Guard.php<!--
   --><span class="frame-line">51</span>
    </span>
            </div>
            <div class="frame " id="frame-line-20">
                <div class="frame-method-info">
                    <span class="frame-index">2.</span>
                    <span class="frame-class">Illuminate\Cookie\Guard</span>
                    <span class="frame-function">handle</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;stack/&shy;builder/&shy;src/&shy;Stack/&shy;StackedHttpKernel.php<!--
   --><span class="frame-line">23</span>
    </span>
            </div>
            <div class="frame " id="frame-line-21">
                <div class="frame-method-info">
                    <span class="frame-index">1.</span>
                    <span class="frame-class">Stack\StackedHttpKernel</span>
                    <span class="frame-function">handle</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;vendor/&shy;laravel/&shy;framework/&shy;src/&shy;Illuminate/&shy;Foundation/&shy;Application.php<!--
   --><span class="frame-line">641</span>
    </span>
            </div>
            <div class="frame " id="frame-line-22">
                <div class="frame-method-info">
                    <span class="frame-index">0.</span>
                    <span class="frame-class">Illuminate\Foundation\Application</span>
                    <span class="frame-function">run</span>
                </div>

                <span class="frame-file">
      &hellip;/&shy;public_html/&shy;index.php<!--
   --><span class="frame-line">49</span>
    </span>
            </div>
        </div>
        <div class="details-container cf">
            <header>
                <div class="exception">
                    <h3 class="exc-title">
                        <span class="exc-title-primary">ErrorException</span>
                        <span title="Exception Code">(E_WARNING)</span>
                    </h3>

                    <div class="help">
                        <button title="show help">HELP</button>

                        <div id="help-overlay">
                            <div id="help-framestack">Callstack information; navigate with mouse or keyboard using <kbd>Ctrl+&uparrow;</kbd> or <kbd>Ctrl+&downarrow;</kbd></div>
                            <div id="help-clipboard">Copy-to-clipboard button</div>
                            <div id="help-exc-message">Exception message and its type</div>
                            <div id="help-code">Code snippet where the error was thrown</div>
                            <div id="help-request">Server state information</div>
                            <div id="help-appinfo">Application provided context information</div>
                        </div>
                    </div>

                    <button id="copy-button" class="clipboard" data-clipboard-target="plain-exception" title="copy exception into clipboard"></button>
                    <span id="plain-exception">ErrorException thrown with message &quot;mysqli::mysqli(): (HY000/1045): Access denied for user &#039;root&#039;@&#039;localhost&#0 ▶

Stacktrace:
#22 ErrorException in /home/d/dtevik/easylox.anira-web.ru/crons/emons/config.php:13
#21 Illuminate\Exception\Handler:handleError in &lt;#unknown&gt;:0
#20 mysqli:mysqli in /home/d/dtevik/easylox.anira-web.ru/crons/emons/config.php:13
#19 require_once in /home/d/dtevik/easylox.anira-web.ru/crons/emons/emons_send.php:8
#18 include in /home/d/dtevik/easylox.anira-web.ru/app/models/ApiHelper.php:645
#17 ApiHelper:SendEmons in /home/d/dtevik/easylox.anira-web.ru/app/controllers/ApiController.php:421
#16 ApiController:EasyApi in &lt;#unknown&gt;:0
#15 call_user_func_array in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/Controller.php:231
#14 Illuminate\Routing\Controller:callAction in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php:93\ ▶
#13 Illuminate\Routing\ControllerDispatcher:call in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php ▶
#12 Illuminate\Routing\ControllerDispatcher:dispatch in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/Router.php:967
#11 Illuminate\Routing\Router:Illuminate\Routing\{closure} in &lt;#unknown&gt;:0
#10 call_user_func_array in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/Route.php:109
#9 Illuminate\Routing\Route:run in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/Router.php:1033
#8 Illuminate\Routing\Router:dispatchToRoute in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/Router.php:1001
#7 Illuminate\Routing\Router:dispatch in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Foundation/Application.php:781
#6 Illuminate\Foundation\Application:dispatch in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Foundation/Application.php:745
#5 Illuminate\Foundation\Application:handle in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Session/Middleware.php:72
#4 Illuminate\Session\Middleware:handle in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Cookie/Queue.php:47
#3 Illuminate\Cookie\Queue:handle in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Cookie/Guard.php:51
#2 Illuminate\Cookie\Guard:handle in /home/d/dtevik/easylox.anira-web.ru/vendor/stack/builder/src/Stack/StackedHttpKernel.php:23
#1 Stack\StackedHttpKernel:handle in /home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Foundation/Application.php:641
#0 Illuminate\Foundation\Application:run in /home/d/dtevik/easylox.anira-web.ru/public_html/index.php:49
</span>

                    <p class="exc-message">
                        mysqli::mysqli(): (HY000/1045): Access denied for user &#039;root&#039;@&#039;localhost&#039; (using password: NO)  </p>
                </div>
            </header>
            <div class="frame-code-container ">
                <div class="frame-code active" id="frame-code-0">
                    <div class="frame-file">
                        Open:
                        <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fcrons%2Femons%2Fconfig.php&line=13" class="editor-link">
                            <strong>/home/d/dtevik/easylox.anira-web.ru/crons/emons/config.php</strong>
                        </a>
                    </div>
                    <pre class="code-block prettyprint linenums:6">define(&#039;PHPMAILER_SMTP_SERVER&#039;, &#039;w00b9afe.kasserver.com&#039;);
define(&#039;PHPMAILER_SMTP_PORT&#039;, &#039;25&#039;);
define(&#039;PHPMAILER_ACCOUNT_USERNAME&#039;, &#039;m019d5a3&#039;);
define(&#039;PHPMAILER_ACCOUNT_PASSWORD&#039;, &#039;xCpRSYWcBJY8php3&#039;);
define(&#039;PHPMAILER_EMAIL&#039;, &#039;support@paket.ag&#039;);
define(&#039;PHPMAILER_NO_REPLY_EMAIL&#039;, &#039;support@paket.ag&#039;);

$db = new mysqli(&quot;localhost&quot;, &quot;root&quot;, &quot;&quot;, &quot;easylox&quot;);

if ($db-&gt;connect_errno) {</pre>

                    <div class="frame-comments empty">
                    </div>

                </div>
                <div class="frame-code " id="frame-code-1">
                    <div class="frame-file">
                        <strong>&lt;#unknown&gt;</strong>
                    </div>

                    <div class="frame-comments empty">
                    </div>

                </div>
                <div class="frame-code " id="frame-code-2">
                    <div class="frame-file">
                        Open:
                        <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fcrons%2Femons%2Fconfig.php&line=13" class="editor-link">
                            <strong>/home/d/dtevik/easylox.anira-web.ru/crons/emons/config.php</strong>
                        </a>
                    </div>
                    <pre class="code-block prettyprint linenums:6">define(&#039;PHPMAILER_SMTP_SERVER&#039;, &#039;w00b9afe.kasserver.com&#039;);
define(&#039;PHPMAILER_SMTP_PORT&#039;, &#039;25&#039;);
define(&#039;PHPMAILER_ACCOUNT_USERNAME&#039;, &#039;m019d5a3&#039;);
define(&#039;PHPMAILER_ACCOUNT_PASSWORD&#039;, &#039;xCpRSYWcBJY8php3&#039;);
define(&#039;PHPMAILER_EMAIL&#039;, &#039;support@paket.ag&#039;);
define(&#039;PHPMAILER_NO_REPLY_EMAIL&#039;, &#039;support@paket.ag&#039;);

$db = new mysqli(&quot;localhost&quot;, &quot;root&quot;, &quot;&quot;, &quot;easylox&quot;);

if ($db-&gt;connect_errno) {</pre>

                    <div class="frame-comments empty">
                    </div>

                </div>
                <div class="frame-code " id="frame-code-3">
                    <div class="frame-file">
                        Open:
                        <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fcrons%2Femons%2Femons_send.php&line=8" class="editor-link">
                            <strong>/home/d/dtevik/easylox.anira-web.ru/crons/emons/emons_send.php</strong>
                        </a>
                    </div>
                    <pre class="code-block prettyprint linenums:1">&lt;?php
header(&#039;Content-Type: text/html; charset=utf-8&#039;);
global $db,$ds,$emons_order_id,$emons_echo;
ini_set(&#039;max_execution_time&#039;, 600);
ini_set(&#039;error_reporting&#039;, E_ALL);
ini_set(&#039;display_errors&#039;, 1);
ini_set(&#039;display_startup_errors&#039;, 1);
require_once(&#039;config.php&#039;);
require_once(ABSPATH.&#039;emons.class.php&#039;);
require_once(ABSPATH.&#039;pdf/vendor/dompdf/dompdf/dompdf_config.inc.php&#039;);</pre>

                    <div class="frame-comments empty">
                    </div>

                </div>
                <div class="frame-code " id="frame-code-4">
                    <div class="frame-file">
                        Open:
                        <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fapp%2Fmodels%2FApiHelper.php&line=645" class="editor-link">
                            <strong>/home/d/dtevik/easylox.anira-web.ru/app/models/ApiHelper.php</strong>
                        </a>
                    </div>
                    <pre class="code-block prettyprint linenums:638">      //add api stats
      self::addApiStats($_data[&#039;user_id&#039;],$shipment-&gt;id,$_data[&#039;carrier&#039;],$_data[&#039;api_config&#039;]);
    }

          //send to emons
    $emons_order_id = $_data[&#039;reference_number&#039;];
    $emons_echo = &#039;off&#039;;


    $shipment_response = Shipment::whereIn(&#039;id&#039;, $shipments)-&gt;get();</pre>

                    <div class="frame-comments empty">
                    </div>

                </div>
                <div class="frame-code " id="frame-code-5">
                    <div class="frame-file">
                        Open:
                        <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fapp%2Fcontrollers%2FApiController.php&line=421" class="editor-link">
                            <strong>/home/d/dtevik/easylox.anira-web.ru/app/controllers/ApiController.php</strong>
                        </a>
                    </div>
                    <pre class="code-block prettyprint linenums:414">    $_data[&#039;the_carrier_id&#039;] = $the_carrier_id;
    $response = ApiHelper::SendDhlFtp($_data);
  } elseif(in_array($the_carrier_id,array(&#039;10&#039;))){

    if(!isset($data[&#039;pickup&#039;]))
      self::error(400, &#039;ERROR::ESY::PAYLOAD::PICKUPDATE::MISSING&#039; , &#039;Fehlende Versanddatum&#039;);

    $response = ApiHelper::SendEmons($_data);
  }elseif(in_array($the_carrier_id,array(&#039;100&#039;))){
 </pre>

                    <div class="frame-comments empty">
                    </div>

                </div>
                <div class="frame-code " id="frame-code-6">
                    <div class="frame-file">
                        <strong>&lt;#unknown&gt;</strong>
                    </div>

                    <div class="frame-comments empty">
                    </div>

                </div>
                <div class="frame-code " id="frame-code-7">
                    <div class="frame-file">
                        Open:
                        <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FRouting%2FController ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/Controller.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:224">\t * @param  array   $parameters
                        \t * @return \Symfony\Component\HttpFoundation\Response
                        \t */
                        \tpublic function callAction($method, $parameters)
                        \t{
                        \t\t$this-&gt;setupLayout();

                        \t\t$response = call_user_func_array(array($this, $method), $parameters);

                        \t\t// If no response is returned from the controller action and a layout is being</pre>

                        <div class="frame-comments empty">
                        </div>

                    </div>
                    <div class="frame-code " id="frame-code-8">
                        <div class="frame-file">
                            Open:
                            <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FRouting%2FController ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:86">\t * @param  string  $method
                            \t * @return mixed
                            \t */
                            \tprotected function call($instance, $route, $method)
                            \t{
                            \t\t$parameters = $route-&gt;parametersWithoutNulls();

                            \t\treturn $instance-&gt;callAction($method, $parameters);
                            \t}
                            </pre>

                            <div class="frame-comments empty">
                            </div>

                        </div>
                        <div class="frame-code " id="frame-code-9">
                            <div class="frame-file">
                                Open:
                                <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FRouting%2FController ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:55">\t\t$response = $this-&gt;before($instance, $route, $request, $method);

                                \t\t// If no before filters returned a response we&#039;ll call the method on the controller
                                \t\t// to get the response to be returned to the router. We will then return it back
                                \t\t// out for processing by this router and the after filters can be called then.
                                \t\tif (is_null($response))
                                \t\t{
                                \t\t\t$response = $this-&gt;call($instance, $route, $method);
                                \t\t}
                                </pre>

                                <div class="frame-comments empty">
                                </div>

                            </div>
                            <div class="frame-code " id="frame-code-10">
                                <div class="frame-file">
                                    Open:
                                    <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FRouting%2FRouter.php ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/Router.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:960">\t\t\t$request = $this-&gt;getCurrentRequest();

                                    \t\t\t// Now we can split the controller and method out of the action string so that we
                                    \t\t\t// can call them appropriately on the class. This controller and method are in
                                    \t\t\t// in the Class@method format and we need to explode them out then use them.
                                    \t\t\tlist($class, $method) = explode(&#039;@&#039;, $controller);

                                    \t\t\treturn $d-&gt;dispatch($route, $request, $class, $method);
                                    \t\t};
                                    \t}</pre>

                                    <div class="frame-comments empty">
                                    </div>

                                </div>
                                <div class="frame-code " id="frame-code-11">
                                    <div class="frame-file">
                                        <strong>&lt;#unknown&gt;</strong>
                                    </div>

                                    <div class="frame-comments empty">
                                    </div>

                                </div>
                                <div class="frame-code " id="frame-code-12">
                                    <div class="frame-file">
                                        Open:
                                        <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FRouting%2FRoute.php& ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/Route.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:102">\t *
                                        \t * @return mixed
                                        \t */
                                        \tpublic function run()
                                        \t{
                                        \t\t$parameters = array_filter($this-&gt;parameters(), function($p) { return isset($p); });

                                        \t\treturn call_user_func_array($this-&gt;action[&#039;uses&#039;], $parameters);
                                        \t}
                                        </pre>

                                        <div class="frame-comments empty">
                                        </div>

                                    </div>
                                    <div class="frame-code " id="frame-code-13">
                                        <div class="frame-file">
                                            Open:
                                            <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FRouting%2FRouter.php ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/Router.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:1026">\t\t// Once we have successfully matched the incoming request to a given route we
                                            \t\t// can call the before filters on that route. This works similar to global
                                            \t\t// filters in that if a response is returned we will not call the route.
                                            \t\t$response = $this-&gt;callRouteBefore($route, $request);

                                            \t\tif (is_null($response))
                                            \t\t{
                                            \t\t\t$response = $route-&gt;run($request);
                                            \t\t}
                                            </pre>

                                            <div class="frame-comments empty">
                                            </div>

                                        </div>
                                        <div class="frame-code " id="frame-code-14">
                                            <div class="frame-file">
                                                Open:
                                                <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FRouting%2FRouter.php ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Routing/Router.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:994">\t\t// If no response was returned from the before filter, we will call the proper
                                                \t\t// route instance to get the response. If no route is found a response will
                                                \t\t// still get returned based on why no routes were found for this request.
                                                \t\t$response = $this-&gt;callFilter(&#039;before&#039;, $request);

                                                \t\tif (is_null($response))
                                                \t\t{
                                                \t\t\t$response = $this-&gt;dispatchToRoute($request);
                                                \t\t}
                                                </pre>

                                                <div class="frame-comments empty">
                                                </div>

                                            </div>
                                            <div class="frame-code " id="frame-code-15">
                                                <div class="frame-file">
                                                    Open:
                                                    <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FFoundation%2FApplica ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Foundation/Application.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:774">\t\t}

                                                    \t\tif ($this-&gt;runningUnitTests() &amp;&amp; ! $this[&#039;session&#039;]-&gt;isStarted())
                                                    \t\t{
                                                    \t\t\t$this[&#039;session&#039;]-&gt;start();
                                                    \t\t}

                                                    \t\treturn $this[&#039;router&#039;]-&gt;dispatch($this-&gt;prepareRequest($request));
                                                    \t}
                                                    </pre>

                                                    <div class="frame-comments empty">
                                                    </div>

                                                </div>
                                                <div class="frame-code " id="frame-code-16">
                                                    <div class="frame-file">
                                                        Open:
                                                        <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FFoundation%2FApplica ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Foundation/Application.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:738">\t{
                                                        \t\ttry
                                                        \t\t{
                                                        \t\t\t$this-&gt;refreshRequest($request = Request::createFromBase($request));

                                                        \t\t\t$this-&gt;boot();

                                                        \t\t\treturn $this-&gt;dispatch($request);
                                                        \t\t}
                                                        \t\tcatch (\Exception $e)</pre>

                                                        <div class="frame-comments empty">
                                                        </div>

                                                    </div>
                                                    <div class="frame-code " id="frame-code-17">
                                                        <div class="frame-file">
                                                            Open:
                                                            <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FSession%2FMiddleware ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Session/Middleware.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:65">\t\tif ($this-&gt;sessionConfigured())
                                                            \t\t{
                                                            \t\t\t$session = $this-&gt;startSession($request);

                                                            \t\t\t$request-&gt;setSession($session);
                                                            \t\t}

                                                            \t\t$response = $this-&gt;app-&gt;handle($request, $type, $catch);

                                                            \t\t// Again, if the session has been configured we will need to close out the session</pre>

                                                            <div class="frame-comments empty">
                                                            </div>

                                                        </div>
                                                        <div class="frame-code " id="frame-code-18">
                                                            <div class="frame-file">
                                                                Open:
                                                                <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FCookie%2FQueue.php&l ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Cookie/Queue.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:40">\t * @param  \Symfony\Component\HttpFoundation\Request  $request
                                                                \t * @param  int   $type
                                                                \t * @param  bool  $catch
                                                                \t * @return \Symfony\Component\HttpFoundation\Response
                                                                \t */
                                                                \tpublic function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
                                                                \t{
                                                                \t\t$response = $this-&gt;app-&gt;handle($request, $type, $catch);

                                                                \t\tforeach ($this-&gt;cookies-&gt;getQueuedCookies() as $cookie)</pre>

                                                                <div class="frame-comments empty">
                                                                </div>

                                                            </div>
                                                            <div class="frame-code " id="frame-code-19">
                                                                <div class="frame-file">
                                                                    Open:
                                                                    <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FCookie%2FGuard.php&l ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Cookie/Guard.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:44">\t * @param  \Symfony\Component\HttpFoundation\Request  $request
                                                                    \t * @param  int   $type
                                                                    \t * @param  bool  $catch
                                                                    \t * @return \Symfony\Component\HttpFoundation\Response
                                                                    \t */
                                                                    \tpublic function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
                                                                    \t{
                                                                    \t\treturn $this-&gt;encrypt($this-&gt;app-&gt;handle($this-&gt;decrypt($request), $type, $catch));
                                                                    \t}
                                                                    </pre>

                                                                    <div class="frame-comments empty">
                                                                    </div>

                                                                </div>
                                                                <div class="frame-code " id="frame-code-20">
                                                                    <div class="frame-file">
                                                                        Open:
                                                                        <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Fstack%2Fbuilder%2Fsrc%2FStack%2FStackedHttpKernel.php&line=23 ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/stack/builder/src/Stack/StackedHttpKernel.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:16">    {
                                                                        $this-&gt;app = $app;
                                                                        $this-&gt;middlewares = $middlewares;
                                                                        }

                                                                        public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
                                                                        {
                                                                        return $this-&gt;app-&gt;handle($request, $type, $catch);
                                                                        }
                                                                        </pre>

                                                                        <div class="frame-comments empty">
                                                                        </div>

                                                                    </div>
                                                                    <div class="frame-code " id="frame-code-21">
                                                                        <div class="frame-file">
                                                                            Open:
                                                                            <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FFoundation%2FApplica ▶
              <strong>/home/d/dtevik/easylox.anira-web.ru/vendor/laravel/framework/src/Illuminate/Foundation/Application.php</strong>
            </a>
                  </div>
                    <pre class="code-block prettyprint linenums:634">\t * @param  \Symfony\Component\HttpFoundation\Request  $request
                                                                            \t * @return void
                                                                            \t */
                                                                            \tpublic function run(SymfonyRequest $request = null)
                                                                            \t{
                                                                            \t\t$request = $request ?: $this[&#039;request&#039;];

                                                                            \t\t$response = with($stack = $this-&gt;getStackedClient())-&gt;handle($request);

                                                                            \t\t$response-&gt;send();</pre>

                                                                            <div class="frame-comments empty">
                                                                            </div>

                                                                        </div>
                                                                        <div class="frame-code " id="frame-code-22">
                                                                            <div class="frame-file">
                                                                                Open:
                                                                                <a href="subl://open?url=file://%2Fhome%2Fd%2Fdtevik%2Feasylox.anira-web.ru%2Fpublic_html%2Findex.php&line=49" class="editor-link">
                                                                                    <strong>/home/d/dtevik/easylox.anira-web.ru/public_html/index.php</strong>
                                                                                </a>
                                                                            </div>
                                                                            <pre class="code-block prettyprint linenums:42">| Once we have the application, we can simply call the run method,
| which will execute the request and send the response back to
| the client&#039;s browser allowing them to enjoy the creative
| and wonderful application we have whipped up for them.
|
*/

$app-&gt;run();
 </pre>

                                                                            <div class="frame-comments empty">
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="details">
                                                                        <div class="data-table-container" id="data-tables">
                                                                            <div class="data-table" id="sg-get-data">
                                                                                <label class="empty">GET Data</label>
                                                                                <span class="empty">empty</span>
                                                                            </div>
                                                                            <div class="data-table" id="sg-post-data">
                                                                                <label class="empty">POST Data</label>
                                                                                <span class="empty">empty</span>
                                                                            </div>
                                                                            <div class="data-table" id="sg-files">
                                                                                <label class="empty">Files</label>
                                                                                <span class="empty">empty</span>
                                                                            </div>
                                                                            <div class="data-table" id="sg-cookies">
                                                                                <label class="empty">Cookies</label>
                                                                                <span class="empty">empty</span>
                                                                            </div>
                                                                            <div class="data-table" id="sg-session">
                                                                                <label class="empty">Session</label>
                                                                                <span class="empty">empty</span>
                                                                            </div>
                                                                            <div class="data-table" id="sg-serverrequest-data">
                                                                                <label>Server/Request Data</label>
                                                                                <table class="data-table">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <td class="data-table-k">Key</td>
                                                                                        <td class="data-table-v">Value</td>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tr>
                                                                                        <td>REDIRECT_UNIQUE_ID</td>
                                                                                        <td>YKZFK1fsFO4AAUl9HmQAAAAX</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_MMDB_ADDR</td>
                                                                                        <td>37.186.119.111</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_GEOIP_ADDR</td>
                                                                                        <td>37.186.119.111</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_MMDB_INFO</td>
                                                                                        <td>result found</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_GEOIP_COUNTRY_NAME</td>
                                                                                        <td>Armenia</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_GEOIP_REGION</td>
                                                                                        <td>ER</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_GEOIP_CITY</td>
                                                                                        <td>Yerevan</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_GEOIP_LONGITUDE</td>
                                                                                        <td>44.50990</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_GEOIP_CONTINENT_CODE</td>
                                                                                        <td>AS</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_GEOIP_LATITUDE</td>
                                                                                        <td>40.18170</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_GEOIP_COUNTRY_CODE</td>
                                                                                        <td>AM</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_HTTP_AUTHORIZATION</td>
                                                                                        <td>Basic OjQ2MTQ0MmM0MTNhOWIyNjJlNGRmNmZiNmE4YmEyNThjNjcwOTI2YTVkNWQ2MjQ1MjFhMjNjZTgzZDcxMmM2NzI=</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_PERL_USE_UNSAFE_INC</td>
                                                                                        <td>1</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_LARAVEL_ENV</td>
                                                                                        <td>local</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_STATUS</td>
                                                                                        <td>200</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>UNIQUE_ID</td>
                                                                                        <td>YKZFK1fsFO4AAUl9HmQAAAAX</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>MMDB_ADDR</td>
                                                                                        <td>37.186.119.111</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>GEOIP_ADDR</td>
                                                                                        <td>37.186.119.111</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>MMDB_INFO</td>
                                                                                        <td>result found</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>GEOIP_COUNTRY_NAME</td>
                                                                                        <td>Armenia</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>GEOIP_REGION</td>
                                                                                        <td>ER</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>GEOIP_CITY</td>
                                                                                        <td>Yerevan</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>GEOIP_LONGITUDE</td>
                                                                                        <td>44.50990</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>GEOIP_CONTINENT_CODE</td>
                                                                                        <td>AS</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>GEOIP_LATITUDE</td>
                                                                                        <td>40.18170</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>GEOIP_COUNTRY_CODE</td>
                                                                                        <td>AM</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>HTTP_AUTHORIZATION</td>
                                                                                        <td>Basic OjQ2MTQ0MmM0MTNhOWIyNjJlNGRmNmZiNmE4YmEyNThjNjcwOTI2YTVkNWQ2MjQ1MjFhMjNjZTgzZDcxMmM2NzI=</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>PERL_USE_UNSAFE_INC</td>
                                                                                        <td>1</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>LARAVEL_ENV</td>
                                                                                        <td>local</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>HTTP_HOST</td>
                                                                                        <td>easylox.anira-web.ru</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>HTTP_X_SERVER_ADDR</td>
                                                                                        <td>87.236.19.238</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>HTTP_X_FORWARDED_PROTO</td>
                                                                                        <td>http</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>HTTP_X_REAL_IP</td>
                                                                                        <td>37.186.119.111</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>CONTENT_LENGTH</td>
                                                                                        <td>611</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>HTTP_ACCEPT</td>
                                                                                        <td>*/*</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>CONTENT_TYPE</td>
                                                                                        <td>application/json</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>PATH</td>
                                                                                        <td>/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>SERVER_SIGNATURE</td>
                                                                                        <td>&lt;address&gt;Apache/2.4.10 (Unix) Server at easylox.anira-web.ru Port 80&lt;/address&gt;
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>SERVER_SOFTWARE</td>
                                                                                        <td>Apache/2.4.10 (Unix)</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>SERVER_NAME</td>
                                                                                        <td>easylox.anira-web.ru</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>SERVER_ADDR</td>
                                                                                        <td>87.236.19.238</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>SERVER_PORT</td>
                                                                                        <td>80</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REQUEST_SCHEME</td>
                                                                                        <td>http</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REMOTE_ADDR</td>
                                                                                        <td>37.186.119.111</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>DOCUMENT_ROOT</td>
                                                                                        <td>/home/d/dtevik/easylox.anira-web.ru/public_html</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>CONTEXT_PREFIX</td>
                                                                                        <td></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>CONTEXT_DOCUMENT_ROOT</td>
                                                                                        <td>/home/d/dtevik/easylox.anira-web.ru/public_html</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>SERVER_ADMIN</td>
                                                                                        <td>webmaster@easylox.anira-web.ru</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>SCRIPT_FILENAME</td>
                                                                                        <td>/home/d/dtevik/easylox.anira-web.ru/public_html/index.php</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REMOTE_PORT</td>
                                                                                        <td>25321</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REDIRECT_URL</td>
                                                                                        <td>/api/v1/create</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>GATEWAY_INTERFACE</td>
                                                                                        <td>CGI/1.1</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>SERVER_PROTOCOL</td>
                                                                                        <td>HTTP/1.1</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REQUEST_METHOD</td>
                                                                                        <td>POST</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>QUERY_STRING</td>
                                                                                        <td></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REQUEST_URI</td>
                                                                                        <td>/api/v1/create</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>SCRIPT_NAME</td>
                                                                                        <td>/index.php</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>PHP_SELF</td>
                                                                                        <td>/index.php</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>PHP_AUTH_USER</td>
                                                                                        <td></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>PHP_AUTH_PW</td>
                                                                                        <td>461442c413a9b262e4df6fb6a8ba258c670926a5d5d624521a23ce83d712c672</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REQUEST_TIME_FLOAT</td>
                                                                                        <td>1621509419.846</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>REQUEST_TIME</td>
                                                                                        <td>1621509419</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>argv</td>
                                                                                        <td>Array
                                                                                            (
                                                                                            )
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>argc</td>
                                                                                        <td>0</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                            <div class="data-table" id="sg-environment-variables">
                                                                                <label>Environment Variables</label>
                                                                                <table class="data-table">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <td class="data-table-k">Key</td>
                                                                                        <td class="data-table-v">Value</td>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tr>
                                                                                        <td>APT_GET_UPGRADE</td>
                                                                                        <td>apt-get dist-upgrade -qq -y</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>HOSTNAME</td>
                                                                                        <td>spock.beget.ru</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>OLDPWD</td>
                                                                                        <td>/</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>APT_GET_INSTALL</td>
                                                                                        <td>apt-get install --no-install-recommends -qq -y</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>PWD</td>
                                                                                        <td>/</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>HOME</td>
                                                                                        <td>/root</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>DEBIAN_FRONTEND</td>
                                                                                        <td>noninteractive</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>SHLVL</td>
                                                                                        <td>0</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>PATH</td>
                                                                                        <td>/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>APT_GET_UPDATE</td>
                                                                                        <td>apt-get update -qq</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>

                                                                        <div class="data-table-container" id="handlers">
                                                                            <label>Registered Handlers</label>
                                                                            <div class="handler active">
                                                                                0. Whoops\Handler\PrettyPageHandler      </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <script src="//cdnjs.cloudflare.com/ajax/libs/zeroclipboard/1.3.5/ZeroClipboard.min.js"></script>
                                                        <script src="//cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.js"></script>
                                                        <script>/* Zepto v1.1.3 - zepto event ajax form ie - zeptojs.com/license */
                                                            var Zepto=function(){function L(t){return null==t?String(t):j[T.call(t)]||"object"}function Z(t){return"function"==L(t)}function $(t){return null!=t&&t==t.windo ▶
                                                        </script>
                                                        <script>Zepto(function($) {
                                                                prettyPrint();

                                                                var $frameContainer = $('.frames-container');
                                                                var $container      = $('.details-container');
                                                                var $activeLine     = $frameContainer.find('.frame.active');
                                                                var $activeFrame    = $container.find('.frame-code.active');
                                                                var $ajaxEditors    = $('.editor-link[data-ajax]');
                                                                var headerHeight    = $('header').height();

                                                                var highlightCurrentLine = function() {
                                                                    // Highlight the active and neighboring lines for this frame:
                                                                    var activeLineNumber = +($activeLine.find('.frame-line').text());
                                                                    var $lines           = $activeFrame.find('.linenums li');
                                                                    var firstLine        = +($lines.first().val());

                                                                    $($lines[activeLineNumber - firstLine - 1]).addClass('current');
                                                                    $($lines[activeLineNumber - firstLine]).addClass('current active');
                                                                    $($lines[activeLineNumber - firstLine + 1]).addClass('current');
                                                                }

                                                                // Highlight the active for the first frame:
                                                                highlightCurrentLine();

                                                                $frameContainer.on('click', '.frame', function() {
                                                                    var $this  = $(this);
                                                                    var id     = /frame\-line\-([\d]*)/.exec($this.attr('id'))[1];
                                                                    var $codeFrame = $('#frame-code-' + id);

                                                                    if ($codeFrame) {
                                                                        $activeLine.removeClass('active');
                                                                        $activeFrame.removeClass('active');

                                                                        $this.addClass('active');
                                                                        $codeFrame.addClass('active');

                                                                        $activeLine  = $this;
                                                                        $activeFrame = $codeFrame;

                                                                        highlightCurrentLine();

                                                                        $container.scrollTop(headerHeight);
                                                                    }
                                                                });

                                                                if (typeof ZeroClipboard !== "undefined") {
                                                                \t  ZeroClipboard.config({
\t\t  moviePath: '//ajax.cdnjs.com/ajax/libs/zeroclipboard/1.3.5/ZeroClipboard.swf',
\t  });

\t  var clipEl = document.getElementById("copy-button");
\t  var clip = new ZeroClipboard( clipEl );
\t  var $clipEl = $(clipEl);

\t  // show the button, when swf could be loaded successfully from CDN
                                                                \t  clip.on("load", function() {
                                                                    \t\t  $clipEl.show();
\t  });
                                                                }

                                                                $(document).on('keydown', function(e) {
                                                                \t  if(e.ctrlKey) {
                                                                    \t\t  // CTRL+Arrow-UP/Arrow-Down support:
                                                                    \t\t  // 1) select the next/prev element
                                                                    \t\t  // 2) make sure the newly selected element is within the view-scope
                                                                    \t\t  // 3) focus the (right) container, so arrow-up/down (without ctrl) scroll the details
                                                                    \t\t  if (e.which === 38 /* arrow up */) {
                                                                        \t\t\t  $activeLine.prev('.frame').click();
\t\t\t  $activeLine[0].scrollIntoView();
\t\t\t  $container.focus();
\t\t\t  e.preventDefault();
\t\t  } else if (e.which === 40 /* arrow down */) {
                                                                        \t\t\t  $activeLine.next('.frame').click();
\t\t\t  $activeLine[0].scrollIntoView();
\t\t\t  $container.focus();
\t\t\t  e.preventDefault();
\t\t  }
\t  }
                                                                });

                                                                // Avoid to quit the page with some protocol (e.g. IntelliJ Platform REST API)
                                                                $ajaxEditors.on('click', function(e){
                                                                    e.preventDefault();
                                                                    $.get(this.href);
                                                                });
                                                            });
                                                        </script>
</body>
</html>
"""
